<?php
//Handles the actual verification when the user clicks the link in the email to confirm their address
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified; // triggered event after user’s email is verified, so other code can hear and react 
use Illuminate\Foundation\Auth\EmailVerificationRequest; // It's SPECIAL REQUEST class makes sure the verification link is valid and user is legit 
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) { // Checks if the logged-in user already verified their email
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1'); // Redirect them to dashboard with ?verified=1 in URL (to show a “you’re verified” message)
        }

        if ($request->user()->markEmailAsVerified()) { // If the user’s email is not verified yet, mark it as verified
            event(new Verified($request->user())); // trigger event that the user’s email is verified, so other parts of the system can respond 
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1'); // Your dashboard page can see verified=1 in the URL and show a pop-up or banner saying “Email verified!”
    }
}
