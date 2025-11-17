<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\TikTokMultiUserService;
use App\Services\BannerVideoService;
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
    public $videosPerUser = 4; // Load 4 videos per user per page
    
    // Video limits per user
    public $userVideoLimits = [];
    
    // Store complete page state for each page number
    public $pageStates = []; // [page_number => ['cursors' => [], 'video_counts' => [], 'has_more' => [], 'videos' => []]]
    
    // Track loaded video IDs globally to prevent duplicates across all pages
    public $loadedVideoIds = [];

    protected $tiktokService;
    protected $bannerService;

    public function boot(TikTokMultiUserService $tiktokService, BannerVideoService $bannerService)
    {
        $this->tiktokService = $tiktokService;
        $this->bannerService = $bannerService;
    }

    public function mount()
    {
        // Set video limits per user from config
        $featuredUsers = config('tiktok.featured_users', []);
        foreach ($featuredUsers as $user) {
            $this->userVideoLimits[$user['username']] = $user['max_videos'] ?? 20;
        }
        
        // Initialize page 1 state
        $usernames = array_column($featuredUsers, 'username');
        $this->pageStates[1] = [
            'cursors' => array_fill_keys($usernames, 0),
            'video_counts' => array_fill_keys($usernames, 0),
            'has_more' => array_fill_keys($usernames, true),
            'videos' => [], // Will be filled when loading
        ];
        
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
            $featuredUsers = config('tiktok.featured_users', []);
            $usernames = array_column($featuredUsers, 'username');

            if (empty($usernames)) {
                throw new \Exception('No featured users configured');
            }

            // Check if this page already has cached videos
            if (isset($this->pageStates[$this->currentPage]['videos']) && 
                !empty($this->pageStates[$this->currentPage]['videos'])) {
                // Use cached videos for this page
                $this->featuredVideos = $this->pageStates[$this->currentPage]['videos'];
                
                Log::info('Using cached videos', [
                    'page' => $this->currentPage,
                    'videos_count' => count($this->featuredVideos),
                ]);
                
                $this->loading = false;
                return;
            }

            // Get the state for current page
            $currentState = $this->pageStates[$this->currentPage] ?? null;
            
            if (!$currentState) {
                // Initialize state for this page if it doesn't exist
                $currentState = [
                    'cursors' => array_fill_keys($usernames, 0),
                    'video_counts' => array_fill_keys($usernames, 0),
                    'has_more' => array_fill_keys($usernames, true),
                    'videos' => [],
                ];
            }

            // Keep loading until we have exactly videosPerPage videos
            $allVideos = [];
            $attempts = 0;
            $maxAttempts = 10; // Increased to handle more iterations
            $loadedVideos = 0;
            
            while (count($allVideos) < $this->videosPerPage && $attempts < $maxAttempts) {
                // Calculate how many more videos we need
                $remaining = $this->videosPerPage - count($allVideos);
                $videosToRequest = max(4, ceil($remaining / count($usernames))); // Request more videos per user
                
                // Load videos
                $result = $this->tiktokService->getMultipleUsersVideos(
                    $usernames, 
                    $videosToRequest,
                    $currentState['cursors'],
                    $this->userVideoLimits,
                    $currentState['video_counts']
                );

                if (!$result['success']) {
                    throw new \Exception($result['error'] ?? 'Failed to load videos');
                }

                // Add new videos to our collection (skip duplicates)
                $newVideos = $result['videos'];
                $loadedVideos += count($newVideos);
                
                if (empty($newVideos)) {
                    // No more videos available from any user
                    Log::info('No more videos available', [
                        'page' => $this->currentPage,
                        'attempt' => $attempts,
                        'collected' => count($allVideos)
                    ]);
                    break;
                }
                
                $skippedCount = 0;
                foreach ($newVideos as $video) {
                    // Skip if we have enough videos
                    if (count($allVideos) >= $this->videosPerPage) {
                        break;
                    }
                    
                    // Get unique video ID
                    $videoId = $video['aweme_id'] ?? $video['video_id'] ?? null;
                    
                    // Skip duplicate videos
                    if ($videoId && in_array($videoId, $this->loadedVideoIds)) {
                        $skippedCount++;
                        continue;
                    }
                    
                    // Add video and track its ID
                    $allVideos[] = $video;
                    if ($videoId) {
                        $this->loadedVideoIds[] = $videoId;
                    }
                }
                
                if ($skippedCount > 0) {
                    Log::info('Skipped duplicate videos', [
                        'page' => $this->currentPage,
                        'skipped' => $skippedCount,
                        'attempt' => $attempts
                    ]);
                }
                
                // Update state for next iteration
                $currentState['cursors'] = $result['cursors'];
                $currentState['video_counts'] = $result['video_counts'];
                $currentState['has_more'] = $result['has_more'];
                
                // Check if any user has more videos
                $hasMoreVideos = false;
                foreach ($result['has_more'] as $hasMore) {
                    if ($hasMore) {
                        $hasMoreVideos = true;
                        break;
                    }
                }
                
                // If no more videos available from any source, stop
                if (!$hasMoreVideos) {
                    Log::info('All users exhausted', [
                        'page' => $this->currentPage,
                        'collected' => count($allVideos)
                    ]);
                    break;
                }
                
                $attempts++;
            }
            
            $this->featuredVideos = $allVideos;
            
            // Store videos in page state for caching
            $currentState['videos'] = $allVideos;
            $this->pageStates[$this->currentPage] = $currentState;
            
            // Check if any user has more videos for next page
            $hasMoreVideos = false;
            foreach ($currentState['has_more'] as $hasMore) {
                if ($hasMore) {
                    $hasMoreVideos = true;
                    break;
                }
            }
            
            // Prepare next page state (without videos, they'll be loaded when needed)
            if ($hasMoreVideos && !isset($this->pageStates[$this->currentPage + 1])) {
                $this->pageStates[$this->currentPage + 1] = [
                    'cursors' => $currentState['cursors'],
                    'video_counts' => $currentState['video_counts'],
                    'has_more' => $currentState['has_more'],
                    'videos' => [],
                ];
            }

            Log::info('Videos loaded', [
                'page' => $this->currentPage,
                'videos_count' => count($this->featuredVideos),
                'attempts' => $attempts,
                'loaded_videos' => $loadedVideos,
                'has_next_page' => $hasMoreVideos,
                'total_unique_videos' => count($this->loadedVideoIds),
                'video_counts' => $currentState['video_counts'],
            ]);

        } catch (\Exception $e) {
            $this->error = 'Failed to load videos: ' . $e->getMessage();
            Log::error('Video loading failed', [
                'error' => $e->getMessage(),
                'page' => $this->currentPage,
            ]);
            $this->featuredVideos = [];
        }

        // Load hashtags
        $this->hashtags = [
            ['tag' => '#GlowSkin', 'videos' => '48'],
            ['tag' => '#DiodioTips', 'videos' => '32'],
            ['tag' => '#NaturalBeauty', 'videos' => '125'],
            ['tag' => '#SkincareRoutine', 'videos' => '95'],
            ['tag' => '#BeautyHaul', 'videos' => '72'],
            ['tag' => '#SkincareTips', 'videos' => '156'],
        ];

        $this->loading = false;
    }

    /**
     * Check if pagination should be shown
     */
    public function shouldShowPagination()
    {
        // Show pagination if we're past page 1 OR if there's a next page available
        return $this->currentPage > 1 || $this->hasNextPage();
    }

    /**
     * Go to specific page
     */
    public function goToPage($page)
    {
        if ($page < 1) {
            return;
        }

        // Don't allow going to pages we haven't calculated yet
        if ($page > $this->currentPage + 1 && !isset($this->pageStates[$page])) {
            return;
        }

        $this->currentPage = $page;
        $this->loadData();
        
        // Scroll to video section
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
        // Check if next page state exists and has more videos
        $nextPageState = $this->pageStates[$this->currentPage + 1] ?? null;
        
        if ($nextPageState) {
            foreach ($nextPageState['has_more'] as $hasMore) {
                if ($hasMore) {
                    return true;
                }
            }
        }
        
        return false;
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
        return max(array_keys($this->pageStates));
    }

    public function formatNumber($number)
    {
        return $this->tiktokService->formatNumber($number);
    }

    public function render()
    {
        return view('livewire.frontend.home');
    }
}