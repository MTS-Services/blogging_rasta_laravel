<?php

namespace App\Livewire\Backend\Admin\TikTokManagement;

use App\Models\TikTokVideo;
use App\Services\TikTokService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithPagination;

class TikTokVideos extends Component
{
    use WithPagination, WithNotification;

    public $search = '';
    public $perPage = 15;
    public $statusFilter = '';
    public $sortField = 'create_time';
    public $sortDirection = 'desc';

    // Bulk actions
    public $selectedIds = [];
    public $selectAll = false;
    public $bulkAction = '';

    protected $tiktokService;

    public function boot(TikTokService $tiktokService)
    {
        $this->tiktokService = $tiktokService;
    }

    public function updatedSelectAll($value)
    {
        $this->selectedIds = $value
            ? TikTokVideo::pluck('id')->toArray()
            : [];
    }

    public function updatedSelectedIds()
    {
        $this->selectAll = false;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->perPage = 15;
        $this->selectedIds = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    /**
     * Sync videos from TikTok API
     */
    public function syncVideos()
    {
        try {
            $usernames = config('tiktok.featured_users', []);

            if (empty($usernames)) {
                $this->error('No TikTok users configured');
                return;
            }

            $usernames = array_column($usernames, 'username');

            $result = $this->tiktokService->syncVideos($usernames, 20);

            if ($result['success']) {
                $this->success("Synced: {$result['synced']} new, {$result['updated']} updated");
            } else {
                $this->error($result['error'] ?? 'Sync failed');
            }
        } catch (\Exception $e) {
            $this->error('Sync error: ' . $e->getMessage());
        }
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($videoId)
    {
        try {
            $result = $this->tiktokService->toggleFeatured($videoId);

            if ($result['success']) {
                $this->success($result['message']);
            } else {
                $this->error($result['error']);
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Toggle active status
     */
    public function toggleActive($videoId)
    {
        try {
            $result = $this->tiktokService->toggleActive($videoId);

            if ($result['success']) {
                $this->success($result['message']);
            } else {
                $this->error($result['error']);
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Delete single video
     */
    public function deleteVideo($videoId)
    {
        try {
            TikTokVideo::findOrFail($videoId)->delete();

            $this->success('Video deleted successfully');
        } catch (\Exception $e) {
            $this->error('Delete error: ' . $e->getMessage());
        }
    }

    /**
     * Bulk actions
     */
    public function confirmBulkAction()
    {
        if (empty($this->bulkAction) || empty($this->selectedIds)) {
            $this->error('Please select action and items');
            return;
        }

        try {
            switch ($this->bulkAction) {
                case 'activate':
                    TikTokVideo::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
                    $this->success(count($this->selectedIds) . ' videos activated');
                    break;

                case 'deactivate':
                    TikTokVideo::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
                    $this->success(count($this->selectedIds) . ' videos deactivated');
                    break;

                case 'feature':
                    TikTokVideo::whereIn('id', $this->selectedIds)->update(['is_featured' => true]);
                    $this->success(count($this->selectedIds) . ' videos featured');
                    break;

                case 'unfeature':
                    TikTokVideo::whereIn('id', $this->selectedIds)->update(['is_featured' => false]);
                    $this->success(count($this->selectedIds) . ' videos unfeatured');
                    break;
            }

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';

        } catch (\Exception $e) {
            $this->error('Bulk action error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $videos = TikTokVideo::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('desc', 'like', '%' . $this->search . '%')
                      ->orWhere('username', 'like', '%' . $this->search . '%')
                      ->orWhere('author_nickname', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter === 'active', fn($q) => $q->where('is_active', true))
            ->when($this->statusFilter === 'inactive', fn($q) => $q->where('is_active', false))
            ->when($this->statusFilter === 'featured', fn($q) => $q->where('is_featured', true))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.admin.tik-tok-management.tik-tok-videos', [
            'videos' => $videos,
            'columns' => $this->getColumns(),
            'actions' => $this->getActions(),
            'statuses' => $this->getStatuses(),
            'bulkActions' => $this->getBulkActions(),
        ]);
    }

    private function getColumns()
    {
        return [
            [
                'key' => 'id',
                'label' => 'ID',
                'sortable' => true,
            ],
            [
                'key' => 'cover',
                'label' => 'Thumbnail',
                'format' => fn($video) => view('components.admin.video-thumbnail', [
                    'video' => $video
                ])->render(),
            ],
            [
                'key' => 'title',
                'label' => 'Title',
                'sortable' => true,
                'format' => fn($video) => '<div class="max-w-xs truncate">' . ($video->title ?: $video->desc) . '</div>',
            ],
            [
                'key' => 'username',
                'label' => 'Username',
                'sortable' => true,
            ],
            [
                'key' => 'play_count',
                'label' => 'Views',
                'sortable' => true,
                'format' => fn($video) => $video->formatted_play_count,
            ],
            [
                'key' => 'digg_count',
                'label' => 'Likes',
                'sortable' => true,
                'format' => fn($video) => $video->formatted_digg_count,
            ],
            [
                'key' => 'is_featured',
                'label' => 'Featured',
                'format' => fn($video) => view('components.admin.badge', [
                    'label' => $video->is_featured ? 'Yes' : 'No',
                    'type' => $video->is_featured ? 'success' : 'gray'
                ])->render(),
            ],
            [
                'key' => 'is_active',
                'label' => 'Status',
                'format' => fn($video) => view('components.admin.badge', [
                    'label' => $video->is_active ? 'Active' : 'Inactive',
                    'type' => $video->is_active ? 'success' : 'danger'
                ])->render(),
            ],
            [
                'key' => 'create_time',
                'label' => 'Created',
                'sortable' => true,
                'format' => fn($video) => $video->create_time->format('M d, Y'),
            ],
        ];
    }

    private function getActions()
    {
        return [
            [
                'label' => 'Featured On/Off',
                'method' => 'toggleFeatured',
                'key' => 'id',
            ],
            [
                'label' => 'Active On/Off',
                'method' => 'toggleActive',
                'key' => 'id',
            ],
            // [
            //     'label' => 'Delete',
            //     'method' => 'deleteVideo',
            //     'key' => 'id',
            // ],
        ];
    }

    private function getStatuses()
    {
        return [
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
            ['value' => 'featured', 'label' => 'Featured'],
        ];
    }

    private function getBulkActions()
    {
        return [
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'deactivate', 'label' => 'Deactivate'],
            ['value' => 'feature', 'label' => 'Feature'],
            ['value' => 'unfeature', 'label' => 'Unfeature'],
        ];
    }
}
