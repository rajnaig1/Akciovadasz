<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavbarDropdownComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $buttonText;
    public function __construct($buttonText)
    {
        //
        $this->buttonText = $buttonText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navbar-dropdown-component');
    }
}
