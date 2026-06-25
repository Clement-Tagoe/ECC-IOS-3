<?php

namespace App\Filament\Resources\ContactLists\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactListForm
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
                        TextInput::make('contact')
                            ->required(),
                        TextInput::make('agency'),
                        TextInput::make('location'),
                        TextInput::make('district'),
                        TextInput::make('region'),
                    ])
            ]);
    }
}
