<?php

namespace App\Livewire\Backend\User\Offers;

use Livewire\Component;
use Livewire\WithPagination;

class Currency extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $deleteItemId = null;
    public $perPage = 7;

    public function render()
    {
        $allItems = collect([
            [
                'id' => 1,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '1B',
                'min_quantity' => '100k',
                'price' => '$6.5 (100k)',
                'status' => 'active',
                'delivery_time' => '1 h',
            ],
            [
                'id' => 2,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '2B',
                'min_quantity' => '200K',
                'price' => '$9.5 (200k)',
                'status' => 'active',
                'delivery_time' => '10 min',
            ],
            [
                'id' => 3,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '2M',
                'min_quantity' => '1K',
                'price' => '$6 (1k)',
                'status' => 'active',
                'delivery_time' => '15 min',
            ],
            [
                'id' => 4,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '10M',
                'min_quantity' => '10K',
                'price' => '$6.5 (10k)',
                'status' => 'active',
                'delivery_time' => '45 min',
            ],
            [
                'id' => 5,
                'name' => 'Call of Duty Skin',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '20M',
                'min_quantity' => '20K',
                'price' => '$9.5 (20k)',
                'status' => 'paused',
                'delivery_time' => '1 h',
            ],
            [
                'id' => 6,
                'name' => 'Apex Legends',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '10M',
                'min_quantity' => '50K',
                'price' => '$5.5 (50k)',
                'status' => 'paused',
                'delivery_time' => '1 h',
            ],
            [
                'id' => 7,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '2.5B',
                'min_quantity' => '100K',
                'price' => '$6.5 (100k)',
                'status' => 'paused',
                'delivery_time' => '1 h',
            ],
            [
                'id' => 8,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '2.5B',
                'min_quantity' => '100K',
                'price' => '$6.5 (100k)',
                'status' => 'paused',
                'delivery_time' => '1 h',
            ],
        ])->map(fn($item) => (object)$item);

        $currentPage = $this->getPage();
        $items = $allItems->slice(($currentPage - 1) * $this->perPage, $this->perPage)->values();
        
        $pagination = [
            'total' => $allItems->count(),
            'per_page' => $this->perPage,
            'current_page' => $currentPage,
            'last_page' => ceil($allItems->count() / $this->perPage),
            'from' => (($currentPage - 1) * $this->perPage) + 1,
            'to' => min($currentPage * $this->perPage, $allItems->count()),
        ];

        // Table columns configuration
        $columns = [
            [
                'key' => 'name',
                'label' => 'Game',
                'sortable' => true,
                'format' => fn($item) => '<div class="flex items-center gap-3"><img src="' . ($item->game_image ?? null) . '" class="w-10 h-10 rounded-lg object-cover" alt="' . ($item->name ?? 'Game') . '"><span class="font-semibold text-text-white">' . ($item->name ?? '-') . '</span></div>'
            ],
            [
                'key' => 'quantity',
                'label' => 'Quantity',
            ],
            [
                'key' => 'min_quantity',
                'label' => 'Minimum quantity',
            ],
            [
                'key' => 'price',
                'label' => 'Price',
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'badge' => true,
                'badgeColors' => [
                    'active' => 'bg-pink-500',
                    'paused' => 'bg-status-paused',
                ]
            ],
            [
                'key' => 'delivery_time',
                'label' => 'Delivery time',
            ],
        ];

        // Action buttons configuration
        $actions = [
            [
                'icon' => 'pause-fill',
                'method' => 'pauseItem',
                'label' => 'Pause',
                'condition' => fn($item) => $item->status === 'active',
            ],
            [
                'icon' => 'play-fill',
                'method' => 'playItem',
                'label' => 'Resume',
                'condition' => fn($item) => $item->status === 'paused',
            ],
            [
                'icon' => 'link-fill',
                'route' => 'user.profile',
                'label' => 'Link',
            ],
            [
                'icon' => 'pencil-simple-fill',
                'route' => 'user.profile',
                'label' => 'Edit',
            ],
            [
                'icon' => 'trash-fill',
                'method' => 'confirmDelete',
                'label' => 'Delete',
            ],
        ];

        return view('livewire.backend.user.offers.currency', [
            'items' => $items,
            'columns' => $columns,
            'actions' => $actions,
            'pagination' => $pagination,
        ]);
    }

    public function pauseItem($id)
    {
        //  pause logic 
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Item #{$id} paused successfully"
        ]);
    }

    public function resumeItem($id)
    {
        // resume logic 
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Item #{$id} resumed successfully"
        ]);
    }

    public function editItem($id)
    {
        // edit logic
        return redirect()->route('routeName', $id);
    }

    public function confirmDelete($id)
    {
        $this->deleteItemId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteItem()
    {
        if (!$this->deleteItemId) {
            return;
        }
        // Game::find($this->deleteItemId)->delete();

        $this->showDeleteModal = false;
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Item deleted successfully"
        ]);

        $this->deleteItemId = null;
    }
}