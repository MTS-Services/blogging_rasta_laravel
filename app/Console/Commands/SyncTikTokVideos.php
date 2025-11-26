<?php

namespace App\Console\Commands;

use App\Jobs\SyncTikTokVideosJob;
use App\Models\ApplicationSetting;
use App\Services\TikTokService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class SyncTikTokVideos extends Command
{
    protected $signature = 'app:sync-tiktok-videos';

    protected $description = 'Dispatches a job to synchronize the latest videos from configured featured TikTok users.';

    public function handle()
    {
        $this->info('Dispatching TikTok video synchronization job...');

        SyncTikTokVideosJob::dispatch();

        $this->info('TikTok sync job has been queued successfully.');

        return self::SUCCESS;
    }
}

