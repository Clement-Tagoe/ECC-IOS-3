<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CallLog;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class CallLogPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CallLog', $this->getGuard());
    }

    public function view(AuthUser $authUser, CallLog $callLog): bool
    {
        return $authUser->can('View:CallLog', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CallLog', $this->getGuard());
    }

    public function update(AuthUser $authUser, CallLog $callLog): bool
    {
        return $authUser->can('Update:CallLog', $this->getGuard());
    }

    public function delete(AuthUser $authUser, CallLog $callLog): bool
    {
        return $authUser->can('Delete:CallLog', $this->getGuard());
    }

    public function restore(AuthUser $authUser, CallLog $callLog): bool
    {
        return $authUser->can('Restore:CallLog', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, CallLog $callLog): bool
    {
        return $authUser->can('ForceDelete:CallLog', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CallLog', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CallLog', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CallLog', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, CallLog $callLog): bool
    {
        return $authUser->can('Replicate:CallLog', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CallLog', $this->getGuard());
    }

}
