<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'userVerify'])->prefix('user')->name('user.')->group(function () {
    //
});
