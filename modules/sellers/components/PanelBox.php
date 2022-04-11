<?php

namespace Modules\sellers\components;

use Illuminate\View\Component;

class PanelBox extends Component
{
    public $args;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($args=[])
    {
        $this->args=$args;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('sellers::panel.seller-panel-box');
    }
}
