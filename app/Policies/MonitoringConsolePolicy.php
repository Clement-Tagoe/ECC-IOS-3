<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MonitoringConsole;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonitoringConsolePolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MonitoringConsole', $this->getGuard());
    }

    public function view(AuthUser $authUser, MonitoringConsole $monitoringConsole): bool
    {
        return $authUser->can('View:MonitoringConsole', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MonitoringConsole', $this->getGuard());
    }

    public function update(AuthUser $authUser, MonitoringConsole $monitoringConsole): bool
    {
        return $authUser->can('Update:MonitoringConsole', $this->getGuard());
    }

    public function delete(AuthUser $authUser, MonitoringConsole $monitoringConsole): bool
    {
        return $authUser->can('Delete:MonitoringConsole', $this->getGuard());
    }

    public function restore(AuthUser $authUser, MonitoringConsole $monitoringConsole): bool
    {
        return $authUser->can('Restore:MonitoringConsole', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, MonitoringConsole $monitoringConsole): bool
    {
        return $authUser->can('ForceDelete:MonitoringConsole', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MonitoringConsole', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MonitoringConsole', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MonitoringConsole', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, MonitoringConsole $monitoringConsole): bool
    {
        return $authUser->can('Replicate:MonitoringConsole', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MonitoringConsole', $this->getGuard());
    }

}
