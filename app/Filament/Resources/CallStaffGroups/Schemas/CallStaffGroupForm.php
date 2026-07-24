<?php

namespace App\Filament\Resources\CallStaffGroups\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CallStaffGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([ 
                        TextInput::make('name')
                            ->required(),
                    ])
            ]);
    }
}
