<?php

namespace App\Filament\Widgets\ReceptionDashboard;

use App\Models\Suspect;
use App\Models\Visitor;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class PeakHoursChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Peak Hours';

    protected ?string $description = 'Foot traffic distribution by hour of day';

    protected int | string | array $columnSpan =  6;

    protected function getData(): array
    {
        $startDate = isset($this->pageFilters['startDate']) 
                    ? Carbon::parse($this->pageFilters['startDate'])->startOfDay() 
                    : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate']) 
                        ? Carbon::parse($this->pageFilters['endDate'])->endOfDay() 
                        : now()->endOfDay();

        // Build all 24 hours as base so no hour is missing
        $hours = collect(range(0, 23))->mapWithKeys(fn ($h) => [$h => 0]);

        // Visitor counts grouped by hour of time_in
        $visitorHours = Visitor::whereBetween('date', [$startDate, $endDate])
            ->whereNotNull('time_in')
            ->select(DB::raw('HOUR(time_in) as hour'), DB::raw('count(*) as total'))
            ->groupBy('hour')
            ->pluck('total', 'hour');

        // Suspect counts grouped by hour of time_in
        $suspectHours = Suspect::whereBetween('date', [$startDate, $endDate])
            ->whereNotNull('time_in')
            ->select(DB::raw('HOUR(time_in) as hour'), DB::raw('count(*) as total'))
            ->groupBy('hour')
            ->pluck('total', 'hour');

        // Merge into base 24-hour map
        $visitorData = $hours->merge($visitorHours);
        $suspectData = $hours->merge($suspectHours);

        // Format hour labels e.g. 09:00, 14:00
        $labels = $hours->keys()->map(fn ($h) => Carbon::createFromTime($h)->format('H:00'))->toArray();

        // Color each bar based on combined traffic intensity
        $combined = $visitorData->map(fn ($v, $h) => $v + $suspectData->get($h, 0));
        $maxCount = $combined->max() ?: 1;

        $barColors = $combined->map(function ($count) use ($maxCount) {
            $intensity = $count / $maxCount;
            return match(true) {
                $intensity >= 0.75 => 'rgba(239, 68, 68, 0.85)',   // red   — very busy
                $intensity >= 0.50 => 'rgba(249, 115, 22, 0.85)',  // orange — busy
                $intensity >= 0.25 => 'rgba(245, 158, 11, 0.85)',  // amber  — moderate
                $count > 0         => 'rgba(59, 130, 246, 0.85)',  // blue   — light
                default            => 'rgba(156, 163, 175, 0.3)',  // gray   — no traffic
            };
        })->values()->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Visitors',
                    'data'            => $visitorData->values()->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.85)',
                    'borderRadius'    => 4,
                    'borderWidth'     => 0,
                    'stack'           => 'traffic',
                ],
                [
                    'label'           => 'Suspects',
                    'data'            => $suspectData->values()->toArray(),
                    'backgroundColor' => 'rgba(239, 68, 68, 0.85)',
                    'borderRadius'    => 4,
                    'borderWidth'     => 0,
                    'stack'           => 'traffic',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display'  => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode'      => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'stacked' => true,
                    'grid'    => ['display' => false],
                    'ticks'   => [
                        'maxRotation' => 45,
                        'minRotation' => 45,
                        'font'        => ['size' => 11],
                    ],
                ],
                'y' => [
                    'stacked'     => true,
                    'beginAtZero' => true,
                    'grid'        => ['color' => 'rgba(0,0,0,0.05)'],
                    'ticks'       => ['stepSize' => 1],
                ],
            ],
        ];
    }
}
