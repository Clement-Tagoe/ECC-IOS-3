<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\LogisticsManagement;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class LogisticsManagementPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LogisticsManagement', $this->getGuard());
    }

    public function view(AuthUser $authUser, LogisticsManagement $logisticsManagement): bool
    {
        return $authUser->can('View:LogisticsManagement', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LogisticsManagement', $this->getGuard());
    }

    public function update(AuthUser $authUser, LogisticsManagement $logisticsManagement): bool
    {
        return $authUser->can('Update:LogisticsManagement', $this->getGuard());
    }

    public function delete(AuthUser $authUser, LogisticsManagement $logisticsManagement): bool
    {
        return $authUser->can('Delete:LogisticsManagement', $this->getGuard());
    }

    public function restore(AuthUser $authUser, LogisticsManagement $logisticsManagement): bool
    {
        return $authUser->can('Restore:LogisticsManagement', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, LogisticsManagement $logisticsManagement): bool
    {
        return $authUser->can('ForceDelete:LogisticsManagement', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:LogisticsManagement', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LogisticsManagement', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LogisticsManagement', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, LogisticsManagement $logisticsManagement): bool
    {
        return $authUser->can('Replicate:LogisticsManagement', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LogisticsManagement', $this->getGuard());
    }

}
