<?php

namespace App\Filament\Resources\LogisticsManagement\Schemas;

use App\Enums\LogisticsUnit;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class LogisticsManagementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 Section::make('Procurement Details')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('item')
                            ->required(),
                        TextInput::make('quantity')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->required(),
                        Select::make('unit')
                            ->options(LogisticsUnit::class)
                            ->searchable()
                            ->required()
                            ->placeholder('Select unit'),
                        DatePicker::make('date')
                            ->required(),
                    ]),

                Section::make('Logistics Distribution')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('logisticsDistribution')
                            ->hiddenLabel()
                            ->relationship()
                            ->defaultItems(1)
                            ->table([
                                TableColumn::make('Department'),
                                TableColumn::make('Quantity')
                                    ->width(250),
                                TableColumn::make('Date')
                                    ->width(250),
                            ])
                            ->schema([
                                TextInput::make('department'),
                                TextInput::make('quantity'),
                                DatePicker::make('date'),
                            ])
                            ->columnSpanFull(),
                    ]),

            ]);
    }
}
