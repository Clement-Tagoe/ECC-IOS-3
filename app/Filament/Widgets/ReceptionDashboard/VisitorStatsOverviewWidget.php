<?php

namespace App\Filament\Widgets\ReceptionDashboard;

use App\Models\Suspect;
use App\Models\Visitor;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;

class VisitorStatsOverviewWidget extends Widget
{
    use InteractsWithPageFilters;

    protected string $view = 'filament.widgets.reception-dashboard.visitor-stats-overview-widget';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $startDate = isset($this->filters['startDate'])
            ? Carbon::parse($this->filters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->filters['endDate'])
            ? Carbon::parse($this->filters['endDate'])->endOfDay()
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
            'dateRangeLabel' => $dateRangeLabel,
            'stats' => [

                // ── Visitor Stats ──────────────────────────────────
                [
                    'label'       => 'Total Visitors',
                    'value'       => $totalVisitors,
                    'description' => $dateRangeLabel,
                    'icon'        => 'heroicon-o-user-group',
                    'bg'          => 'bg-blue-400',
                    'text'        => 'text-white',
                    'icon_bg'     => 'bg-blue-600',
                ],
                [
                    'label'       => 'Visitors Today',
                    'value'       => $visitorsToday,
                    'description' => today()->format('F j, Y'),
                    'icon'        => 'heroicon-o-calendar-days',
                    'bg'          => 'bg-sky-400',
                    'text'        => 'text-white',
                    'icon_bg'     => 'bg-sky-600',
                ],
                [
                    'label'       => 'Currently Checked In',
                    'value'       => $checkedInVisitors,
                    'description' => 'Still on premises',
                    'icon'        => 'heroicon-o-arrow-right-circle',
                    'bg'          => 'bg-emerald-400',
                    'text'        => 'text-white',
                    'icon_bg'     => 'bg-emerald-600',
                ],
    
                [
                    'label'       => 'Avg. Visit Duration',
                    'value'       => $avgTimeStayedFormatted,
                    'description' => 'Average visitor stay',
                    'icon'        => 'heroicon-o-clock',
                    'bg'          => 'bg-violet-400',
                    'text'        => 'text-white',
                    'icon_bg'     => 'bg-violet-600',
                ],

                // ── Suspect Stats ──────────────────────────────────
                [
                    'label'       => 'Total Suspects',
                    'value'       => $totalSuspects,
                    'description' => $dateRangeLabel,
                    'icon'        => 'heroicon-o-shield-exclamation',
                    'bg'          => 'bg-red-400',
                    'text'        => 'text-white',
                    'icon_bg'     => 'bg-red-600',
                ],
                [
                    'label'       => 'Suspects Today',
                    'value'       => $suspectsToday,
                    'description' => today()->format('F j, Y'),
                    'icon'        => 'heroicon-o-calendar-days',
                    'bg'          => 'bg-rose-400',
                    'text'        => 'text-white',
                    'icon_bg'     => 'bg-rose-600',
                ],
                [
                    'label'       => 'Currently Held',
                    'value'       => $currentlyHeld,
                    'description' => 'Suspects still on premises',
                    'icon'        => 'heroicon-o-lock-closed',
                    'bg'          => $currentlyHeld > 0 ? 'bg-red-600'     : 'bg-emerald-400',
                    'text'        => 'text-white',
                    'icon_bg'     => $currentlyHeld > 0 ? 'bg-red-700'     : 'bg-emerald-600',
                ],
                [
                    'label'       => 'Avg. Hold Duration',
                    'value'       => $avgHoldFormatted,
                    'description' => 'Average holding time',
                    'icon'        => 'heroicon-o-clock',
                    'bg'          => 'bg-orange-400',
                    'text'        => 'text-white',
                    'icon_bg'     => 'bg-orange-600',
                ],
            ],
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

        if ($hours > 0) return "{$hours}h {$minutes}m";
        if ($minutes > 0) return "{$minutes}m {$seconds}s";
        return "{$seconds}s";
    }
}
