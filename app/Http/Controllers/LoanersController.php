<?php

    namespace App\Http\Controllers;

    use App\Models\Category;
    use App\Models\Product;
    use App\Models\ReturnStatus;
    use App\Models\User;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;

    class LoanersController extends Controller
    {

        public function dashboard(): Factory|View|Application
        {
            $categories = Category::allActive()->orderBy('name', 'asc')->get();
            $productRows =
                [
                    'Uitgelichte producten' => Product::featuredProducts()->get(),
                ];
            return view('loaners.home_page', ['categories' => $categories, 'productRows' => $productRows]);
        }

        public function returns(): Factory|View|Application
        {
            // get the current user model
            $user = User::getLoggedInUser();
            // order list by returned_at date
            $returns = $user->returns()->sortByDesc('returned_at');
            $pendingReturns = $returns?->where('status_id', ReturnStatus::getPendingId()) ?? [];
            $acceptedReturns = $returns?->where('status_id', ReturnStatus::getApprovedId()) ?? [];
            $declinedReturns = $returns?->where('status_id', ReturnStatus::getRejectedId()) ?? [];
            return view('loaners.returns', ['returns' => $returns, 'pendingReturns' => $pendingReturns, 'acceptedReturns' => $acceptedReturns, 'declinedReturns' => $declinedReturns]);
        }

    }
