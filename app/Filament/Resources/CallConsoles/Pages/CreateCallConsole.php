<?php

namespace App\Filament\Resources\CallConsoles\Pages;

use App\Enums\ConsoleStatus;
use App\Filament\Resources\CallConsoles\CallConsoleResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateCallConsole extends CreateRecord
{
    protected static string $resource = CallConsoleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function beforeCreate(): void
    {
        $status = $this->data['status'] ?? null;
        $callStaffId = $this->data['call_staff_id'] ?? null;

        $isBlockedStatus = in_array(
            $status instanceof ConsoleStatus ? $status->value : $status,
            [ConsoleStatus::Faulty->value, ConsoleStatus::Maintenance->value],
            true
        );

        if ($callStaffId && $isBlockedStatus) {
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
}
