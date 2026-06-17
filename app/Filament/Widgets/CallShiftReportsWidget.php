<?php

namespace App\Filament\Widgets;

use App\Models\CallShiftReport;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class CallShiftReportsWidget extends Widget
{
    protected string $view = 'filament.widgets.call-shift-reports-widget';
    
    protected function getViewData(): array
    {
        $reports = CallShiftReport::where('date', Carbon::today())
            ->get()
            ->keyBy('shift_type');

        $shifts = ['am', 'pm'];

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
                    'absent_with_permission' => $report->absent_with_permission,
                    'attendance_pct'         => $attendance,
                ];
            } else {
                $data[$shift] = ['exists' => false];
            }
        }

        return ['shifts' => $data];
    }
}
