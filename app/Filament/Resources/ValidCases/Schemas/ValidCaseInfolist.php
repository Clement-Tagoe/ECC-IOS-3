<?php

namespace App\Filament\Resources\ValidCases\Schemas;


use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ValidCaseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Valid Case Details')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('case_id')
                            ->label('Case ID'),
                        TextEntry::make('reporting_time')
                            ->time(),
                        TextEntry::make('reporting_date')
                            ->date(),
                        TextEntry::make('location.name')
                            ->label('Location'),
                        TextEntry::make('region.name')
                            ->label('Region'),
                        TextEntry::make('contact_name'),
                        TextEntry::make('contact_number'),
                        TextEntry::make('validCaseNature.name')
                            ->label('Case Nature'),
                        TextEntry::make('status')
                            ->badge(),
                    ]),

                Section::make('Responding Agency Details')
                    ->schema([
                        TextEntry::make('agency.name')
                            ->label('Responding Agency'),
                        TextEntry::make('dispatched_time'),
                        TextEntry::make('agency_arrival_time'),
                        TextEntry::make('agency_response_time'),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Description & Feedback')
                    ->schema([
                        TextEntry::make('description')
                            ->html(),
                        TextEntry::make('feedback_comment')
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

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