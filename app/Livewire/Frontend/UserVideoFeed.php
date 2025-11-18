<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\TikTokMultiUserService;
use Illuminate\Support\Facades\Log;

class UserVideoFeed extends Component
{
    public $username;
    public $displayName;
    public $videos = [];
    public $loading = true;
    public $error = null;

    // Pagination properties
    public $currentPage = 1;
    public $videosPerPage = 9;
    public $maxVideos = '';
    
    // Store page states
    public $pageStates = [];
    
    // Track loaded video IDs to prevent duplicates
    public $loadedVideoIds = [];

    protected $tiktokService;

    public function boot(TikTokMultiUserService $tiktokService)
    {
        $this->tiktokService = $tiktokService;
    }

    public function mount($username)
    {
        $this->username = $username;
        
        // Get display name from config
        $featuredUsers = config('tiktok.featured_users', []);
        $user = collect($featuredUsers)->firstWhere('username', $username);
        
        if (!$user) {
            $this->error = 'User not found';
            $this->loading = false;
            return;
        }
        
        $this->displayName = $user['display_name'] ?? $username;
        // Increase max videos to allow multiple pages
        $this->maxVideos = $user['max_videos'] ?? 100;
        
        // Initialize page 1 state
        $this->pageStates[1] = [
            'cursors' => [$username => 0],
            'video_counts' => [$username => 0],
            'has_more' => [$username => true],
            'videos' => [],
        ];
        
        $this->loadVideos();
    }

