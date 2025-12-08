<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Services\VideoManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VideoManagementControllerManual extends Controller
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
     * Redownload missing videos
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

            Log::info("Redownload missing videos request", [
                'limit' => $limit,
                'force' => $force
            ]);

            $result = $this->videoManagementService->redownloadMissingVideos($limit, $force);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'data' => [
                        'total' => $result['total'],
                        'success_count' => $result['success_count'],
                        'failed_count' => $result['failed_count'],
                        'skipped_count' => $result['skipped_count'],
                        'details' => $result['details']
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error("Redownload missing videos error", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to redownload videos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cleanup expired videos
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

            Log::info("Cleanup expired videos request", [
                'older_than_days' => $olderThanDays,
                'delete_inactive' => $deleteInactive
            ]);

            $result = $this->videoManagementService->cleanupExpiredVideos($olderThanDays, $deleteInactive);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'data' => [
                        'total' => $result['total'],
                        'checked_count' => $result['checked_count'],
                        'expired_count' => $result['expired_count'],
                        'deactivated_count' => $result['deactivated_count'],
                        'deleted_count' => $result['deleted_count'],
                        'details' => $result['details']
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error("Cleanup expired videos error", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to cleanup videos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete old videos
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

            Log::info("Delete old videos request", [
                'older_than_days' => $olderThanDays,
                'limit' => $limit
            ]);

            $result = $this->videoManagementService->deleteOldVideos($olderThanDays, $limit);

            return response()->json([
                'success' => $result['success'],
                'message' => $result['message'],
                'data' => [
                    'deleted_count' => $result['deleted_count'] ?? 0,
                    'freed_space_mb' => $result['freed_space_mb'] ?? 0
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error("Delete old videos error", [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete old videos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify and fix broken videos
     */
    public function verifyAndFix(Request $request)
    {
        try {
            $validated = $request->validate([
                'limit' => 'nullable|integer|min:1|max:500'
            ]);

            $limit = $validated['limit'] ?? 100;

            Log::info("Verify and fix broken videos request", ['limit' => $limit]);

            $result = $this->videoManagementService->verifyAndFixBrokenVideos($limit);

            return response()->json([
                'success' => $result['success'],
                'message' => $result['message'],
                'data' => [
                    'total' => $result['total'] ?? 0,
                    'broken_count' => $result['broken_count'] ?? 0,
                    'fixed_count' => $result['fixed_count'] ?? 0
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error("Verify and fix videos error", [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to verify videos: ' . $e->getMessage()
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
}
