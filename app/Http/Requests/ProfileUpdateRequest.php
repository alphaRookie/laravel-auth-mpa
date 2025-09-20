<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
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
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id), // Must be unique in the users table BUT ignores the current logged-in user’s email (so you don’t get an error if you keep your own email)
            ],
            'birthdate' => ['required', 'date', 'before:today'], #addedbyme  //When you submit the profile update form, Laravel will check birthdate too in the request
        ];
    }
}

/* 
What this does:
    Checks if your new name and email are okay when you update your profile.
    Makes sure your email looks like a real email and is not used by other people.
    If you keep your same email, it doesn’t complain.
    It also makes sure the email is in lowercase.
*/