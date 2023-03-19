<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $id;
    public $title;
    public $url;
    public $body;
    public $buttonText;
    public function __construct($buttonText,$id,$title,$body,$url)
    {
        //
        $this->buttonText=$buttonText;
        $this->id=$id;
        $this->title=$title;
        $this->body=$body;
        $this->url=$url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-component');
    }
}
