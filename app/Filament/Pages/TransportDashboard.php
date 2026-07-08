<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TransportDashboard\FleetAvailabilityBreakdownChart;
use App\Filament\Widgets\TransportDashboard\FleetByCategoryChart;
use App\Filament\Widgets\TransportDashboard\FleetStatusBreakdownChart;
use App\Filament\Widgets\TransportDashboard\VehicleStatsOverviewWidget;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class TransportDashboard extends BaseDashboard
{
    use HasFiltersAction;

    protected static string $routePath = 'Transport-Dashboard';

    protected static ?string $title = 'Transport Dashboard';

    protected static ?string $navigationLabel = 'Transport Dashboard';

    protected static string | UnitEnum | null $navigationGroup = 'Dashboards';

    public static function canAccess(): bool
    {
        return Gate::allows('View:TransportDashboard');
    }
    
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
            VehicleStatsOverviewWidget::class,
            FleetStatusBreakdownChart::class,
            FleetAvailabilityBreakdownChart::class,
            FleetByCategoryChart::class,
        ];
    }

}