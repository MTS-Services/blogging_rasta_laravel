<?php

namespace App\Livewire\Backend\Admin\Settings\Language;

use App\DTOs\Language\CreateLanguageDTO;
use App\Enums\LanguageDirection;
use App\Enums\LanguageStatus;
use App\Livewire\Forms\Backend\Admin\Settings\LanguageForm;
use App\Services\LanguageService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public LanguageForm $form;

    protected LanguageService $languageService;

    /**
     * Inject the LanguageService via the boot method.
     */
    public function boot(LanguageService $languageService): void
    {
        $this->languageService = $languageService;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = LanguageStatus::ACTIVE->value;
        $this->form->direction = LanguageDirection::LTR->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.settings.language.create', [
            'statuses' => LanguageStatus::options(),
            'directions' => LanguageDirection::options(),
        ]);
    }

    /**
     * Handle form submission to create a new language.
     */
    public function save()
    {
        
        try {
            $validated = $this->form->validate();
    
            $flagIcon = null;
            if (!empty($validated['country_code'])) {
                $flagIcon = 'https://flagcdn.com/' . strtolower($validated['country_code']) . '.svg';
            }
            $data = array_merge($validated, [
                'flag_icon' => $flagIcon,
                'created_by' => admin()->id,
            ]);

            $this->languageService->createData($data);

            $this->success('Language created successfully.');

            return $this->redirect(route('admin.as.language.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to create language: ' . $e->getMessage());
        }
    }


    /**
     * Cancel creation and redirect back to index.
     */
    public function cancel(): void
    {
        $this->redirect(route('admin.as.language.index'), navigate: true);
    }

     public function resetForm(): void
    {
        $this->form->reset();
    }
}
