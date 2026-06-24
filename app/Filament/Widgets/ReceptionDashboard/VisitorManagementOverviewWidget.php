<?php

namespace App\Filament\Widgets\ReceptionDashboard;

use App\Models\Suspect;
use App\Models\Visitor;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VisitorManagementOverviewWidget extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    public function getColumns(): int | array
    {
        return [
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

        $dateRangeLabel = $startDate->format('M d') . ' — ' . $endDate->format('M d, Y');

        // ── Visitors ──────────────────────────────────────────────
        $visitors = Visitor::whereBetween('date', [$startDate, $endDate]);

        $totalVisitors      = $visitors->clone()->count();
        $visitorsToday      = Visitor::whereDate('date', today())->count();
        $checkedInVisitors  = Visitor::whereDate('date', today())->whereNotNull('time_in')->whereNull('time_out')->count();
        $checkedOutVisitors = Visitor::whereDate('date', today())->whereNotNull('time_out')->count();
        $maleVisitors       = $visitors->clone()->where('sex', 'Male')->count();
        $femaleVisitors     = $visitors->clone()->where('sex', 'Female')->count();

        $avgTimeStayedFormatted = $this->calculateAverageTimeStayed(
            Visitor::whereBetween('date', [$startDate, $endDate])
                ->whereNotNull('time_stayed')
                ->pluck('time_stayed')
        );

        // ── Suspects ──────────────────────────────────────────────
        $suspects = Suspect::whereBetween('date', [$startDate, $endDate]);

        $totalSuspects  = $suspects->clone()->count();
        $suspectsToday  = Suspect::whereDate('date', today())->count();
        $currentlyHeld  = Suspect::whereDate('date', today())->whereNotNull('time_in')->whereNull('time_out')->count();
        $releasedToday  = Suspect::whereDate('date', today())->whereNotNull('time_out')->count();

        $avgHoldFormatted = $this->calculateAverageTimeStayed(
            Suspect::whereBetween('date', [$startDate, $endDate])
                ->whereNotNull('time_stayed')
                ->pluck('time_stayed')
        );

        return [
            Stat::make('Total Visitors', $totalVisitors)
                ->description($dateRangeLabel)
                ->descriptionIcon('heroicon-o-user-group')
                ->color('primary')
                ->chart([2, 2, 2, 2, 2, 2, 2]),

            Stat::make('Visitors Today', $visitorsToday)
                ->description(today()->format('F j, Y'))
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('info')
                 ->chart([2, 2, 2, 2, 2, 2, 2]),

            Stat::make('Currently Checked In', $checkedInVisitors)
                ->description('Visitors still on premises')
                ->descriptionIcon('heroicon-o-arrow-right-circle')
                ->color('success')
                 ->chart([2, 2, 2, 2, 2, 2, 2]),

            Stat::make('Avg. Visit Duration', $avgTimeStayedFormatted)
                ->description('Average visitor stay ' . $dateRangeLabel)
                ->descriptionIcon('heroicon-o-clock')
                ->color('primary')
                 ->chart([2, 2, 2, 2, 2, 2, 2]),

            Stat::make('Total Suspects', $totalSuspects)
                ->description($dateRangeLabel)
                ->descriptionIcon('heroicon-o-shield-exclamation')
                ->color('danger')
                 ->chart([2, 2, 2, 2, 2, 2, 2]),

            Stat::make('Suspects Today', $suspectsToday)
                ->description(today()->format('F j, Y'))
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('danger')
                 ->chart([2, 2, 2, 2, 2, 2, 2]),

            Stat::make('Currently Held', $currentlyHeld)
                ->description('Suspects still on premises')
                ->descriptionIcon('heroicon-o-lock-closed')
                ->color($currentlyHeld > 0 ? 'danger' : 'success')
                 ->chart([2, 2, 2, 2, 2, 2, 2]),

            Stat::make('Avg. Hold Duration', $avgHoldFormatted)
                ->description('Average suspect holding time ' . $dateRangeLabel)
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning')
                 ->chart([2, 2, 2, 2, 2, 2, 2]),
        ];
    }

    protected function calculateAverageTimeStayed(\Illuminate\Support\Collection $times): string
    {
        if ($times->isEmpty()) {
            return 'N/A';
        }

        $totalSeconds = $times->sum(function ($time) {
            [$hours, $minutes, $seconds] = explode(':', $time);
            return ((int) $hours * 3600) + ((int) $minutes * 60) + (int) $seconds;
        });

        $avgSeconds = (int) round($totalSeconds / $times->count());

        $hours   = floor($avgSeconds / 3600);
        $minutes = floor(($avgSeconds % 3600) / 60);
        $seconds = $avgSeconds % 60;

        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }

        if ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        }

        return "{$seconds}s";
    }
}
