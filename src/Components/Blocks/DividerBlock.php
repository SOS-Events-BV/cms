<?php

namespace SOSEventsBV\Cms\Components\Blocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class DividerBlock extends Component
{
    public int $px;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public stdClass $data
    )
    {
        $this->px = $data->px;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('cms::components.blocks.divider-block');
    }
}
