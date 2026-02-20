<?php

use App\Http\Controllers\MultiLangController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Frontend\Pages\Home;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\User\UserCreate;
use App\Livewire\User\UserEdit;
use App\Livewire\User\UserList;

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    //     Route::redirect('settings', 'settings/profile');

    //     Route::get('settings/profile', Profile::class)->name('settings.profile');
    //     Route::get('settings/password', Password::class)->name('settings.password');
    //     Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::post('language', [MultiLangController::class, 'langChange'])->name('lang.change');

require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';

// Individual user page by username (must be after /user/account so "account" is not captured)
Route::get('/user/{username}', function ($username) {
    return view('tiktok-single-user', ['username' => $username]);
})->name('user.profile');

require __DIR__ . '/admin.php';
require __DIR__ . '/frontend.php';
// require __DIR__ . '/fortify-admin.php';
