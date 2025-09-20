<?php
//LET LOGGED-IN USER CHANGE THEIR PROFILE (Email, Name, etc.)
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect; // another to redirect like below instead of  redirect()->route('...')
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(), // Passes that user data to the profile.edit Blade view so the form can be pre-filled with their current info
        ]);
    }

    /**
     * Update the user's profile information (Name, Email, Birthdate)
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user(); // Grab the currently logged-in user and store it in $user

        $data = $request->validated(); // collect validated data first, DO NOT directly fill() before processing uploaded files.
        $user->fill($data); // 📌fill() takes that array and assigns each key to the matching column in $fillable in Model (only if it’s available) 📌

        // If nothing has changed, bounce back
        if (! $user->isDirty()) { // ! $user->isDirty() → means "if there nothing changed"
            return back()->with('info_status', 'no-changes');
        }

        if ($user->isDirty('email')) { // If the email field has changed
            $user->email_verified_at = null; // set the email_verified_at to null, so user must verify the new email
        }

        $user->save(); // save the user to DB

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     *  Set/Update profile picture.
     */
    public function profilePicture(Request $request): RedirectResponse
    {
        // validate that if profile_picture exists, it must be an image (nullable allowed)
        $request->validate([
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], // Validate the uploaded file
        ]);

        $user = $request->user(); // Get the currently logged-in user info

        if ($request->hasFile('profile_picture')) { //Check is there new file uploaded?
            // delete old picture if exists in storage
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // store new file and save path
            $path = $request->file('profile_picture')->store('profile_pictures','public');
            $user->profile_picture = $path;
            $user->save();

            return back()->with('status','profile-picture-updated');
        }

        // else: no file uploaded — nothing changed
        return back()->with('photo_status', 'no-changes');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Handle profile picture deletion
        $user = $request->user();
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // set null di DB supaya accessor fallback ke default
        $user->profile_picture = null;
        $user->save();

        // Handle user deletion
        $request->validateWithBag('userDeletion', [ // run validation and stores the error messages in a named error bag called userDeletion
            'password' => ['required', 'current_password'], // Requires the password field and checks it against the current logged-in password
        ]);

        $user = $request->user(); // Store the logged-in user in $user before doing anything destructive

        Auth::logout(); // Logs them out immediately so they can’t keep browsing with an active session

        $user->delete(); // Deletes the user record from the database

        $request->session()->invalidate(); // Wipes the session so it’s no longer valid
        $request->session()->regenerateToken(); // Creates a brand new CSRF token

        return Redirect::to('/');
    }
}

/* 
Update info: "Did the user change something in the database?" → isDirty matches.
Photo upload: "Are there any new files in the form?" → just hasFile(), no need for isDirty.
*/