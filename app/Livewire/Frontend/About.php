<?php

namespace App\Livewire\Frontend;

use App\Services\AboutCmsService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class About extends Component
{
    public $aboutCms = null;
    protected AboutCmsService $aboutCmsService;
    public function boot(AboutCmsService $aboutCmsService)
    {
        $this->aboutCmsService = $aboutCmsService;
    }

    public function mount()
    {
        $this->loadBanner();
    }

    public function loadBanner()
    {
        try {
            $this->aboutCms = $this->aboutCmsService->getFirstData();

        } catch (\Exception $e) {
            Log::error('Data loading failed', [
                'error' => $e->getMessage()
            ]);
            $this->data = null;
        }
    }


    public function render()
    {
        return view('livewire.frontend.about');
    }
}
