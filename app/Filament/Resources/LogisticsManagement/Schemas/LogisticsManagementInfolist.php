<?php

namespace App\Filament\Resources\LogisticsManagement\Schemas;


use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;


class LogisticsManagementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Item Details')
                    ->icon('heroicon-o-archive-box')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('item')
                            ->label('Item Name')
                            ->weight(\Filament\Support\Enums\FontWeight::Bold),

                        TextEntry::make('date')
                            ->label('Date Stocked')
                            ->date('F j, Y'),

                        TextEntry::make('unit')
                            ->label('Unit')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state?->getLabel()),
                    ]),
                Section::make('Stock Summary')
                    ->icon('heroicon-o-chart-bar')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('quantity_with_unit')
                            ->label('Total Stocked')
                            ->weight(\Filament\Support\Enums\FontWeight::Bold)
                            ->color('info'),

                        TextEntry::make('remaining_stock_with_unit')
                            ->label('Remaining Stock')
                            ->weight(\Filament\Support\Enums\FontWeight::Bold)
                            ->color(fn ($record) => match(true) {
                                $record->stock_percentage <= 20 => 'danger',
                                $record->stock_percentage <= 50 => 'warning',
                                default                         => 'success',
                            }),

                        TextEntry::make('stock_percentage')
                            ->label('Stock Level')
                            ->suffix('%')
                            ->badge()
                            ->color(fn ($state) => match(true) {
                                $state <= 20 => 'danger',
                                $state <= 50 => 'warning',
                                default      => 'success',
                            }),
                    ]),

                Section::make('Logistics Distribution')
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('logisticsDistribution')
                            ->hiddenLabel()
                            ->table([
                                TableColumn::make('Department'),
                                TableColumn::make('Quantity')
                                    ->width(250),
                                TableColumn::make('Date')
                                    ->width(250),
                            ])
                            ->schema([
                               TextEntry::make('department')
                                    ->label('Department')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('quantity')
                                    ->label('Quantity Distributed')
                                    ->suffix(fn ($record) => ' ' . ($record->logisticsManagement?->unit?->value ?? '')),

                                TextEntry::make('date')
                                    ->label('Date')
                                    ->date('F j, Y'),
                            ])
                            ->columnSpanFull(),
                ]),
                Section::make()
                        ->columnSpanFull()
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
            ]);
    }
}