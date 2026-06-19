<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CameraStatusByRegionChart;
use App\Filament\Widgets\LatestMonitoringTasks;
use App\Filament\Widgets\MonitoringConsolesStatusWidget;
use App\Filament\Widgets\MonitoringShiftReportsWidget;
use App\Filament\Widgets\MonitoringStatsOverview;
use App\Filament\Widgets\TopMonitoringTopicsChart;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class MonitoringDashboard extends BaseDashboard
{
    use HasFiltersAction;
    
    protected static string $routePath = 'monitoring';

    protected static ?string $title = 'Monitoring Unit Dashboard';

    protected static ?int $navigationSort = -2;

    protected static string | UnitEnum | null $navigationGroup = 'Monitoring';

    protected static ?string $navigationLabel = 'Monitoring Dashboard';

    public static function canAccess(): bool
    {
        return Gate::allows('View:MonitoringDashboard');
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
            MonitoringStatsOverview::class,
            MonitoringConsolesStatusWidget::class,
            MonitoringShiftReportsWidget::class,
            LatestMonitoringTasks::class,
            CameraStatusByRegionChart::class,
            TopMonitoringTopicsChart::class,
        ];
    }
}