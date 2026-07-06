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

    public function getColumns(): int | array
    {
        return [
            'md' => 3,
            'xl' => 4,
        ];
    }
    
    protected function getStats(): array
    {
        $startDate = isset($this->pageFilters['startDate']) 
                    ? Carbon::parse($this->pageFilters['startDate'])->startOfDay() 
                    : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate']) 
                        ? Carbon::parse($this->pageFilters['endDate'])->endOfDay() 
                        : now()->endOfDay();

        $forensicCasesSent = ForensicCase::where('user_id', Auth::id())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $forensicCasesReceived = ForensicCase::whereHas('receivers', fn ($q) => $q->where('users.id', Auth::id()))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

         $forensicReportsSent = ForensicReport::where('user_id', Auth::id())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $forensicReportsReceived = ForensicReport::whereHas('receivers', fn ($q) => $q->where('users.id', Auth::id()))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        return [
            Stat::make('Forensic Cases Sent', $forensicCasesSent)
                ->description('Sent Cases')
                ->color('success')
                ->icon('heroicon-o-document-arrow-up')
                ->chart([2, 2, 2, 2, 2, 2, 2, 2]),

            Stat::make('Forensic Cases Received', $forensicCasesReceived)
                ->description('Cases received')
                ->color('auxiliary')
                ->icon('heroicon-o-document-arrow-down')
                ->chart([2, 2, 2, 2, 2, 2, 2, 2]),
            
            Stat::make('Forensic Reports Sent', $forensicReportsSent)
                ->description('Reports sent')
                ->color('success')
                ->icon('heroicon-o-document-arrow-up')
                ->chart([2, 2, 2, 2, 2, 2, 2, 2]),

            Stat::make('Forensic Reports Received', $forensicReportsReceived)
                ->description('Reports received')
                ->color('auxiliary')
                ->icon('heroicon-o-document-arrow-down')
                ->chart([2, 2, 2, 2, 2, 2, 2, 2]),

            // Stat::make('Tasks Completed', $tasksCompleted)
            //     ->description('Completed Tasks')
            //     ->color('info')
            //     ->icon('heroicon-o-clipboard-document-check')
            //     ->chart([2, 2, 2, 2, 2, 2, 2, 2]),
        ];
    }
}
