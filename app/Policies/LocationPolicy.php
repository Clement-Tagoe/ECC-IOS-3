<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Location;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Location', $this->getGuard());
    }

    public function view(AuthUser $authUser, Location $location): bool
    {
        return $authUser->can('View:Location', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Location', $this->getGuard());
    }

    public function update(AuthUser $authUser, Location $location): bool
    {
        return $authUser->can('Update:Location', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Location $location): bool
    {
        return $authUser->can('Delete:Location', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Location $location): bool
    {
        return $authUser->can('Restore:Location', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Location $location): bool
    {
        return $authUser->can('ForceDelete:Location', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Location', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Location', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Location', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Location $location): bool
    {
        return $authUser->can('Replicate:Location', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Location', $this->getGuard());
    }

}
