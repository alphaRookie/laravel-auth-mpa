<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// The page that users see after logging in
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// the profile page (shows what can we update)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Patch/Put is to update existing data
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::patch('/profile/picture', [ProfileController::class, 'profilePicture'])->name('profile.picture'); // Update profile picture
Route::patch('/login', [ProfileController::class])->name('social.redirect');
});


require __DIR__.'/auth.php';
