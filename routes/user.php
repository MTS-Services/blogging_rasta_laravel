<?php

use App\Livewire\Frontend\UserProfile;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:web', 'userVerify'])->prefix('user')->name('user.')->group(function () {
    Route::get('account', UserProfile::class)->name('account');
});
