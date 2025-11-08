<?php

namespace App\Livewire\Backend\User\Offers;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class GiftCards extends Component
{

    use WithPagination;

    public $showDeleteModal = false;
    public $deleteItemId = null;
    public $perPage = 4;
    
    public function render()
    {
        $allItems = collect(
            [
                [
                    'id' => 1,
                    'name' => 'Cheapest Fresh Fortnite',
                    'subtitle' => 'Account with 135,000 V-Bud....',
                    'game_image' => asset('assets/images/item1.png'),
                    'quantity' => '1',
                    'min_quantity' => '1',
                    'price' => '$65',
                    'device' => 'PC',
                    'status' => 'active',
                    'delivery_time' => '1 h',
                ],
                [
                    'id' => 2,
                    'name' => 'Fortnite Fresh Account ',
                    'subtitle' => '(135,000 V-Bucks) | Works...',
                    'game_image' => asset('assets/images/item2.png'),
                    'quantity' => '1',
                    'min_quantity' => '1',
                    'price' => '$95',
                    'device' => 'Xbox',
                    'status' => 'active',
                    'delivery_time' => '10 min',
                ],
                [
                    'id' => 3,
                    'name' => '135,000 V-Bucks Fortnite ',
                    'subtitle' => 'Account | All Platforms Sup...',
                    'game_image' => asset('assets/images/item3.png'),
                    'quantity' => '1',
                    'min_quantity' => '1',
                    'price' => '$60',
                    'device' => 'PC',
                    'status' => 'active',
                    'delivery_time' => '15 min',
                ],
                [
                    'id' => 4,
                    'name' => 'Fresh Fortnite Account 135K',
                    'subtitle' => 'V-Bucks | All Platforms Sup...',
                    'game_image' => asset('assets/images/item4.png'),
                    'quantity' => '1',
                    'min_quantity' => '1',
                    'price' => '$65',
                    'device' => 'PC',
                    'status' => 'active',
                    'delivery_time' => '45 min',
                ],
                [
                    'id' => 5,
                    'name' => 'Fresh Fortnite Account 135K',
                    'subtitle' => 'V-Bucks | All Platforms Sup...',
                    'game_image' => asset('assets/images/item4.png'),
                    'quantity' => '1',
                    'min_quantity' => '1',
                    'price' => '$65',
                    'device' => 'PC',
                    'status' => 'active',
                    'delivery_time' => '45 min',
                ],
            ]
        )->map(fn($item) => (object)$item);

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
                        <img src="' . ($item->game_image ?? '/default.png') . '" 
                            class="w-14 h-14 rounded-lg object-cover flex-shrink-0" 
                            alt="' . e($item->name ?? 'Game') . '">
                        <div class="flex flex-col">
                            <span class="font-semibold text-text-white text-sm sm:text-base leading-tight"
                                title="' . e($item->name ?? '-') . '">'
                        . e(Str::limit($item->name ?? '-', 30)) .
                        '</span>
                        <span class="text-text-muted text-xs sm:text-sm"
                            title="' . e($item->subtitle ?? '(No details)') . '">'
                        . e(Str::limit($item->subtitle ?? '(No details)', 28)) .
                        '</span>
                    </div>
                </div>'
                ],
                [
                    'key' => 'quantity',
                    'label' => 'Quantity',
                ],
                [
                    'key' => 'price',
                    'label' => 'Price',
                ],
                [
                    'key' => 'device',
                    'label' => 'Device',
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

        return view('livewire.backend.user.offers.gift-cards', [
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
