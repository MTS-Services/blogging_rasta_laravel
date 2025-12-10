<?php

namespace App\Jobs;

use App\Services\TikTokService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateEmptyVideosJob implements ShouldQueue
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
        Log::info('Update empty videos job started.');

        try {


            // Execute sync
            $result = $tiktokService->updateEmptyVideos();

            if ($result['success']) {
                $message = sprintf(
                    'Updated empty videos successfully! Updated: %d, Total: %d',
                    $result['updated'],
                    $result['total_found']
                );
                Log::info($message);
            } else {
                $errorMessage = 'Failed to update empty videos';
                Log::error($errorMessage);
                throw new \RuntimeException($errorMessage);
            }
        } catch (Throwable $e) {
            Log::error('Update empty videos job failed: ' . $e->getMessage(), [
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
        Log::critical('Update empty videos job failed after all retry attempts.', [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);

        // You can add notification logic here (e.g., send email to admin)
        // Notification::route('mail', config('app.admin_email'))
        //     ->notify(new TikTokSyncFailedNotification($exception));
    }
}
