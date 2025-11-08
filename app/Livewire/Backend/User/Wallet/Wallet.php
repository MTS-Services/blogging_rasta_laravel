<?php

namespace App\Livewire\Backend\User\Wallet;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Wallet extends Component
{
    use WithPagination;
    public $perPage = 3;
    public function render()
    {
        $allItems = collect(
            [
                [
                    'id' => 1,
                    'date_created' => 'DD/MM/YYYY',
                    'balance' => '-$1.20',
                    'ordered_id' => '98bc4674-4bde-4498-9175-a4a0318458e0',
                    'description' => 'Purchased Order. Transaction CANCELED.',
                    'action' => 'active',
                ],
                [
                    'id' => 2,
                    'date_created' => 'DD/MM/YYYY',
                    'balance' => '+$1.20',
                    'ordered_id' => '98bc4674-4bde-4498-9175-a4a0318458e0',
                    'description' => 'You successfully sold Order.',
                    'action' => 'active',
                ],
                [
                    'id' => 3,
                    'date_created' => 'DD/MM/YYYY',
                    'balance' => '-$185.14',
                    'ordered_id' => '',
                    'description' => 'Payoneer withdrawal successful.',
                    'action' => 'active',
                ],
                [
                    'id' => 4,
                    'date_created' => 'DD/MM/YYYY',
                    'balance' => '-$185.14',
                    'ordered_id' => '',
                    'description' => 'Payoneer withdrawal successful.',
                    'action' => 'active',
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
                    'key' => 'date_created',
                    'label' => 'Date created',
                ],
                [
                    'key' => 'balance',
                    'label' => 'Balance',
                ],
                [
                    'key' => 'ordered_id',
                    'label' => 'Ordered ID',
                ],
                [
                    'key' => 'description',
                    'label' => 'Description',
                ],
                [
                    'key' => 'action',
                    'label' => 'Action',
                    'format' => fn($item) => '
                      <div class="flex items-center gap-3">
                        <a href="javascript:void(0)"  class="bg-zinc-500 hover:bg-zinc-600 text-white py-2 px-4 rounded-full">View</a>
                      </div>'
                ],
            ];

        return view('livewire.backend.user.wallet.wallet', [
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
