<?php

namespace App\Filament\Widgets;

use App\Models\MonitoringShiftReport;
use Filament\Widgets\Widget;

class MonitoringShiftReportsWidget extends Widget
{
    protected string $view = 'filament.widgets.monitoring-shift-reports-widget';

    protected function getViewData(): array
    {
        $reports = MonitoringShiftReport::whereDate('date', today())
            ->get()
            ->keyBy('shift_type');

        $shifts = ['morning', 'afternoon', 'night']; // updated

        $data = [];

        foreach ($shifts as $shift) {
            $report = $reports->get($shift);

            if ($report) {
                $attendance = $report->expected_attendance > 0
                    ? round(($report->present / $report->expected_attendance) * 100, 1)
                    : 0;

                $data[$shift] = [
                    'exists'                 => true,
                    'status'                 => $report->status,
                    'expected_attendance'    => $report->expected_attendance,
                    'present'                => $report->present,
                    'absent'                 => $report->absent,
                    'attendance_pct'         => $attendance,
                ];
            } else {
                $data[$shift] = ['exists' => false];
            }
        }

        return ['shifts' => $data];
    }
}
