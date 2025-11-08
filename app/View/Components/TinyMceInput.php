<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class TinyMceInput extends Component
{
    public string $id;
    public string $name;
    public mixed $value;
    public string $placeholder;
    public int $height;
    public string $plugins;
    public string $toolbar;
    public bool $menubar;
    public bool $readonly;
    public ?string $label;
    public bool $required;
    public ?string $class;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        mixed $value = '',
        ?string $id = null,
        string $placeholder = 'Enter content here...',
        int $height = 400,
        ?string $plugins = null,
        ?string $toolbar = null,
        bool $menubar = false,
        bool $readonly = false,
        ?string $label = null,
        bool $required = false,
        ?string $class = null
    ) {
        $this->id = $id ?? 'tinymce-' . uniqid();
        $this->name = $name;
        $this->value = old($name, $value);
        $this->placeholder = $placeholder;
        $this->height = $height;
        $this->plugins = $plugins ?? 'code table lists link image media preview';
        $this->toolbar = $toolbar ?? 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | link image media | code preview';
        $this->menubar = $menubar;
        $this->readonly = $readonly;
        $this->label = $label;
        $this->required = $required;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.tiny-mce-input');
    }
}