<?php

namespace App\Livewire\Backend\Admin\Settings\Currency;

use App\Enums\CurrencyStatus;
use App\Livewire\Forms\Backend\Admin\Settings\CurrencyForm;
use App\Models\Currency;
use App\Services\CurrencyService;
use App\Traits\Livewire\WithNotification;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Edit extends Component
{
    use WithNotification;

    public CurrencyForm $form;

    #[Locked]
    public Currency $currency;
    protected CurrencyService $service;

    /**
     * Inject the currencyService via the boot method.
     */
    public function boot(CurrencyService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize form with existing language data.
     */
    public function mount(Currency $data): void
    {
        $this->currency = $data;
        $this->form->setData($this->currency);
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.settings.currency.edit', [
            'statuses' => CurrencyStatus::options(),
        ]);
    }

    /**
     * Handle form submission to update the language.
     */
    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->currency->id, $data);
            $this->success('Data updated successfully.');
            return $this->redirect(route('admin.as.currency.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel editing and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->setData($this->currency);
        $this->form->resetValidation();
    }
}
