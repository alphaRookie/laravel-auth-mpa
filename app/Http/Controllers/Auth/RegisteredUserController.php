<?php
//HANDLE REGISTRATION (show form + stores user and and triggers the event that sends the verification email)
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; //Brings in the User model so you we can create new users in the DB
use Illuminate\Auth\Events\Registered; //Import event class that’s triggered after a new user registers (used to send verification emails, etc.)
//
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules; //For password validation rules like min length, complexity, etc
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request): RedirectResponse // Takes in the request data (form inputs)
    {
        $user = User::create([ //Creates a new user in the database with the given data by user
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthdate' => $request->birthdate, #addedbyme
        ]);

        event(new Registered($user));    // Triggers a "Registered" event so Laravel can do things like send a verification email

        Auth::login($user); // Logs in the new user immediately, no need for them to manually login after registering

        return redirect(route('dashboard', absolute: false)); // user will go back to where he previously he was
    }
}
