<?php

namespace SOSEventsBV\Cms\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum AnnouncementType: string implements HasColor, HasLabel
{
    case Info = 'info';
    case Warning = 'warning';
    case Error = 'error';

    public function getLabel(): string|null|Htmlable
    {
        return match ($this) {
            self::Info => __('cms::announcements.types.info'),
            self::Warning => __('cms::announcements.types.warning'),
            self::Error => __('cms::announcements.types.error'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Info => 'info',
            self::Warning => 'warning',
            self::Error => 'danger',
        };
    }

    /**
     * Semantic CSS class of the announcement on the website. The styling of these classes
     * is defined in the website itself, so every website can use its own colors.
     */
    public function getCssClass(): string
    {
        return match ($this) {
            self::Info => 'announcement-info',
            self::Warning => 'announcement-warning',
            self::Error => 'announcement-error',
        };
    }

    public function getFaIcon(): string
    {
        return match ($this) {
            self::Info => 'fa-solid fa-info-circle',
            self::Warning => 'fa-solid fa-exclamation-triangle',
            self::Error => 'fa-solid fa-exclamation-circle',
        };
    }
}
