<?php

namespace App\Livewire\Backend\Admin\AuditLogManagement;

use App\Models\Audit;
use Livewire\Component;

class View extends Component
{
    public Audit $data;
    public function mount(Audit $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.audit-log-management.view', [
            'data' => $this->data,
        ]);
    }
}
