<?php

namespace App\Filament\Widgets\MainDashboard;

use App\Models\CallLog;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class CallBreakdownChart extends ChartWidget
{
    use InteractsWithPageFilters;
    
    protected ?string $heading = 'Call Breakdown';
 
    protected ?string $description = 'Incoming, valid, and prank calls per day';

    protected int | string | array $columnSpan =  4;

    protected function getData(): array
    {
        $startDate = isset($this->pageFilters['startDate'])
            ? Carbon::parse($this->pageFilters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate'])
            ? Carbon::parse($this->pageFilters['endDate'])->endOfDay()
            : now()->endOfDay();

        // Dynamically generate days between the selected range
        $days = collect(Carbon::parse($startDate)->toPeriod($endDate, '1 day'))
            ->map(fn ($d) => $d->toDateString());

        $logs = CallLog::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get()
            ->keyBy(fn ($row) => Carbon::parse($row->date)->toDateString());

        $labels = $days->map(fn ($d) => Carbon::parse($d)->format('D d M'))->toArray();
        $total  = $days->map(fn ($d) => $logs->get($d)?->total_calls_received ?? 0)->toArray();
        $valid  = $days->map(fn ($d) => $logs->get($d)?->valid_calls ?? 0)->toArray();
        $prank  = $days->map(fn ($d) => $logs->get($d)?->prank_calls ?? 0)->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Total Received',
                    'data'            => $total,
                    'backgroundColor' => '#8b5cf6',
                    'borderRadius'    => 4,
                    'borderWidth'     => 0,
                ],
                [
                    'label'           => 'Valid Calls',
                    'data'            => $valid,
                    'backgroundColor' => '#059669',
                    'borderRadius'    => 4,
                    'borderWidth'     => 0,
                ],
                [
                    'label'           => 'Prank / Invalid',
                    'data'            => $prank,
                    'backgroundColor' => '#dc2626',
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
                'legend' => ['position' => 'top'],
            ],
            'scales' => [
                'x' => ['grid' => ['display' => false]],
                'y' => ['beginAtZero' => true],
            ],
        ];
    }
}
