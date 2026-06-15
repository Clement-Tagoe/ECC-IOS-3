<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Visitor;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitorPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Visitor', $this->getGuard());
    }

    public function view(AuthUser $authUser, Visitor $visitor): bool
    {
        return $authUser->can('View:Visitor', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Visitor', $this->getGuard());
    }

    public function update(AuthUser $authUser, Visitor $visitor): bool
    {
        return $authUser->can('Update:Visitor', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Visitor $visitor): bool
    {
        return $authUser->can('Delete:Visitor', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Visitor $visitor): bool
    {
        return $authUser->can('Restore:Visitor', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Visitor $visitor): bool
    {
        return $authUser->can('ForceDelete:Visitor', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Visitor', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Visitor', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Visitor', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Visitor $visitor): bool
    {
        return $authUser->can('Replicate:Visitor', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Visitor', $this->getGuard());
    }

}
