<?php

namespace App\Filament\Resources\Procurements\Schemas;

use App\Enums\ProcurementPriority;
use App\Enums\ProcurementUnit;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProcurementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                    Section::make('Procurement Details')
                        ->columns(2)
                        ->columnSpanFull()
                        ->schema([
                            DatePicker::make('date')
                                ->required(),
                            TextInput::make('item')
                                ->required(),
                            TextInput::make('quantity')
                                ->numeric()
                                ->integer()
                                ->minValue(1)
                                ->required(),
                            Select::make('unit')
                                ->options(ProcurementUnit::class)
                                ->searchable()
                                ->required()
                                ->placeholder('Select unit'),
                            Select::make('priority')
                                ->options(ProcurementPriority::class)
                                ->default('medium')
                                ->required(),
                            Textarea::make('purpose')
                                ->required()
                                ->columnSpanFull(),
                            Textarea::make('feedback')
                                ->required()
                                ->columnSpanFull(),
                            SpatieMediaLibraryFileUpload::make('images')
                                ->collection('procurement-images')
                                ->multiple()
                                ->image()
                                ->preserveFilenames()
                                ->maxFiles(4)
                                ->nullable(),    
                    ]),  
        ]);
    }
}
