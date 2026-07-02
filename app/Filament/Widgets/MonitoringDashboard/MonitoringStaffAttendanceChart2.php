<?php

namespace App\Filament\Widgets\MonitoringDashboard;

use App\Models\MonitoringStaff;
use App\Models\MonitoringStaffAttendance;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class MonitoringStaffAttendanceChart2 extends ChartWidget
{
    protected ?string $heading = 'Monitoring Staff Attendance Chart';

    protected int | string | array $columnSpan =  4;

    protected function getData(): array
    {
        $today = Carbon::today()->toDateString();

        $totalStaff = MonitoringStaff::count();

        $todaysAttendance = MonitoringStaffAttendance::query()
            ->where('date', $today)
            ->get();

        $presentCount = $todaysAttendance->where('status', 'present')->count();
        $absentCount  = $todaysAttendance->where('status', 'absent')->count();
        $permCount    = $todaysAttendance->where('status', 'absent_with_permission')->count();
        $sickCount    = $todaysAttendance->where('status', 'sick')->count();

        return [
            'datasets' => [
                [
                    'data' => [$presentCount, $absentCount, $permCount, $sickCount],
                    'backgroundColor' => [
                        '#22c55e', // green - present
                        '#ef4444', // red - absent
                        '#fbbf24', // amber - permission
                        '#60a5fa', // blue - sick
                    ],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => ['Present', 'Absent', 'Absent w/ Permission', 'Sick'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
