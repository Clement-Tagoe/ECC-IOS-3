<?php

namespace App\Filament\Resources\CameraAudits\Schemas;


use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CameraAuditInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Camera Audit Details')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                            TextEntry::make('camera_name'),
                            TextEntry::make('region.name')
                                ->label('Region'),
                            TextEntry::make('cameraLocation.name')
                                ->label('Location'),
                            TextEntry::make('status')
                                ->badge(),
                            TextEntry::make('observations.name')
                                ->label('Observation(s)'), 
                            TextEntry::make('notes')
                                ->html()
                                ->columnSpanFull(),
                            ]),
                Section::make('')
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