<?php

namespace App\Filament\Resources\CallLogs\Schemas;

use App\Enums\CallLogStatus;
use App\Enums\ShiftType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
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
                        ToggleButtons::make('Shift')
                            ->options(ShiftType::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(ShiftType::Morning),
                        DatePicker::make('date')
                            ->required(),
                        TimePicker::make('start_time')
                            ->required(),
                        TimePicker::make('end_time')
                            ->required(),
                        ])->columns(2)->columnSpan(1),
                    
                 Section::make('Agents on Duty')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('agentActivity')
                            ->hiddenLabel()
                            ->relationship()
                            ->defaultItems(1)
                            ->table([
                                TableColumn::make('Name'),
                                TableColumn::make('Call Taker ID')
                                    ->width(130),
                                TableColumn::make('Attendance')
                                    ->width(130),
                                TableColumn::make('Console ID')
                                    ->width(130),
                                TableColumn::make('Incoming')
                                    ->width(130),
                                TableColumn::make('Received')
                                    ->width(130),
                                TableColumn::make('Unanswered')
                                    ->width(130),
                            ])
                            ->schema([
                                Select::make('call_staff_id')
                                    ->relationship('callStaff', 'name')
                                    ->required(),
                                TextInput::make('call_taker_id'),
                                TextInput::make('attendance'),
                                TextInput::make('console_id'),
                                TextInput::make('incoming'),
                                TextInput::make('received'),
                                TextInput::make('unanswered'),
                            ])
                            ->columnSpanFull(),
                ]),
            ]);
    }
}
