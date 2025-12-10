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

class CleanupUnusedTiktokVideosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Max retry attempts.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Job timeout (seconds).
     *
     * @var int
     */
    public $timeout = 1800;

    /**
     * Delay before retrying.
     *
     * @var array
     */
    public $backoff = [60, 300, 900];

    /**
     * Delete the job when models are missing.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * Debug mode toggle.
     *
     * @var bool
     */
    protected bool $debug;

    /**
     * Create a new job instance.
     */
    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    /**
     * Execute the job.
     */
    public function handle(TikTokService $tiktokService): void
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '1800');
        Log::info('Cleanup unused TikTok videos job started.', [
            'debug_mode' => $this->debug
        ]);

        try {

            // Call service to perform the cleanup
            $result = $tiktokService->cleanupUnusedLocalVideos($this->debug);

            if ($result['success']) {
                $message = sprintf(
                    'Cleanup completed successfully! Deleted: %d | Unused Found: %d | Debug: %s',
                    $result['deleted'],
                    $result['unused_count'],
                    $this->debug ? 'YES' : 'NO'
                );

                Log::info($message);
            } else {
                $errorMessage = 'TikTok cleanup failed.';
                Log::error($errorMessage);
                throw new \RuntimeException($errorMessage);
            }

        } catch (Throwable $e) {

            Log::error('Cleanup unused TikTok videos job failed: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // Re-throw to allow retry
            throw $e;
        }
    }

    /**
     * Handle permanent job failure after retries.
     */
    public function failed(Throwable $exception): void
    {
        Log::critical('Cleanup unused TikTok videos job FAILED after all retries.', [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);

        // Optional: Send notification to admin
        // Notification::route('mail', config('app.admin_email'))
        //     ->notify(new CleanupFailedNotification($exception));
    }
}
