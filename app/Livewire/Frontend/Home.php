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
    public $videosPerUser = 4;
    
    // Video limits per user
    public $userVideoLimits = [];
    
    // Store complete page state for each page number
    public $pageStates = [];
    
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
            'videos' => [],
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
            $maxAttempts = 10;
            $loadedVideos = 0;
            
            while (count($allVideos) < $this->videosPerPage && $attempts < $maxAttempts) {
                // Calculate how many more videos we need
                $remaining = $this->videosPerPage - count($allVideos);
                $videosToRequest = max(4, ceil($remaining / count($usernames)));
                
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
                    Log::info('No more videos available', [
                        'page' => $this->currentPage,
                        'attempt' => $attempts,
                        'collected' => count($allVideos)
                    ]);
                    break;
                }
                
                $skippedCount = 0;
                foreach ($newVideos as $video) {
                    if (count($allVideos) >= $this->videosPerPage) {
                        break;
                    }
                    
                    $videoId = $video['aweme_id'] ?? $video['video_id'] ?? null;
                    
                    if ($videoId && in_array($videoId, $this->loadedVideoIds)) {
                        $skippedCount++;
                        continue;
                    }
                    
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
            
            // Check if we have enough videos for a next page
            // Only create next page state if:
            // 1. We loaded at least videosPerPage videos on this page
            // 2. At least one user has more videos
            $canHaveNextPage = false;
            if (count($allVideos) >= $this->videosPerPage) {
                foreach ($currentState['has_more'] as $username => $hasMore) {
                    if ($hasMore) {
                        $canHaveNextPage = true;
                        break;
                    }
                }
            }
            
            // Prepare next page state only if there can be more videos
            if ($canHaveNextPage && !isset($this->pageStates[$this->currentPage + 1])) {
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
                'can_have_next_page' => $canHaveNextPage,
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

        // Don't allow going to pages that don't exist
        if (!isset($this->pageStates[$page])) {
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
        // Check if next page state exists
        return isset($this->pageStates[$this->currentPage + 1]);
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