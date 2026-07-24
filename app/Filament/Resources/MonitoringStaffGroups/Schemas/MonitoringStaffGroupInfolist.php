<?php

namespace App\Filament\Resources\MonitoringStaffGroups\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MonitoringStaffGroupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([ 
                        TextEntry::make('name'),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
                
                    
                Section::make()
                    ->schema([
                        Group::make([
                                TextEntry::make('creator.name')
                                    ->label('Created by'), 
                                TextEntry::make('editor.name')
                                    ->label('Edited by'),
                                TextEntry::make('destroyer.name') 
                                    ->label('Deleted by')
                                ])->columns(3),
                            Group::make([
                                TextEntry::make('created_at')
                                    ->dateTime(),
                                TextEntry::make('updated_at')
                                    ->dateTime(),
                                TextEntry::make('deleted_at')
                                    ->dateTime(),
                                ])->columns(3),
                            ])->columnSpanFull(),
            ]);
    }
}
