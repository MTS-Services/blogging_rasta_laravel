<?php

namespace App\Livewire\Frontend;

use App\Services\BannerVideoService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class About extends Component
{
     public $banner = null;
    protected $bannerService;
     public function boot( BannerVideoService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function mount(){
        $this->loadBanner();
    }

      public function loadBanner()
    {
        try {
            $this->banner = $this->bannerService->getFirstData();
            
            Log::info('Banner video loaded', [
                'has_banner' => $this->banner !== null,
            ]);
        } catch (\Exception $e) {
            Log::error('Banner loading failed', [
                'error' => $e->getMessage()
            ]);
            $this->banner = null;
        }
    }


    public function render()
    {
        return view('livewire.frontend.about');
    }
}
