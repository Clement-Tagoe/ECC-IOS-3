<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Kirschbaum\Commentions\Filament\Infolists\Components\CommentsEntry;

class TaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Task Details')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('title')
                            ->label('Task Title')
                            ->weight(FontWeight::Bold),
                        
                        TextEntry::make('due_date'),

                        TextEntry::make('status')
                            ->badge(),

                        TextEntry::make('priority')
                            ->badge(),

                        TextEntry::make('completed_at')
                            ->visible(fn (Get $get): bool => in_array($get('status'), [
                                TaskStatus::Completed,
                                TaskStatus::Completed->value,
                            ])),
                            
                        TextEntry::make('collaborators.name')
                            ->label('Collaborators')
                            ->listWithLineBreaks()
                            ->placeholder('No collaborators'),


                        TextEntry::make('description')
                            ->html()
                            ->columnSpanFull(),
                    ]),
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        CommentsEntry::make('comments')
                            ->mentionables(fn (Task $record) => $record->collaborators)
                            ->perPage(8),
                    ]),
                ]);
    }
}