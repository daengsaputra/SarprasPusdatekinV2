<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Use a single login field that accepts email or username.
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Validate the login request.
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);
    }

    /**
     * Build credentials for email-or-username login.
     */
    protected function credentials(Request $request)
    {
        $login = trim((string) $request->input('login'));
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if ($field === 'email') {
            $login = strtolower($login);
        }

        return [
            $field => $login,
            'password' => $request->input('password'),
        ];
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Limit login attempts to reduce brute-force attacks.
     */
    protected function maxAttempts()
    {
        return 5;
    }

    /**
     * Lockout window in minutes.
     */
    protected function decayMinutes()
    {
        return 1;
    }

    /**
     * The user has been authenticated.
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect($this->redirectPath())->with('success', 'Berhasil login!');
    }

    /**
     * Send the response after the user was authenticated.
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        return redirect($this->redirectPath())->with('success', 'Berhasil login!');
    }

    /**
     * Send the response after the user was unsuccessfully authenticated.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ])->redirectTo(route('login'));
    }

    /**
     * Redirect users to login page after logout.
     */
    protected function loggedOut($request)
    {
        return redirect('/login')->with('status', 'Logout berhasil. Sampai jumpa!');
    }
}
