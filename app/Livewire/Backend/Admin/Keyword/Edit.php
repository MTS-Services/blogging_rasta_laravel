<?php

namespace App\Livewire\Backend\Admin\Keyword;

use Livewire\Component;
use Livewire\Attributes\Locked;
use App\Livewire\Forms\KeywordForm;
use App\Models\Keyword;
use App\Services\KeywordService;
use App\Traits\Livewire\WithNotification;

class Edit extends Component
{
    use WithNotification;

    public KeywordForm $form;

    #[Locked]
    public Keyword $data;
    protected KeywordService $service;

    /**
     * Inject the currencyService via the boot method.
     */
    public function boot(KeywordService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize form with existing language data.
     */
    public function mount(Keyword $data): void
    {
        $this->data = $data;
        $this->form->setData($data);
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.keyword.edit');
    }

    /**
     * Handle form submission to update the language.
     */
    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->data->id, $data);

            $this->success('Data updated successfully.');
            return $this->redirect(route('admin.keyword.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel editing and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->setData($this->data);
        $this->form->resetValidation();
    }
}
