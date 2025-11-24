<?php

namespace App\Livewire\Frontend;

use App\Models\TikTokVideo;
use Livewire\Component;

class VideoDetails extends Component
{
    public TikTokVideo $data;

    public function mount(TikTokVideo $data): void
    {
        $this->data = $data;
    }

    public function formatNumber($number)
    {
        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }
        return $number;
    }

    public function render()
    {
        return view('livewire.frontend.video-details');
    }
}
