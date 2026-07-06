<?php

namespace App\Filament\Resources\ForensicCases\Schemas;

use App\Enums\ForensicCaseReviewStatus;
use App\Enums\ForensicCaseStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ForensicCaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Forensic Case Details')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('case_title')
                            ->required(),
                        TextInput::make('reference_id')
                            ->label('Reference ID')
                            ->required(),
                        TextInput::make('location')
                            ->required(),
                        ToggleButtons::make('status')
                            ->options(ForensicCaseStatus::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(ForensicCaseStatus::Open),
                        ToggleButtons::make('review_status')
                            ->options(ForensicCaseReviewStatus::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(ForensicCaseReviewStatus::InReview),
                        Textarea::make('description')
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
                        SpatieMediaLibraryFileUpload::make('evidence_files')
                                ->collection('forensic-evidence-files')
                                ->multiple()
                                ->preserveFilenames()
                                ->maxFiles(4)
                                ->nullable(),
                        SpatieMediaLibraryFileUpload::make('chain_of_custody_files')
                                ->collection('forensic-chain-of-custody-files')
                                ->multiple()
                                ->preserveFilenames()
                                ->maxFiles(4)
                                ->nullable(),
                        SpatieMediaLibraryFileUpload::make('images')
                                ->collection('forensic-images')
                                ->multiple()
                                ->image()
                                ->preserveFilenames()
                                ->maxFiles(4)
                                ->nullable(),
                    ]),
            ]);
    }
}
