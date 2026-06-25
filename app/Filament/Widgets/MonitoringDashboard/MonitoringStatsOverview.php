<?php

namespace App\Filament\Widgets\MonitoringDashboard;

use App\Models\CameraAudit;
use App\Models\MonitoringShiftReport;
use App\Models\MonitoringTask;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonitoringStatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;
    
    protected function getStats(): array
    {
        $startDate = isset($this->pageFilters['startDate'])
            ? Carbon::parse($this->pageFilters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate'])
            ? Carbon::parse($this->pageFilters['endDate'])->endOfDay()
            : now()->endOfDay();

        $totalMonitoringTasks = MonitoringTask::whereBetween('date', [$startDate, $endDate])->count();
        $todayReports = MonitoringShiftReport::whereBetween('date', [$startDate, $endDate])->get();
        
        $totalCameras  = CameraAudit::count();
        $onlineCameras = CameraAudit::where('status', 'online')->count();
        $offlineCameras = CameraAudit::where('status', 'offline')->count();

        $onlineRate  = $totalCameras > 0
            ? round(($onlineCameras / $totalCameras) * 100, 1)
            : 0;

        $offlineRate = $totalCameras > 0
            ? round(($offlineCameras / $totalCameras) * 100, 1)
            : 0;
      

        return [
            Stat::make('Total Monitoring Tasks', $totalMonitoringTasks)
                ->description('Monitoring Tasks')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-list-bullet')
                ->chart([1.5, 1.5, 1.5, 1.5, 1.5]),
            // Stat::make('Expected Attendance', number_format($totalExpected))
            //     ->description('Across all shifts today')
            //     ->descriptionIcon('heroicon-m-users')
            //     ->color('gray'),
            Stat::make('Total Cameras', $totalCameras)
                ->description('All registered cameras')
                ->descriptionIcon('heroicon-o-video-camera')
                ->color('primary')
                ->chart([1.5, 1.5, 1.5, 1.5, 1.5]),

            Stat::make('Online Cameras', $onlineCameras)
                ->description("{$onlineRate}% of total fleet")
                ->descriptionIcon('heroicon-o-signal')
                ->color('success')
                ->chart([1.5, 1.5, 1.5, 1.5, 1.5]),

            Stat::make('Offline cameras', $offlineCameras)
                ->description("{$offlineRate}% of total fleet")
                ->descriptionIcon('heroicon-o-signal-slash')
                ->color($offlineCameras > 0 ? 'danger' : 'success')
                ->chart([1.5, 1.5, 1.5, 1.5, 1.5]),
        ];
    }
}
