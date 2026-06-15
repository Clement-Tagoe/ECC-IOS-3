<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MonitoringTask;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonitoringTaskPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MonitoringTask', $this->getGuard());
    }

    public function view(AuthUser $authUser, MonitoringTask $monitoringTask): bool
    {
        return $authUser->can('View:MonitoringTask', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MonitoringTask', $this->getGuard());
    }

    public function update(AuthUser $authUser, MonitoringTask $monitoringTask): bool
    {
        return $authUser->can('Update:MonitoringTask', $this->getGuard());
    }

    public function delete(AuthUser $authUser, MonitoringTask $monitoringTask): bool
    {
        return $authUser->can('Delete:MonitoringTask', $this->getGuard());
    }

    public function restore(AuthUser $authUser, MonitoringTask $monitoringTask): bool
    {
        return $authUser->can('Restore:MonitoringTask', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, MonitoringTask $monitoringTask): bool
    {
        return $authUser->can('ForceDelete:MonitoringTask', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MonitoringTask', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MonitoringTask', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MonitoringTask', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, MonitoringTask $monitoringTask): bool
    {
        return $authUser->can('Replicate:MonitoringTask', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MonitoringTask', $this->getGuard());
    }

}
