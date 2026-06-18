<?php

namespace App\Filament\Resources\MonitoringShiftReports\Schemas;

use App\Enums\ShiftStatus;
use App\Enums\ShiftType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class MonitoringShiftReportForm
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
                        ToggleButtons::make('shift_type')
                            ->options(ShiftType::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(ShiftType::Morning)
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
                ]) 
            ]);
    }
}
