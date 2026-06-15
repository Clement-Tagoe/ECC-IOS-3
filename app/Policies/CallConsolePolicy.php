<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CallConsole;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class CallConsolePolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CallConsole', $this->getGuard());
    }

    public function view(AuthUser $authUser, CallConsole $callConsole): bool
    {
        return $authUser->can('View:CallConsole', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CallConsole', $this->getGuard());
    }

    public function update(AuthUser $authUser, CallConsole $callConsole): bool
    {
        return $authUser->can('Update:CallConsole', $this->getGuard());
    }

    public function delete(AuthUser $authUser, CallConsole $callConsole): bool
    {
        return $authUser->can('Delete:CallConsole', $this->getGuard());
    }

    public function restore(AuthUser $authUser, CallConsole $callConsole): bool
    {
        return $authUser->can('Restore:CallConsole', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, CallConsole $callConsole): bool
    {
        return $authUser->can('ForceDelete:CallConsole', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CallConsole', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CallConsole', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CallConsole', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, CallConsole $callConsole): bool
    {
        return $authUser->can('Replicate:CallConsole', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CallConsole', $this->getGuard());
    }

}
