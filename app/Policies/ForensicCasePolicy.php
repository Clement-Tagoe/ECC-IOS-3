<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ForensicCase;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForensicCasePolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ForensicCase', $this->getGuard());
    }

    public function view(AuthUser $authUser, ForensicCase $forensicCase): bool
    {
        return $authUser->can('View:ForensicCase', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ForensicCase', $this->getGuard());
    }

    public function update(AuthUser $authUser, ForensicCase $forensicCase): bool
    {
        return $authUser->can('Update:ForensicCase', $this->getGuard());
    }

    public function delete(AuthUser $authUser, ForensicCase $forensicCase): bool
    {
        return $authUser->can('Delete:ForensicCase', $this->getGuard());
    }

    public function restore(AuthUser $authUser, ForensicCase $forensicCase): bool
    {
        return $authUser->can('Restore:ForensicCase', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, ForensicCase $forensicCase): bool
    {
        return $authUser->can('ForceDelete:ForensicCase', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ForensicCase', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ForensicCase', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ForensicCase', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, ForensicCase $forensicCase): bool
    {
        return $authUser->can('Replicate:ForensicCase', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ForensicCase', $this->getGuard());
    }

}
