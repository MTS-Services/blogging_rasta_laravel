<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\TikTokVideo;
use App\Services\TikTokService;
use App\Services\BannerVideoService;
use App\Services\KeywordService;
use Illuminate\Support\Facades\Log;

class Home extends Component
{
    public $featuredVideos = [];
    public $hashtags = [];
    public $loading = true;
    public $error = null;
    public $banner = null;

    // Pagination properties
    public $currentPage = 1;
    public $videosPerPage = 12;

    protected $tiktokService;
    protected $bannerService;
    protected KeywordService $keywordService;

    public function boot(TikTokService $tiktokService, BannerVideoService $bannerService, KeywordService $keywordService)
    {
        $this->tiktokService = $tiktokService;
        $this->bannerService = $bannerService;
        $this->keywordService = $keywordService;
    }

    public function mount()
    {
        $this->loadBanner();
        $this->loadData();
    }

    public function loadBanner()
    {
        try {
            $this->banner = $this->bannerService->getFirstData();

            Log::info('Banner video loaded', [
                'has_banner' => $this->banner !== null,
            ]);
        } catch (\Exception $e) {
            Log::error('Banner loading failed', [
                'error' => $e->getMessage()
            ]);
            $this->banner = null;
        }
    }

    public function loadData()
    {
        $this->loading = true;
        $this->error = null;

        try {
            // Get featured videos from database
            $query = TikTokVideo::where('is_featured', true)
                ->where('is_active', true)
                ->orderBy('create_time', 'desc');

            // Get total count for pagination
            $totalVideos = $query->count();
            $totalPages = ceil($totalVideos / $this->videosPerPage);

            // Get videos for current page
            $videos = $query->skip(($this->currentPage - 1) * $this->videosPerPage)
                ->take($this->videosPerPage)
                ->get()
                ->shuffle();

            // Format videos for display
            $this->featuredVideos = $videos->map(function ($video) {
                return [
                    'aweme_id' => $video->aweme_id,
                    'slug' => $video->slug,
                    'video_id' => $video->video_id,
                    'title' => $video->title ?: $video->desc ?: 'TikTok Video',
                    'desc' => $video->desc,
                    'cover' => $video->cover,
                    'origin_cover' => $video->origin_cover,
                    'dynamic_cover' => $video->dynamic_cover,
                    'play' => $video->local_video_url ? storage_url($video->local_video_url) : $video->play_url,
                    'create_time' => strtotime($video->create_time),
                    'play_count' => $video->play_count,
                    'digg_count' => $video->digg_count,
                    'comment_count' => $video->comment_count,
                    'share_count' => $video->share_count,
                    'author' => [
                        'unique_id' => $video->username,
                        'nickname' => $video->author_nickname ?: $video->username,
                        'avatar' => $video->author_avatar,
                    ],
                    '_username' => $video->username,
                    'thumbnail_url' => $video->thumbnail_url
                ];
            })->toArray();

            Log::info('Featured videos loaded from database', [
                'page' => $this->currentPage,
                'videos_count' => count($this->featuredVideos),
                'total_videos' => $totalVideos,
                'total_pages' => $totalPages,
            ]);
        } catch (\Exception $e) {
            $this->error = 'Failed to load videos: ' . $e->getMessage();
            Log::error('Video loading failed', [
                'error' => $e->getMessage(),
                'page' => $this->currentPage,
            ]);
            $this->featuredVideos = [];
        }


        $this->loading = false;
    }

    /**
     * Check if pagination should be shown
     */
    public function shouldShowPagination()
    {
        $totalVideos = TikTokVideo::where('is_featured', true)
            ->where('is_active', true)
            ->count();

        return $totalVideos > $this->videosPerPage;
    }

    /**
     * Go to specific page
     */
    public function goToPage($page)
    {
        if ($page < 1) {
            return;
        }

        $totalVideos = TikTokVideo::where('is_featured', true)
            ->where('is_active', true)
            ->count();

        $totalPages = ceil($totalVideos / $this->videosPerPage);

        if ($page > $totalPages) {
            return;
        }

        $this->currentPage = $page;
        $this->loadData();

        $this->dispatch('scroll-to-videos');
    }

    /**
     * Go to next page
     */
    public function nextPage()
    {
        if ($this->hasNextPage()) {
            $this->currentPage++;
            $this->loadData();
            $this->dispatch('scroll-to-videos');
        }
    }

    /**
     * Go to previous page
     */
    public function previousPage()
    {
        if ($this->hasPreviousPage()) {
            $this->currentPage--;
            $this->loadData();
            $this->dispatch('scroll-to-videos');
        }
    }

    /**
     * Check if can go to next page
     */
    public function hasNextPage()
    {
        $totalVideos = TikTokVideo::where('is_featured', true)
            ->where('is_active', true)
            ->count();

        $totalPages = ceil($totalVideos / $this->videosPerPage);

        return $this->currentPage < $totalPages;
    }

    /**
     * Check if can go to previous page
     */
    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }

    /**
     * Get total available pages
     */
    public function getTotalPages()
    {
        $totalVideos = TikTokVideo::where('is_featured', true)
            ->where('is_active', true)
            ->count();

        return max(1, ceil($totalVideos / $this->videosPerPage));
    }

    public function formatNumber($number)
    {
        return $this->tiktokService->formatNumber($number);
    }

    public function render()
    {
        $keywords = $this->keywordService->getAllDatasWithCount()->take(6);

        return view('livewire.frontend.home', [
            'keywords' => $keywords
        ]);
    }
}
