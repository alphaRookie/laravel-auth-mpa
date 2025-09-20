<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout; // Imports the Lockout event class. Used to signal the app when too many login attempts happen
use Illuminate\Foundation\Http\FormRequest; // imports Laravel’s base FormRequest class, Handle validation rules and Auto-run before entering your controller
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\RateLimiter; // to track failed attempts and block brute-force attempts
use Illuminate\Support\Str; // helper to generate random tokens
use Illuminate\Validation\ValidationException; // Import this when i want to throw validation errors to user (their own mistake, has nothing to do with the code)
use App\Models\User; // Import the User model to do some validations based on the user data

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool // we expect funtion ro return true, so Laravel allows this request to be processed
    {
        return true; // Returning true means any visitor can attempt login
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array //laravel will run these rules automatically when i call $request->validate() (in controller usually) or use a custom FormRequest
    {
        return [
            // Previously, it was 'email' => ['required', 'string', 'email'],
            'email' => [
                'required',
                'string',
                function ($attribute, $value, $fail) { //we create like this, so user will be blocked if he type randomly (saves time, bcoz we dont check DB)
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) { // !filter_var() checks if the email isnt valid
                        $fail('Please enter a valid email address.');
                    }
                },
            ],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): void // we expect function not to return anything
    {
        $this->ensureIsNotRateLimited(); // Before trying login, check if the user is already blocked for too many failed attempts
        // If not then we can check.....
        
        // CASE: Email not found
        $user = User::where('email', $this->email)->first(); // Find and get the user's email by 'email' in DB. And grab the data from what user typed in 
        if (!$user) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([  // Mistake counter
                'email' => trans('auth.undefined-email'), // Message in lang/auth
            ]);
        }

        // CASE: Wrong password
        if (!Auth::attempt(
            $this->only('email', 'password'), // the way to grab data from the form user typed in
            $this->boolean('remember') // if user checked the checkbox "remember me", will return true. Otherwise false
        )) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([ //Mistake counter
                'password' => trans('auth.incorrect-password'),
            ]);
        }

        RateLimiter::clear($this->throttleKey()); // If login is successful, reset the failed attempts count for this user
    }

    /**
     * Ensure the login request is not rate limited.
     */
    public function ensureIsNotRateLimited(): void 
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) { // Check if user tried to login more than 5 times. If not, just continue
            return;
        }

        event(new Lockout($this)); // If yes, trigger a Lockout event so the app can log or notify or whatever
        $seconds = RateLimiter::availableIn($this->throttleKey()); // Get how many seconds user must wait before trying again

        throw ValidationException::withMessages([ // throw validation error message telling user have to wait for 1 minutes
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        // Basically saying "Make a unique ID based on the user’s email and their IP so the system knows exactly who’s trying too many times."
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());

        /* 
        Why would we track the IP adress too?
            Email is unique for every accounts, But anyone can try logging in with that email from anywhere.
            So, rate limit tracks email + IP to stop one person’s bad tries from blocking others.
            If hacker from IP1 fails, only IP1 gets blocked, you from IP2 can still try
        */
    }
}

