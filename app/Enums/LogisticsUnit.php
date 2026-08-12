<?php

// app/Enums/LogisticsUnit.php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum LogisticsUnit: string implements HasLabel
{
    // Count
    case Pieces    = 'pcs';
    case Units     = 'units';
    case Sets      = 'sets';
    case Pairs     = 'pairs';
    case Bottles   = 'bottles';
    case Gallons   = 'gallons';

    // Weight
    case Kilograms = 'kg';
    case Grams     = 'g';
    case Tonnes    = 'tonnes';

    // Volume
    case Litres    = 'L';
    case Millilitres = 'mL';

    // Length
    case Metres    = 'm';
    case Centimetres = 'cm';

    // Packaging
    case Boxes     = 'boxes';
    case Cartons   = 'cartons';
    case Packs     = 'packs';
    case Rolls     = 'rolls';
    case Bags      = 'bags';
    case Pallets   = 'pallets';
    case Reams     = 'reams';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pieces      => 'Pieces (pcs)',
            self::Units       => 'Units',
            self::Sets        => 'Sets',
            self::Pairs       => 'Pairs',
            self::Bottles     => 'Bottles',
            self::Gallons     => 'Gallons',
            self::Reams       => 'Reams',
            self::Kilograms   => 'Kilograms (kg)',
            self::Grams       => 'Grams (g)',
            self::Tonnes      => 'Tonnes',
            self::Litres      => 'Litres (L)',
            self::Millilitres => 'Millilitres (mL)',
            self::Metres      => 'Metres (m)',
            self::Centimetres => 'Centimetres (cm)',
            self::Boxes       => 'Boxes',
            self::Cartons     => 'Cartons',
            self::Packs       => 'Packs',
            self::Rolls       => 'Rolls',
            self::Bags        => 'Bags',
            self::Pallets     => 'Pallets',
        };
    }
}