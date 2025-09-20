<?php
//Asks user to re-enter password before sensitive actions
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException; // Import this when i want to throw validation errors to user (their own mistake, has nothing to do with the code)
use Illuminate\View\View;
use App\Http\Requests\Auth\ConfirmPasswordRequest;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(ConfirmPasswordRequest $request): RedirectResponse
    {
        // This checks if the entered password matches the currently logged-in user’s email & password
        if (! Auth::guard('web')->validate([ // basically saying " if the user is not logged in or the password is wrong....."
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) { // the 'throw' below only happens if the validation return false
            throw ValidationException::withMessages([ // If the password is wrong, throw a validation error
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time()); // Stores a timestamp in the session that says “user confirmed password now”

        return redirect()->intended(route('dashboard', absolute: false)); // Redirects user to the page they originally wanted to go to (or dashboard if none
    }
}
