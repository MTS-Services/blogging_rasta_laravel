<?php

namespace App\Livewire\Frontend;

use App\Services\AboutCmsService;
use Livewire\Component;
use App\Models\Contact as ContactModel;
use App\Traits\Livewire\WithNotification;

class Contact extends Component
{
    use WithNotification;

    public $aboutCms = null;

    protected AboutCmsService $aboutCmsService;
    public function boot(AboutCmsService $aboutCmsService)
    {
        $this->aboutCmsService = $aboutCmsService;
    }
    public $form = [
        'name' => '',
        'email' => '',
        'message' => '',
    ];

    protected $rules = [
        'form.name' => 'required|string|max:255',
        'form.email' => 'required|email|max:255',
        'form.message' => 'required|string|max:2000',
    ];

    public function mount()
    {
        try {
            $this->aboutCms = $this->aboutCmsService->getFirstData();

        } catch (\Exception $e) {
            $this->aboutCms = null;
        }
    }

    public function save()
    {
        $this->validate();

        ContactModel::create([
            'name' => $this->form['name'],
            'email' => $this->form['email'],
            'message' => $this->form['message'],
        ]);

        // Reset form
        $this->reset('form');

        $this->success('Your message has been sent successfully!');
        return $this->redirect(route('contact'), navigate: true);
    }

    public function render()
    {
        return view('livewire.frontend.contact');
    }
}
