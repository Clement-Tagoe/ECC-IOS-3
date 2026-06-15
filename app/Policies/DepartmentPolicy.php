<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Department;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Department', $this->getGuard());
    }

    public function view(AuthUser $authUser, Department $department): bool
    {
        return $authUser->can('View:Department', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Department', $this->getGuard());
    }

    public function update(AuthUser $authUser, Department $department): bool
    {
        return $authUser->can('Update:Department', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Department $department): bool
    {
        return $authUser->can('Delete:Department', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Department $department): bool
    {
        return $authUser->can('Restore:Department', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Department $department): bool
    {
        return $authUser->can('ForceDelete:Department', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Department', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Department', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Department', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Department $department): bool
    {
        return $authUser->can('Replicate:Department', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Department', $this->getGuard());
    }

}
