<?php

namespace App\Filament\Widgets\LogisticsDashboard;

use App\Models\LogisticsManagement;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class StockVsDistributedChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Stock vs Distributed';

    protected ?string $description = 'Total stocked quantity against distributed per item';

    protected int | string | array $columnSpan =  4;

    protected function getData(): array
    {
        $startDate = isset($this->pageFilters['startDate']) 
                    ? Carbon::parse($this->pageFilters['startDate'])->startOfDay() 
                    : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate']) 
                        ? Carbon::parse($this->pageFilters['endDate'])->endOfDay() 
                        : now()->endOfDay();

        $items = LogisticsManagement::with(['logisticsDistribution' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function ($item) {
                $item->total_distributed = $item->logisticsDistribution->sum('quantity');
                $item->total_remaining   = max(0, $item->quantity - $item->total_distributed);
                return $item;
            })
            ->sortBy('total_remaining') // most depleted items first
            ->take(8);

        $labels = $stocked = $distributed = $remaining = [];

        foreach ($items as $item) {
            $unit          = $item->unit?->value ?? '';
            $labels[]      = $item->item . ($unit ? " ({$unit})" : '');
            $stocked[]     = $item->quantity;
            $distributed[] = $item->total_distributed;
            $remaining[]   = $item->total_remaining;
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Stocked',
                    'data'            => $stocked,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.85)',
                    'borderRadius'    => 4,
                    'borderWidth'     => 0,
                ],
                [
                    'label'           => 'Distributed',
                    'data'            => $distributed,
                    'backgroundColor' => 'rgba(249, 115, 22, 0.85)',
                    'borderRadius'    => 4,
                    'borderWidth'     => 0,
                ],
                [
                    'label'           => 'Remaining',
                    'data'            => $remaining,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.85)',
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
            'plugins' => [
                'legend' => [
                    'display'  => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'x' => ['grid' => ['display' => false]],
                'y' => ['beginAtZero' => true, 'grid' => ['color' => 'rgba(0,0,0,0.05)']],
            ],
        ];
    }
}
