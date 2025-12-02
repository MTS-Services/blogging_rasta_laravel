<?php

namespace App\Jobs;

use App\Models\ApplicationSetting;
use App\Models\TikTokUser;
use App\Services\TikTokService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SyncTikTokVideosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The maximum number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = [60, 300, 900];

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(TikTokService $tiktokService): void
    {
        Log::info('TikTok video synchronization job started.');

        try {
            // Get the featured users and decode JSON
            $users = TikTokUser::active()->get();

            if (empty($users)) {
                Log::warning('No featured_users setting found in application settings.');
                return;
            }


            if (empty($users) || count($users) < 1) {
                Log::warning('Featured users configuration is empty or invalid.');
                return;
            }

            // Execute sync
            $result = $tiktokService->syncVideos($users);

            // Handle result
            if ($result['success']) {
                $message = sprintf(
                    'TikTok sync completed successfully! New: %d, Updated: %d, Total: %d',
                    $result['synced'],
                    $result['updated'],
                    $result['total']
                );
                Log::info($message);
            } else {
                $errorMessage = 'TikTok sync failed: ' . ($result['error'] ?? 'Unknown error');
                Log::error($errorMessage);
                throw new \RuntimeException($errorMessage);
            }
        } catch (Throwable $e) {
            Log::error('TikTok sync job exception: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // Re-throw to trigger job retry mechanism
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        Log::critical('TikTok sync job failed after all retry attempts.', [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);

        // You can add notification logic here (e.g., send email to admin)
        // Notification::route('mail', config('app.admin_email'))
        //     ->notify(new TikTokSyncFailedNotification($exception));
    }
}
