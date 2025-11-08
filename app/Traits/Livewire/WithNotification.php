<?php

namespace App\Traits\Livewire;

trait WithNotification
{
    public function success(string $message, string $title = 'Success'): void
    {
       
        $this->dispatch('notify', type: 'success', title: $title, message: $message);
    }

    public function error(string $message, string $title = 'Error'): void
    {
        $this->dispatch('notify', type: 'error', title: $title, message: $message);
    }

    public function warning(string $message, string $title = 'Warning'): void
    {
        $this->dispatch('notify', type: 'warning', title: $title, message: $message);
    }

    public function info(string $message, string $title = 'Info'): void
    {
        $this->dispatch('notify', type: 'info', title: $title, message: $message);
    }
}
