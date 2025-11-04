<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WireButton extends Component
{
    public $href;
    public $blue;

    /**
     * Create a new component instance.
     */
    public function __construct($href = null, $blue = false)
    {
        $this->href = $href;
        $this->blue = $blue;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.wire-button');
    }
}
