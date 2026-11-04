<?php

namespace SOSEventsBV\Cms\Resources\Reviews\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use SOSEventsBV\Cms\Resources\Reviews\ReviewResource;

class EditReview extends EditRecord
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
        ];
    }
}
