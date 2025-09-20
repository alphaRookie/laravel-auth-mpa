<?php
//SEND RESET PASSWORD LINK TO EMAIL
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'], //  It checks if user typed in an email and if it looks like a real email
        ]);

        // Tries to send a password reset email to the address user gave
        // Saves the result (success or fail) in $status
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT // Checks if the result from sending the reset link was successful
                    ? back()->with('status', __($status)) // ? means 'if true'.. send the user back and show the success message
                    : back()->withInput($request->only('email')) // : means 'if false'.. send the user back with the email they typed in, and 
                        ->withErrors(['email' => __($status)]);  // show an error message
    }
}
