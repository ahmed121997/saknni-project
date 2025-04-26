<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableActions extends Component
{
    public $id;
    public $editClass;
    public $deleteClass;

    public function __construct($id, $editClass = null, $deleteClass = null)
    {
        $this->id = $id;
        $this->editClass = $editClass;
        $this->deleteClass = $deleteClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-actions');
    }
}
