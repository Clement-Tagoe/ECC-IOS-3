<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Vehicle;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Vehicle', $this->getGuard());
    }

    public function view(AuthUser $authUser, Vehicle $vehicle): bool
    {
        return $authUser->can('View:Vehicle', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Vehicle', $this->getGuard());
    }

    public function update(AuthUser $authUser, Vehicle $vehicle): bool
    {
        return $authUser->can('Update:Vehicle', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Vehicle $vehicle): bool
    {
        return $authUser->can('Delete:Vehicle', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Vehicle $vehicle): bool
    {
        return $authUser->can('Restore:Vehicle', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Vehicle $vehicle): bool
    {
        return $authUser->can('ForceDelete:Vehicle', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Vehicle', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Vehicle', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Vehicle', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Vehicle $vehicle): bool
    {
        return $authUser->can('Replicate:Vehicle', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Vehicle', $this->getGuard());
    }

}
