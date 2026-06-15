<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Procurement;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProcurementPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Procurement', $this->getGuard());
    }

    public function view(AuthUser $authUser, Procurement $procurement): bool
    {
        return $authUser->can('View:Procurement', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Procurement', $this->getGuard());
    }

    public function update(AuthUser $authUser, Procurement $procurement): bool
    {
        return $authUser->can('Update:Procurement', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Procurement $procurement): bool
    {
        return $authUser->can('Delete:Procurement', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Procurement $procurement): bool
    {
        return $authUser->can('Restore:Procurement', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Procurement $procurement): bool
    {
        return $authUser->can('ForceDelete:Procurement', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Procurement', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Procurement', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Procurement', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Procurement $procurement): bool
    {
        return $authUser->can('Replicate:Procurement', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Procurement', $this->getGuard());
    }

}
