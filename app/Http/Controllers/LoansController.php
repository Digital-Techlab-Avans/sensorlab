<?php

    namespace App\Http\Controllers;

    use App\Models\Category;
    use App\Models\LoanEntry;
    use App\Models\Product;
    use App\Models\ReturnStatus;
    use App\Models\User;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;

    class LoansController extends Controller
    {

        public function updateLoan(Request $request, $loan): RedirectResponse
        {
            $request->merge([
                'due_date' => date('Y-m-d H:i:s', strtotime($request->get('due_date')))
            ]);

            $request->validate([
                'due_date' => 'required|dateformat:Y-m-d H:i:s',
                'amount' => 'required|numeric|min:1'
            ]);

            $loanId = $loan ?? null;
            try {
                $loan = LoanEntry::class::find($loanId);
                $loan->due_at = $request->input('due_date');
                $loan->amount = $request->input('amount');
                $loan->save();
                $loaner = User::find($loan->user_id);
                // keep the state of the page with all the filters
                return redirect()->back()->with('success', "De lening van {$loaner->name} voor {$loan->product->name} is aangepast.");
            } catch (\Exception $e) {
                return redirect()->back()->with('error', "Er is iets misgegaan bij het aanpassen van de lening.");
            }

        }

    }
