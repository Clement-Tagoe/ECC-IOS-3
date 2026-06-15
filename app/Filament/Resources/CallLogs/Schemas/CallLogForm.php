<?php

namespace App\Filament\Resources\CallLogs\Schemas;

use App\Enums\CallLogStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CallLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Calls')
                    ->description('Breakdown of all calls')
                    ->schema([
                        TextInput::make('incoming_calls')
                            ->required()
                            ->numeric(),
                        TextInput::make('total_calls_received')
                            ->required()
                            ->numeric(),
                        TextInput::make('valid_calls')
                            ->required()
                            ->numeric(),
                        TextInput::make('prank_calls')
                            ->required()
                            ->numeric(),
                        TextInput::make('unanswered_calls')
                            ->required()
                            ->numeric(),
                        ToggleButtons::make('status')
                            ->options(CallLogStatus::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(CallLogStatus::InReview),
                    ])->columns(2)->columnSpan(1),

                Section::make('Duty Details & Duration')
                    ->description('Details of User, time & date of shift')
                    ->schema([
                        Select::make('shift')
                            ->options([
                                'Day' => 'Day',
                                'Night' => 'Night',
                            ])->required(),
                        DatePicker::make('date')
                            ->required(),
                        TimePicker::make('start_time')
                            ->required(),
                        TimePicker::make('end_time')
                            ->required(),
                        ])->columns(2)->columnSpan(1),
                    
                
            ]);
    }
}
