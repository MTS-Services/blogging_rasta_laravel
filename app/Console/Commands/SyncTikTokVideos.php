<?php

namespace App\Console\Commands;

use App\Models\ApplicationSetting;
use App\Services\TikTokService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class SyncTikTokVideos extends Command
{
    protected $signature = 'app:sync-tiktok-videos';
    protected $description = 'Synchronizes the latest videos from configured featured TikTok users.';

    public function handle(TikTokService $tiktokService)
    {
        $this->info('Starting TikTok video synchronization...');

        try {
            // Get the featured users and decode JSON
            $usersJson = ApplicationSetting::where('key', 'featured_users')
                ->pluck('value')
                ->first();

            $users = json_decode($usersJson, true);

            Log::info("Starting TikTok Sync for users: " . implode(', ', array_column($users, 'username')));

            if (empty($users) || !is_array($users)) {
                $this->warn('No featured TikTok users found in configuration.');
                return self::SUCCESS;
            }

            // Execute sync
            $result = $tiktokService->syncVideos($users);

            // Handle result
            if ($result['success']) {
                $message = sprintf(
                    'Sync completed! New: %d, Updated: %d, Total: %d',
                    $result['synced'],
                    $result['updated'],
                    $result['total']
                );
                $this->info($message);
                Log::info($message);
                return self::SUCCESS;
            } else {
                $error = 'Sync failed: ' . ($result['error'] ?? 'Unknown error');
                $this->error($error);
                Log::error($error);
                return self::FAILURE;
            }

        } catch (Throwable $e) {
            $error = 'TikTok sync exception: ' . $e->getMessage();
            $this->error($error);
            Log::error($error, [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return self::FAILURE;
        }
    }
}
