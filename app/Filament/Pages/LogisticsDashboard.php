<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LogisticsDashboard\DistributionByDepartmentChart;
use App\Filament\Widgets\LogisticsDashboard\DistributionTrendChart;
use App\Filament\Widgets\LogisticsDashboard\InventoryOverviewWidget;
use App\Filament\Widgets\LogisticsDashboard\StockVsDistributedChart;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Support\Enums\Width;

class LogisticsDashboard extends BaseDashboard
{
    use HasFiltersAction;

    protected static string $routePath = 'logistics-dashboard';

    protected static ?string $title = 'Logistics Dashboard';

    public function getColumns(): int | array
    {
        return 12; // Change from the default 12 if you need a different grid size
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make()
                ->schema([
                    DatePicker::make('startDate'),
                    DatePicker::make('endDate'),
                ]),
        ];
    }

    public function getWidgets(): array
    {
        return [
            InventoryOverviewWidget::class,
            StockVsDistributedChart::class,
            DistributionByDepartmentChart::class,
            DistributionTrendChart::class,
        ];
    }
}