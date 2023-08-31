<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::getLoggedInUser();
        if ($user == null) {
            return $next($request);
        } elseif ($user->is_admin) {
            return redirect()->route('admin_home');
        } else {
            return redirect()->route('loaners_home');
        }
    }
}
