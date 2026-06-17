<?php

namespace App\Filament\Widgets;

use App\Models\Region;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class CameraStatusByRegionChart extends ChartWidget
{
    use InteractsWithPageFilters;
    
    protected ?string $heading = 'Camera Status By Region Chart';

    protected ?string $description = 'Online vs offline cameras per region';

    protected function getData(): array
    {
        $startDate = isset($this->pageFilters['startDate'])
            ? Carbon::parse($this->pageFilters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate'])
            ? Carbon::parse($this->pageFilters['endDate'])->endOfDay()
            : now()->endOfDay();

        $regions = Region::leftJoin('camera_audits', function ($join) use ($startDate, $endDate) {
                $join->on('regions.id', '=', 'camera_audits.region_id')
                ->whereBetween('camera_audits.updated_at', [$startDate, $endDate]);
            })
            ->selectRaw("regions.id, regions.name as region_name, camera_audits.status, count(camera_audits.id) as total")
            ->groupBy('regions.id', 'regions.name', 'camera_audits.status')
            ->get()
            ->groupBy('region_name');

        $labels  = $regions->keys()->toArray();
        $online  = [];
        $offline = [];

        foreach ($regions as $region => $cameras) {
            $online[]  = $cameras->where('status', 'online')->sum('total');
            $offline[] = $cameras->where('status', 'offline')->sum('total');
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Online',
                    'data'            => $online,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.8)',
                    'borderColor'     => 'rgba(16, 185, 129, 1)',
                    'borderWidth'     => 2,
                ],
                [
                    'label'           => 'Offline',
                    'data'            => $offline,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.8)',
                    'borderColor'     => 'rgba(239, 68, 68, 1)',
                    'borderWidth'     => 2,
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
                'x' => ['stacked' => false],
                'y' => [
                    'beginAtZero' => true,
                    'ticks'       => ['stepSize' => 1],
                ],
            ],
        ];
    }
}
