<?php

namespace SOSEventsBV\Cms\Widgets;

use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Override;
use SOSEventsBV\Cms\Models\Review;

class ReviewStats extends StatsOverviewWidget
{
    protected ?string $heading = "Reviews";

    protected int|array|null $columns = 2;

    #[Override]
    protected function getStats(): array
    {
        $stats = Review::toBase()
            ->selectRaw('COUNT(*) as total, AVG(stars) as average')
            ->first();

        return [
            Stat::make(__('cms::reviews.widget.total'), number_format((int) $stats->total, 0, ',', '.'))
                ->icon(Heroicon::ChatBubbleLeftEllipsis),

            Stat::make(__('cms::reviews.widget.average'), number_format((float) $stats->average, 1, ',', '.'))
                ->icon(Heroicon::Star),
        ];
    }
}
