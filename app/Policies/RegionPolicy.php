<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Region;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegionPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Region', $this->getGuard());
    }

    public function view(AuthUser $authUser, Region $region): bool
    {
        return $authUser->can('View:Region', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Region', $this->getGuard());
    }

    public function update(AuthUser $authUser, Region $region): bool
    {
        return $authUser->can('Update:Region', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Region $region): bool
    {
        return $authUser->can('Delete:Region', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Region $region): bool
    {
        return $authUser->can('Restore:Region', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Region $region): bool
    {
        return $authUser->can('ForceDelete:Region', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Region', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Region', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Region', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Region $region): bool
    {
        return $authUser->can('Replicate:Region', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Region', $this->getGuard());
    }

}
