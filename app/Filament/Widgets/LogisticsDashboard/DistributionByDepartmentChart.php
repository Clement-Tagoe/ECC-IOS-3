<?php

namespace App\Filament\Widgets\LogisticsDashboard;

use App\Models\LogisticsDistribution;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class DistributionByDepartmentChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Distribution by Department';

    protected ?string $description = 'Which departments receive the most resources';

    protected int | string | array $columnSpan =  4;

    protected function getData(): array
    {
        $startDate = isset($this->pageFilters['startDate']) 
                    ? Carbon::parse($this->pageFilters['startDate'])->startOfDay() 
                    : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate']) 
                        ? Carbon::parse($this->pageFilters['endDate'])->endOfDay() 
                        : now()->endOfDay();
                        
        $data = LogisticsDistribution::whereBetween('date', [$startDate, $endDate])
            ->select('department', DB::raw('sum(quantity) as total'))
            ->groupBy('department')
            ->orderByDesc('total')
            ->get();

        $total = $data->sum('total');

        $palette = [
            '#059669', '#dc2626', '#7c3aed',
            '#d97706', '#0891b2', '#be185d',
            '#65a30d', '#ea580c', '#6366f1',
            '#0f766e', '#1d4ed8',
        ];

        $labels     = [];
        $values     = [];
        $richLabels = [];

        foreach ($data as $i => $row) {
            $name  = $row->department ?? 'Unknown';
            $count = $row->total;
            $pct   = $total > 0 ? round(($count / $total) * 100, 1) : 0;

            $labels[]     = "{$name} ({$count} — {$pct}%)";
            $values[]     = $count;
            $richLabels[] = "{$name} — {$count} ({$pct}%)";
        }

        $colors = collect($labels)->map(fn ($_, $i) => $palette[$i % count($palette)])->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Quantity',
                    'data'            => $values,
                    'backgroundColor' => $colors,
                    'borderWidth'     => 2,
                    'borderColor'     => '#ffffff',
                    'hoverOffset'     => 8,
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
                'legend' => [
                    'display'  => true,
                    'position' => 'right',
                ],
            ],
            'cutout' => '65%',
        ];
    }
}
