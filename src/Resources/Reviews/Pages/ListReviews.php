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
        return __('cms::reviews.privacy_notice');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('showReviewPage')
                ->label(__('cms::reviews.show_reviews_page'))
                ->icon(Heroicon::Users)
                ->url(config('cms.routes.reviews') ? route(config('cms.routes.reviews')) : null)
                ->hidden(!config('cms.routes.reviews'))
                ->openUrlInNewTab()
        ];
    }
}
