<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Details')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        TextInput::make('contact')
                            ->default(null),
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->same('passwordConfirmation')
                            ->hiddenOn('edit'),
                        TextInput::make('passwordConfirmation')
                            ->required()
                            ->password()
                            ->hiddenOn('edit'),
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->default(null),
                        Select::make('department_id')
                            ->relationship('department', 'name')
                            ->required(),
                ])
            ]);
    }
}
