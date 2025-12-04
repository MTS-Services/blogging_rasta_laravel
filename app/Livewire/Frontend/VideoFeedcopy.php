<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\TikTokVideo;
use App\Services\TikTokService;
use Illuminate\Support\Facades\Log;

class VideoFeedcopy extends Component
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
            // Base query - only active videos with keywords relationship
            $query = TikTokVideo::with(['videoKeywords.keyword'])
                ->where('is_active', true)
                ->orderBy('create_time', 'desc');

            // Filter by user if not 'All'
            if ($this->activeUser !== 'All') {
                $query->where('author_nickname', $this->activeUser);
            }

            // Get total count for pagination
            $totalVideos = $query->count();

            // Get videos for current page
            $videosCollection = $query->skip(($this->currentPage - 1) * $this->videosPerPage)
                ->take($this->videosPerPage)
                ->get()
                ->shuffle();

            // Format videos for display
            $this->videos = $videosCollection->map(function ($video) {
                // Extract keywords from relationship
                $keywords = $video->videoKeywords->map(function ($videoKeyword) {
                    return $videoKeyword->keyword->name ?? null;
                })->filter()->values()->toArray();

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
                    'keywords' => $keywords,
                    'text_extra' => $this->formatKeywordsAsTextExtra($keywords),
                    'tiktok_url' => $this->getTikTokUrl($video->username, $video->video_id),
                    'thumbnail_url' => $video->thumbnail_url
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
     * Generate TikTok video URL
     */


    private function getTikTokUrl($username, $videoId)
    {
        $url = "https://www.tiktok.com/@{$username}/video/{$videoId}";


        return $url;
    }


    /**
     * Convert keywords array to text_extra format
     */
    private function formatKeywordsAsTextExtra($keywords)
    {
        if (empty($keywords)) {
            return [];
        }

        $textExtra = [];
        foreach ($keywords as $keyword) {
            $textExtra[] = [
                'hashtag_name' => $keyword,
            ];
        }

        return $textExtra;
    }

    /**
     * Get filtered query based on active user
     */
    private function getFilteredQuery()
    {
        $query = TikTokVideo::where('is_active', true);

        if ($this->activeUser !== 'All') {
            $query->where('author_nickname', $this->activeUser);
        }

        return $query;
    }

    public function setUser($username)
    {
        $this->activeUser = $username;
        $this->currentPage = 1;
        $this->loadVideos();
        $this->dispatch('scroll-to-videos');
    }

    public function shouldShowPagination()
    {
        $totalVideos = $this->getFilteredQuery()->count();
        return $totalVideos > $this->videosPerPage;
    }

    public function goToPage($page)
    {
        if ($page < 1) {
            return;
        }

        $totalVideos = $this->getFilteredQuery()->count();
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
        $totalVideos = $this->getFilteredQuery()->count();
        $totalPages = ceil($totalVideos / $this->videosPerPage);
        return $this->currentPage < $totalPages;
    }

    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }

    public function getTotalPages()
    {
        $totalVideos = $this->getFilteredQuery()->count();
        return max(1, ceil($totalVideos / $this->videosPerPage));
    }

    public function getUsersProperty()
    {
        $users = ['All' => 'All'];

        // Get distinct author nicknames from active videos
        $authors = TikTokVideo::where('is_active', true)->distinct('username')
            ->pluck('username', 'author_nickname')
            ->toArray();
        return array_merge($users, $authors);
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
