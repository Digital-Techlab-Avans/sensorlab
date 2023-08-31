<?php

namespace App\Http\Controllers;

use App\Models\EmailPreference;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class AccountController extends Controller
{
    public function show(): Factory|View|Application
    {
        return view('account.account');
    }

    public function settings(): Factory|View|Application
    {
        return view('account.settings', [
            'emailPreferences' => EmailPreference::all()->where('user_id', User::getLoggedInUser()->id)->first()
        ]);
    }

    public function changeSettings(Request $request)
    {
        if ($request->get('reset')) {
            return $this->reset();
        } else if ($request->get('save')) {
            return $this->update($request);
        }
    }

    public function update(Request $request): RedirectResponse
    {

        $user = User::getLoggedInUser();
        EmailPreference::all()->where('user_id', $user->id)->first()->update([
            'reminder_7_days' => $request->reminder_7_days ?? 0,
            'reminder_same_day' => $request->reminder_same_day ?? 0,
            'approved_or_denied_message' => $request->approved_or_denied_message ?? 0
        ]);

        return redirect()->route('account')->with('success', 'Instellingen succesvol geupdate!');
    }

    public function reset(): RedirectResponse
    {
        $user = User::getLoggedInUser();
        EmailPreference::all()->where('user_id', $user->id)->first()->update([
            'reminder_7_days' => 1,
            'reminder_same_day' => 1,
            'approved_or_denied_message' => 0
        ]);
        return redirect()->route('account')->with('success', 'Instellingen succesvol gereset!');

    }
}
