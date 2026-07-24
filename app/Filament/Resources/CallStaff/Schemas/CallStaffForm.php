<?php

namespace App\Filament\Resources\CallStaff\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CallStaffForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        Select::make('call_staff_group_id')
                            ->relationship('group', 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->unique()
                                    ->required(),
                            ])
                            ->required()
                            ->live()
                            ->searchable()
                            ->preload(),
                ])
                
            ]);
    }
}
