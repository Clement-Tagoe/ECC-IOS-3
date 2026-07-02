<?php

namespace App\Filament\Resources\CallShiftReports\Schemas;


use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;


class CallShiftReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Shift Details')
                    ->columns(3)
                    ->schema([
                            TextEntry::make('date'),
                            TextEntry::make('start_time'),
                            TextEntry::make('end_time'),
                            TextEntry::make('shift_type'),
                            TextEntry::make('status')
                                ->badge(),
                            TextEntry::make('notes')
                                ->html()
                                ->columnSpanFull()
                            ]),
                Section::make('')
                    ->schema([
                            Group::make([
                                TextEntry::make('creator.name')
                                    ->label('Created by'), 
                                TextEntry::make('editor.name')
                                    ->label('Edited by'),
                                TextEntry::make('destroyer.name') 
                                    ->label('Deleted by')
                                ])->columns(3)->columnSpan(2),
                            Group::make([
                                TextEntry::make('created_at')
                                    ->dateTime(),
                                TextEntry::make('updated_at')
                                    ->dateTime(),
                                TextEntry::make('deleted_at')
                                    ->dateTime(),
                                ])->columns(3)->columnSpan(2),
                            ]),

                Section::make('Agents on Duty')
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('agentActivity')
                            ->hiddenLabel()
                            ->table([
                                TableColumn::make('Name'),
                                TableColumn::make('Call Taker ID')
                                    ->width(100),
                                TableColumn::make('Attendance')
                                    ->width(120),
                                TableColumn::make('Console ID')
                                    ->width(120),
                                TableColumn::make('Incoming')
                                    ->width(120),
                                TableColumn::make('Received')
                                    ->width(120),
                                TableColumn::make('Unanswered')
                                    ->width(120),
                            ])
                            ->schema([
                                TextEntry::make('callStaff.name'),
                                TextEntry::make('call_taker_id'),
                                TextEntry::make('attendance'),
                                TextEntry::make('console_id'),
                                TextEntry::make('incoming'),
                                TextEntry::make('received'),
                                TextEntry::make('unanswered'),
                            ])
                            ->columnSpanFull(),
                    ]),
                ]);
                
    }
}