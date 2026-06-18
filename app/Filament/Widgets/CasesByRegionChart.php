<?php

namespace App\Filament\Widgets;

use App\Models\Region;
use App\Models\ValidCase;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class CasesByRegionChart extends ChartWidget
{
    use InteractsWithPageFilters;
    
    protected ?string $heading = 'Cases By Region Chart';
 
    protected ?string $description = 'Valid cases per region';

    protected function getData(): array
    {
        $startDate = isset($this->filters['startDate'])
            ? Carbon::parse($this->filters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->filters['endDate'])
            ? Carbon::parse($this->filters['endDate'])->endOfDay()
            : now()->endOfDay();

        $caseCounts = ValidCase::whereBetween('reporting_date', [$startDate, $endDate])
            ->select('region_id', DB::raw('count(*) as total'))
            ->groupBy('region_id')
            ->pluck('total', 'region_id');

        $regions = Region::orderBy('name')->get();

        $palette = [
            'rgba(59, 130, 246, 0.85)',
            'rgba(16, 185, 129, 0.85)',
            'rgba(245, 158, 11, 0.85)',
            'rgba(239, 68, 68, 0.85)',
            'rgba(139, 92, 246, 0.85)',
            'rgba(20, 184, 166, 0.85)',
            'rgba(249, 115, 22, 0.85)',
            'rgba(236, 72, 153, 0.85)',
            'rgba(6, 182, 212, 0.85)',
            'rgba(132, 204, 22, 0.85)',
            'rgba(168, 85, 247, 0.85)',
            'rgba(251, 191, 36, 0.85)',
        ];

        $labels = [];
        $values = [];

        foreach ($regions as $i => $region) {
            $labels[] = $region->name;
            $values[] = $caseCounts->get($region->id, 0);
        }

        $colors = collect($regions)->map(
            fn ($_, $i) => $caseCounts->get($regions[$i]->id, 0) > 0
                ? $palette[$i % count($palette)]
                : 'rgba(156, 163, 175, 0.3)'
        )->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Cases',
                    'data'            => $values,
                    'backgroundColor' => $colors,
                    'borderRadius'    => 4,
                    'borderWidth'     => 0,
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
            'indexAxis' => 'y',
            'plugins'   => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => ['beginAtZero' => true, 'grid' => ['display' => true]],
                'y' => ['grid' => ['display' => false]],
            ],
        ];
    }
}
