<?php

namespace App\Http\Controllers;

use App\Mail\ReturnStatusMail;
use App\Models\DueDate;
use App\Models\ReturnStatus;
use App\Models\ReturnEntry;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{

    public function showHomePage(): Factory|View|Application
    {
        $returnsByUser = ReturnEntry::getPendingReturnsByUser();
        return view('admin.home_page', [
            'returnsByUser' => $returnsByUser
        ]);
    }

    public function index(): Factory|View|Application
{
    $loaners = User::where('is_admin', false)->get();

    $active_loaners = $loaners->filter(function ($loaner) {
        return $loaner->active();
    });

    $inactive_loaners = $loaners->filter(function ($loaner) {
        return !$loaner->active();
    });

    return view('loaners.overview', [
        'loaners' => $loaners,
        'active_loaners' => $active_loaners,
        'inactive_loaners' => $inactive_loaners,
    ]);
}

    public function show($id): View|Factory|RedirectResponse|Application
    {
        $user = User::find($id);

        if ($user == null) {
            return redirect()->route('loaners_overview');
        }
        return view('loaners.details', ['loaner' => $user]);
    }

    public function createLoaner(): Factory|View|Application
    {
        return view('loaners.create');
    }

    public function storeLoaner(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email|avans_email',
        ]);

        User::insert([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return redirect::route('loaners_overview');
    }

    public function showDueDates(): Factory|View|Application
    {
        return view('admin.due_dates', [
            'futureDueDates' => DueDate::futureDueDates(),
            'pastDueDates' => DueDate::pastDueDates(),
        ]);
    }

    public function createDueDate(Request $request): RedirectResponse
    {
        // convert datetime to correct format
        $request->merge([
            'datetime' => date('Y-m-d H:i:s', strtotime($request->get('datetime')))
        ]);

        // validate request
        $request->validate([
            'datetime' => 'required|dateformat:Y-m-d H:i:s'
        ]);

        $dueDate = DueDate::create(
            [
                'due_date' => request('datetime')
            ]
        );
        $dueDateDate = date('d-m-Y H:i', strtotime($dueDate->due_date));
        return redirect()->route('due_dates_overview')->with('success', "Eindtermijn ($dueDateDate) is toegevoegd");
    }

    public function deleteDueDate($id): RedirectResponse
    {
        $dueDate = DueDate::find($id);
        $dueDateDate = date('d-m-Y H:i', strtotime($dueDate->due_date));
        $dueDate->delete();
        return redirect()->route('due_dates_overview')->with('success', "Eindtermijn ($dueDateDate) is verwijderd");
    }

    public function acceptReturns(Request $request)
    {
        $returnIds = $request->input('returnIds');
        $comments = $request->input('comments');
        $returns = [];

        // Update the returns with the given IDs to be accepted
        foreach ($returnIds as $returnId) {
            $return = ReturnEntry::findOrFail($returnId);
            array_push($returns, $return);
            $return->update(['status_id' => ReturnStatus::getApprovedId()]);
            foreach ($comments as $commentEntry) {
                if ($commentEntry["returnId"] == $returnId) {
                    $this->updateComment($return, $commentEntry["comment"]);
                }
            }
        }
        $this->sendEmail($returns, true);

        return response()->json(['message' => 'Items succesvol goedgekeurd']);
    }

    public function rejectReturns(Request $request)
    {
        $returnIds = $request->input('returnIds');
        $comments = $request->input('comments');
        $returns = [];
        // Update all the returns with the given IDs to be rejected with their corresponding comments
        foreach ($returnIds as $returnId) {
            $return = ReturnEntry::findOrFail($returnId);
            array_push($returns, $return);
            $return->update([
                'status_id' => ReturnStatus::getRejectedId()
            ]);
            foreach ($comments as $commentEntry) {
                if ($commentEntry["returnId"] == $returnId) {
                    $this->updateComment($return, $commentEntry["comment"]);
                }
            }
        }

        $this->sendEmail($returns, false);

        return response()->json(['message' => 'Items succesvol afgekeurd']);
    }

    public function acceptReturn(Request $request, $returnId)
    {
        $return = ReturnEntry::findOrFail($returnId);
        $comment = $request->input('comment');
        // Update the return to be accepted
        $return->update(['status_id' => ReturnStatus::getApprovedId()]);
        $this->updateComment($return, $comment);
        $this->sendEmail([$return], true);

        return response()->json(['message' => 'Succesvol goedgekeurd']);
    }

    public function rejectReturn(Request $request, $returnId)
    {
        $return = ReturnEntry::findOrFail($returnId);
        $comment = $request->input('comment');
        // Update the return to be rejected
        $return->update(['status_id' => ReturnStatus::getRejectedId()]);
        $this->updateComment($return, $comment);
        $this->sendEmail([$return], false);
        return response()->json(['message' => 'Succesvol afgekeurd']);
    }

    public function sendEmail(array $returnEntries, bool $isApproved)
    {
        $user = $returnEntries[0]->loans->first()->user;
        $mailData = [
            'title' => 'Lening goedgekeurd',
            'user' => $user,
            'returnEntry' => $returnEntries,
            'type' => 'goedgekeurd'
        ];


        if (!$isApproved) {
            $mailData['title'] = 'Lening afgekeurd';
            $mailData['type'] = 'afgekeurd';
        }
        Mail::to($user->email)->send(new ReturnStatusMail($mailData));
    }

    public function updateComment($return, $comment)
    {
        if (!empty($comment)) {
            $return->update([
                'admin_comment' => $comment
            ]);
        }
    }
}
