<?php

namespace App\Filament\Widgets\MainDashboard;

use Filament\Widgets\Widget;

class ChartStackWrapper extends Widget
{
    protected string $view = 'filament.widgets.chart-stack-wrapper';

    protected int | string | array $columnSpan =  4;

}
