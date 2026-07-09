<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskStatus;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Str;
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
                
                // Attachments Section
                Section::make('Attachments')
                    ->columnSpanFull()
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('images')
                                ->collection('task-images')
                                ->imageGallery(),
                        
                        RepeatableEntry::make('media')
                                ->columns(3)
                                ->label('Files/Videos')
                                ->schema([
                                    TextEntry::make('name')
                                        ->label('File Name')
                                        ->suffixAction(
                                            Action::make('download')
                                                ->icon('heroicon-m-arrow-down-tray')
                                                ->button()
                                                ->action(function ($record) {
                                                    // $record here is an instance of Spatie\MediaLibrary\MediaCollections\Models\Media
                                                    return response()->download($record->getPath(), $record->file_name);
                                                })
                                        ),
                                    
                                    ImageEntry::make('mime_type')
                                        ->label('File Icon')
                                        ->getStateUsing(function ($record) {
                                            // Determine icon based on mime type
                                            $mime = $record->mime_type;
                                            
                                            $icon = match (true) {
                                                Str::contains($mime, ['application/pdf', 'application/x-pdf', 'application/acrobat', 'application/vnd.pdf','text/pdf','text/x-pdf']) => 'pdf.png',
                                                Str::contains($mime, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-word.document.macroEnabled.12', 'application/vnd.ms-word.template.macroEnabled.12']) => 'word.png',
                                                Str::contains($mime, ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.ms-excel.template.macroEnabled.12']) => 'excel.png',
                                                Str::contains($mime, ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-powerpoint.presentation.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow', 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.template', 'application/vnd.ms-powerpoint.template.macroEnabled.12',]) => 'powerpoint.png',
                                                Str::contains($mime, 'video/') => 'video.png',
                                                Str::contains($mime, ['audio/mpeg', 'audio/ogg', 'audio/wav', 'audio/x-m4a', 'audio/webm', 'audio/']) => 'audio.png',
                                                Str::contains($mime, ['application/zip','zip']) => 'zip.png',
                                                Str::contains($mime, 'text/') => 'txt-file.png',
                                                default => 'attach-file.png', // Default icon
                                            };
                
                                                // Return path to the icon in public/images/file-icons/
                                                return asset('images/file-icons/' . $icon);
                                            })
                                            ->disk('public') // Assuming images are in public disk
                                            ->imageSize(20),

                                    TextEntry::make('mime_type')
                                        ->label('File Type')
                                        ->getStateUsing(function ($record) {
                                                // Determine icon based on mime type
                                                $mime = $record->mime_type;

                                                return match (true) {
                                                    Str::contains($mime, ['application/pdf','application/x-pdf', 'application/acrobat','application/vnd.pdf','text/pdf','text/x-pdf']) => 'PDF Document',
                                                    Str::contains($mime, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-word.document.macroEnabled.12', 'application/vnd.ms-word.template.macroEnabled.12']) => 'Microsoft Word',
                                                    Str::contains($mime, ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.ms-excel.template.macroEnabled.12']) => 'Microsoft Excel',
                                                    Str::contains($mime, ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-powerpoint.presentation.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow', 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.template', 'application/vnd.ms-powerpoint.template.macroEnabled.12']) => 'Microsoft PowerPoint',
                                                    Str::contains($mime, ['video/']) => 'Video',
                                                    Str::contains($mime, ['audio/']) => 'Audio',
                                                    Str::contains($mime, ['zip']) => 'Zip',
                                                    Str::contains($mime, ['text/']) => 'Txt-File',
                                                    default => 'Attachment',
                                                };
                                            }),
                                        
                                ])
                                // 4. Filter for specific collection
                                ->getStateUsing(function ($record) {
                                    return $record->media->where('collection_name', 'task-files');
                                }),
                ]),
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        CommentsEntry::make('comments')
                            ->mentionables(function (Task $record) {
                                return $record->collaborators
                                    ->push($record->user)
                                    ->filter()
                                    ->unique('id');
                            })
                            ->perPage(8),
                    ]),
                ]);
    }
}