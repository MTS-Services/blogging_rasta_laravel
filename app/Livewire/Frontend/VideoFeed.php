<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class VideoFeed extends Component
{
    public $activeCategory = 'All';

    public $categories = [
        'All',
        'Morning',
        'Evening',
        'Haul',
        'Tips',
        'Problem-Solving',
        'Makeup'
    ];

    public $videos = [
        [
            'title' => '10-Step Korean Skincare Routine',
            'author' => 'Diodio Glow',
            'likes' => '2.8K',
            'comments' => '1.4K',
            'category' => 'Morning',
            'tags' => ['#GlowSkin', '#KoreanSkincare', '#DiodioTips'],
            'image' => 'assets/images/video/video (1).png',
        ],
        [
            'title' => 'Budget Skincare Haul (Under $50)',
            'author' => 'Diodio Glow',
            'likes' => '18K',
            'comments' => '2.8K',
            'category' => 'Haul',
            'tags' => ['#GlowSkin', '#Haul', '#DiodioTips'],
            'image' => 'assets/images/video/video (2).png',
        ],
        [
            'title' => 'How to Fix Dehydrated Skin Fast',
            'author' => 'Diodio Glow',
            'likes' => '18K',
            'comments' => '2.8K',
            'category' => 'Problem-Solving',
            'tags' => ['#GlowSkin', '#Hydration', '#DiodioTips'],
            'image' => 'assets/images/video/video (3).png',
        ],
        [
            'title' => 'Acne-Prone Skin Routine That Actually Works',
            'author' => 'Diodio Glow',
            'likes' => '18K',
            'comments' => '2.8K',
            'category' => 'Tips',
            'tags' => ['#GlowSkin', '#KoreanSkincare', '#DiodioTips'],
            'image' => 'assets/images/video/video (4).png',
        ],

        [
            'title' => 'Evening Glow Routine for All Skin Types',
            'author' => 'Diodio Glow',
            'likes' => '18K',
            'comments' => '2.8K',
            'category' => 'Evening',
            'tags' => ['#GlowSkin', '#KoreanSkincare', '#DiodioTips'],
            'image' => 'assets/images/video/video (5).png',
        ],

        [
            'title' => 'Glow-Getter Makeup Remover Alternative',
            'author' => 'Diodio Glow',
            'likes' => '18K',
            'comments' => '2.8K',
            'category' => 'Makeup',
            'tags' => ['#GlowSkin', '#KoreanSkincare', '#DiodioTips'],
            'image' => 'assets/images/video/video (6).png',
        ],
    ];

    public function setCategory($category)
    {
        $this->activeCategory = $category;
    }

    public function getFilteredVideosProperty()
    {
        if ($this->activeCategory === 'All') {
            return $this->videos;
        }

        return collect($this->videos)->where('category', $this->activeCategory)->toArray();
    }

    public function render()
    {
        return view('livewire.frontend.video-feed', [
            'filteredVideos' => $this->filtered_videos,
        ]);
    }
}
