<?php

namespace App\Livewire\Backend\Admin\TikTokManagement\User;

use App\Services\UserCategoryService;
use Livewire\Component;
use App\Models\TikTokUser;
use App\Enums\TikTokUserStatus;
use Livewire\Attributes\Locked;
use App\Services\TikTokUserService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Backend\Admin\TikTokUserForm;

class Edit extends Component
{

    use WithNotification;

    public TikTokUserForm $form;

    #[Locked]
    public TikTokUser $data;
    protected TikTokUserService $service;

    protected UserCategoryService $userCategpruServoce;

    public $categories = [];

    /**
     * Inject the CurrencyService via the boot method.
     */
    public function boot(TikTokUserService $service, UserCategoryService $userCategpruServoce): void
    {
        $this->service = $service;
        $this->userCategpruServoce = $userCategpruServoce;
    }


    /**
     * Initialize form with existing language data.
     */
    public function mount(TikTokUser $data): void
    {
        $this->categories = $this->userCategpruServoce->getActiveData();
        $this->data = $data;
        $this->form->setData($data);
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.tik-tok-management.user.edit', [
            'statuses' => TikTokUserStatus::options(),
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
            $this->service->updateData($this->data->id, $data);

            $this->success('Data updated successfully.');
            return $this->redirect(route('admin.tm.user.index'), navigate: true);
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
