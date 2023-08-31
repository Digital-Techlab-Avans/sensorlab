<?php

namespace App\Http\Controllers;

use App\Models\EmailPreference;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('login.login');
    }

    public function processLogin(Request $request)
    {
        try {
            $email = $this->validateInputEmail($request);
            $this->getAndCreateUser($email);
            $this->validateAdmin($request, $email);

            $this->startSession($request, $email);
            $loggedInUser = User::getLoggedInUser();

            if ($loggedInUser->is_admin) {
                return redirect::route('admin_home');
            }else{
                return redirect::route('loaners_home');
            }

        } catch (ValidationException $e) {
            $message = $e->validator->messages()->messages();
            if (count($message) == 1 && array_key_exists('password', $message)) {
                return redirect::route('login')->with(['password' => $e->getMessage()])->withInput();

            } elseif (array_key_exists('password', $message)) {
                return redirect::route('login')->with(['error' => $message["error"][0], 'password' => true])->withInput();

            }
            return redirect::route('login')->with(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * @throws ValidationException
     */
    private function validateAdmin(Request $request, $email): void
    {
        if (User::where('email', '=', $email)->first()->is_admin == 1 ?? false) {
            if (!isset($request->password)) {
                throw ValidationException::withMessages(['password' => true]);
            } else {
                $attributes = $request->validate([
                    'email' => 'required|email',
                    'password' => 'required'
                ]);
                if (auth()->attempt($attributes)) {
                    $this->startSession($request, $email);
                }
                throw ValidationException::withMessages(["error" => 'De gegevens zijn niet correct', 'password' => true]);
            }
        }
    }

    /**
     * @throws ValidationException
     */
    private function validateInputEmail(Request $request)
    {
        $email = $request->input('email');

        if (empty($email)) {
            throw ValidationException::withMessages(['email' => 'Vul je Avans e-mailadres in.']);
        }

        $mail_match = preg_match('/^.+\..+@(student\.)?avans\.nl$/', $email) != false;
        if (!$mail_match) {
            throw ValidationException::withMessages(['email' => 'Je moet een Avans e-mailadres gebruiken.']);
        }
        return $email;
    }

    public function getAndCreateUser($email)
    {

        if (!$this->userAccountExists($email)) {
            $emailParts = explode('.', strstr($email, '@', true));
            $name = ucwords(end($emailParts));

            User::insert([
                'email' => $email,
                'name' => $name,
            ]);

            EmailPreference::create([
                'user_id' => User::where('email', '=', $email)->first()->id,
            ]);
        }

        return User::getLoggedInUser();
    }

    private function startSession(Request $request, $email): void
    {
        $sessionId = Str::uuid();
        $request->session()->put('session_id', $sessionId);
        $request->session()->put('user_email', $email);
    }

    private function userAccountExists($email): bool
    {
        return User::userExists($email);
    }
}
