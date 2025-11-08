<?php

namespace App\Livewire\Ui;

use Livewire\Component;

class TextAreat extends Component
{
    public $editorId;
    public $value = '';
    public $placeholder = 'Enter content here...';
    public $height = 400;
    public $plugins = 'code table lists link image media preview';
    public $toolbar = 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | link image media | code preview';
    public $menubar = false;
    public $readonly = false;
    public $label = '';
    public $error = '';
    public $required = false;

    public function mount(
        $value = '',
        $editorId = null,
        $placeholder = 'Enter content here...',
        $height = 400,
        $plugins = null,
        $toolbar = null,
        $menubar = false,
        $readonly = false,
        $label = '',
        $error = '',
        $required = false
    ) {
        $this->editorId = $editorId ?? 'tinymce-' . uniqid();
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->height = $height;
        $this->menubar = $menubar;
        $this->readonly = $readonly;
        $this->label = $label;
        $this->error = $error;
        $this->required = $required;

        if ($plugins) {
            $this->plugins = $plugins;
        }

        if ($toolbar) {
            $this->toolbar = $toolbar;
        }
    }

    public function updatedValue($value)
    {
        $this->dispatch('tinymce-updated-' . $this->editorId, content: $value);
    }
    public function render()
    {
        return view('livewire.ui.text-areat');
    }
}
