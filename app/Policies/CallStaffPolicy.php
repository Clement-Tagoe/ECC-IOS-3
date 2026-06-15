<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CallStaff;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class CallStaffPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CallStaff', $this->getGuard());
    }

    public function view(AuthUser $authUser, CallStaff $callStaff): bool
    {
        return $authUser->can('View:CallStaff', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CallStaff', $this->getGuard());
    }

    public function update(AuthUser $authUser, CallStaff $callStaff): bool
    {
        return $authUser->can('Update:CallStaff', $this->getGuard());
    }

    public function delete(AuthUser $authUser, CallStaff $callStaff): bool
    {
        return $authUser->can('Delete:CallStaff', $this->getGuard());
    }

    public function restore(AuthUser $authUser, CallStaff $callStaff): bool
    {
        return $authUser->can('Restore:CallStaff', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, CallStaff $callStaff): bool
    {
        return $authUser->can('ForceDelete:CallStaff', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CallStaff', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CallStaff', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CallStaff', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, CallStaff $callStaff): bool
    {
        return $authUser->can('Replicate:CallStaff', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CallStaff', $this->getGuard());
    }

}
