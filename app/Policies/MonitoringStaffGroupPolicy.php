<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MonitoringStaffGroup;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonitoringStaffGroupPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MonitoringStaffGroup', $this->getGuard());
    }

    public function view(AuthUser $authUser, MonitoringStaffGroup $monitoringStaffGroup): bool
    {
        return $authUser->can('View:MonitoringStaffGroup', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MonitoringStaffGroup', $this->getGuard());
    }

    public function update(AuthUser $authUser, MonitoringStaffGroup $monitoringStaffGroup): bool
    {
        return $authUser->can('Update:MonitoringStaffGroup', $this->getGuard());
    }

    public function delete(AuthUser $authUser, MonitoringStaffGroup $monitoringStaffGroup): bool
    {
        return $authUser->can('Delete:MonitoringStaffGroup', $this->getGuard());
    }

    public function restore(AuthUser $authUser, MonitoringStaffGroup $monitoringStaffGroup): bool
    {
        return $authUser->can('Restore:MonitoringStaffGroup', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, MonitoringStaffGroup $monitoringStaffGroup): bool
    {
        return $authUser->can('ForceDelete:MonitoringStaffGroup', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MonitoringStaffGroup', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MonitoringStaffGroup', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MonitoringStaffGroup', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, MonitoringStaffGroup $monitoringStaffGroup): bool
    {
        return $authUser->can('Replicate:MonitoringStaffGroup', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MonitoringStaffGroup', $this->getGuard());
    }

}
