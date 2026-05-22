<?php

namespace App\Enums\FileManager;

enum SortDirection: string
{
    case Asc = 'asc';
    case Desc = 'desc';

    public function toggle(): self
    {
        return match ($this) {
            self::Asc => self::Desc,
            self::Desc => self::Asc,
        };
    }
}