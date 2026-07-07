<?php

namespace App\Filament\Resources\Agencies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AgencyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Agency Details')
                    ->columns(2)
                    ->columnSpanFull()
                     ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('contact')
                            ->required(),
                        TextInput::make('email'),
                        TextInput::make('location')
                            ->required(),
                        TextInput::make('website'),
                ])
            ]);
    }
}
