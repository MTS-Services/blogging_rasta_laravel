<?php
namespace App\Console\Commands;

use App\Models\TikTokVideo;
use App\Services\ThumbnailDownloadService;
use Illuminate\Console\Command;

class FixTikTokThumbnails extends Command
{
    protected $signature = 'tiktok:fix-thumbnails {--limit=100}';
    protected $description = 'Download and fix TikTok thumbnails for existing videos';

    public function handle(ThumbnailDownloadService $service): int
    {
        $limit = $this->option('limit');

        $this->info("Fixing thumbnails for up to {$limit} videos...");

        // Get videos that don't have local thumbnails
        $videos = TikTokVideo::where(function ($query) {
            $query->whereNull('thumbnail_url')
                ->orWhere('thumbnail_url', 'like', '%tiktokcdn%');
        })
            ->whereNotNull('origin_cover')
            ->limit($limit)
            ->get();

        if ($videos->isEmpty()) {
            $this->info('No videos need thumbnail fixes.');
            return Command::SUCCESS;
        }

        $bar = $this->output->createProgressBar($videos->count());
        $bar->start();

        $success = 0;
        $failed = 0;

        foreach ($videos as $video) {
            // Try origin_cover first
            $localUrl = $service->downloadAndStore($video->origin_cover, $video->video_id);

            // Fallback to cover
            if (!$localUrl && $video->cover) {
                $localUrl = $service->downloadAndStore($video->cover, $video->video_id);
            }

            if ($localUrl) {
                $video->update(['thumbnail_url' => $localUrl]);
                $success++;
            } else {
                $failed++;
            }

            $bar->advance();
            usleep(100000); // 100ms delay to be nice to CDN
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✅ Success: {$success}");
        if ($failed > 0) {
            $this->warn("⚠️  Failed: {$failed}");
        }

        return Command::SUCCESS;
    }
}
