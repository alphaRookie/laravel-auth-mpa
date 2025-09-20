<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password; //Brings in Laravel’s built-in password validation rules for complexity and safety

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check(); 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'], // must match current password
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
        ];
    }
}
