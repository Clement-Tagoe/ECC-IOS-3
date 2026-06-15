<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MonitoringStaff;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonitoringStaffPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MonitoringStaff', $this->getGuard());
    }

    public function view(AuthUser $authUser, MonitoringStaff $monitoringStaff): bool
    {
        return $authUser->can('View:MonitoringStaff', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MonitoringStaff', $this->getGuard());
    }

    public function update(AuthUser $authUser, MonitoringStaff $monitoringStaff): bool
    {
        return $authUser->can('Update:MonitoringStaff', $this->getGuard());
    }

    public function delete(AuthUser $authUser, MonitoringStaff $monitoringStaff): bool
    {
        return $authUser->can('Delete:MonitoringStaff', $this->getGuard());
    }

    public function restore(AuthUser $authUser, MonitoringStaff $monitoringStaff): bool
    {
        return $authUser->can('Restore:MonitoringStaff', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, MonitoringStaff $monitoringStaff): bool
    {
        return $authUser->can('ForceDelete:MonitoringStaff', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MonitoringStaff', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MonitoringStaff', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MonitoringStaff', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, MonitoringStaff $monitoringStaff): bool
    {
        return $authUser->can('Replicate:MonitoringStaff', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MonitoringStaff', $this->getGuard());
    }

}
