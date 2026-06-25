<?php

namespace App\Filament\Widgets\TransportDashboard;

use App\Models\Vehicle;
use Filament\Widgets\ChartWidget;

class FleetStatusBreakdownChart extends ChartWidget
{
    protected ?string $heading = 'Fleet Status Breakdown Chart';

    protected ?string $description = 'Active vs Maintenance vs Retired';

    protected int | string | array $columnSpan =  4;

    protected function getData(): array
    {
        $vehicles = Vehicle::all();
        $total    = $vehicles->count();

        $data = [
            'active'      => $vehicles->where('status', 'active')->count(),
            'maintenance' => $vehicles->where('status', 'maintenance')->count(),
            'retired'     => $vehicles->where('status', 'retired')->count(),
        ];

        $labels = [];
        $values = [];

        foreach ($data as $key => $count) {
            $pct      = $total > 0 ? round(($count / $total) * 100, 1) : 0;
            $labels[] = ucfirst($key) . " ({$count} — {$pct}%)";
            $values[] = $count;
        }

        return [
            'datasets' => [
                [
                    'data'        => $values,
                    'backgroundColor' => [
                        '#096850', // active   — emerald
                        '#a08f33', // maintenance — amber
                        '#9e504e', // retired  — red
                    ],
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                    'hoverOffset' => 8,
                ],
            ],
            'labels' => $labels,
            'total'  => $total,
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
                    'position' => 'bottom',
                ],
            ],
            'cutout' => '65%',
        ];
    }
}
