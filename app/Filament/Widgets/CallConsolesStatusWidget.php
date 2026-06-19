<?php

namespace App\Filament\Widgets;

use App\Models\CallConsole;
use Filament\Widgets\Widget;

class CallConsolesStatusWidget extends Widget
{
    protected string $view = 'filament.widgets.call-consoles-status-widget';

    protected static ?int $sort = 1;

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
