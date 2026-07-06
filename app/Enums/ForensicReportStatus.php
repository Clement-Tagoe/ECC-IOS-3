<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum ForensicReportStatus: string implements HasColor, HasIcon, HasLabel
{
    case Open = 'open';

    case OnHold = 'on_hold';

    case Closed = 'closed';

    public function getLabel(): string
    {
        return match ($this) {
            self::Open => 'Open',
            self::OnHold => 'On Hold',
            self::Closed => 'Closed',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Open => 'primary',
            self::OnHold => 'warning',
            self::Closed => 'success',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::Open => Heroicon::FolderOpen,
            self::OnHold => Heroicon::PauseCircle,
            self::Closed => Heroicon::CheckCircle,
        };
    }
}