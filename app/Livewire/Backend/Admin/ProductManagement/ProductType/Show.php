<?php

namespace App\Livewire\Backend\Admin\ProductManagement\ProductType;

use App\Models\ProductType;
use Livewire\Component;

class Show extends Component
{

    public ProductType $data;
    public function mount(ProductType $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.product-management.product-type.show');
    }
}
