<?php

namespace App\Livewire\Backend\Admin\Settings\Currency;

use App\DTOs\Currency\CreateDTO;
use App\Enums\CurrencyStatus;
use App\Livewire\Forms\Backend\Admin\Settings\CurrencyForm;
use App\Services\CurrencyService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public CurrencyForm $form;

    protected CurrencyService $service;

    /**
     * Inject the CurrencyService via the boot method.
     */
    public function boot(CurrencyService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = CurrencyStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.settings.currency.create', [
            'statuses' => CurrencyStatus::options(),
        ]);
    }

    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['created_by'] = admin()->id;
            $this->service->createData($data);
            $this->success('Data created successfully.');
            return $this->redirect(route('admin.as.currency.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to create data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->reset();
    }
}
