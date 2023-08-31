<?php

namespace App\Http\Controllers;

use App\Models\ReturnEntry;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HandInController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('loaners.hand_in', ['loaner' => User::getLoggedInUser()]);
    }


    public function store(Request $request): RedirectResponse
    {
        if($this->storeReturn($request, User::getLoggedInUser()->id)){
            return redirect()->route('hand_in')->with('success', 'Product(en) succesvol ingeleverd!');
        } else{
            return redirect()->route('hand_in')->with('error', 'Je hebt geen product geselecteerd om in te leveren.');
        }
    }

    public function indexAdmin($id): Factory|View|Application
    {
        return view('loaners.handin_admin', ['loaner' => User::find($id)]);
    }

    public function storeAdmin(Request $request, $id): RedirectResponse
    {
        if($this->storeReturn($request, $id)){
            return redirect()->route('admin_handin', ['loaner'=> User::find($id)])->with('success', 'Product(en) succesvol ingeleverd!');
        } else{
            return redirect()->route('admin_handin', ['loaner' => User::find($id)])->with('error', 'Je hebt geen product geselecteerd om in te leveren.');
        }
    }

    //Stores the return for the specified user (necessary because of Admin returns)
    public function storeReturn($request, $loanerid): bool
    {
        $totalAmount = array_sum($request->amounts);
        if ($totalAmount > 0) {

            foreach ($request->amounts as $productId => $amount) {

                if ($amount <= 0) {
                    continue;
                }

                $comment = $request->comments[$productId] ?? '';
                $returnEntry = ReturnEntry::create([
                    'comment' => $comment,
                ]);

                $this->returnProduct($amount, $productId, $returnEntry, $loanerid);
            }
            return true;
        }
        return false;
    }

    public function returnProduct($amount, $productId, $returnEntry, $loanerid): void
    {
        $productIdLoans = User::find($loanerid)->activeLoans()->where('product_id', $productId);
        foreach ($productIdLoans as $loan) {
            $returnAmount = min($amount, $loan->remainingAmount());
            $returnEntry->loans()->attach($loan->id, ['amount' => $returnAmount]);
            $amount -= $returnAmount;

            if ($amount <= 0) {
                break;
            }
        }
    }
}
