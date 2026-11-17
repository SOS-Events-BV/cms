<?php

namespace SOSEventsBV\Cms\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * Navigation groups of the CMS panel. The order of the cases is the order in the sidebar.
 * Use these cases in `$navigationGroup` of resources and pages, also in the website itself.
 */
enum NavigationGroup implements HasLabel
{
    case Pages;
    case Products;
    case Settings;

    public function getLabel(): string
    {
        return match ($this) {
            self::Pages => __('cms::navigation.groups.pages'),
            self::Products => __('cms::navigation.groups.products'),
            self::Settings => __('cms::navigation.groups.settings'),
        };
    }
}
