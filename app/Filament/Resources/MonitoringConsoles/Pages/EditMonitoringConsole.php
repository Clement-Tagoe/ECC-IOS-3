<?php

namespace App\Filament\Resources\MonitoringConsoles\Pages;

use App\Enums\ConsoleStatus;
use App\Filament\Resources\MonitoringConsoles\MonitoringConsoleResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMonitoringConsole extends EditRecord
{
    protected static string $resource = MonitoringConsoleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function beforeSave(): void
    {
        $status = $this->data['status'] ?? null;
        $monitoringStaffId = $this->data['monitoring_staff_id'] ?? null;

        $isBlockedStatus = in_array(
            $status instanceof ConsoleStatus ? $status->value : $status,
            [ConsoleStatus::Faulty->value, ConsoleStatus::Maintenance->value],
            true
        );

        if ($monitoringStaffId && $isBlockedStatus) {
            $this->mountAction('cannotAssignConsole');
            $this->halt();
        }
    }

    public function cannotAssignConsoleAction(): Action
    {
        return Action::make('cannotAssignConsole')
            ->modalHeading('Cannot assign this console')
            ->modalDescription('This console is marked as faulty or under maintenance and cannot be assigned to a staff member. Please change the status first, or unassign the staff member.')
            ->modalIcon('heroicon-o-exclamation-triangle')
            ->modalIconColor('warning')
            ->modalSubmitAction(false) // no confirm button, just acknowledge
            ->modalCancelActionLabel('OK');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
