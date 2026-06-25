<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use App\Enums\VehicleAvailability;
use App\Enums\VehicleCategory;
use App\Enums\VehicleStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Suspect Details')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('registration_number')
                            ->required(),
                        TextInput::make('vehicle_make')
                            ->required(),
                        TextInput::make('model')
                            ->required(),
                        TextInput::make('year')
                            ->required(),
                        Radio::make('category')
                            ->options(VehicleCategory::class)
                            ->inline()
                            ->required()
                            ->default(VehicleCategory::PickupTruck)
                            ->columnSpanFull(),
                        ToggleButtons::make('status')
                            ->options(VehicleStatus::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(VehicleStatus::Active)
                            ->columnSpanFull(),
                        ToggleButtons::make('availability')
                            ->options(VehicleAvailability::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(VehicleAvailability::Available)
                            ->columnSpanFull(),
                        TextInput::make('assigned_driver')
                            ->default(null),
                        TextInput::make('location')
                            ->default(null),
                        DatePicker::make('last_service_date'),
                        TextInput::make('mileage')
                            ->label('Mileage (km)')
                            ->numeric()
                            ->minValue(0)
                            ->suffix('km')
                            ->placeholder('e.g. 12500'),

                        DatePicker::make('next_service_date')
                            ->label('Next Service Date')
                            ->minDate(now())
                            ->displayFormat('M d, Y'),
                        Textarea::make('notes')
                            ->default(null)
                            ->columnSpanFull(),
                ])
            ]);
    }
}
