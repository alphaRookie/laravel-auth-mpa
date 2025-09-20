<?php
//LOGIN + LOGOUT (show form + stores user, and destroys session)
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest; // custom request to handle login validation
use Illuminate\Http\RedirectResponse; // When it call in function header, it basically says "This function will return a redirect response"
use Illuminate\Http\Request; // built-in request to handle logout request (rather than making custom request for logout, its overkill)
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request(When the login form is submitted)
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); //Checks email & password from the form. If wrong, kicks user back with an error

        $request->session()->regenerate(); //Generates a new session ID so hackers can’t steal the old one

        return redirect()->intended(route('dashboard', absolute: false)); //📌user will go back to where he previously he was, if there's no redirect to 'dashboard'
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout(); // Logs the user out of the web guard (it's like security mode for web in laravel)

        $request->session()->invalidate(); // Completely clears all session data from storage (old session can't be reused)

        $request->session()->regenerateToken(); // Generates a new CSRF token after logout

        return redirect('/');
    }
}
