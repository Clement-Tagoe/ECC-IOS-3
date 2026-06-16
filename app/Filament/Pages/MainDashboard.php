<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\GhanaCasesMapWidget;
use App\Filament\Widgets\GhanaTasksTopicsMapWidget;
use App\Filament\Widgets\MainStatsOverview;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Illuminate\Support\Facades\Gate;

class MainDashboard extends BaseDashboard
{
    use HasFiltersAction;
    
    protected static string $routePath = 'main-dashboard';

    protected static ?string $title = 'Main Dashboard';

    public static function canAccess(): bool
    {
        return Gate::allows('View:MainDashboard');
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

            MainStatsOverview::class,
            GhanaCasesMapWidget::class,
            GhanaTasksTopicsMapWidget::class,
            
            
        ];
    }
}