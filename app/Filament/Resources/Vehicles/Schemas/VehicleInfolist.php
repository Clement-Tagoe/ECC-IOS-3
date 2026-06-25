<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;


class VehicleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Vehicle Identity')
                    ->icon('heroicon-o-truck')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')
                            ->label('Fleet Name')
                            ->weight(FontWeight::Bold),

                        TextEntry::make('registration_number')
                            ->label('Registration Number')
                            ->badge()
                            ->color('primary'),

                        TextEntry::make('year')
                            ->label('Year'),

                        TextEntry::make('vehicle_make')
                            ->label('Make'),

                        TextEntry::make('model')
                            ->label('Model'),

                        TextEntry::make('category')
                            ->label('Category')
                            ->badge()
                            ->color('info'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge(),

                        TextEntry::make('availability')
                            ->label('Availability')
                            ->badge(),
                    ]),

                Section::make('')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('assigned_driver')
                            ->label('Assigned Driver')
                            ->placeholder('Unassigned')
                            ->icon('heroicon-o-user'),

                        TextEntry::make('location')
                            ->label('Current Location')
                            ->placeholder('Unknown')
                            ->icon('heroicon-o-building-office'),

                        TextEntry::make('formatted_mileage')
                            ->label('Current Mileage')
                            ->icon('heroicon-o-chart-bar'),

                        TextEntry::make('last_service_date')
                            ->label('Last Service Date')
                            ->date('F j, Y')
                            ->icon('heroicon-o-calendar'),

                        TextEntry::make('next_service_date')
                            ->label('Next Service Date')
                            ->date('F j, Y')
                            ->icon('heroicon-o-calendar-days')
                            ->color(fn ($record) => match(true) {
                                $record->is_service_overdue       => 'danger',
                                $record->days_until_service <= 7  => 'warning',
                                $record->days_until_service <= 30 => 'primary',
                                default                           => 'success',
                            }),

                        TextEntry::make('service_status')
                            ->label('Service Status')
                            ->badge()
                            ->color(fn ($record) => match(true) {
                                $record->is_service_overdue       => 'danger',
                                $record->days_until_service <= 7  => 'warning',
                                $record->days_until_service <= 30 => 'primary',
                                default                           => 'success',
                            }),
                    ]),

                Section::make('Notes')
                    ->icon('heroicon-o-document-text')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('notes')
                            ->label('')
                            ->placeholder('No notes recorded.')
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