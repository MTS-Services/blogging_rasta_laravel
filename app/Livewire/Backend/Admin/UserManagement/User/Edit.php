<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use App\Models\User;
use App\Models\Country;
use Livewire\Component;

use App\DTOs\User\UpdateUserDTO;
use App\Enums\UserAccountStatus;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithNotification;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Livewire\Forms\Backend\Admin\UserManagement\UserForm;
use App\Services\LanguageService;

class Edit extends Component
{

    use WithFileUploads, WithNotification;

    public $countries;
    public $languases;
    public UserForm $form;
    public User $user;
    public $userId;
    public $existingAvatar;



    protected UserService $service;

    protected LanguageService $languageService;
    public function boot(UserService $service, LanguageService $languageService)
    {
        $this->service = $service;
        $this->languageService = $languageService;
    }
    public function mount(User $user): void
    {
        $this->user = $user;
        $this->userId = $user->id;
        $this->form->setData($user);
        $this->existingAvatar = $user->avatar_url;
        // $this->form->date_of_birth->format('Y-m-d');

        $this->languases();
        $this->countries();

        Log::info('UserEdit mounted', [
            'user_id' => $user->id,
            'form_data' => [
                'first_name' => $this->form->first_name,
                'last_name' => $this->form->last_name,
                'username' => $this->form->username,
                // 'display_name' => $this->form->display_name,
                'date_of_birth' => $this->form->date_of_birth,
                'country_id' => $this->form->country_id,
                'email' => $this->form->email,
                'account_status' => $this->form->account_status,
            ]
        ]);
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
        return view('livewire.backend.admin.user-management.user.edit', [
            'statuses' => UserAccountStatus::options(),
            'countries' => $this->countries,
            'languages' => $this->languases,
        ]);
    }

    public function save()
    {
        Log::info('Save method called', [
            'user_id' => $this->userId,
            'form_data' => [
                'first_name' => $this->form->first_name,
                'last_name' => $this->form->last_name,
                'username' => $this->form->username,
                // 'display_name' => $this->form->display_name,
                'date_of_birth' => $this->form->date_of_birth,
                'country_id' => $this->form->country_id,
                'email' => $this->form->email,
                'password' => $this->form->password ? 'SET' : 'NOT SET',
                'phone' => $this->form->phone,
                'account_status' => $this->form->account_status,
                'avatar' => $this->form->avatar ? 'FILE' : 'NULL',
                'remove_avatar' => $this->form->remove_avatar,
            ]
        ]);



        try {

            $this->form->validate();
            // $this->existingAvatar = $this->admin->avatar_url;
            $data = $this->form->fillables();

            $data['updater_id'] = admin()->id;

            $users = $this->service->updateData($this->userId, $data);

            $this->dispatch('UserUpdated');
            $this->success('User updated successfully');
            return redirect()->route('admin.um.user.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to update User', [
                'user_id' => $this->userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update User: ' . $e->getMessage());
            //  session()->flash('error', 'Failed to update User: ' . $e->getMessage());
        }
    }
    public function removeAvatar(): void
    {
        Log::info('removeAvatar called', ['user_id' => $this->userId]);
        $this->form->remove_avatar = true;
        $this->existingAvatar = null;
        $this->form->avatar = null;
    }

    public function cancel(): void
    {
        $this->redirect(route('admin.um.user.index'), navigate: true);
    }
}
