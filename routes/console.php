<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:sync-tiktok-videos')
    ->daily()
    ->withoutOverlapping()
    ->onSuccess(function () {
        \Log::info('TikTok video synchronization completed successfully via scheduled task.');
    })
    ->onFailure(function () {
        \Log::error('TikTok video synchronization failed via scheduled task.');
    });
