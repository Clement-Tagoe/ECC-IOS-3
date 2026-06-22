<?php

namespace App\Filament\Widgets\CallTakingDashboard;

use App\Models\ValidCase;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class CasesByNatureChart extends ChartWidget
{
    use InteractsWithPageFilters;
    
    protected ?string $heading = 'Cases By Nature Chart';

    protected ?string $description = 'Incident type breakdown';

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
            ->select('valid_case_nature_id', DB::raw('count(*) as total'))
            ->with('validCaseNature')
            ->groupBy('valid_case_nature_id')
            ->orderByDesc('total')
            ->get();

        $total = $data->sum('total');

        $labels     = [];
        $values     = [];
        $richLabels = [];

        $palette = [
            '#059669', '#dc2626', '#7c3aed',
            '#d97706', '#0891b2', '#be185d', '#65a30d',
            '#ea580c', '#6366f1', '#0f766e', '#1d4ed8',
        ];

        foreach ($data as $i => $row) {
            $name  = $row->validCaseNature?->name ?? "Nature {$row->valid_case_nature_id}";
            $count = $row->total;
            $pct   = $total > 0 ? round(($count / $total) * 100, 1) : 0;

            $labels[]     = "{$name} ({$count} — {$pct}%)";  // value baked into label
            $values[]     = $count;
            $richLabels[] = "{$name} — {$count} ({$pct}%)";
        }

        $colors = collect($labels)->map(fn ($_, $i) => $palette[$i % count($palette)])->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Cases',
                    'data'            => $values,
                    'backgroundColor' => $colors,
                    'borderWidth'     => 2,
                    'borderColor'     => '#ffffff',
                    'hoverOffset'     => 8,
                    'datalabels'      => [
                        'display'    => true,
                        'color'      => '#ffffff',
                        'font'       => ['weight' => 'bold', 'size' => 12],
                        'formatter'  => "JS::(value, ctx) => value > 0 ? value : ''",
                    ],
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
                'datalabels' => [
                    'display'   => true,
                    'color'     => '#ffffff',
                    'font'      => ['weight' => 'bold', 'size' => 12],
                ],
            ],
        ];
    }
}
