<?php

use App\Http\Controllers\Frontend\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\VideoFeedController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/video-feed', [VideoFeedController::class,'index'])->name('video-feed');
Route::get('/product', [ProductController::class, 'product'])->name('product');
Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
Route::get('/blog/details', [BlogController::class, 'details'])->name('blog.details');
