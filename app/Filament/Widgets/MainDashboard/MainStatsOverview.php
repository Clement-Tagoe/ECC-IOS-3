<?php

namespace App\Filament\Widgets\MainDashboard;

use App\Models\CallLog;
use App\Models\Report;
use App\Models\Task;
use App\Models\ValidCase;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class MainStatsOverview extends StatsOverviewWidget
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

        $reportsReceived = Report::whereBetween('date', [
                                $startDate,
                                $endDate,
                            ])
                            ->whereHas('receivers', fn ($q) => $q->where('users.id', Auth::id()))->count();

        $totalValidCases = ValidCase::whereBetween('reporting_date', [$startDate, $endDate])->count();

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
        $valid   = $stats->valid ?? 0;
        $prank   = $stats->prank ?? 0;
        
        $tasksCompleted = Task::whereBetween('created_at', [
                                $startDate,
                                $endDate,
                            ])
                            ->where('status', 'completed')->count();

        return [
            Stat::make('Reports Received', $reportsReceived)
                ->description('Reports received')
                ->color('auxiliary')
                ->icon('heroicon-o-document-arrow-down')
                ->chart([4, 11, 5, 10, 6, 4, 8, 11]),

            Stat::make('Total Valid Cases', $totalValidCases)
                ->description('Valid Cases')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-briefcase')
                ->chart([6, 10, 5, 15, 3, 10, 7, 17]),

            Stat::make('Total Calls Received', $stats->received ?? 0)
                ->description('Calls Received')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([10, 8, 5, 12, 6, 8, 4, 2]),
            
            Stat::make('All Tasks Completed', $tasksCompleted)
                ->description('Completed tasks')
                ->color('info')
                ->icon('heroicon-o-clipboard-document-check')
                ->chart([11, 13, 5, 15, 6, 7, 8, 14]),
            
        ];
    }
}
