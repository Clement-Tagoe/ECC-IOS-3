<?php

namespace App\Filament\Resources\CameraAudits\Pages;

use App\Filament\Resources\CameraAudits\CameraAuditResource;
use App\Models\CameraAudit;
use App\Models\Region;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListCameraAudits extends ListRecords
{
    protected static string $resource = CameraAuditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New camera'),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('All')
                ->badge(CameraAudit::count()),
        ];

        foreach (Region::orderBy('name')->get() as $region) {
            $tabs[$region->id] = Tab::make($region->name)
                ->modifyQueryUsing(fn ($query) => $query->where('region_id', $region->id))
                ->badge(CameraAudit::where('region_id', $region->id)->count());
        }

        return $tabs;
    }
}
