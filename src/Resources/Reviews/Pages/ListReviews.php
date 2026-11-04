<?php

namespace SOSEventsBV\Cms\Resources\Reviews\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use SOSEventsBV\Cms\Resources\Reviews\ReviewResource;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    public function getSubheading(): ?string
    {
        return 'In dit overzicht zie je de volledige namen van reviewers. Ter bescherming van de privacy wordt op de website enkel de voornaam getoond.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('showReviewPage')
                ->label('Toon reviews pagina')
                ->icon(Heroicon::Users)
                ->url(config('cms.routes.reviews') ? route(config('cms.routes.reviews')) : null)
                ->hidden(!config('cms.routes.reviews'))
                ->openUrlInNewTab()
        ];
    }
}
