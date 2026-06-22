<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CallTakingDashboard\AgencyCaseLoadChart;
use App\Filament\Widgets\CallTakingDashboard\CallBreakdownChart2;
use App\Filament\Widgets\CallTakingDashboard\CallConsoleStatusWidget2;
use App\Filament\Widgets\CallTakingDashboard\CallShiftReportsWidget2;
use App\Filament\Widgets\CallTakingDashboard\CallStatsOverview;
use App\Filament\Widgets\CallTakingDashboard\CasesByNatureChart;
use App\Filament\Widgets\CallTakingDashboard\CasesByRegionChart;
use App\Filament\Widgets\CallTakingDashboard\EmergencyContacts;
use App\Filament\Widgets\CallTakingDashboard\LatestValidCases;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Support\Enums\Width;
use UnitEnum;

class CallTakingDashboard extends BaseDashboard
{
    use HasFiltersAction;

    protected static string $routePath = 'call-taking';

    protected static ?string $title = 'Call-Taking & Dispatch Unit Dashboard';

    protected static ?int $navigationSort = -3;

    protected static ?string $navigationLabel = 'Call-Taking Dashboard';

    protected static string | UnitEnum | null $navigationGroup = 'Call-Taking';

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    public function getColumns(): int | array
    {
        return 12; // Change from the default 12 if you need a different grid size
    }

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
            CallConsoleStatusWidget2::class,
            LatestValidCases::class,
            CallShiftReportsWidget2::class,
            CasesByNatureChart::class,
            AgencyCaseLoadChart::class,
            CasesByRegionChart::class,
            CallBreakdownChart2::class,
            EmergencyContacts::class,
        ];
    }
}