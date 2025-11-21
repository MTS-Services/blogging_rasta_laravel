<?php

namespace App\Console\Commands;

use App\Services\TikTokService;
use Illuminate\Console\Command;
use Throwable; // Import Throwable for catching all errors/exceptions

class SyncTikTokVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-tiktok-videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronizes the latest videos from configured featured TikTok users.';

    /**
     * Execute the console command.
     */
    public function handle(TikTokService $tiktokService)
    {
        $this->info('Starting TikTok video synchronization...');

        try {
            // 1. Get the list of featured users from the configuration
            $users = config('tiktok.featured_users', []);

            if (empty($users)) {
                $this->warn('No featured TikTok users found in configuration.');
                return self::SUCCESS; // Exit successfully if there's nothing to do
            }

            $this->comment('Found ' . count($users) . ' users to process.');

            // 2. Execute the sync logic via the Service layer
            // The TikTokService is injected directly into the handle method (Method Injection)
            // which is a standard Laravel practice.
            $tiktokService->syncVideos($users);

            $this->info('TikTok video synchronization completed successfully!');

            return self::SUCCESS;

        } catch (Throwable $e) {
            // 3. Handle any exceptions or errors during the process
            $this->error('An error occurred during synchronization!');
            $this->error($e->getMessage()); // Display the error message

            // Optionally log the full exception stack trace for debugging
            $this->getOutput()->writeln('<error>' . $e->getTraceAsString() . '</error>');

            // Return a failure status code
            return self::FAILURE;
        }
    }
}
