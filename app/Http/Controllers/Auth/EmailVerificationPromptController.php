<?php
//Shows a page that asks the user to verify their email if they haven’t done it yet
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View // make controller acts like a function (used for single-action controllers)
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false)) // If verified (true): Redirect user to the dashboard (or wherever they were trying to go)
                    : view('auth.verify-email'); // If not verified (false): Show the verify email page (auth.verify-email view)
    }
}
