<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\TikTokVideo;
use App\Services\TikTokService;
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

    protected $tiktokService;

    public function boot(TikTokService $tiktokService)
    {
        $this->tiktokService = $tiktokService;
    }

    public function mount()
    {
        $this->loadVideos();
    }

    public function loadVideos()
    {
        $this->loading = true;
        $this->error = null;

        try {
            // Base query - only active videos
            $query = TikTokVideo::where('is_active', true)
                ->orderBy('create_time', 'desc');

            // Filter by user if not 'All'
            if ($this->activeUser !== 'All') {
                // Find actual username from display name
                $featuredUsers = config('tiktok.featured_users', []);
                $user = collect($featuredUsers)->firstWhere('display_name', $this->activeUser);
                
                if ($user) {
                    $query->where('username', $user['username']);
                }
            }

            // Get total count for pagination
            $totalVideos = $query->count();

            // Get videos for current page
            $videosCollection = $query->skip(($this->currentPage - 1) * $this->videosPerPage)
                ->take($this->videosPerPage)
                ->get();

            // Format videos for display
            $this->videos = $videosCollection->map(function ($video) {
                return [
                    'aweme_id' => $video->aweme_id,
                    'video_id' => $video->video_id,
                    'title' => $video->title ?: $video->desc ?: 'TikTok Video',
                    'desc' => $video->desc,
                    'cover' => $video->cover,
                    'origin_cover' => $video->origin_cover,
                    'dynamic_cover' => $video->dynamic_cover,
                    'play' => $video->play_url,
                    'create_time' => strtotime($video->create_time),
                    'play_count' => $video->play_count,
                    'digg_count' => $video->digg_count,
                    'comment_count' => $video->comment_count,
                    'share_count' => $video->share_count,
                    'video' => [
                        'cover' => $video->cover,
                        'origin_cover' => $video->origin_cover,
                        'dynamic_cover' => $video->dynamic_cover,
                        'play' => $video->play_url,
                    ],
                    'author' => [
                        'unique_id' => $video->username,
                        'nickname' => $video->author_nickname ?: $video->username,
                        'avatar' => $video->author_avatar,
                        'avatar_larger' => $video->author_avatar_larger,
                        'avatar_medium' => $video->author_avatar_medium,
                    ],
                    '_username' => $video->username,
                    'text_extra' => $this->extractHashtagsAsTextExtra($video->hashtags),
                ];
            })->toArray();

            Log::info('VideoFeed - Videos loaded from database', [
                'page' => $this->currentPage,
                'videos_count' => count($this->videos),
                'total_videos' => $totalVideos,
                'active_user' => $this->activeUser,
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

    /**
     * Convert hashtags array to text_extra format
     */
    private function extractHashtagsAsTextExtra($hashtags)
    {
        if (empty($hashtags)) {
            return [];
        }

        $textExtra = [];
        foreach ($hashtags as $tag) {
            $textExtra[] = [
                'hashtag_name' => $tag,
            ];
        }

        return $textExtra;
    }

    public function setUser($username)
    {
        // Update active user
        $this->activeUser = $username;
        
        // Reset to page 1 when changing filter
        $this->currentPage = 1;
        
        // Reload videos with the new filter
        $this->loadVideos();
        
        // Scroll to video section
        $this->dispatch('scroll-to-videos');
    }

    public function shouldShowPagination()
    {
        // Base query - only active videos
        $query = TikTokVideo::where('is_active', true);

        // Filter by user if not 'All'
        if ($this->activeUser !== 'All') {
            $featuredUsers = config('tiktok.featured_users', []);
            $user = collect($featuredUsers)->firstWhere('display_name', $this->activeUser);
            
            if ($user) {
                $query->where('username', $user['username']);
            }
        }

        $totalVideos = $query->count();
        
        return $totalVideos > $this->videosPerPage;
    }

    public function goToPage($page)
    {
        if ($page < 1) {
            return;
        }

        // Base query - only active videos
        $query = TikTokVideo::where('is_active', true);

        // Filter by user if not 'All'
        if ($this->activeUser !== 'All') {
            $featuredUsers = config('tiktok.featured_users', []);
            $user = collect($featuredUsers)->firstWhere('display_name', $this->activeUser);
            
            if ($user) {
                $query->where('username', $user['username']);
            }
        }

        $totalVideos = $query->count();
        $totalPages = ceil($totalVideos / $this->videosPerPage);

        if ($page > $totalPages) {
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
        // Base query - only active videos
        $query = TikTokVideo::where('is_active', true);

        // Filter by user if not 'All'
        if ($this->activeUser !== 'All') {
            $featuredUsers = config('tiktok.featured_users', []);
            $user = collect($featuredUsers)->firstWhere('display_name', $this->activeUser);
            
            if ($user) {
                $query->where('username', $user['username']);
            }
        }

        $totalVideos = $query->count();
        $totalPages = ceil($totalVideos / $this->videosPerPage);
        
        return $this->currentPage < $totalPages;
    }

    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }

    public function getTotalPages()
    {
        // Base query - only active videos
        $query = TikTokVideo::where('is_active', true);

        // Filter by user if not 'All'
        if ($this->activeUser !== 'All') {
            $featuredUsers = config('tiktok.featured_users', []);
            $user = collect($featuredUsers)->firstWhere('display_name', $this->activeUser);
            
            if ($user) {
                $query->where('username', $user['username']);
            }
        }

        $totalVideos = $query->count();
        
        return max(1, ceil($totalVideos / $this->videosPerPage));
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