<?php

namespace App\Filament\Widgets;

use App\Models\MonitoringConsole;
use Filament\Widgets\Widget;

class MonitoringConsolesStatusWidget extends Widget
{
    protected string $view = 'filament.widgets.monitoring-consoles-status-widget';

    protected static ?int $sort = 1;

    // Match ChartWidget's default column span
    protected int | string | array $columnSpan = 1;

    protected function getViewData(): array
    {
        $consoles = MonitoringConsole::with('assignee')->get();

        return [
            'consoles'     => $consoles,
            'total'        => $consoles->count(),
            'assigned'     => $consoles->filter(fn ($c) => $c->monitoring_staff_id !== null)->count(),
            'unassigned'   => $consoles->filter(fn ($c) => $c->monitoring_staff_id === null)->count(),
            'maintenance'  => $consoles->filter(fn ($c) => $c->status->value === 'maintenance')->count(),
            'faulty'       => $consoles->filter(fn ($c) => $c->status->value === 'faulty')->count(),
        ];
    }
}
