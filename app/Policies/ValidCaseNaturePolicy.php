<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ValidCaseNature;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class ValidCaseNaturePolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ValidCaseNature', $this->getGuard());
    }

    public function view(AuthUser $authUser, ValidCaseNature $validCaseNature): bool
    {
        return $authUser->can('View:ValidCaseNature', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ValidCaseNature', $this->getGuard());
    }

    public function update(AuthUser $authUser, ValidCaseNature $validCaseNature): bool
    {
        return $authUser->can('Update:ValidCaseNature', $this->getGuard());
    }

    public function delete(AuthUser $authUser, ValidCaseNature $validCaseNature): bool
    {
        return $authUser->can('Delete:ValidCaseNature', $this->getGuard());
    }

    public function restore(AuthUser $authUser, ValidCaseNature $validCaseNature): bool
    {
        return $authUser->can('Restore:ValidCaseNature', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, ValidCaseNature $validCaseNature): bool
    {
        return $authUser->can('ForceDelete:ValidCaseNature', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ValidCaseNature', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ValidCaseNature', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ValidCaseNature', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, ValidCaseNature $validCaseNature): bool
    {
        return $authUser->can('Replicate:ValidCaseNature', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ValidCaseNature', $this->getGuard());
    }

}
