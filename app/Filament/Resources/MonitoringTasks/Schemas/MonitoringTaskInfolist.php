<?php

namespace App\Filament\Resources\MonitoringTasks\Schemas;

use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class MonitoringTaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Monitoring Task Details')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([ 
                        TextEntry::make('date'),

                        TextEntry::make('time'),

                        TextEntry::make('shift')
                            ->badge(),

                        TextEntry::make('status')
                            ->badge(),
                        
                        TextEntry::make('topics.name')
                            ->label('Topics/Areas of Interest'),

                        TextEntry::make('location.name')
                            ->label('Location'),

                        TextEntry::make('region.name')
                            ->label('Region'),

                        TextEntry::make('cameras.camera_name')
                            ->label('Camera Names'),

                        TextEntry::make('observation')
                            ->html()
                            ->columnSpanFull(),
                    ]),


                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('recommendation')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('images')
                                ->collection('monitoring-images')
                                ->imageGallery(),
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