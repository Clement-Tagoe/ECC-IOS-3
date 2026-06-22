<?php

namespace App\Filament\Widgets\CallTakingDashboard;

use App\Models\ValidCase;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class AgencyCaseLoadChart extends ChartWidget
{
    use InteractsWithPageFilters;
    
    protected ?string $heading = 'Agency Case Load Chart';

    protected ?string $description = 'Agency case load';

    protected int | string | array $columnSpan =  4;
 
    protected function getData(): array
    {
        $startDate = isset($this->filters['startDate'])
            ? Carbon::parse($this->filters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->filters['endDate'])
            ? Carbon::parse($this->filters['endDate'])->endOfDay()
            : now()->endOfDay();

        $data = ValidCase::whereBetween('reporting_date', [$startDate, $endDate])
            ->select('agency_id', DB::raw('count(*) as total'))
            ->with('agency')
            ->groupBy('agency_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $agencyColors = [
            'Ghana National Fire Service'       => '#dc2626', // red
            'Ghana Ambulance Service'           => '#d8c34a', // yellow
            'Ghana Police Service'              => '#1d4ed8', // blue
            'NADMO'                             => '#d66c33', // orange
            'NSB/GIFEC'                         => '#059669', // green
        ];

        $fallbackPalette = [
            '#7c3aed', '#0891b2', '#be185d',
            '#65a30d', '#0f766e',
        ];

        $fallbackIndex = 0;

        $labels = [];
        $values = [];
        $colors = [];

        foreach ($data as $row) {
            $name = $row->agency?->name ?? "Agency {$row->agency_id}";

            $labels[] = $name;
            $values[] = $row->total;
            $colors[] = $agencyColors[$name] ?? $fallbackPalette[$fallbackIndex++ % count($fallbackPalette)];
        }

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
            'plugins'   => ['legend' => ['display' => false]],
            'scales'    => [
                'x' => ['beginAtZero' => true, 'grid' => ['color' => 'rgba(0,0,0,0.05)']],
                'y' => ['grid' => ['display' => false]],
            ],
        ];
    }
}
