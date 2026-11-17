<?php

namespace SOSEventsBV\Cms\Traits;

use Filament\Panel;

trait HasCmsFields
{
    public function initializeHasCmsFields(): void
    {
        $this->mergeCasts(['roles' => 'array']);
        $this->mergeFillable(['roles', 'avatar']);

        // The avatar is a base64 data URI, keep it out of arrays/JSON
        $this->hidden[] = 'avatar';
    }

    /**
     * Get all roles of the User
     *
     * @return array<string>
     */
    public function getRoles(): array
    {
        return $this->roles ?? [];
    }

    /**
     * Check if the user has the given role, or one of the given roles.
     *
     * @param  string|array<string>  $roles
     */
    public function hasRole(string|array $roles): bool
    {
        return array_intersect((array) $roles, $this->getRoles()) !== [];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->getRoles() !== [];
    }

    /**
     * Used by Filament when the User model implements Filament\Models\Contracts\HasAvatar.
     * Returns null when there is no avatar, so Filament falls back to the initials.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar;
    }
}
