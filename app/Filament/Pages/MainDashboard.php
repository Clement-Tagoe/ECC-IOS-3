<?php

namespace App\Filament\Pages;


use App\Filament\Widgets\MainDashboard\CallConsolesStatusWidget;
use App\Filament\Widgets\MainDashboard\CallStaffAttendanceChart;
use App\Filament\Widgets\MainDashboard\CameraStatusByRegionChart;
use App\Filament\Widgets\MainDashboard\ChartStackWrapper;
use App\Filament\Widgets\MainDashboard\GhanaCasesMapWidget;
use App\Filament\Widgets\MainDashboard\LatestReports;
use App\Filament\Widgets\MainDashboard\LatestTasks;
use App\Filament\Widgets\MainDashboard\MainStatsOverview;
use App\Filament\Widgets\MainDashboard\MonitoringConsolesStatusWidget;
use App\Filament\Widgets\MainDashboard\MonitoringStaffAttendanceChart;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Gate;

class MainDashboard extends BaseDashboard
{
    use HasFiltersAction;
    
    protected static string $routePath = 'main-dashboard';

    protected static ?string $title = 'Main Dashboard';

    public static function canAccess(): bool
    {
        return Gate::allows('View:MainDashboard');
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
            MainStatsOverview::class,
            GhanaCasesMapWidget::class,
            ChartStackWrapper::class,
            LatestReports::class,
            LatestTasks::class,
            CallConsolesStatusWidget::class,
            MonitoringConsolesStatusWidget::class,
            CallStaffAttendanceChart::class,
            MonitoringStaffAttendanceChart::class,
            CameraStatusByRegionChart::class,
        ];
    }
}