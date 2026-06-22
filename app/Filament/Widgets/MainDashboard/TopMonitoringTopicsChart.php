<?php

namespace App\Filament\Widgets\MainDashboard;

use App\Models\Topic;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class TopMonitoringTopicsChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Top Monitoring Topics Chart';

    protected ?string $description = 'Most frequently tagged topics across monitoring tasks';

    protected int | string | array $columnSpan =  4;

    protected function getData(): array
    {
        $startDate = isset($this->pageFilters['startDate'])
            ? Carbon::parse($this->pageFilters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate'])
            ? Carbon::parse($this->pageFilters['endDate'])->endOfDay()
            : now()->endOfDay();

        $data = Topic::withCount(['monitoringTasks' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }])
            ->having('monitoring_tasks_count', '>', 0)
            ->orderByDesc('monitoring_tasks_count')
            ->limit(8)
            ->get();

        $total = $data->sum('monitoring_tasks_count');

        $labels     = [];
        $values     = [];
        $richLabels = [];

        $palette = [
            '#059669', '#dc2626', '#7c3aed',
            '#d97706', '#0891b2', '#be185d', '#65a30d',
            '#ea580c',
        ];

        foreach ($data as $i => $topic) {
            $name  = $topic->name;
            $count = $topic->monitoring_tasks_count;
            $pct   = $total > 0 ? round(($count / $total) * 100, 1) : 0;

            $labels[]     = "{$name} ({$count} — {$pct}%)";
            $values[]     = $count;
            $richLabels[] = "{$name} — {$count} ({$pct}%)";
        }

        $colors = collect($labels)->map(fn ($_, $i) => $palette[$i % count($palette)])->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Tasks',
                    'data'            => $values,
                    'backgroundColor' => $colors,
                    'borderWidth'     => 2,
                    'borderColor'     => '#ffffff',
                    'hoverOffset'     => 8,
                    'datalabels'      => [
                        'display'   => true,
                        'color'     => '#ffffff',
                        'font'      => ['weight' => 'bold', 'size' => 12],
                        'formatter' => "JS::(value, ctx) => value > 0 ? value : ''",
                    ],
                ],
            ],
            'labels'     => $labels,
            'richLabels' => $richLabels,
            'total'      => $total,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'datalabels' => [
                    'display' => true,
                    'color'   => '#ffffff',
                    'font'    => ['weight' => 'bold', 'size' => 12],
                ],
            ],
            'cutout' => '65%',
        ];
    }
}