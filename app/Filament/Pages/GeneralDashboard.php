<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ReportsChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TaskChart;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class GeneralDashboard extends BaseDashboard
{
    use HasFiltersAction;
    
    protected static string $routePath = 'general';

    protected static ?string $title = 'General Dashboard';

    protected static string | UnitEnum | null $navigationGroup = 'Dashboards';

    protected static ?int $navigationSort = -4;

    public static function canAccess(): bool
    {
        return Gate::allows('View:GeneralDashboard');
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
            StatsOverview::class,
            ReportsChart::class,
            TaskChart::class,
        ];
    }


}