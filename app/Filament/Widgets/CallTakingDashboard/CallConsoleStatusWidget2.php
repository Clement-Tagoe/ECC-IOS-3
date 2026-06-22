<?php

namespace App\Filament\Widgets\CallTakingDashboard;

use App\Models\CallConsole;
use Filament\Widgets\Widget;

class CallConsoleStatusWidget2 extends Widget
{
    protected string $view = 'filament.widgets.call-console-status-widget2';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan =  6;

    protected function getViewData(): array
    {
        $consoles = CallConsole::with('assignee')->get();

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
