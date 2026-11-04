<?php

namespace SOSEventsBV\Cms\Components\Blocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class ContentBlock extends Component
{
    public string $content;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public stdClass $data
    )
    {
        $this->content = $data->content;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('cms::components.blocks.content-block');
    }
}
