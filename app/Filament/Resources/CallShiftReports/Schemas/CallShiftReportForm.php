<?php

namespace App\Filament\Resources\CallShiftReports\Schemas;

use App\Enums\ShiftStatus;
use App\Enums\ShiftType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Repeater\TableColumn;


class CallShiftReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Shift Report Details')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        DatePicker::make('date')
                            ->required(),
                        TimePicker::make('start_time')
                            ->required(),
                        TimePicker::make('end_time')
                            ->required(),
                        ToggleButtons::make('shift_type')
                            ->options(ShiftType::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(ShiftType::Day)
                            ->columnSpan(2),
                        TextInput::make('expected_attendance')
                            ->required()
                            ->numeric(),
                        TextInput::make('present')
                            ->required()
                            ->numeric(),
                        TextInput::make('absent')
                            ->required()
                            ->numeric(),
                        TextInput::make('absent_with_permission')
                            ->required()
                            ->numeric(),
                        TextInput::make('occupied_consoles')
                            ->required()
                            ->numeric(),
                        TextInput::make('unoccupied_consoles')
                            ->required()
                            ->numeric(),
                        ToggleButtons::make('status')
                            ->options(ShiftStatus::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(ShiftStatus::InReview),
                        RichEditor::make('notes')
                            ->columnSpanFull(),
                ]),

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
