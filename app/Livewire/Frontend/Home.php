<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class Home extends Component
{
    public $input;
    public $email;
    public $password;
    public $disabled;

    public $standardSelect;
    public $disabledSelect;
    public $select2Single;
    public $select2Multiple;

    public $content = '<p>This is the initial content of the editor.</p>';

    public function saveContent()
    {
        dd($this->content);
    }
    public function saveContent2()
    {
        dd($this->content);
    }

    public function render()
    {
        return view('livewire.frontend.home');
    }
}
