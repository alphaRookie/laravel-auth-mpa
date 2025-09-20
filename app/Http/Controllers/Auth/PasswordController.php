<?php
//LET LOGGED-IN USER CHANGE THEIR PASSWORD
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse; //when it call in function header, it basically says "This function will return a redirect response"
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\ChangePasswordRequest;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(ChangePasswordRequest $request): RedirectResponse
    {
        $request->user()->update([ //get the currect logged-in user and update their password
            'password' => Hash::make($request['password']),
        ]);

        return back()->with('status', 'password-updated'); // save the session flash message with key name 'status'
    }
}


/* 
$request->validateWithBag()
    - This is like $request->validate(), but Errors are stored in a named error bag called "updatePassword".
    - Error bags are useful when you have multiple forms on the same page and you want their errors separated.

    Example: If you had a "Change Email" form and a "Change Password" form on one page, you don’t want the password form’s errors to show up under the email form.
*/