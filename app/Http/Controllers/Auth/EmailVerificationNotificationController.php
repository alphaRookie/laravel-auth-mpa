<?php
//Lets users resend the verification email if they didn’t get or lost the original one
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) { // Checks if the user’s email is already verified
            return redirect()->intended(route('dashboard', absolute: false)); // If yes, no need to resend, so redirect them to dashboard immediately
        }

        $request->user()->sendEmailVerificationNotification(); // If not verified yet, send the verification email again to the logged-in user

        return back()->with('status', 'verification-link-sent'); // Sends the user back to the page they came from and flash a message
    }
}
