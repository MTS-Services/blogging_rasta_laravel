<?php

namespace App\Livewire\Backend\Admin\Keyword;

use App\Livewire\Forms\KeywordForm;
use App\Services\KeywordService;
use Livewire\Component;
use App\Traits\Livewire\WithNotification;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public KeywordForm $form;

    protected KeywordService $service;

    /**
     * Inject the CurrencyService via the boot method.
     */
    public function boot(KeywordService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        // $this->form->status = CurrencyStatus::ACTIVE->value;
    }

    public function render()
    {
        return view('livewire.backend.admin.keyword.create');
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
            return $this->redirect(route('admin.keyword.index'), navigate: true);
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
