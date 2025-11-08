<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\DTOs\User\CreateUserDTO;
use App\Enums\UserAccountStatus;
use App\Services\UserService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Backend\Admin\UserManagement\UserForm;
use App\Models\Language;
use App\Services\LanguageService;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    public  $languases = null;

    public  $countries = null;

    public UserForm $form;

    protected UserService $service;

    protected LanguageService $languageService;

    public function boot(UserService $service, LanguageService $languageService)
    {
        $this->service = $service;
        $this->languageService = $languageService;
    }
    public function mount(): void
    {
        $this->form->account_status = UserAccountStatus::ACTIVE->value;
        $this->languases();
        $this->countries();
    }

    public function languases(): void
    {

        $this->languases = $this->languageService->getAllDatas();
    }

    public function countries(): void
    {

        $this->countries = Country::orderBy('name', 'asc')->get();
    }
    public function render()
    {

        return view('livewire.backend.admin.user-management.user.create', [
            'statuses' => UserAccountStatus::options(),
            'countries' => $this->countries,
            'languages' => $this->languases,
        ]);
    }

    public function save()
    {
        $this->form->validate();

        try {
            $data = $this->form->fillables();

            $user = $this->service->createData($data);

            $this->dispatch('User Created');
            $this->success('User created successfully');
            return $this->redirect(route('admin.um.user.index'), navigate: true);
        } catch (\Exception $e) {
            Log::error('Failed to create user:' . $e->getMessage());
            $this->error('Failed to create user.');
            dd($e->getMessage());
        }
    }

    public function resetForm(): void
    {

        $this->form->reset();
    }

    public function cancel(): void
    {
        $this->redirect(route('admin.um.user.index'), navigate: true);
    }
}
