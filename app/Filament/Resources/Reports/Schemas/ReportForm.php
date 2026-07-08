<?php

namespace App\Filament\Resources\Reports\Schemas;

use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Report Details')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        DatePicker::make('date')
                            ->required(),
                        Select::make('report_type_id')
                            ->label('type')
                            ->relationship('reportType', 'name'),
                        Select::make('shift')
                            ->options([
                                'Day' => 'Day',
                                'Night' => 'Night',
                            ])
                            ->required(),
                        ToggleButtons::make('status')
                            ->options(ReportStatus::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(ReportStatus::InReview),
                        Select::make('department_id')
                            ->relationship('department', 'name'),
                        Radio::make('priority')
                            ->options(ReportPriority::class)
                            ->inline()
                            ->required()
                            ->default(ReportPriority::Medium),
                        RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('collaborators')
                            ->relationship('collaborators', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('receivers')
                            ->label('Send To (Receivers)')
                            ->relationship(
                                name: 'receivers', 
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('users.id', '!=',Auth::id()))   // assuming User has 'name' column
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('images')
                            ->collection('report-images')
                            ->multiple()
                            ->image()
                            ->preserveFilenames()
                            ->maxFiles(4)
                            ->nullable(),
                        SpatieMediaLibraryFileUpload::make('files/videos')
                            ->collection('report-files')
                            ->multiple()
                            ->preserveFilenames()
                            ->nullable(),
                    ])
                
            ]);
    }
}
