<?php

namespace App\Filament\Resources\Visitors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class VisitorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                            TextEntry::make('date'),
                            TextEntry::make('name'),
                            TextEntry::make('contact'),
                            TextEntry::make('nationality'),
                            TextEntry::make('department.name'),
                            TextEntry::make('purpose'),
                            TextEntry::make('sex'),
                            TextEntry::make('status'),
                            TextEntry::make('card_number'),
                            TextEntry::make('time_in')
                                ->time(),
                            TextEntry::make('time_out')
                                ->time(),
                            TextEntry::make('time_stayed'),
                            TextEntry::make('remarks')
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