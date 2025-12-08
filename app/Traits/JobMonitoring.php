<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Trait for monitoring job progress
 * Can be used in jobs to update and track progress
 */
trait JobMonitoring
{
    /**
     * Job ID for tracking
     */
    protected $jobId;

    /**
     * Job type
     */
    protected $jobType;

    /**
     * Initialize job monitoring
     *
     * @param string $type
     * @return void
     */
    protected function initializeJobMonitoring(string $type)
    {
        $this->jobType = $type;
        $this->jobId = uniqid($type . '_', true);
    }

    /**
     * Update job progress
     *
     * @param int $progress (0-100)
     * @param string $message
     * @param bool $completed
     * @param array $data
     * @return void
     */
    protected function updateJobProgress(
        int $progress,
        string $message,
        bool $completed = false,
        array $data = []
    ) {
        $cacheKey = "job_progress:{$this->jobType}:{$this->jobId}";

        $progressData = [
            'job_id' => $this->jobId,
            'type' => $this->jobType,
            'progress' => min(100, max(0, $progress)), // Clamp between 0-100
            'message' => $message,
            'completed' => $completed,
            'data' => $data,
            'updated_at' => now()->toDateTimeString()
        ];

        Cache::put($cacheKey, $progressData, now()->addHours(24));

        Log::debug("Job progress updated", [
            'job_id' => $this->jobId,
            'type' => $this->jobType,
            'progress' => $progress,
            'message' => $message
        ]);
    }

    /**
     * Mark job as failed
     *
     * @param string $errorMessage
     * @param array $additionalData
     * @return void
     */
    protected function markJobAsFailed(string $errorMessage, array $additionalData = [])
    {
        $this->updateJobProgress(
            100,
            'Job failed: ' . $errorMessage,
            true,
            array_merge(['error' => $errorMessage], $additionalData)
        );

        Log::error("Job marked as failed", [
            'job_id' => $this->jobId,
            'type' => $this->jobType,
            'error' => $errorMessage,
            'additional_data' => $additionalData
        ]);
    }

    /**
     * Get current job progress from cache
     *
     * @return array|null
     */
    protected function getJobProgress()
    {
        $cacheKey = "job_progress:{$this->jobType}:{$this->jobId}";
        return Cache::get($cacheKey);
    }

    /**
     * Clear job progress from cache
     *
     * @return void
     */
    protected function clearJobProgress()
    {
        $cacheKey = "job_progress:{$this->jobType}:{$this->jobId}";
        Cache::forget($cacheKey);
    }

    /**
     * Get job ID
     *
     * @return string
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * Calculate percentage progress
     *
     * @param int $current
     * @param int $total
     * @return int
     */
    protected function calculateProgress(int $current, int $total): int
    {
        if ($total === 0) {
            return 0;
        }

        return (int) (($current / $total) * 100);
    }

    /**
     * Format progress message
     *
     * @param string $action
     * @param int $current
     * @param int $total
     * @param string $itemIdentifier
     * @return string
     */
    protected function formatProgressMessage(
        string $action,
        int $current,
        int $total,
        string $itemIdentifier = ''
    ): string {
        $identifier = $itemIdentifier ? " {$itemIdentifier}" : '';
        return "{$action}{$identifier} ({$current}/{$total})";
    }

    /**
     * Log job start
     *
     * @param array $parameters
     * @return void
     */
    protected function logJobStart(array $parameters = [])
    {
        Log::info("Job started: {$this->jobType}", array_merge([
            'job_id' => $this->jobId,
            'type' => $this->jobType
        ], $parameters));
    }

    /**
     * Log job completion
     *
     * @param array $result
     * @return void
     */
    protected function logJobCompletion(array $result = [])
    {
        Log::info("Job completed: {$this->jobType}", array_merge([
            'job_id' => $this->jobId,
            'type' => $this->jobType
        ], $result));
    }

    /**
     * Sleep with microseconds for throttling
     *
     * @param int $microseconds
     * @return void
     */
    protected function throttle(int $microseconds = 500000)
    {
        usleep($microseconds);
    }
}
