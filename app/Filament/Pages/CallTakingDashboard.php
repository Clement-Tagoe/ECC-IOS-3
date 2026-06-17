<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AgencyCaseLoadChart;
use App\Filament\Widgets\CallBreakdownChart;
use App\Filament\Widgets\CallStatsOverview;
use App\Filament\Widgets\CasesByNatureChart;
use App\Filament\Widgets\CasesByRegionChart;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use UnitEnum;

class CallTakingDashboard extends BaseDashboard
{
    use HasFiltersAction;

    protected static string $routePath = 'call-taking';

    protected static ?string $title = 'Call-Taking Dashboard';

    protected static ?int $navigationSort = -3;

    protected static string | UnitEnum | null $navigationGroup = 'Call-Taking';

    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make()
                ->schema([
                    DatePicker::make('startDate'),
                    DatePicker::make('endDate'),
                ]),
        ];
    }

    public function getWidgets(): array
    {
        return [
            CallStatsOverview::class,
            CallBreakdownChart::class,
            CasesByRegionChart::class,
            CasesByNatureChart::class,
            AgencyCaseLoadChart::class,
        ];
    }
}