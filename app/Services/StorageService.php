<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class StorageService
{
    /**
     * Get disk usage information
     *
     * @return array
     */
    public function getDiskUsage()
    {
        try {
            $path = storage_path('app/public');

            // Total space available on the disk
            $totalSpace = disk_total_space($path);

            // Free space available
            $freeSpace = disk_free_space($path);

            // Used space
            $usedSpace = $totalSpace - $freeSpace;

            // Calculate percentages
            $usedPercentage = ($usedSpace / $totalSpace) * 100;
            $freePercentage = ($freeSpace / $totalSpace) * 100;

            return [
                'total' => $totalSpace,
                'used' => $usedSpace,
                'free' => $freeSpace,
                'used_percentage' => round($usedPercentage, 2),
                'free_percentage' => round($freePercentage, 2),
                'total_formatted' => $this->formatBytes($totalSpace),
                'used_formatted' => $this->formatBytes($usedSpace),
                'free_formatted' => $this->formatBytes($freeSpace),
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get disk usage: ' . $e->getMessage());

            return [
                'total' => 0,
                'used' => 0,
                'free' => 0,
                'used_percentage' => 0,
                'free_percentage' => 0,
                'total_formatted' => 'N/A',
                'used_formatted' => 'N/A',
                'free_formatted' => 'N/A',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get storage usage by type (videos, thumbnails, etc.)
     *
     * @return array
     */
    public function getStorageBreakdown()
    {
        try {
            $storagePath = storage_path('app/public');

            $breakdown = [
                'videos' => $this->getDirectorySize($storagePath . '/videos/tiktok'),
                'thumbnails' => $this->getDirectorySize($storagePath . '/thumbnails'),
                'total_app' => $this->getDirectorySize($storagePath),
            ];

            return [
                'videos_size' => $breakdown['videos'],
                'thumbnails_size' => $breakdown['thumbnails'],
                'total_app_size' => $breakdown['total_app'],
                'videos_formatted' => $this->formatBytes($breakdown['videos']),
                'thumbnails_formatted' => $this->formatBytes($breakdown['thumbnails']),
                'total_app_formatted' => $this->formatBytes($breakdown['total_app']),
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get storage breakdown: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get directory size recursively
     *
     * @param string $directory
     * @return int Size in bytes
     */
    private function getDirectorySize($directory)
    {
        if (!is_dir($directory)) {
            return 0;
        }

        $size = 0;

        try {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CATCH_GET_CHILD
            );

            foreach ($files as $file) {
                if ($file->isFile()) {
                    $size += $file->getSize();
                }
            }
        } catch (\Exception $e) {
            Log::error('Error calculating directory size: ' . $e->getMessage());
        }

        return $size;
    }

    /**
     * Format bytes to human readable format
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    public function formatBytes($bytes, $precision = 2)
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = floor(log($bytes, 1024));
        $power = min($power, count($units) - 1);

        return round($bytes / pow(1024, $power), $precision) . ' ' . $units[$power];
    }

    /**
     * Check if storage is running low
     *
     * @param float $threshold Percentage threshold (default 80%)
     * @return bool
     */
    public function isStorageLow($threshold = 80)
    {
        $usage = $this->getDiskUsage();
        return $usage['used_percentage'] >= $threshold;
    }

    /**
     * Get storage alert status
     *
     * @return array
     */
    public function getStorageAlert()
    {
        $usage = $this->getDiskUsage();
        $usedPercentage = $usage['used_percentage'];

        if ($usedPercentage >= 90) {
            return [
                'status' => 'critical',
                'message' => 'Storage is critically low!',
                'color' => 'red'
            ];
        } elseif ($usedPercentage >= 80) {
            return [
                'status' => 'warning',
                'message' => 'Storage is running low',
                'color' => 'orange'
            ];
        } elseif ($usedPercentage >= 70) {
            return [
                'status' => 'caution',
                'message' => 'Storage usage is high',
                'color' => 'yellow'
            ];
        }

        return [
            'status' => 'normal',
            'message' => 'Storage is healthy',
            'color' => 'green'
        ];
    }
}
