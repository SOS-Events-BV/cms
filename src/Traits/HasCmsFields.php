<?php

namespace SOSEventsBV\Cms\Traits;

use Filament\Panel;

/**
 * @property bool $is_active
 */
trait HasCmsFields
{
    /**
     * Initialize the trait and add is_active to fillable, so it can be changed in the Filament panel.
     *
     * @return void
     */
    protected function initializeHasCmsFields(): void
    {
        $this->mergeFillable(['is_active']);
    }

    /**
     * Checks if the user is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Checks if the user can access the CMS panel.
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isActive();
    }
}
