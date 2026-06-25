<?php

namespace App\Filament\Widgets\TransportDashboard;

use App\Models\Vehicle;
use Filament\Widgets\ChartWidget;

class FleetByCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Fleet By Category Chart';

    protected ?string $description = 'Vehicle type composition';

    protected int | string | array $columnSpan =  4;

    protected function getData(): array
    {
        $vehicles = Vehicle::all();
        $total    = $vehicles->count();

        $grouped = $vehicles
            ->groupBy('category')
            ->map(fn ($group) => $group->count())
            ->sortDesc();

        $palette = [
            '#b85e2e','#15358f', '#0f766e', '#ec7272',
            '#d97706', '#7c3aed', '#0891b2',
            '#db1e6d', '#65a30d', '#4f8b78',
            
        ];

        $labels = [];
        $values = [];

        foreach ($grouped as $category => $count) {
            $pct      = $total > 0 ? round(($count / $total) * 100, 1) : 0;
            $labels[] = ucfirst($category) . " ({$count} — {$pct}%)";
            $values[] = $count;
        }

        $colors = collect($labels)
            ->map(fn ($_, $i) => $palette[$i % count($palette)])
            ->toArray();

        return [
            'datasets' => [
                [
                    'data'            => $values,
                    'backgroundColor' => $colors,
                    'borderWidth'     => 2,
                    'borderColor'     => '#ffffff',
                    'hoverOffset'     => 8,
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
