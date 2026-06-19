<?php

namespace App\Filament\Resources\EmergencyContacts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmergencyContactForm
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
                        TextInput::make('contacts')
                            ->required(),
                ])
            ]);
    }
}
