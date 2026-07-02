<?php

namespace App\Filament\Widgets\ForensicsDashboard;

use App\Models\ForensicCase;
use App\Models\ForensicReport;
use App\Models\Task;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ForensicsStatsOverview extends StatsOverviewWidget
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

        $taskAssigned = Task::whereHas('collaborators', fn ($q) => $q->where('users.id', Auth::id()))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $tasksCompleted = Task::where('status', 'completed')
            ->whereHas('collaborators', fn ($q) => $q->where('users.id', Auth::id()))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $forensicCasesInReview = ForensicCase::where('status', 'in_review')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $forensicCasesReviewed = ForensicCase::where('status', 'reviewed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $forensicReportsInReview = ForensicReport::where('status', 'in_review')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $forensicReportsReviewed = ForensicReport::where('status', 'reviewed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        return [
            Stat::make('Forensic Cases In Review', $forensicCasesInReview)
                ->description('Cases in review')
                ->color('success')
                ->icon('heroicon-o-document-arrow-up')
                ->chart([2, 2, 2, 2, 2, 2, 2, 2]),

            Stat::make('Forensic Cases Reviewed', $forensicCasesReviewed)
                ->description('Cases reviewed')
                ->color('auxiliary')
                ->icon('heroicon-o-document-arrow-down')
                ->chart([2, 2, 2, 2, 2, 2, 2, 2]),
            
            Stat::make('Forensic Reports In Review', $forensicReportsInReview)
                ->description('Reports in review')
                ->color('success')
                ->icon('heroicon-o-document-arrow-up')
                ->chart([2, 2, 2, 2, 2, 2, 2, 2]),

            Stat::make('Forensic Reports Reviewed', $forensicReportsReviewed)
                ->description('Reports reviewed')
                ->color('auxiliary')
                ->icon('heroicon-o-document-arrow-down')
                ->chart([2, 2, 2, 2, 2, 2, 2, 2]),
            
            Stat::make('Tasks Assigned', $taskAssigned)
                ->description('Tasks Assigned')
                ->color('nonary')
                ->icon('heroicon-o-clipboard-document')
                ->chart([2, 2, 2, 2, 2, 2, 2, 2]),

            // Stat::make('Tasks Completed', $tasksCompleted)
            //     ->description('Completed Tasks')
            //     ->color('info')
            //     ->icon('heroicon-o-clipboard-document-check')
            //     ->chart([2, 2, 2, 2, 2, 2, 2, 2]),
        ];
    }
}
