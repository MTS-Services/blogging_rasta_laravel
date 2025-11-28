<?php

namespace App\Livewire\Frontend;

use App\Models\ApplicationSetting;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\TikTokVideo;
use App\Services\TikTokService;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class VideoFeed extends Component
{

    use WithPagination;

    #[Url(keep: true)]
    public $activeUser = 'All';
    public $videos = [];
    public $loading = true;
    public $error = null;

    public $keywords = [];

    // Pagination properties
    public $currentPage = 1;
    public $videosPerPage = 9;

    // Cache total count to avoid repeated queries
    private $cachedTotalVideos = null;

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
        $this->videos = TikTokVideo::with(['videoKeywords'])
            ->where('is_active', true)->paginate(10);
    }

    // public function loadVideos()
    // {
    //     $this->loading = true;
    //     $this->error = null;

    //     try {
    //         // Base query - only active videos with keywords relationship
    //         $query = TikTokVideo::with(['videoKeywords'])
    //             ->where('is_active', true);


    //         // Filter by user if not 'All'
    //         if ($this->activeUser !== 'All') {
    //             $query->where('author_nickname', $this->activeUser);
    //         }

    //         // Order by create_time in descending order
    //         $query->orderBy('create_time', 'desc');

    //         // Get total count for pagination and cache it
    //         $this->cachedTotalVideos = $query->count();

    //         // Get videos for current page
    //         // $videosCollection = $query->skip(($this->currentPage - 1) * $this->videosPerPage)
    //         //     ->take($this->videosPerPage)
    //         //     ->get()
    //         //     ->shuffle();

    //         $this->videos = $query->paginate($this->videosPerPage);

    //         Log::info('VideoFeed - Videos loaded from database', [
    //             // 'page' => $this->currentPage,
    //             'videos_count' => count($this->videos),
    //             'total_videos' => $this->cachedTotalVideos,
    //             'active_user' => $this->activeUser,
    //         ]);

    //     } catch (\Exception $e) {
    //         $this->error = 'Failed to load videos: ' . $e->getMessage();
    //         Log::error('VideoFeed - Video loading failed', [
    //             'error' => $e->getMessage(),
    //             'page' => $this->currentPage,
    //         ]);
    //         $this->videos = [];
    //     }

    //     $this->loading = false;
    // }



    // /**
    //  * Convert keywords array to text_extra format
    //  */
    // private function formatKeywordsAsTextExtra($keywords)
    // {
    //     if (empty($keywords)) {
    //         return [];
    //     }

    //     $textExtra = [];
    //     foreach ($keywords as $keyword) {
    //         $textExtra[] = [
    //             'hashtag_name' => $keyword,
    //         ];
    //     }

    //     return $textExtra;
    // }

    /**
     * Get total videos count (uses cache if available)
     */
    // private function getTotalVideosCount()
    // {
    //     if ($this->cachedTotalVideos === null) {
    //         $this->cachedTotalVideos = $this->getFilteredQuery()->count();
    //     }
    //     return $this->cachedTotalVideos;
    // }

    /**
     * Get filtered query based on active user
     */
    // private function getFilteredQuery()
    // {
    //     $query = TikTokVideo::select('is_active')->where('is_active', true);

    //     if ($this->activeUser !== 'All') {
    //         $query->where('author_nickname', $this->activeUser);
    //     }

    //     return $query;
    // }

    public function setUser($username)
    {
        $this->activeUser = $username;
        $this->currentPage = 1;
        $this->cachedTotalVideos = null; // Reset cache when user changes
        $this->loadVideos();
        $this->dispatch('scroll-to-videos');
    }

    // public function shouldShowPagination()
    // {
    //     return $this->getTotalVideosCount() > $this->videosPerPage;
    // }

    // public function goToPage($page)
    // {
    //     if ($page < 1) {
    //         return;
    //     }

    //     $totalPages = ceil($this->getTotalVideosCount() / $this->videosPerPage);

    //     if ($page > $totalPages) {
    //         return;
    //     }

    //     $this->currentPage = $page;
    //     $this->loadVideos();
    //     $this->dispatch('scroll-to-videos');
    // }

    // public function nextPage()
    // {
    //     if ($this->hasNextPage()) {
    //         $this->currentPage++;
    //         $this->loadVideos();
    //         $this->dispatch('scroll-to-videos');
    //     }
    // }

    // public function previousPage()
    // {
    //     if ($this->hasPreviousPage()) {
    //         $this->currentPage--;
    //         $this->loadVideos();
    //         $this->dispatch('scroll-to-videos');
    //     }
    // }

    // public function hasNextPage()
    // {
    //     $totalPages = ceil($this->getTotalVideosCount() / $this->videosPerPage);
    //     return $this->currentPage < $totalPages;
    // }

    // public function hasPreviousPage()
    // {
    //     return $this->currentPage > 1;
    // }

    // public function getTotalPages()
    // {
    //     return max(1, ceil($this->getTotalVideosCount() / $this->videosPerPage));
    // }

    public function getUsersProperty()
    {

        $all = [
            [
                "username" => "All",
                "display_name" => "All",
                "max_videos" => "1000000",
            ]
        ];

        // Get distinct author nicknames from active videos
        $authors = ApplicationSetting::get('featured_users', '[]');
        $authors = json_decode($authors, true);


        return array_merge($all, $authors);
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
