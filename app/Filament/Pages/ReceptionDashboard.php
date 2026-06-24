<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ReceptionDashboard\PeakHoursChart;
use App\Filament\Widgets\ReceptionDashboard\ReceptionTrendChart;
use App\Filament\Widgets\ReceptionDashboard\VisitorManagementOverviewWidget;
use App\Filament\Widgets\ReceptionDashboard\VisitorStatsOverviewWidget;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Support\Enums\Width;

class ReceptionDashboard extends BaseDashboard
{
     use HasFiltersAction;
    
    protected static string $routePath = 'reception';

    protected static ?string $title = 'Reception Dashboard';

    protected static ?string $navigationLabel = 'Reception Dashboard';

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
            VisitorManagementOverviewWidget::class,
            // VisitorStatsOverviewWidget::class,
            ReceptionTrendChart::class,
            PeakHoursChart::class,
        ];
    }

}