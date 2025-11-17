<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\TikTokMultiUserService;
use Illuminate\Support\Facades\Log;

class VideoFeed extends Component
{
    public $activeUser = 'All';
    public $videos = [];
    public $loading = true;
    public $error = null;

    // Pagination properties
    public $currentPage = 1;
    public $videosPerPage = 9;
    public $videosPerUser = 4;
    
    // Video limits per user
    public $userVideoLimits = [];
    
    // Store complete page state for each page number
    public $pageStates = [];
    
    // Track loaded video IDs globally to prevent duplicates across all pages
    public $loadedVideoIds = [];

    protected $tiktokService;

    public function boot(TikTokMultiUserService $tiktokService)
    {
        $this->tiktokService = $tiktokService;
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
        
        $this->loadVideos();
    }

    public function loadVideos()
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
                $this->videos = $this->pageStates[$this->currentPage]['videos'];
                
                Log::info('VideoFeed - Using cached videos', [
                    'page' => $this->currentPage,
                    'videos_count' => count($this->videos),
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
                    Log::info('VideoFeed - No more videos available', [
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
                    Log::info('VideoFeed - Skipped duplicate videos', [
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
                    Log::info('VideoFeed - All users exhausted', [
                        'page' => $this->currentPage,
                        'collected' => count($allVideos)
                    ]);
                    break;
                }
                
                $attempts++;
            }
            
            $this->videos = $allVideos;
            
            // Store videos in page state for caching
            $currentState['videos'] = $allVideos;
            $this->pageStates[$this->currentPage] = $currentState;
            
            // Check if we have enough videos for a next page
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

            Log::info('VideoFeed - Videos loaded', [
                'page' => $this->currentPage,
                'videos_count' => count($this->videos),
                'attempts' => $attempts,
                'loaded_videos' => $loadedVideos,
                'can_have_next_page' => $canHaveNextPage,
                'total_unique_videos' => count($this->loadedVideoIds),
                'video_counts' => $currentState['video_counts'],
            ]);

        } catch (\Exception $e) {
            $this->error = 'Failed to load videos: ' . $e->getMessage();
            Log::error('VideoFeed - Video loading failed', [
                'error' => $e->getMessage(),
                'page' => $this->currentPage,
            ]);
            $this->videos = [];
        }

        $this->loading = false;
    }

    public function setUser($username)
    {
        $this->activeUser = $username;
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
        $this->loadVideos();
        
        $this->dispatch('scroll-to-videos');
    }

    /**
     * Go to next page
     */
    public function nextPage()
    {
        if ($this->hasNextPage()) {
            $this->currentPage++;
            $this->loadVideos();
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
            $this->loadVideos();
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

    public function getUsersProperty()
    {
        $featuredUsers = config('tiktok.featured_users', []);
        $users = ['All'];
        
        foreach ($featuredUsers as $user) {
            $users[] = $user['display_name'] ?? $user['username'] ;
        }
        
        return $users;
    }

    public function getFilteredVideosProperty()
    {
        if ($this->activeUser === 'All') {
            return $this->videos;
        }
        
        return collect($this->videos)
            ->filter(function ($video) {
                $username = $video['_username'] ?? ($video['author']['unique_id'] ?? '');
                return $username === $this->activeUser;
            })
            ->values()
            ->toArray();
    }

    public function formatNumber($number)
    {
        return $this->tiktokService->formatNumber($number);
    }

    public function render()
    {
        return view('livewire.frontend.video-feed', [
            'filteredVideos' => $this->filtered_videos,
            'users' => $this->users,
        ]);
    }
}