    public function loadVideos()
    {
        $this->loading = true;
        $this->error = null;

        try {
            // Check if this page already has cached videos
            if (isset($this->pageStates[$this->currentPage]['videos']) && 
                !empty($this->pageStates[$this->currentPage]['videos'])) {
                // Use cached videos for this page
                $this->videos = $this->pageStates[$this->currentPage]['videos'];
                
                Log::info('UserVideoFeed - Using cached videos', [
                    'username' => $this->username,
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
                $previousPage = $this->currentPage - 1;
                if (isset($this->pageStates[$previousPage])) {
                    // Copy state from previous page
                    $currentState = [
                        'cursors' => $this->pageStates[$previousPage]['cursors'],
                        'video_counts' => $this->pageStates[$previousPage]['video_counts'],
                        'has_more' => $this->pageStates[$previousPage]['has_more'],
                        'videos' => [],
                    ];
                } else {
                    $currentState = [
                        'cursors' => [$this->username => 0],
                        'video_counts' => [$this->username => 0],
                        'has_more' => [$this->username => true],
                        'videos' => [],
                    ];
                }
            }

            $allVideos = [];
            $attempts = 0;
            $maxAttempts = 10;
            
            // Keep loading until we have enough videos
            while (count($allVideos) < $this->videosPerPage && $attempts < $maxAttempts) {
                // Check if this user still has more videos
                if (!$currentState['has_more'][$this->username]) {
                    Log::info('UserVideoFeed - User exhausted', [
                        'username' => $this->username,
                        'page' => $this->currentPage,
                        'collected' => count($allVideos),
                        'video_counts' => $currentState['video_counts'],
                    ]);
                    break;
                }
                
                // Check if we've reached max videos limit
                if ($currentState['video_counts'][$this->username] >= $this->maxVideos) {
                    Log::info('UserVideoFeed - Max videos limit reached', [
                        'username' => $this->username,
                        'page' => $this->currentPage,
                        'collected' => count($allVideos),
                        'video_counts' => $currentState['video_counts'],
                        'max_videos' => $this->maxVideos,
                    ]);
                    break;
                }
                
                // Calculate how many more videos we need
                $remaining = $this->videosPerPage - count($allVideos);
                
                // Calculate how many videos we can still load from API
                $alreadyLoaded = $currentState['video_counts'][$this->username];
                $canStillLoad = $this->maxVideos - $alreadyLoaded;
                
                // Don't request more than we can load
                $videosToRequest = min(
                    12, // Max per request
                    $remaining + 3, // A bit more than needed for duplicates
                    $canStillLoad // Don't exceed total limit
                );
                
                // If we can't load enough videos, adjust expectations
                if ($videosToRequest < 1) {
                    Log::info('UserVideoFeed - Cannot request more videos', [
                        'username' => $this->username,
                        'page' => $this->currentPage,
                        'already_loaded' => $alreadyLoaded,
                        'max_videos' => $this->maxVideos,
                    ]);
                    break;
                }
                
                Log::info('UserVideoFeed - Requesting videos', [
                    'username' => $this->username,
                    'page' => $this->currentPage,
                    'attempt' => $attempts + 1,
                    'requesting' => $videosToRequest,
                    'current_cursor' => $currentState['cursors'][$this->username],
                    'current_video_count' => $currentState['video_counts'][$this->username],
                    'already_collected_on_page' => count($allVideos),
                    'max_videos' => $this->maxVideos,
                ]);
                
                // IMPORTANT: Pass a temporary video count for this request only
                // We'll manually update the count based on what we actually use
                $tempVideoCounts = $currentState['video_counts'];
                
                // Use the existing service method but for single user
                $result = $this->tiktokService->getMultipleUsersVideos(
                    [$this->username], 
                    $videosToRequest,
                    $currentState['cursors'],
                    [$this->username => $this->maxVideos],
                    $tempVideoCounts // Use temp counts
                );

                if (!$result['success']) {
                    throw new \Exception($result['error'] ?? 'Failed to load videos');
                }

                $newVideos = $result['videos'];
                
                if (empty($newVideos)) {
                    Log::info('UserVideoFeed - No more videos available', [
                        'username' => $this->username,
                        'page' => $this->currentPage,
                        'attempt' => $attempts,
                        'collected' => count($allVideos),
                        'video_counts' => $result['video_counts'],
                    ]);
                    break;
                }
                
                // Filter out duplicates
                $skippedCount = 0;
                $addedCount = 0;
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
                    $addedCount++;
                    if ($videoId) {
                        $this->loadedVideoIds[] = $videoId;
                    }
                }
                
                Log::info('UserVideoFeed - Processed videos', [
                    'username' => $this->username,
                    'page' => $this->currentPage,
                    'attempt' => $attempts + 1,
                    'new_videos' => count($newVideos),
                    'added' => $addedCount,
                    'skipped' => $skippedCount,
                    'total_collected' => count($allVideos),
                ]);
                
                // Update state for next iteration
                $currentState['cursors'] = $result['cursors'];
                $currentState['video_counts'] = $result['video_counts'];
                $currentState['has_more'] = $result['has_more'];
                
                $attempts++;
            }
            
            $this->videos = $allVideos;
            
            // Store videos in page state for caching
            $currentState['videos'] = $allVideos;
            $this->pageStates[$this->currentPage] = $currentState;
            
            // Check if we can have a next page
            $canHaveNextPage = false;
            
            // Next page possible if:
            // 1. We have full page of videos AND
            // 2. User still has more videos AND  
            // 3. We haven't reached the max limit yet
            $remainingVideos = $this->maxVideos - $currentState['video_counts'][$this->username];
            
            if (count($allVideos) >= $this->videosPerPage && 
                $currentState['has_more'][$this->username] &&
                $remainingVideos > 0) {
                $canHaveNextPage = true;
            }
            
            Log::info('UserVideoFeed - Pagination check', [
                'username' => $this->username,
                'page' => $this->currentPage,
                'videos_on_page' => count($allVideos),
                'videos_per_page' => $this->videosPerPage,
                'has_more_from_api' => $currentState['has_more'][$this->username],
                'total_loaded' => $currentState['video_counts'][$this->username],
                'max_videos' => $this->maxVideos,
                'remaining_videos' => $remainingVideos,
                'can_have_next_page' => $canHaveNextPage,
            ]);
            
            // Prepare next page state only if there can be more videos
            if ($canHaveNextPage && !isset($this->pageStates[$this->currentPage + 1])) {
                $this->pageStates[$this->currentPage + 1] = [
                    'cursors' => $currentState['cursors'],
                    'video_counts' => $currentState['video_counts'],
                    'has_more' => $currentState['has_more'],
                    'videos' => [],
                ];
            }

            Log::info('UserVideoFeed - Videos loaded', [
                'username' => $this->username,
                'page' => $this->currentPage,
                'videos_count' => count($this->videos),
                'attempts' => $attempts,
                'can_have_next_page' => $canHaveNextPage,
                'total_unique_videos' => count($this->loadedVideoIds),
                'video_counts' => $currentState['video_counts'],
                'max_videos' => $this->maxVideos,
            ]);

        } catch (\Exception $e) {
            $this->error = 'Failed to load videos: ' . $e->getMessage();
            Log::error('UserVideoFeed - Video loading failed', [
                'username' => $this->username,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'page' => $this->currentPage,
            ]);
            $this->videos = [];
        }

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
        $this->loadVideos();
        
        $this->dispatch('scroll-to-user-videos');
    }

    /**
     * Go to next page
     */
    public function nextPage()
    {
        if ($this->hasNextPage()) {
            $this->currentPage++;
            $this->loadVideos();
            $this->dispatch('scroll-to-user-videos');
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
            $this->dispatch('scroll-to-user-videos');
        }
    }

    /**
     * Check if can go to next page
     */
    public function hasNextPage()
    {
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
        return view('livewire.frontend.user-video-feed');
    }
}