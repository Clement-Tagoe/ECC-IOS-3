<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Livewire\Attributes\Url;

class FilesManager extends Page
{
    protected string $view = 'filament.pages.files-manager';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::FolderOpen;

    #[Url]
    public string $viewMode = 'grid';

    #[Url]
    public string $sortField = 'name';

    #[Url]
    public string $sortDirection = 'asc';
}
