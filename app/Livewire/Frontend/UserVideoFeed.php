<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\TikTokVideo;
use App\Services\TikTokService;
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

    protected $tiktokService;

    public function boot(TikTokService $tiktokService)
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
        
        $this->loadVideos();
    }

    public function loadVideos()
    {
        $this->loading = true;
        $this->error = null;

        try {
            // Query videos from database for this specific user
            $query = TikTokVideo::where('is_active', true)
                ->where('username', $this->username)
                ->orderBy('create_time', 'desc');

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

            Log::info('UserVideoFeed - Videos loaded from database', [
                'username' => $this->username,
                'page' => $this->currentPage,
                'videos_count' => count($this->videos),
                'total_videos' => $totalVideos,
            ]);

        } catch (\Exception $e) {
            $this->error = 'Failed to load videos: ' . $e->getMessage();
            Log::error('UserVideoFeed - Video loading failed', [
                'username' => $this->username,
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

    public function shouldShowPagination()
    {
        $totalVideos = TikTokVideo::where('is_active', true)
            ->where('username', $this->username)
            ->count();
        
        return $totalVideos > $this->videosPerPage;
    }

    public function goToPage($page)
    {
        if ($page < 1) {
            return;
        }

        $totalVideos = TikTokVideo::where('is_active', true)
            ->where('username', $this->username)
            ->count();
        
        $totalPages = ceil($totalVideos / $this->videosPerPage);

        if ($page > $totalPages) {
            return;
        }

        $this->currentPage = $page;
        $this->loadVideos();
        
        $this->dispatch('scroll-to-user-videos');
    }

    public function nextPage()
    {
        if ($this->hasNextPage()) {
            $this->currentPage++;
            $this->loadVideos();
            $this->dispatch('scroll-to-user-videos');
        }
    }

    public function previousPage()
    {
        if ($this->hasPreviousPage()) {
            $this->currentPage--;
            $this->loadVideos();
            $this->dispatch('scroll-to-user-videos');
        }
    }

    public function hasNextPage()
    {
        $totalVideos = TikTokVideo::where('is_active', true)
            ->where('username', $this->username)
            ->count();
        
        $totalPages = ceil($totalVideos / $this->videosPerPage);
        
        return $this->currentPage < $totalPages;
    }

    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }

    public function getTotalPages()
    {
        $totalVideos = TikTokVideo::where('is_active', true)
            ->where('username', $this->username)
            ->count();
        
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
        return view('livewire.frontend.user-video-feed');
    }
}