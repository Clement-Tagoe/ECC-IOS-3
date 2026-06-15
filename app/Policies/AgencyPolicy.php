<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Agency;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgencyPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Agency', $this->getGuard());
    }

    public function view(AuthUser $authUser, Agency $agency): bool
    {
        return $authUser->can('View:Agency', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Agency', $this->getGuard());
    }

    public function update(AuthUser $authUser, Agency $agency): bool
    {
        return $authUser->can('Update:Agency', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Agency $agency): bool
    {
        return $authUser->can('Delete:Agency', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Agency $agency): bool
    {
        return $authUser->can('Restore:Agency', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Agency $agency): bool
    {
        return $authUser->can('ForceDelete:Agency', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Agency', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Agency', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Agency', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Agency $agency): bool
    {
        return $authUser->can('Replicate:Agency', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Agency', $this->getGuard());
    }

}
