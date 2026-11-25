<?php

namespace SOSEventsBV\Cms\Models;

use SOSEventsBV\Cms\Enums\AnnouncementType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['type', 'title', 'message', 'button_text', 'button_url', 'starts_at', 'ends_at'])]
class Announcement extends Model
{
    protected function casts(): array
    {
        return [
            'type' => AnnouncementType::class,
        ];
    }

    /**
     * Get only active announcements.
     */
    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('starts_at', '<=', today())->where('ends_at', '>=', today());
    }
}
