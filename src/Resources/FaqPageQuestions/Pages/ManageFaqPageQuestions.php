<?php

namespace SOSEventsBV\Cms\Resources\FaqPageQuestions\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use SOSEventsBV\Cms\Resources\FaqPageQuestions\FaqPageQuestionResource;

class ManageFaqPageQuestions extends ManageRecords
{
    protected static string $resource = FaqPageQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('showFAQPage')
                ->label('Toon FAQ pagina')
                ->icon(Heroicon::QuestionMarkCircle)
                ->url(config('cms.routes.faq') ? route(config('cms.routes.faq')) : null)
                ->hidden(!config('cms.routes.faq'))
                ->color('gray')
                ->openUrlInNewTab(),

            CreateAction::make(),
        ];
    }
}
