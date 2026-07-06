<?php

namespace App\Filament\Widgets\ForensicsDashboard;

use App\Models\ForensicReport;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\Auth;

class ForensicReportsSentChart extends ChartWidget
{
    use InteractsWithPageFilters;
    
    protected ?string $heading = 'Forensic Reports Sent Chart';

    protected int | string | array $columnSpan =  4;

    protected function getData(): array
    {
        $userId = Auth::id();

        $startDate = isset($this->pageFilters['startDate'])
            ? Carbon::parse($this->pageFilters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate'])
            ? Carbon::parse($this->pageFilters['endDate'])->endOfDay()
            : now()->endOfDay();

        $rows = ForensicReport::query()
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhereHas('collaborators', fn ($q) => $q->where('users.id', $userId));
            })
            ->whereHas('receivers')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, count(*) as aggregate')
            ->groupBy('date')
            ->pluck('aggregate', 'date');

        $period = CarbonPeriod::create($startDate, $endDate);

        $labels = [];
        $data = [];

        foreach ($period as $date) {
            $key = $date->format('Y-m-d');
            $labels[] = $date->format('M j');
            $data[] = (int) ($rows->get($key, 0));
        }

        return [
            'datasets' => [
                [
                    'label' => 'Reports Sent',
                    'data' => $data,
                    'borderColor' => '#8b5cf6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
