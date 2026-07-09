<?php

namespace App\Filament\Resources\Tasks\RelationManagers;

use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use App\Filament\Resources\Reports\ReportResource;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;


class ReportsRelationManager extends RelationManager
{
    protected static string $relationship = 'reports';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                 TextInput::make('title')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                Select::make('report_type_id')
                            ->label('Type')
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
                    ->relationship('receivers', 'name')   // assuming User has 'name' column
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Sent By')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium)
                    ->limit(40),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('priority')
                    ->badge(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('receivers.name')
                    ->label('Sent To')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('attachments_count')
                    ->label('Attachments')
                    ->getStateUsing(fn ($record) => $record->media->count())
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'info' : 'success')
                    ->sortable(false)   // counting is not easily sortable without extra work
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(function (array $data): array {
                        $data['user_id'] = Auth::id();

                        return $data;
                    }),
                AssociateAction::make()
                    ->preloadRecordSelect() // Enables search/loading
                    ->recordSelectOptionsQuery(function (Builder $query) {
                            return $query
                                // 1. Filter by ownership or collaboration
                                ->where(function (Builder $innerQuery) {
                                    $innerQuery->where('user_id', Auth::id())
                                        ->orWhereHas('collaborators', fn ($q) => $q->where('users.id', Auth::id()));
                                })
                                // 2. Exclude reports already linked to this specific task
                                ->whereDoesntHave('task', function (Builder $innerQuery) {
                                    $innerQuery->where('tasks.id', $this->getOwnerRecord()->id);
                                });
                        }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn ($record): string => ReportResource::getUrl('view', ['record' => $record])),
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
