<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ValidCase;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class ValidCasePolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ValidCase', $this->getGuard());
    }

    public function view(AuthUser $authUser, ValidCase $validCase): bool
    {
        return $authUser->can('View:ValidCase', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ValidCase', $this->getGuard());
    }

    public function update(AuthUser $authUser, ValidCase $validCase): bool
    {
        return $authUser->can('Update:ValidCase', $this->getGuard());
    }

    public function delete(AuthUser $authUser, ValidCase $validCase): bool
    {
        return $authUser->can('Delete:ValidCase', $this->getGuard());
    }

    public function restore(AuthUser $authUser, ValidCase $validCase): bool
    {
        return $authUser->can('Restore:ValidCase', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, ValidCase $validCase): bool
    {
        return $authUser->can('ForceDelete:ValidCase', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ValidCase', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ValidCase', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ValidCase', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, ValidCase $validCase): bool
    {
        return $authUser->can('Replicate:ValidCase', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ValidCase', $this->getGuard());
    }

}
