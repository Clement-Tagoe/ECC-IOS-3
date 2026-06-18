<?php

namespace App\Filament\Resources\ValidCases\Schemas;

use App\Enums\ValidCaseStatus;
use App\Models\Location;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class ValidCaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('case_id')
                                    ->label('Case ID')
                                    ->required(),
                                TimePicker::make('reporting_time')
                                    ->required(),
                                DatePicker::make('reporting_date')
                                    ->required(),
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
                            ->columns(2),
                        Section::make()
                            ->schema([
                                Select::make('agency_id')
                                    ->relationship('agency', 'name')
                                    ->required(), 
                                TimePicker::make('dispatched_time'),
                                TimePicker::make('agency_arrival_time'),
                            ])
                            ->columns(2),
                        Section::make()
                            ->schema([
                                RichEditor::make('description')
                                    ->columnSpan('full'),    
                            ])
                            ->columns(2),
                        Section::make()
                            ->schema([
                                TextInput::make('contact_name')
                                    ->required(),
                                TextInput::make('contact_number')
                                    ->required(),
                                Select::make('valid_case_nature_id')
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('Case Nature')
                                            ->unique()
                                            ->required(),
                                    ])
                                    ->relationship('validCaseNature', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),   
                            ])
                            ->columns(2),

                        Section::make()
                            ->schema([
                                Textarea::make('feedback_comment')
                                    ->required()
                                    ->columnSpanFull(),   
                            ])
                            ->columns(2),               
                
            ])
            ->columnSpan(['lg' => 2]),

            Group::make()
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                ToggleButtons::make('status')
                                    ->options(ValidCaseStatus::class)
                                    ->inline()
                                    ->required()
                                    ->live()
                                    ->default(ValidCaseStatus::InReview),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
        ])->columns(3);
    }
}