<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class FilesManagerPage extends Page
{
    protected string $view = 'filament.pages.files-manager-page';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedFolderOpen;
}
