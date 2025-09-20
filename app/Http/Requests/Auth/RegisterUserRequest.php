<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // anyone can try to register
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                function ($attribute, $value, $fail) { // user will be blocked if he type randomly (saves time, bcoz we dont check DB)
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) { // !filter_var() checks if the email isnt valid
                        $fail('Please enter a valid email address.');
                    }
                },
                'max:255', 
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                Password::min(8) // minimum 8 chars
                    ->mixedCase()  // must contain uppercase and lowercase
                    ->numbers(),    // must have numbers
                    # ->symbols(),   // must have symbols like !@#$%
                // 'confirmed' → Previously we put this to check if both password fields matches (but the message that belongs to 'password_confirmation' appeared in this field too)
            ],
            'password_confirmation' => ['required', 'string', 'confirmed:password'], // same:password → Laravel checks password_confirmation == password
            'birthdate' => ['required', 'date', 'before:today'], #addedbyme
        ];
    }
}
