<?php

use App\Http\Controllers\Backend\Admin\AboutCmsController;
use App\Http\Controllers\Backend\Admin\VideoManagementController;
use App\Http\Controllers\SitemapController;
use Firebase\JWT\Key;
use App\Livewire\Frontend\Blog;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\BlogController;
use App\Http\Controllers\Backend\Admin\KeywordController;
use App\Http\Controllers\Backend\Admin\AuditingController;
use App\Http\Controllers\Backend\Admin\Settings\LanguageController;
use App\Http\Controllers\Backend\Admin\UserManagement\UserController;
use App\Http\Controllers\Backend\Admin\TikTokManagement\UserController as TikTokUserController;
use App\Http\Controllers\Backend\Admin\UserManagement\AdminController;
use App\Http\Controllers\Backend\Admin\BannerVideo\BannerVideoController;
use App\Http\Controllers\Backend\Admin\ProductManagement\ProductController;
use App\Http\Controllers\Backend\Admin\ProductManagement\CategoryController;
use App\Http\Controllers\Backend\Admin\TikTokManagement\TikTokMixedFeedController;
use App\Http\Controllers\Backend\Admin\TikTokManagement\UserCategoryController;
use App\Http\Controllers\Backend\Admin\ApplicationSettings\ApplicationSettingsController;
use App\Http\Controllers\Backend\Admin\ContactController;

Route::middleware(['auth:admin', 'admin', 'adminVerify'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.admin.pages.dashboard');
    })->name('dashboard');


    // Dashboard
    // Route::controller(VideoManagementController::class)->name('vm.')->prefix('video-management')->group(function () {
    //     Route::get('/', 'index')->name('index');

    //     // Actions - Remove nested prefix
    //     Route::post('/redownload-missing', 'redownloadMissing')->name('redownload-missing');
    //     Route::post('/cleanup-expired', 'cleanupExpired')->name('cleanup-expired');
    //     Route::post('/delete-old', 'deleteOld')->name('delete-old');
    //     Route::post('/verify-fix', 'verifyAndFix')->name('verify-fix');
    //     Route::get('/statistics', 'getStatistics')->name('statistics');
    // });


    Route::controller(VideoManagementController::class)
        ->name('vm.')
        ->prefix('video-management')
        ->group(function () {
            // Main dashboard
            Route::get('/', 'index')->name('index');

            // Job dispatch endpoints
            Route::post('/redownload-missing', 'redownloadMissing')->name('redownload-missing');
            Route::post('/cleanup-expired', 'cleanupExpired')->name('cleanup-expired');
            Route::post('/delete-old', 'deleteOld')->name('delete-old');
            Route::post('/verify-fix', 'verifyAndFix')->name('verify-fix');

            // Monitoring endpoints
            Route::get('/job-progress', 'getJobProgress')->name('job-progress');
            Route::get('/statistics', 'getStatistics')->name('statistics');
        });
    Route::group(['prefix' => 'user-management', 'as' => 'um.'], function () {

        Route::controller(AdminController::class)->name('admin.')->prefix('admin')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });

        Route::controller(UserController::class)->name('user.')->prefix('user')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
            Route::get('/profile-info/{id}', 'profileInfo')->name('profileInfo');
            Route::get('/shop-info/{id}', 'shopInfo')->name('shopInfo');
            Route::get('/kyc-info/{id}', 'kycInfo')->name('kycInfo');
            Route::get('/statistic/{id}', 'statistic')->name('statistic');
            Route::get('/referral/{id}', 'referral')->name('referral');
        });
    });

    Route::controller(ContactController::class)->name('contact.')->prefix('contact')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/view/{id}', 'view')->name('view');
        Route::get('/trash', 'trash')->name('trash');
    });
    Route::controller(BlogController::class)->name('blog.')->prefix('blog')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::get('/view/{id}', 'view')->name('view');
        Route::get('/trash', 'trash')->name('trash');
    });

    Route::group(['prefix' => 'application-settings', 'as' => 'as.'], function () {

        Route::controller(ApplicationSettingsController::class)->prefix('application-settings')->group(function () {
            Route::get('/general-settings', 'generalSettings')->name('general-settings');
            Route::get('/database-settings', 'databaseSettings')->name('database-settings');
            Route::get('/tik-tok-settings', 'tikTokSettings')->name('tik-tok-settings');
        });
    });

    Route::group(['prefix' => 'audit-log-management', 'as' => 'alm.'], function () {
        Route::controller(AuditingController::class)->name('audit.')->prefix('audit')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });
    });

    Route::get('banner-video', [BannerVideoController::class, 'index'])->name('banner-video');
    Route::get('about-cms', [AboutCmsController::class, 'index'])->name('about-cms');

    Route::controller(KeywordController::class)->name('keyword.')->prefix('keyword')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::get('/view/{id}', 'view')->name('view');
        Route::get('/trash', 'trash')->name('trash');
    });


    Route::group(['prefix' => 'product-management', 'as' => 'pm.'], function () {
        Route::controller(CategoryController::class)->name('category.')->prefix('category')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });

        Route::controller(ProductController::class)->name('product.')->prefix('product')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });

    });

    Route::group(['prefix' => 'tiktok-management', 'as' => 'tm.'], function () {
        Route::controller(UserCategoryController::class)->name('user-category.')->prefix('user-category')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });

        Route::controller(TikTokUserController::class)->name('user.')->prefix('user')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });



    });

    Route::get('/sitemap-generate', [SitemapController::class, 'generate'])->name('sitemap.generate');


    Route::controller(TikTokMixedFeedController::class)->prefix('tiktok-videos')->group(function () {
        Route::get('/', 'index')->name('tiktok-videos');
        Route::get('/keyword{id}', 'videoKeyword')->name('video-keyword');
    });
});
