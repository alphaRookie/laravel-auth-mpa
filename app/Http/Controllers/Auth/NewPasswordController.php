<?php
//AFTER CLICKING RESET LINK (SHOW FORM + STORE NEW PASSWORD)
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str; // helper to generate random tokens
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(ForgotPasswordRequest $request): View
    {
        // Passes the whole $request along, so the form has access to the reset token and email
        // Why? The form needs to know which user wanna reset their password
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ForgotPasswordRequest $request): RedirectResponse
    {
        // Here we will attempt to reset the user's password. If it is successful we...
            // will update the password on an actual user model and persist it to the DB
            // Otherwise we will parse the error and return the response.

        $status = Password::reset( //Laravel built-in function that handles the entire password reset proces
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([ // forces the model to store these values, ignoring mass assignment protection.
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user)); // Broadcasts a message that password reset happened, so other parts of the system can respond
            }
        );

        // If reset was successful, redirects user to login page with a success message.
        // If failed, sends user back to the form with email input preserved and shows error messages.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
