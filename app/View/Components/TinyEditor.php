<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TinyEditor extends Component
{
    public $id;
    public $model;
    public $placeholder;
    public $height;
    public $disabled;

    public function __construct(
        $model = '',
        $id = null,
        $placeholder = '',
        $height = 400,
        $disabled = false
    ) {
        $this->model = $model;
        $this->id = $id ?? 'tinymce-' . uniqid();
        $this->placeholder = $placeholder;
        $this->height = $height;
        $this->disabled = $disabled;
    }

    public function render()
    {
        return view('components.tiny-editor');
    }
}