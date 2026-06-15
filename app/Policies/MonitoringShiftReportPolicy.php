<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MonitoringShiftReport;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonitoringShiftReportPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MonitoringShiftReport', $this->getGuard());
    }

    public function view(AuthUser $authUser, MonitoringShiftReport $monitoringShiftReport): bool
    {
        return $authUser->can('View:MonitoringShiftReport', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MonitoringShiftReport', $this->getGuard());
    }

    public function update(AuthUser $authUser, MonitoringShiftReport $monitoringShiftReport): bool
    {
        return $authUser->can('Update:MonitoringShiftReport', $this->getGuard());
    }

    public function delete(AuthUser $authUser, MonitoringShiftReport $monitoringShiftReport): bool
    {
        return $authUser->can('Delete:MonitoringShiftReport', $this->getGuard());
    }

    public function restore(AuthUser $authUser, MonitoringShiftReport $monitoringShiftReport): bool
    {
        return $authUser->can('Restore:MonitoringShiftReport', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, MonitoringShiftReport $monitoringShiftReport): bool
    {
        return $authUser->can('ForceDelete:MonitoringShiftReport', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MonitoringShiftReport', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MonitoringShiftReport', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MonitoringShiftReport', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, MonitoringShiftReport $monitoringShiftReport): bool
    {
        return $authUser->can('Replicate:MonitoringShiftReport', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MonitoringShiftReport', $this->getGuard());
    }

}
