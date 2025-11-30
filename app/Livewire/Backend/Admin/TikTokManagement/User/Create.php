<?php

namespace App\Livewire\Backend\Admin\TikTokManagement\User;

use App\Enums\TikTokUserStatus;
use App\Livewire\Forms\Backend\Admin\TikTokUserForm;
use App\Services\TikTokUserService;
use App\Services\UserCategoryService;
use Livewire\Component;
use App\Traits\Livewire\WithNotification;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public TikTokUserForm $form;

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
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->categories = $this->userCategpruServoce->getActiveData();
        $this->form->status = TikTokUserStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.tik-tok-management.user.create', [
            'statuses' => TikTokUserStatus::options(),
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
            return $this->redirect(route('admin.tm.user.index'), navigate: true);
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
