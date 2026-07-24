<?php

namespace App\Filament\Resources\MonitoringConsoles\Schemas;

use App\Enums\ConsoleStatus;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MonitoringConsoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Console Details')
                    ->columns(2)
                    ->columnSpanFull()
                     ->schema([
                        TextInput::make('console_name')
                            ->unique()
                            ->required(),
                        ToggleButtons::make('status')
                            ->options(ConsoleStatus::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(ConsoleStatus::Operational),
                        RichEditor::make('notes')
                            ->helperText('Based on status of console')
                            ->columnSpanFull()
                            ->nullable(),
                        Select::make('monitoring_staff_id')
                            ->relationship('assignee', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->nullable()
                            ->placeholder('Unassigned')
                            ->helperText('A console cannot be assigned to a staff member if it is faulty or under maintenance'),
                     ])
            ]);
    }
}
