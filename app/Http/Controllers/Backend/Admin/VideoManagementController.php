<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\CleanupUnusedTiktokVideosJob;
use App\Jobs\RedownloadMissingVideosJob;
use App\Jobs\CleanupExpiredVideosJob;
use App\Jobs\VerifyAndFixBrokenVideosJob;
use App\Jobs\DeleteOldVideosJob;
use App\Services\VideoManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class VideoManagementController extends Controller
{
    protected $videoManagementService;

    public function __construct(VideoManagementService $videoManagementService)
    {
        $this->videoManagementService = $videoManagementService;
    }

    /**
     * Display the video management dashboard
     */
    public function index()
    {
        // Get statistics
        $statsResult = $this->videoManagementService->getStorageStatistics();
        $stats = $statsResult['success'] ? $statsResult['statistics'] : [];

        return view('backend.admin.pages.video_manager', compact('stats'));
    }

    /**
     * Redownload missing videos (Dispatch Job)
     */
    public function redownloadMissing(Request $request)
    {
        try {
            $validated = $request->validate([
                'limit' => 'nullable|integer|min:1|max:500',
                'force' => 'nullable|boolean'
            ]);

            $limit = $validated['limit'] ?? 50;
            $force = $validated['force'] ?? false;

            Log::info("Dispatching RedownloadMissingVideosJob", [
                'limit' => $limit,
                'force' => $force
            ]);

            // Dispatch the job
            $job = new RedownloadMissingVideosJob($limit, $force);
            dispatch($job);

            return response()->json([
                'success' => true,
                'message' => 'Redownload job has been queued. It will process in the background.',
                'job_id' => $job->jobId ?? null
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error("Failed to dispatch redownload job", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to queue job: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cleanup expired videos (Dispatch Job)
     */
    public function cleanupExpired(Request $request)
    {
        try {
            $validated = $request->validate([
                'older_than_days' => 'nullable|integer|min:1|max:365',
                'delete_inactive' => 'nullable|boolean'
            ]);

            $olderThanDays = $validated['older_than_days'] ?? 7;
            $deleteInactive = $validated['delete_inactive'] ?? false;

            Log::info("Dispatching CleanupExpiredVideosJob", [
                'older_than_days' => $olderThanDays,
                'delete_inactive' => $deleteInactive
            ]);

            // Dispatch the job
            $job = new CleanupExpiredVideosJob($olderThanDays, $deleteInactive);
            dispatch($job);

            return response()->json([
                'success' => true,
                'message' => 'Cleanup job has been queued. It will process in the background.',
                'job_id' => $job->jobId ?? null
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error("Failed to dispatch cleanup job", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to queue job: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete old videos (Dispatch Job)
     */
    public function deleteOld(Request $request)
    {
        try {
            $validated = $request->validate([
                'older_than_days' => 'nullable|integer|min:30|max:365',
                'limit' => 'nullable|integer|min:1|max:500'
            ]);

            $olderThanDays = $validated['older_than_days'] ?? 90;
            $limit = $validated['limit'] ?? 100;

            Log::info("Dispatching DeleteOldVideosJob", [
                'older_than_days' => $olderThanDays,
                'limit' => $limit
            ]);

            // Dispatch the job
            $job = new DeleteOldVideosJob($olderThanDays, $limit);
            dispatch($job);

            return response()->json([
                'success' => true,
                'message' => 'Delete job has been queued. It will process in the background.',
                'job_id' => $job->jobId ?? null
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error("Failed to dispatch delete job", [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to queue job: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify and fix broken videos (Dispatch Job)
     */
    public function verifyAndFix(Request $request)
    {
        try {
            $validated = $request->validate([
                'limit' => 'nullable|integer|min:1|max:500'
            ]);

            $limit = $validated['limit'] ?? 100;

            Log::info("Dispatching VerifyAndFixBrokenVideosJob", ['limit' => $limit]);

            // Dispatch the job
            $job = new VerifyAndFixBrokenVideosJob($limit);
            dispatch($job);

            return response()->json([
                'success' => true,
                'message' => 'Verify job has been queued. It will process in the background.',
                'job_id' => $job->jobId ?? null
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error("Failed to dispatch verify job", [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to queue job: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get job progress
     */
    public function getJobProgress(Request $request)
    {
        try {
            $validated = $request->validate([
                'job_id' => 'required|string',
                'type' => 'required|in:redownload,cleanup,verify,delete'
            ]);

            $jobId = $validated['job_id'];
            $type = $validated['type'];

            $cacheKey = "job_progress:{$type}:{$jobId}";
            $progress = Cache::get($cacheKey);

            if (!$progress) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job progress not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $progress
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error("Failed to get job progress", [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get job progress: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current statistics
     */
    public function getStatistics()
    {
        try {
            $result = $this->videoManagementService->getStorageStatistics();

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'data' => $result['statistics']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to get statistics'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error("Get statistics error", [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteUnusedVideos()
    {
        try {
            // Dispatch the job
            $job = new CleanupUnusedTiktokVideosJob();
            dispatch($job);

            return redirect()->back()->with('info', 'Cleanup job has been queued. It will process in the background.');

        } catch (\Exception $e) {
            Log::error("Failed to dispatch redownload job", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Failed to queue job: ' . $e->getMessage());
        }
    }
}
