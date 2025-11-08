<?php

namespace App\Livewire\Backend\User\Offers;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class TopUps extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $deleteItemId = null;
    public $perPage = 3;
    public function render()
    {
        $allItems = collect([
            [
                'id' => 1,
                'name' => 'Genshin Impact - Genesis ',
                'subtitle' => 'Crystals top up',
                'service' => 'Genshin Impact - Genesis Crystals top up',
                'amount' => '5000 Crystals',
                'quantity' => '1',
                'min_quantity' => '1',
                'price' => '$35',
                'device' => 'PC',
                'status' => 'active',
                'delivery_time' => '15 minutes',
            ],
            [
                'id' => 2,
                'name' => 'Fortnite - 10,000 V-Bucks',
                'amount' => '10,000 V-Bucks',
                'price' => '$50',
                'status' => 'active',
                'delivery_time' => 'Instant',
            ],
            [
                'id' => 3,
                'name' => 'FIFA Coins - 1,000,000',
                'amount' => '1,000,000 coins',
                'price' => '$30',
                'status' => 'active',
                'delivery_time' => '30 minutes',
            ],
            [
                'id' => 4,
                'name' => 'Cheapest Fresh Fortnite',
                'amount' => '135,000 V-Bucks',
                'price' => '$65',
                'status' => 'active',
                'delivery_time' => '1 h',
            ],
            [
                'id' => 5,
                'name' => 'Fortnite Fresh Account',
                'amount' => '135,000 V-Bucks',
                'price' => '$95',
                'status' => 'active',
                'delivery_time' => '10 min',
            ],
            [
                'id' => 6,
                'name' => '135,000 V-Bucks Fortnite',
                'amount' => '135,000 V-Bucks',
                'price' => '$60',
                'status' => 'active',
                'delivery_time' => '15 min',
            ],
            [
                'id' => 7,
                'name' => 'Fresh Fortnite Account 135K',
                'amount' => '135,000 V-Bucks',
                'price' => '$65',
                'status' => 'active',
                'delivery_time' => '45 min',
            ],
            [
                'id' => 8,
                'name' => 'Call of Duty Skin',
                'amount' => '20M Credits',
                'price' => '$9.5 (20k)',
                'status' => 'paused',
                'delivery_time' => '1 h',
            ]
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
        $columns =
            [
                [
                    'key' => 'name',
                    'label' => 'Game',
                    'sortable' => true,
                    'format' => fn($item) => '
                <div class="flex items-center gap-3">
                    <div class="flex flex-col">
                        <span class="font-semibold text-text-white text-sm sm:text-base leading-tight"
                            title="' . e($item->name ?? '-') . '">'
                        . e(Str::limit($item->name ?? '-', 30)) .
                        '</span>
                        <span class="text-text-muted text-xs sm:text-sm"
                            title="' . e($item->subtitle ?? '') . '">'
                        . e(Str::limit($item->subtitle ?? '', 28)) .
                        '</span>
                    </div>
                </div>'
                ],
                [
                    'key' => 'amount',
                    'label' => 'Amount',
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

        return view('livewire.backend.user.offers.top-ups', [
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
