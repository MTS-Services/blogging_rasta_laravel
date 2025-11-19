<?php

namespace App\Livewire\Backend\Admin\TikTokManagement;

use App\Models\TikTokVideo;
use App\Models\Keyword;
use App\Models\VideoKeyword;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class VideoKeywords extends Component
{
    use  WithNotification;
    public TikTokVideo $data;
    public $keywords;
    public $selectedKeywords = [];
    public $hasExistingKeywords = false;

    public function mount(TikTokVideo $data): void
    {
        $this->data = $data;
        $this->keywords = Keyword::orderBy('sort_order')->get();

        // Load already selected keywords through VideoKeyword
        $this->selectedKeywords = VideoKeyword::where('tik_tok_video_id', $this->data->id)
            ->pluck('keyword_id')
            ->toArray();

        // Check if keywords already exist
        $this->hasExistingKeywords = count($this->selectedKeywords) > 0;
    }

    public function save()
    {
        // Delete existing video keywords
        VideoKeyword::where('tik_tok_video_id', $this->data->id)->delete();

        // Insert new selected keywords
        foreach ($this->selectedKeywords as $keywordId) {
            VideoKeyword::create([
                'tik_tok_video_id' => $this->data->id,
                'keyword_id' => $keywordId,
            ]);
        }

        $message = $this->hasExistingKeywords ? 'Keywords updated successfully!' : 'Keywords created successfully!';
        $this->success('Keywords saved successfully!', $message);

        // Refresh selected keywords after save
        $this->selectedKeywords = VideoKeyword::where('tik_tok_video_id', $this->data->id)
            ->pluck('keyword_id')
            ->toArray();

        $this->hasExistingKeywords = true;
    }

    public function resetForm()
    {
        // Reset to original keywords
        $this->selectedKeywords = VideoKeyword::where('tik_tok_video_id', $this->data->id)
            ->pluck('keyword_id')
            ->toArray();

        $this->dispatch('reset-select2', selectedKeywords: $this->selectedKeywords);
    }

    public function render()
    {
        // Get selected keyword details for display
        $selectedKeywordDetails = Keyword::whereIn('id', $this->selectedKeywords)->get();

        return view('livewire.backend.admin.tik-tok-management.video-keywords', [
            'selectedKeywordDetails' => $selectedKeywordDetails
        ]);
    }
}
