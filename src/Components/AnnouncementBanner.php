<?php

namespace SOSEventsBV\Cms\Components;

use SOSEventsBV\Cms\Models\Announcement;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class AnnouncementBanner extends Component
{
    public Collection $announcements;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->announcements = Announcement::active()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('cms::components.announcement-banner');
    }
}
