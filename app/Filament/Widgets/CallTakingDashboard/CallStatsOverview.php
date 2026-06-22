<?php

namespace App\Filament\Widgets\CallTakingDashboard;

use App\Models\CallLog;
use App\Models\ValidCase;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CallStatsOverview extends StatsOverviewWidget
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

        $totalValidCases = ValidCase::whereBetween('reporting_date', [$startDate, $endDate])->count();
        
        // Sum each column for records matching today's date
        $stats = CallLog::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('
                SUM(incoming_calls) as incoming,
                SUM(total_calls_received) as received,
                SUM(valid_calls) as valid,
                SUM(prank_calls) as prank,
                SUM(unanswered_calls) as unanswered
            ')
            ->first();
        

        $total   = $stats->received ?? 0;
        $prank   = $stats->prank ?? 0;
 
        $prankRate = $total > 0
            ? round(($prank / $total) * 100, 1)
            : 0;


        // $todayReports = CallShiftReport::whereBetween('date', [$startDate, $endDate])->get();
 
        // $totalExpected  = $todayReports->sum('expected_attendance');
        // $totalPresent   = $todayReports->sum('present');
        // $totalAbsent    = $todayReports->sum('absent');

        // $attendanceRate = $totalExpected > 0
        //     ? round(($totalPresent / $totalExpected) * 100, 1)
        //     : 0;

        return [
            Stat::make('Total Valid Cases', $totalValidCases)
                ->description('Valid Cases')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-briefcase')
                ->chart([6, 10, 5, 15, 3, 10, 7, 17]),
            Stat::make('Incoming Calls', $stats->incoming ?? 0)
                ->icon('heroicon-o-phone-arrow-down-left')
                ->color('auxiliary')
                ->chart([18, 15, 5, 10, 6, 8, 4, 9]),
            Stat::make('Total Received', $stats->received ?? 0)
                ->description('Received Calls')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([10, 8, 5, 12, 6, 8, 4, 2]),
            Stat::make('Valid Calls', $stats->valid ?? 0)
                ->description('Call validity')
                ->icon('heroicon-o-check-circle')
                ->color('nonary')
                ->chart([9, 10, 8, 10, 6, 9, 4, 7]),
            Stat::make('Prank Calls', $stats->prank ?? 0)
                ->description("{$prankRate}% of all received calls")
                ->icon('heroicon-o-phone-x-mark')
                ->color('primary')
                ->chart([14, 10, 3, 7, 6, 9, 4, 10]),
            // Stat::make('Unanswered Calls', $stats->unanswered ?? 0),
            // Stat::make('Expected Attendance', number_format($totalExpected))
            //     ->description('Across all shifts today')
            //     ->descriptionIcon('heroicon-m-users')
            //     ->color('gray'),
            // Stat::make('Staff Present', number_format($totalPresent))
            //     ->description("{$attendanceRate}% attendance rate")
            //     ->descriptionIcon('heroicon-m-check-badge')
            //     ->color($attendanceRate >= 85 ? 'success' : ($attendanceRate >= 70 ? 'warning' : 'danger'))
            //     ->chart([2, 6, 3, 5, 7, 3, 2, 8]),
 
            // Stat::make('Staff Absent', number_format($totalAbsent))
            //     ->description(round(100 - $attendanceRate, 1) . '% absence rate today')
            //     ->descriptionIcon('heroicon-m-x-mark')
            //     ->color($totalAbsent > 5 ? 'danger' : 'warning'),
            
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'md' => 4,
            'xl' => 5,
        ];
    }
}
