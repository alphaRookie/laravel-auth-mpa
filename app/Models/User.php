<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * $fillable tells laravel: "These are the columns I allow to be mass-assigned into the model."
     * @var list<string>
     */
    protected $fillable = [ //$fillable controls what you can mass assign (bulk assign) to the model
        'name',
        'birthdate',
        'email',
        'password', #addedbyme
        'profile_picture', // addedbyme
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* No need to type if else stuffs in blade whenever we want to show either default avatar or updated user's image 
        Just call "->profile_picture_url" whenever we need
    */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture && Storage::disk('public')->exists($this->profile_picture)) { // Check if profile_picture exists and is stored in storage
            return asset('storage/' . $this->profile_picture); //return the URL to the profile_picture so it can be displayed in the views
        }
        // default avatar
        return asset('images/default-avatar.svg');
    }
}
