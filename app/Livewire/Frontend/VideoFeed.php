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
    
    // For switching to single user view
    public $showSingleUser = false;
    public $selectedUsername = null;

    // Pagination properties
    public $currentPage = 1;
    public $videosPerPage = 9;
    
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
        // Multi-user mode
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
            // Check if this page already has cached videos
            if (isset($this->pageStates[$this->currentPage]['videos']) && 
                !empty($this->pageStates[$this->currentPage]['videos'])) {
                $this->videos = $this->pageStates[$this->currentPage]['videos'];
                
                // Filter by active user if not 'All'
                if ($this->activeUser !== 'All') {
                    $this->videos = $this->filterVideosByUser($this->videos);
                }
                
                Log::info('VideoFeed - Using cached videos', [
                    'page' => $this->currentPage,
                    'videos_count' => count($this->videos),
                    'active_user' => $this->activeUser,
                ]);
                
                $this->loading = false;
                return;
            }

            $this->loadMultiUserVideos();

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

    private function loadMultiUserVideos()
    {
        $featuredUsers = config('tiktok.featured_users', []);
        $usernames = array_column($featuredUsers, 'username');

        if (empty($usernames)) {
            throw new \Exception('No featured users configured');
        }

        $currentState = $this->pageStates[$this->currentPage] ?? [
            'cursors' => array_fill_keys($usernames, 0),
            'video_counts' => array_fill_keys($usernames, 0),
            'has_more' => array_fill_keys($usernames, true),
            'videos' => [],
        ];

        $allVideos = [];
        $attempts = 0;
        $maxAttempts = 10;
        
        while (count($allVideos) < $this->videosPerPage && $attempts < $maxAttempts) {
            $remaining = $this->videosPerPage - count($allVideos);
            $videosToRequest = max(4, ceil($remaining / count($usernames)));
            
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

            $newVideos = $result['videos'];
            
            if (empty($newVideos)) {
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
            
            $currentState['cursors'] = $result['cursors'];
            $currentState['video_counts'] = $result['video_counts'];
            $currentState['has_more'] = $result['has_more'];
            
            $hasMoreVideos = false;
            foreach ($result['has_more'] as $hasMore) {
                if ($hasMore) {
                    $hasMoreVideos = true;
                    break;
                }
            }
            
            if (!$hasMoreVideos) {
                break;
            }
            
            $attempts++;
        }
        
        // Store all videos in cache
        $currentState['videos'] = $allVideos;
        $this->pageStates[$this->currentPage] = $currentState;
        
        // Filter by active user if not 'All'
        if ($this->activeUser !== 'All') {
            $this->videos = $this->filterVideosByUser($allVideos);
        } else {
            $this->videos = $allVideos;
        }
        
        $canHaveNextPage = false;
        if (count($allVideos) >= $this->videosPerPage) {
            foreach ($currentState['has_more'] as $username => $hasMore) {
                if ($hasMore) {
                    $canHaveNextPage = true;
                    break;
                }
            }
        }
        
        if ($canHaveNextPage && !isset($this->pageStates[$this->currentPage + 1])) {
            $this->pageStates[$this->currentPage + 1] = [
                'cursors' => $currentState['cursors'],
                'video_counts' => $currentState['video_counts'],
                'has_more' => $currentState['has_more'],
                'videos' => [],
            ];
        }

        Log::info('VideoFeed - Multi user videos loaded', [
            'page' => $this->currentPage,
            'videos_count' => count($this->videos),
            'active_user' => $this->activeUser,
        ]);
    }

    private function filterVideosByUser($videos)
    {
        // Find the actual username from display name
        $featuredUsers = config('tiktok.featured_users', []);
        $user = collect($featuredUsers)->firstWhere('display_name', $this->activeUser);
        
        if (!$user) {
            return $videos;
        }
        
        $targetUsername = $user['username'];
        
        // Filter videos by username
        return array_values(array_filter($videos, function($video) use ($targetUsername) {
            $videoUsername = $video['_username'] ?? 
                            ($video['author']['unique_id'] ?? 
                            ($video['author']['username'] ?? null));
            
            return $videoUsername === $targetUsername;
        }));
    }

    public function setUser($username)
    {
        // Update active user
        $this->activeUser = $username;
        
        // Reset to page 1 when changing filter
        $this->currentPage = 1;
        
        // Clear loaded video IDs for fresh filtering
        $this->loadedVideoIds = [];
        
        // Reload videos with the new filter
        $this->loadVideos();
        
        // Scroll to video section
        $this->dispatch('scroll-to-videos');
    }

    public function shouldShowPagination()
    {
        return $this->currentPage > 1 || $this->hasNextPage();
    }

    public function goToPage($page)
    {
        if ($page < 1 || !isset($this->pageStates[$page])) {
            return;
        }

        $this->currentPage = $page;
        $this->loadVideos();
        
        $this->dispatch('scroll-to-videos');
    }

    public function nextPage()
    {
        if ($this->hasNextPage()) {
            $this->currentPage++;
            $this->loadVideos();
            $this->dispatch('scroll-to-videos');
        }
    }

    public function previousPage()
    {
        if ($this->hasPreviousPage()) {
            $this->currentPage--;
            $this->loadVideos();
            $this->dispatch('scroll-to-videos');
        }
    }

    public function hasNextPage()
    {
        return isset($this->pageStates[$this->currentPage + 1]);
    }

    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }

    public function getTotalPages()
    {
        return max(array_keys($this->pageStates));
    }

    public function getUsersProperty()
    {
        $featuredUsers = config('tiktok.featured_users', []);
        $users = ['All'];
        
        foreach ($featuredUsers as $user) {
            $users[] = $user['display_name'] ?? $user['username'];
        }
        
        return $users;
    }

    public function formatNumber($number)
    {
        return $this->tiktokService->formatNumber($number);
    }

    public function render()
    {
        return view('livewire.frontend.video-feed');
    }
}