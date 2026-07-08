<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\MonitoringDashboard\CameraStatusByRegionChart2;
use App\Filament\Widgets\MonitoringDashboard\LatestMonitoringTasks;
use App\Filament\Widgets\MonitoringDashboard\MonitoringConsolesStatusWidget2;
use App\Filament\Widgets\MonitoringDashboard\MonitoringStaffAttendanceChart2;
use App\Filament\Widgets\MonitoringDashboard\MonitoringStatsOverview;
use App\Filament\Widgets\MonitoringDashboard\TopMonitoringTopicsChart2;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class MonitoringDashboard extends BaseDashboard
{
    use HasFiltersAction;
    
    protected static string $routePath = 'Monitoring-Dashboard';

    protected static ?string $title = 'Monitoring Unit Dashboard';

    protected static ?int $navigationSort = -2;

    protected static string | UnitEnum | null $navigationGroup = 'Dashboards';

    protected static ?string $navigationLabel = 'Monitoring Dashboard';

    public static function canAccess(): bool
    {
        return Gate::allows('View:MonitoringDashboard');
    }

    public function getColumns(): int | array
    {
        return 12; // Change from the default 12 if you need a different grid size
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
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
            MonitoringConsolesStatusWidget2::class,
            LatestMonitoringTasks::class,
            TopMonitoringTopicsChart2::class,
            CameraStatusByRegionChart2::class,
            MonitoringStaffAttendanceChart2::class,
        ];
    }
}