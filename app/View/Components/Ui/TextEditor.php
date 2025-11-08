<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextEditor extends Component
{
    public $id;
    public $model;
    public $placeholder;
    public $height;
    public $disabled;
    public $menubar = false;
    public $readonly = false;

    public function __construct(
        $model = '',
        $id = null,
        $placeholder = '',
        $height = 400,
        $disabled = false,
        $menubar = false,
        $readonly = false
    ) {
        $this->model = $model;
        $this->id = $id ?? 'tinymce-' . uniqid();
        $this->placeholder = $placeholder;
        $this->height = $height;
        $this->disabled = $disabled;
        $this->menubar = $menubar;
        $this->readonly = $readonly;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.text-editor');
    }
}
