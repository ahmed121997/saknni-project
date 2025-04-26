<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LanguageInput extends Component
{
    public $label;
    public $name;
    public $id;

    public function __construct($label, $name, $id = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id ?? uniqid('lang_input_');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.language-input');
    }
}
