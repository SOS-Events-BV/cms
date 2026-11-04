<?php

namespace SOSEventsBV\Cms\Components\Blocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class ButtonGroupBlock extends Component
{
    public array $buttons;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public stdClass $data
    )
    {
        $this->buttons = $data->buttons;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('cms::components.blocks.button-group-block');
    }
}
