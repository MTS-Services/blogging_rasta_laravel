<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Contact as ContactModel;
use App\Traits\Livewire\WithNotification;

class Contact extends Component
{
    use WithNotification;
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
