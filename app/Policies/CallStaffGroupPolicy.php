<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CallStaffGroup;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class CallStaffGroupPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CallStaffGroup', $this->getGuard());
    }

    public function view(AuthUser $authUser, CallStaffGroup $callStaffGroup): bool
    {
        return $authUser->can('View:CallStaffGroup', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CallStaffGroup', $this->getGuard());
    }

    public function update(AuthUser $authUser, CallStaffGroup $callStaffGroup): bool
    {
        return $authUser->can('Update:CallStaffGroup', $this->getGuard());
    }

    public function delete(AuthUser $authUser, CallStaffGroup $callStaffGroup): bool
    {
        return $authUser->can('Delete:CallStaffGroup', $this->getGuard());
    }

    public function restore(AuthUser $authUser, CallStaffGroup $callStaffGroup): bool
    {
        return $authUser->can('Restore:CallStaffGroup', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, CallStaffGroup $callStaffGroup): bool
    {
        return $authUser->can('ForceDelete:CallStaffGroup', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CallStaffGroup', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CallStaffGroup', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CallStaffGroup', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, CallStaffGroup $callStaffGroup): bool
    {
        return $authUser->can('Replicate:CallStaffGroup', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CallStaffGroup', $this->getGuard());
    }

}
