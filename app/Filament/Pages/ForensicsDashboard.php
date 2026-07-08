<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ForensicsDashboard\ForensicCaseReviewStatusChart;
use App\Filament\Widgets\ForensicsDashboard\ForensicCasesSentChart;
use App\Filament\Widgets\ForensicsDashboard\ForensicCaseStatusChart;
use App\Filament\Widgets\ForensicsDashboard\ForensicReportsReviewStatusChart;
use App\Filament\Widgets\ForensicsDashboard\ForensicReportsSentChart;
use App\Filament\Widgets\ForensicsDashboard\ForensicReportsStatusChart;
use App\Filament\Widgets\ForensicsDashboard\ForensicsStatsOverview;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class ForensicsDashboard extends BaseDashboard
{
    use HasFiltersAction;

    protected static string $routePath = 'Forensics-Dashboard';

    protected static ?string $title = 'Forensics Dashboard';

    protected static string | UnitEnum | null $navigationGroup = 'Dashboards';

    public static function canAccess(): bool
    {
        return Gate::allows('View:ForensicsDashboard');
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
            ForensicsStatsOverview::class,
            ForensicCaseStatusChart::class,
            ForensicCaseReviewStatusChart::class,
            ForensicCasesSentChart::class,
            ForensicReportsStatusChart::class,
            ForensicReportsReviewStatusChart::class,
            ForensicReportsSentChart::class,
        ];
    }
}