<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShoppingCartTableComponent extends Component
{
    public $h2;
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($h2, $id)
    {
        //
        $this->h2 = $h2;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.shopping-cart-table-component');
    }
}
