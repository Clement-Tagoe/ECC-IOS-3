<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:User', $this->getGuard());
    }

    public function view(AuthUser $authUser): bool
    {
        return $authUser->can('View:User', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:User', $this->getGuard());
    }

    public function update(AuthUser $authUser): bool
    {
        return $authUser->can('Update:User', $this->getGuard());
    }

    public function delete(AuthUser $authUser): bool
    {
        return $authUser->can('Delete:User', $this->getGuard());
    }

    public function restore(AuthUser $authUser): bool
    {
        return $authUser->can('Restore:User', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDelete:User', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:User', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:User', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:User', $this->getGuard());
    }

    public function replicate(AuthUser $authUser): bool
    {
        return $authUser->can('Replicate:User', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:User', $this->getGuard());
    }

}
