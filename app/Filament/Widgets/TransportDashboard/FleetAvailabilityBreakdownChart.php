<?php

namespace App\Filament\Widgets\TransportDashboard;

use App\Models\Vehicle;
use Filament\Widgets\ChartWidget;

class FleetAvailabilityBreakdownChart extends ChartWidget
{
    protected ?string $heading = 'Fleet Availability Breakdown Chart';

    protected ?string $description = 'Available vs In-Use vs Unavailable';

    protected int | string | array $columnSpan =  4;

    protected function getData(): array
    {
        $vehicles = Vehicle::all();
        $total    = $vehicles->count();

        $data = [
            'available'   => $vehicles->where('availability', 'available')->count(),
            'in-use'      => $vehicles->where('availability', 'in-use')->count(),
            'unavailable' => $vehicles->where('availability', 'unavailable')->count(),
        ];

        $labels = [];
        $values = [];

        foreach ($data as $key => $count) {
            $pct      = $total > 0 ? round(($count / $total) * 100, 1) : 0;
            $label    = ucfirst(str_replace('-', ' ', $key));
            $labels[] = "{$label} ({$count} — {$pct}%)";
            $values[] = $count;
        }

        return [
            'datasets' => [
                [
                    'data'            => $values,
                    'backgroundColor' => [
                        '#0d9488', // available   — teal
                        '#3b82f6', // in-use      — blue
                        '#dc2626', // unavailable — red
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
