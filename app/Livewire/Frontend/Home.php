<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class Home extends Component
{
    public $input;
    public $email;
    public $password;
    public $disabled;

    public $standardSelect;
    public $disabledSelect;
    public $select2Single;
    public $select2Multiple;

    public $featuredVideos;
    public $hashtags;
    public function mount()
    {
        $this->loadData();
    }


    public function loadData()
    {
        $this->featuredVideos = [
            ['thumb' => 'Image(video thumbnail).png', 'avatar' => 'Image (user avatar).png'],
            ['thumb' => 'Featured 2.png', 'avatar' => 'Featured 2.1.png'],
            ['thumb' => 'Featured3.png', 'avatar' => 'Featured3.1.png'],
            ['thumb' => 'Featured4.png', 'avatar' => '1 (4).png'],
            ['thumb' => 'Featured4.png', 'avatar' => 'xcc.png'],
            ['thumb' => 'Featured5.png', 'avatar' => '1 (2).png'],
            ['thumb' => 'Featured6.png', 'avatar' => '1 (3).png'],
            ['thumb' => 'Featured7.png', 'avatar' => '1 (4).png'],
            ['thumb' => 'Featured8.png', 'avatar' => '1 (5).png'],
            ['thumb' => 'Featured9.png', 'avatar' => '1 (6).png'],
            ['thumb' => 'Featured10.png', 'avatar' => '1 (7).png'],
            ['thumb' => 'Featured11.png', 'avatar' => '1 (8).png'],
        ];
        $this->hashtags = [
            ['tag' => '#GlowSkin', 'videos' => '48'],
            ['tag' => '#DiodioTips', 'videos' => '32'],
            ['tag' => '#NaturalBeauty', 'videos' => '125'],
            ['tag' => '#SkincareRoutine', 'videos' => '95'],
            ['tag' => '#BeautyHaul', 'videos' => '72'],
            ['tag' => '#SkincareTips', 'videos' => '156'],
        ];
    }

    public $content = '<p>This is the initial content of the editor.</p>';

    public function saveContent()
    {
        dd($this->content);
    }
    public function saveContent2()
    {
        dd($this->content);
    }

    public function render()
    {
        return view('livewire.frontend.home');
    }
}
