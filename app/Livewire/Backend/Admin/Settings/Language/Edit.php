<?php

namespace App\Livewire\Backend\Admin\Settings\Language;

use App\DTOs\Language\UpdateLanguageDTO;
use App\Enums\LanguageDirections;
use App\Enums\LanguageStatus;
use App\Livewire\Forms\Backend\Admin\Settings\LanguageForm;
use App\Models\Language;
use App\Services\Admin\LanguageService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Edit extends Component
{
    use WithNotification;

    public LanguageForm $form;
    public Language $language;

    protected LanguageService $languageService;

    /**
     * Inject the LanguageService via the boot method.
     */
    public function boot(LanguageService $languageService): void
    {
        $this->languageService = $languageService;
    }

    /**
     * Initialize form with existing language data.
     */
    public function mount(Language $language): void
    {
        $this->language = $language;
        $this->form->setLanguage($language);
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.settings.language.edit', [
            'statuses' => LanguageStatus::options(),
            'directions' => LanguageDirections::options(),
        ]);
    }

    /**
     * Handle form submission to update the language.
     */
    public function save()
    {
        $this->form->validate();

        // Generate flag icon URL from country code
        $flagIcon = null;
        if (!empty($this->form->country_code)) {
            $flagIcon = 'https://flagcdn.com/' . strtolower($this->form->country_code) . '.svg';
        }

        try {
            $dto = UpdateLanguageDTO::fromArray([
                'locale' => $this->form->locale,
                'name' => $this->form->name,
                'country_code' => $this->form->country_code,
                'native_name' => $this->form->native_name,
                'flag_icon' => $flagIcon,
                'status' => $this->form->status,
                'is_default' => $this->form->is_default,
                'direction' => $this->form->direction,
                'updated_by' => admin()->id
            ]);

            $updatedLanguage = $this->languageService->updateLanguage($this->language->id, $dto);

            $this->dispatch('languageUpdated');
            $this->success('Language updated successfully.');

            return $this->redirect(route('admin.as.language.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update language: ' . $e->getMessage());
        }
    }

    /**
     * Cancel editing and redirect back to index.
     */
    public function cancel(): void
    {
        $this->redirect(route('admin.as.language.index'), navigate: true);
    }
}
