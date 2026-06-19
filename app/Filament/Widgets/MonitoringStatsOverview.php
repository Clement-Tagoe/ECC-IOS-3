<?php

namespace App\Filament\Widgets;

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
        
        $totalExpected  = $todayReports->sum('expected_attendance');
        $totalPresent   = $todayReports->sum('present');
        $totalAbsent    = $todayReports->sum('absent');

        $attendanceRate = $totalExpected > 0
            ? round(($totalPresent / $totalExpected) * 100, 1)
            : 0;
        
    
        $cameraAudits = CameraAudit::whereBetween('updated_at', [$startDate, $endDate])->count();
      

        return [
            Stat::make('Total Monitoring Tasks', $totalMonitoringTasks)
                ->description('Monitoring Tasks')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-list-bullet')
                ->chart([6, 10, 5, 15, 3, 10, 7, 17]),
            // Stat::make('Expected Attendance', number_format($totalExpected))
            //     ->description('Across all shifts today')
            //     ->descriptionIcon('heroicon-m-users')
            //     ->color('gray'),
            Stat::make('Staff Present', number_format($totalPresent))
                ->description("{$attendanceRate}% attendance rate")
                ->descriptionIcon('heroicon-m-check-badge')
                ->color($attendanceRate >= 85 ? 'success' : ($attendanceRate >= 70 ? 'warning' : 'danger'))
                ->chart([5, 2, 6, 3, 7, 4, 3, 5]),
 
            Stat::make('Staff Absent', number_format($totalAbsent))
                ->description(round(100 - $attendanceRate, 1) . '% absence rate today')
                ->descriptionIcon('heroicon-m-x-mark')
                ->color($totalAbsent > 5 ? 'danger' : 'warning'),

            Stat::make('Audited Cameras', number_format($cameraAudits))
                ->description('Total number of cameras audited today')
                ->descriptionIcon('heroicon-o-camera')
                ->color('info')
                ->chart([6, 10, 5, 15, 3, 10, 7, 17]),
        ];
    }
}
