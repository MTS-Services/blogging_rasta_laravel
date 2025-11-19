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

        // Get display name (author_nickname) from first video of this user
        $firstVideo = TikTokVideo::where('is_active', true)
            ->where('username', $username)
            ->whereNotNull('author_nickname')
            ->first();

        if (!$firstVideo) {
            $this->error = 'User not found';
            $this->loading = false;
            return;
        }

        $this->displayName = $firstVideo->author_nickname ?: $username;

        $this->loadVideos();
    }

    // Replace the loadVideos() method:

    public function loadVideos()
    {
        $this->loading = true;
        $this->error = null;

        try {
            // Query videos from database for this specific user with keywords relationship
            $query = TikTokVideo::with(['videoKeywords.keyword'])
                ->where('is_active', true)
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

// Replace the extractHashtagsAsTextExtra() method:

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
     * Get filtered query for this user
     */
    private function getFilteredQuery()
    {
        return TikTokVideo::where('is_active', true)
            ->where('username', $this->username);
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
        $users = ['All'];

        // Get distinct author nicknames from active videos
        $authors = TikTokVideo::where('is_active', true)
            ->whereNotNull('author_nickname')
            ->where('author_nickname', '!=', '')
            ->select('author_nickname')
            ->distinct()
            ->orderBy('author_nickname')
            ->pluck('author_nickname')
            ->toArray();

        return array_merge($users, $authors);
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
