<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Product;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public Product $data;
    public function mount(Product $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.product-management.product.show');
    }
}
