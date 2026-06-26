<?php

namespace App\Filament\Resources\MonitoringStaff\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MonitoringStaffForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('monitoring_staff_group_id')
                    ->relationship('group', 'name')
            ]);
    }
}
