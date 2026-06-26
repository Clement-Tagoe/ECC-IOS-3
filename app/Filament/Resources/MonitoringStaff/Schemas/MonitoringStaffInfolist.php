<?php

namespace App\Filament\Resources\MonitoringStaff\Schemas;


use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MonitoringStaffInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Call Staff')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Group::make([
                                    TextEntry::make('name'),
                                    TextEntry::make('group.name')
                                        ->label('Group'),
                                    TextEntry::make('creator.name')
                                        ->label('Created by'), 
                                ]),
                                Group::make([
                                    TextEntry::make('editor.name')
                                        ->label('Edited by'), 
                                    TextEntry::make('created_at')
                                        ->dateTime(),
                                    TextEntry::make('updated_at')
                                        ->dateTime(), 

                                ]),
                            ]),
                        ]),
                    ]);
    }
}