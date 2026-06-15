<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Observation;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class ObservationPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Observation', $this->getGuard());
    }

    public function view(AuthUser $authUser, Observation $observation): bool
    {
        return $authUser->can('View:Observation', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Observation', $this->getGuard());
    }

    public function update(AuthUser $authUser, Observation $observation): bool
    {
        return $authUser->can('Update:Observation', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Observation $observation): bool
    {
        return $authUser->can('Delete:Observation', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Observation $observation): bool
    {
        return $authUser->can('Restore:Observation', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Observation $observation): bool
    {
        return $authUser->can('ForceDelete:Observation', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Observation', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Observation', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Observation', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Observation $observation): bool
    {
        return $authUser->can('Replicate:Observation', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Observation', $this->getGuard());
    }

}
