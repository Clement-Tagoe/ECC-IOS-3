<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CallBreakdownChart;
use App\Filament\Widgets\CallConsolesStatusWidget;
use App\Filament\Widgets\CallShiftReportsWidget;
use App\Filament\Widgets\CameraStatusByRegionChart;
use App\Filament\Widgets\GhanaCasesMapWidget;
use App\Filament\Widgets\LatestReports;
use App\Filament\Widgets\LatestTasks;
use App\Filament\Widgets\MainStatsOverview;
use App\Filament\Widgets\MonitoringConsolesStatusWidget;
use App\Filament\Widgets\MonitoringShiftReportsWidget;
use App\Filament\Widgets\TopMonitoringTopicsChart;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
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
            LatestReports::class,
            LatestTasks::class,
            CallBreakdownChart::class,
            TopMonitoringTopicsChart::class,
            CallConsolesStatusWidget::class,
            MonitoringConsolesStatusWidget::class,
            MonitoringShiftReportsWidget::class,
            CallShiftReportsWidget::class,
            CameraStatusByRegionChart::class,
        ];
    }
}