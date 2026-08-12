<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Task Details')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),

                        Select::make('assigned_to')
                            ->label('Assign to (Collaborators)')
                            ->relationship(
                                name: 'collaborators', 
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) =>  $query->whereNot('users.id', Auth::id())
                                ) 
                            ->multiple()
                            ->searchable()
                            ->preload(),

                        ToggleButtons::make('status')
                            ->options(TaskStatus::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(TaskStatus::InProgress)
                            ->columnSpanFull(),

                        Radio::make('priority')
                            ->options(TaskPriority::class)
                            ->inline()
                            ->required()
                            ->default(TaskPriority::Medium),

                        DatePicker::make('due_date')
                            ->required(),

                        RichEditor::make('description')
                            ->columnSpanFull(),

                        DateTimePicker::make('completed_at')
                            ->visible(fn (Get $get): bool => in_array($get('status'), [
                                TaskStatus::Completed,
                                TaskStatus::Completed->value,
                            ])),
                        SpatieMediaLibraryFileUpload::make('images')
                            ->collection('task-images')
                            ->multiple()
                            ->image()
                            ->preserveFilenames()
                            ->maxFiles(4)
                            ->nullable(),
                        SpatieMediaLibraryFileUpload::make('files/videos')
                            ->collection('task-files')
                            ->multiple()
                            ->preserveFilenames()
                            ->nullable(),
                    ]),
            ]);
    }
}