<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product', [ProductController::class, 'product'])->name('product');
// Route::get('/', function () {
//     return redirect(
//         route('admin.login')
//     );
// })->name('home');
