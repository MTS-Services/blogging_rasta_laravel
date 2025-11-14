<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/', function () {
//     return redirect(
//         route('admin.login')
//     );
// })->name('home');
// routes/web.php
