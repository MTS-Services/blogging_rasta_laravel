<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\StaticController;

use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\VideoFeedController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/video-feed', [VideoFeedController::class,'index'])->name('video-feed');
Route::get('/product', [ProductController::class, 'product'])->name('product');
Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
Route::get('/blog/details/{slug}', [BlogController::class, 'details'])->name('blog.details');
Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/PrivacyPolicy', [StaticController::class, 'PrivacyPolicy'])->name('PrivacyPolicy');
Route::get('/TermsOfService', [StaticController::class, 'TermsOfService'])->name('TermsOfService');
Route::get('/affiliate', [StaticController::class, 'affiliate'])->name('affiliate');
Route::get('/support', [StaticController::class, 'support'])->name('support');
Route::get('/contact', [StaticController::class, 'contact'])->name('contact');
