<?php

use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/', function () {
//     return redirect(
//         route('admin.login')
//     );
// })->name('home');


Route::group(['as' => 'f.'], function () {
    Route::controller(FrontendController::class)->group(function () {
        Route::get('home', 'home')->name('home');
        Route::get('products', 'products')->name('products');
    });
});