<?php

namespace App\Filament\Widgets\ReceptionDashboard;

use App\Models\Suspect;
use App\Models\Visitor;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class ReceptionTrendChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Daily Visitor & Suspect Trend';

    protected ?string $description = 'Daily foot traffic breakdown across the selected period';

    protected int | string | array $columnSpan =  6;

    protected function getData(): array
    {
        $startDate = isset($this->pageFilters['startDate']) 
                    ? Carbon::parse($this->pageFilters['startDate'])->startOfDay() 
                    : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate']) 
                        ? Carbon::parse($this->pageFilters['endDate'])->endOfDay() 
                        : now()->endOfDay();

        // Daily visitor counts
        $visitorCounts = Visitor::whereBetween('date', [$startDate, $endDate])
            ->select('date', DB::raw('count(*) as total'))
            ->groupBy('date')
            ->pluck('total', 'date');

        // Daily suspect counts
        $suspectCounts = Suspect::whereBetween('date', [$startDate, $endDate])
            ->select('date', DB::raw('count(*) as total'))
            ->groupBy('date')
            ->pluck('total', 'date');

        // Fill every day in range with 0 if no record that day
        $period = CarbonPeriod::create($startDate, $endDate);

        $labels  = [];
        $visitors = [];
        $suspects = [];

        foreach ($period as $date) {
            $key       = $date->format('Y-m-d');
            $labels[]  = $date->format('M d');
            $visitors[] = $visitorCounts->get($key, 0);
            $suspects[] = $suspectCounts->get($key, 0);
        }

        return [
            'datasets' => [
                [
                    'label'                => 'Visitors',
                    'data'                 => $visitors,
                    'borderColor'          => 'rgba(59, 130, 246, 1)',
                    'backgroundColor'      => 'rgba(59, 130, 246, 0.1)',
                    'borderWidth'          => 2,
                    'pointBackgroundColor' => 'rgba(59, 130, 246, 1)',
                    'pointRadius'          => 3,
                    'pointHoverRadius'     => 6,
                    'fill'                 => true,
                    'tension'              => 0.4,
                ],
                [
                    'label'                => 'Suspects',
                    'data'                 => $suspects,
                    'borderColor'          => 'rgba(239, 68, 68, 1)',
                    'backgroundColor'      => 'rgba(239, 68, 68, 0.1)',
                    'borderWidth'          => 2,
                    'pointBackgroundColor' => 'rgba(239, 68, 68, 1)',
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
                'legend' => [
                    'display'  => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'x' => [
                    'grid'  => ['display' => false],
                    'ticks' => ['maxTicksLimit' => 12],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid'        => ['color' => 'rgba(0,0,0,0.05)'],
                    'ticks'       => ['stepSize' => 1],
                ],
            ],
        ];
    }
}
