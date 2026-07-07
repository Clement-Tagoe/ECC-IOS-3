<?php

namespace App\Filament\Resources\ContactLists\Schemas;

use App\Models\Location;
use Filament\Forms\Components\Select;
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
                        Select::make('agency_id')
                                    ->relationship('agency', 'name'), 
                        Select::make('location_id')
                                    ->relationship('location', 'name')
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->unique(ignoreRecord: true)
                                            ->required(),
                                        Select::make('region_id')
                                            ->relationship('region', 'name')
                                            ->required(),
                                    ])
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->required()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        // Auto-fill region_id based on selected location
                                        $location = Location::find($state);
                                        $set('region_id', $location?->region_id ?? null);
                                    }),
                                Select::make('region_id')
                                    ->relationship('region', 'name')
                                    ->required()
                                    ->disabled()
                                    ->saved(),
                    ])
            ]);
    }
}
