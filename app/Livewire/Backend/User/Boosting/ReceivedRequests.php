<?php

namespace App\Livewire\Backend\User\Boosting;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class ReceivedRequests extends Component
{

    use WithPagination;

    public $perPage = 6;
    public function render()
    {
        $allItems = collect(
            [
                [
                    'id' => 1,
                    'name' => 'Fortnite VB Skin Gift',
                    'game_image' => asset('assets/images/fortnite.png'),
                    'buyer' => 'Shadow_Elder',
                    'category'  => 'Battle Royale Rank Boost',
                    'request_creation_date' => 'DD/MM/YYYY',
                    // 'status' => 'Cancel',
                ],
                [
                    'id' => 2,
                    'name' => 'Fortnite VB Skin Gift',
                    'game_image' => asset('assets/images/fortnite.png'),
                    'buyer' => 'DandyClap',
                    'category' => 'Items',
                    'request_creation_date' => 'DD/MM/YYYY',
                    // 'status' => 'Completed',
                ],
                [
                    'id' => 3,
                    'name' => 'Fortnite VB Skin Gift',
                    'game_image' => asset('assets/images/fortnite.png'),
                    'buyer' => 'SassyLab-6uUz',
                    'category' => 'Items',
                    'request_creation_date' => 'DD/MM/YYYY',
                    // 'status' => 'Completed',
                ],
                [
                    'id' => 4,
                    'name' => 'Fortnite VB Skin Gift',
                    'game_image' => asset('assets/images/fortnite.png'),
                    'buyer' => 'Ample Run-Xvwe',
                    'category' => 'Items',
                    'request_creation_date' => 'DD/MM/YYYY',
                    // 'status' => 'Completed',
                ],
                [
                    'id' => 5,
                    'name' => 'Fortnite VB Skin Gift',
                    'game_image' => asset('assets/images/fortnite.png'),
                    'buyer' => 'keryasie',
                    'category' => 'Items',
                    'request_creation_date' => 'DD/MM/YYYY',
                    // 'status' => 'Completed',
                ],
                [
                    'id' => 6,
                    'name' => 'Fortnite VB Skin Gift',
                    'game_image' => asset('assets/images/fortnite.png'),
                    'buyer' => 'Keevun',
                    'category' => 'Items',
                    'request_creation_date' => 'DD/MM/YYYY',
                    // 'status' => 'Completed',
                ],
                [
                    'id' => 7,
                    'name' => 'Fortnite VB Skin Gift',
                    'game_image' => asset('assets/images/fortnite.png'),
                    'buyer' => 'Keevun',
                    'category' => 'Items',
                    'request_creation_date' => 'DD/MM/YYYY',
                    // 'status' => 'Completed',
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
                    </div>
                </div>'
                ],
                [
                    'key' => 'buyer',
                    'label' => 'Buyer',
                ],
                [
                    'key' => 'category',
                    'label' => 'Category',
                ],
                [
                    'key' => 'request_creation_date',
                    'label' => 'Request creation date',
                ],
                // [
                //     'key' => 'status',
                //     'label' => 'Status',
                //     'badge' => true,
                //     'badgeColors' => [
                //         'completed' => 'bg-pink-500',
                //         'cancel' => 'bg-status-paused',
                //     ]
                // ],
            ];
        return view('livewire.backend.user.boosting.received-requests', [
            'items' => $items,
            'columns' => $columns,
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
}
