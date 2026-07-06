<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum ForensicReportReviewStatus: string implements HasColor, HasIcon, HasLabel
{
    case InReview = 'in_review';

    case Reviewed = 'reviewed';

    public function getLabel(): string
    {
        return match ($this) {
            self::InReview => 'In Review',
            self::Reviewed => 'Reviewed',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::InReview => 'primary',
            self::Reviewed => 'success',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::InReview => Heroicon::Eye,
            self::Reviewed => Heroicon::CheckCircle,
        };
    }
}