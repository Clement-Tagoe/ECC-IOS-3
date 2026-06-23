<?php

namespace App\Filament\Widgets\LogisticsDashboard;

use App\Models\LogisticsDistribution;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class DistributionTrendChart extends ChartWidget
{
     use InteractsWithPageFilters;

    protected ?string $heading = 'Distribution Trend';

    protected ?string $description = 'Daily distribution quantities over the selected period';

    protected int | string | array $columnSpan =  4;

    protected function getData(): array
    {
       $startDate = isset($this->pageFilters['startDate']) 
                    ? Carbon::parse($this->pageFilters['startDate'])->startOfDay() 
                    : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate']) 
                        ? Carbon::parse($this->pageFilters['endDate'])->endOfDay() 
                        : now()->endOfDay();

        // Get daily totals within range
        $dailyTotals = LogisticsDistribution::whereBetween('date', [$startDate, $endDate])
            ->select('date', DB::raw('sum(quantity) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // Fill every day in range with 0 if no distribution that day
        $period = CarbonPeriod::create($startDate, $endDate);

        $labels = [];
        $values = [];

        foreach ($period as $date) {
            $key      = $date->format('Y-m-d');
            $labels[] = $date->format('M d');
            $values[] = $dailyTotals->get($key, 0);
        }

        return [
            'datasets' => [
                [
                    'label'                => 'Distributed',
                    'data'                 => $values,
                    'borderColor'          => 'rgba(59, 130, 246, 1)',
                    'backgroundColor'      => 'rgba(59, 130, 246, 0.1)',
                    'borderWidth'          => 2,
                    'pointBackgroundColor' => 'rgba(59, 130, 246, 1)',
                    'pointRadius'          => 3,
                    'pointHoverRadius'     => 6,
                    'fill'                 => true,
                    'tension'              => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => [
                    'grid'   => ['display' => false],
                    'ticks'  => ['maxTicksLimit' => 10],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid'        => ['color' => 'rgba(0,0,0,0.05)'],
                ],
            ],
        ];
    }
}
