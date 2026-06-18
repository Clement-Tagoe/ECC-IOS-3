<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum ShiftType: string implements HasColor, HasIcon, HasLabel
{
    case Morning = 'morning';

    case Afternoon = 'afternoon';

    case Night = 'night';

    public function getLabel(): string
    {
        return match ($this) {
            self::Morning => 'Morning',
            self::Afternoon => 'Afternoon',
            self::Night => 'Night',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Morning => 'info',
            self::Afternoon => 'warning',
            self::Night => 'gray',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::Morning => Heroicon::Cloud,
            self::Afternoon => Heroicon::Sun,
            self::Night => Heroicon::Moon,
        };
    }
}