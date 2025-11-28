<?php

namespace App\Livewire\Frontend;

use App\Models\ApplicationSetting;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\TikTokVideo;
use Livewire\WithPagination;

class VideoFeed extends Component
{
    use WithPagination;

    #[Url(keep: true)]
    public $activeUser = 'All';

    public function render()
    {
        $query = TikTokVideo::with(['videoKeywords'])
            ->where('is_active', true);

        // Filter by user if not "All"
        if ($this->activeUser !== 'All') {
            $query->where('username', $this->activeUser);
        }

        $videos = $query->paginate(9);

        return view('livewire.frontend.video-feed', compact('videos'));
    }

    public function setUser($username)
    {
        $this->activeUser = $username;
        $this->resetPage(); // Reset to page 1 when changing filters
        $this->dispatch('scroll-to-videos');
    }

    // Custom pagination methods
    public function nextPage()
    {
        $this->setPage($this->getPage() + 1);
        $this->dispatch('scroll-to-videos');
    }

    public function previousPage()
    {
        $this->setPage($this->getPage() - 1);
        $this->dispatch('scroll-to-videos');
    }

    public function goToPage($page)
    {
        $this->setPage($page);
        $this->dispatch('scroll-to-videos');
    }

    public function getPage()
    {
        return $this->paginators['page'] ?? 1;
    }

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
        if (!is_numeric($number)) {
            return '0';
        }

        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }

        return number_format($number);
    }
}
