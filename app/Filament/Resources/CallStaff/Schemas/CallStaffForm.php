<?php

namespace App\Filament\Resources\CallStaff\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CallStaffForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('call_staff_group_id')
                            ->relationship('group', 'name')
            ]);
    }
}
