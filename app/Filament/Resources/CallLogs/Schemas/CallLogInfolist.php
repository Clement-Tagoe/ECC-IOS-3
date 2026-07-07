<?php

namespace App\Filament\Resources\CallLogs\Schemas;


use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CallLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Calls')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Group::make([
                                    TextEntry::make('incoming_calls')
                                        ->numeric(),
                                    TextEntry::make('total_calls_received')
                                        ->numeric(),
                                    TextEntry::make('valid_calls')
                                        ->numeric(), 
                                ]),
                                Group::make([
                                    TextEntry::make('prank_calls')
                                        ->numeric(),
                                    TextEntry::make('unanswered_calls')
                                        ->numeric(),
                                    TextEntry::make('status')
                                        ->badge(),

                                ]),
                            ]),
                        ]),
                Section::make('Duty Details & Duration')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Group::make([
                                    TextEntry::make('shift')
                                        ->badge(),
                                    TextEntry::make('date'),
                                    TextEntry::make('start_time'),
                                    TextEntry::make('end_time'),
                                    TextEntry::make('creator.name')
                                        ->label('Created by'), 
                                    TextEntry::make('editor.name')
                                        ->label('Edited by'), 
                                    ])->columns(3)->columnSpan(2),
                                Group::make([
                                    TextEntry::make('created_at')
                                        ->dateTime(),
                                    TextEntry::make('updated_at')
                                        ->dateTime(), 
                                    ])->columns(3)->columnSpan(2),
                                ]),
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