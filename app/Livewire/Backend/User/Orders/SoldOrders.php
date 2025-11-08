<?php

namespace App\Livewire\Backend\User\Orders;

use Livewire\Component;
use Livewire\WithPagination;

class SoldOrders extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $deleteItemId = null;
    public $perPage = 7;

    public function render()
    {
        // Orders data matching your table structure
        $allOrders = collect([
            [
                'id' => 1,
                'name' => 'Fortnite VB Skin Gift',
                'image' => asset('assets/images/order.png'),
                'subtitle' => 'Cheapest +75% Discount',
                'type' => 'Items',
                'buyer' => 'Albert Flores',
                'ordered_date' => 'February 11, 2014',
                'status' => 'Completed',
                'quantity' => 7421,
                'price' => 4.75,
            ],
            [
                'id' => 2,
                'name' => 'Fortnite VB Skin Gift',
                'image' => asset('assets/images/order.png'),
                'subtitle' => 'Cheapest +75% Discount',
                'type' => 'Items',
                'buyer' => 'Jenny Wilson',
                'ordered_date' => 'February 28, 2018',
                'status' => 'Completed',
                'quantity' => 5832,
                'price' => 15.30,
            ],
            [
                'id' => 3,
                'name' => 'Fortnite VB Skin Gift',
                'image' => asset('assets/images/order.png'),
                'subtitle' => 'Cheapest +75% Discount',
                'type' => 'Items',
                'buyer' => 'Albert Flores',
                'ordered_date' => 'February 11, 2014',
                'status' => 'Completed',
                'quantity' => 7421,
                'price' => 4.75,
            ],
            [
                'id' => 4,
                'name' => 'Fortnite VB Skin Gift',
                'image' => asset('assets/images/order.png'),
                'subtitle' => 'Cheapest +75% Discount',
                'type' => 'Items',
                'buyer' => 'Jenny Wilson',
                'ordered_date' => 'February 28, 2018',
                'status' => 'Completed',
                'quantity' => 5832,
                'price' => 15.30,
            ],
            [
                'id' => 5,
                'name' => 'Fortnite VB Skin Gift',
                'image' => asset('assets/images/order.png'),
                'subtitle' => 'Cheapest +75% Discount',
                'type' => 'Items',
                'buyer' => 'Albert Flores',
                'ordered_date' => 'February 11, 2014',
                'status' => 'Completed',
                'quantity' => 7421,
                'price' => 4.75,
            ],
            [
                'id' => 6,
                'name' => 'Fortnite VB Skin Gift',
                'image' => asset('assets/images/order.png'),
                'subtitle' => 'Cheapest +75% Discount',
                'type' => 'Items',
                'buyer' => 'Jenny Wilson',
                'ordered_date' => 'February 28, 2018',
                'status' => 'In Progress',
                'quantity' => 5832,
                'price' => 15.30,
            ],
            [
                'id' => 7,
                'name' => 'Fortnite VB Skin Gift',
                'image' => asset('assets/images/order.png'),
                'subtitle' => 'Cheapest +75% Discount',
                'type' => 'Items',
                'buyer' => 'Jenny Wilson',
                'ordered_date' => 'February 28, 2018',
                'status' => 'Pending',
                'quantity' => 5832,
                'price' => 15.30,
            ],
            [
                'id' => 8,
                'name' => 'Fortnite VB Skin Gift',
                'image' => asset('assets/images/order.png'),
                'subtitle' => 'Cheapest +75% Discount',
                'type' => 'Items',
                'buyer' => 'Jenny Wilson',
                'ordered_date' => 'February 28, 2018',
                'status' => 'Pending',
                'quantity' => 5832,
                'price' => 15.30,
            ],
        ])->map(fn($order) => (object)$order);

        $currentPage = $this->getPage();
        $items = $allOrders->slice(($currentPage - 1) * $this->perPage, $this->perPage)->values();
        
        $pagination = [
            'total' => $allOrders->count(),
            'per_page' => $this->perPage,
            'current_page' => $currentPage,
            'last_page' => ceil($allOrders->count() / $this->perPage),
            'from' => (($currentPage - 1) * $this->perPage) + 1,
            'to' => min($currentPage * $this->perPage, $allOrders->count()),
        ];

        // Table columns configuration for orders
        $columns = [
            [
                'key' => 'name',
                'label' => 'Order Name',
                'sortable' => true,
                'format' => fn($order) => '
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 xxs:w-10 xxs:h-10 rounded-lg flex-shrink-0">
                            <img src="' . $order->image . '" alt="' . $order->name . '" class="w-full h-full rounded-lg object-cover" />
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">' . $order->name . '</h3>
                            <p class="text-xs text-text-white/50 truncate hidden xxs:block">' . $order->subtitle . '</p>
                            <a href="#" class="text-pink-400 text-xs hover:underline flex items-center gap-1 hidden xs:flex">Learn more →</a>
                        </div>
                    </div>
                '
            ],
            [
                'key' => 'type',
                'label' => 'Type',
            ],
            [
                'key' => 'buyer',
                'label' => 'Buyer',
            ],
            [
                'key' => 'ordered_date',
                'label' => 'Ordered date',
            ],
            [
                'key' => 'status',
                'label' => 'Order status',
                'badge' => true,
                'badgeColors' => [
                    'completed' => 'bg-pink-500',
                    'in progress' => 'bg-pink-500',
                    'pending' => 'bg-pink-500',
                ]
            ],
            [
                'key' => 'quantity',
                'label' => 'Quantity',
            ],
            [
                'key' => 'price',
                'label' => 'Price ($)',
                'format' => fn($order) => '<span class="text-text-white font-semibold text-xs sm:text-sm">$' . number_format($order->price, 2) . '</span>'
            ],
        ];

        return view('livewire.backend.user.orders.sold-orders', [
            'items' => $items,
            'columns' => $columns,
            'pagination' => $pagination,
        ]);
    }
}
