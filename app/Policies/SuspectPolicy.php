<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Suspect;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuspectPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Suspect', $this->getGuard());
    }

    public function view(AuthUser $authUser, Suspect $suspect): bool
    {
        return $authUser->can('View:Suspect', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Suspect', $this->getGuard());
    }

    public function update(AuthUser $authUser, Suspect $suspect): bool
    {
        return $authUser->can('Update:Suspect', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Suspect $suspect): bool
    {
        return $authUser->can('Delete:Suspect', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Suspect $suspect): bool
    {
        return $authUser->can('Restore:Suspect', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Suspect $suspect): bool
    {
        return $authUser->can('ForceDelete:Suspect', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Suspect', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Suspect', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Suspect', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Suspect $suspect): bool
    {
        return $authUser->can('Replicate:Suspect', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Suspect', $this->getGuard());
    }

}
