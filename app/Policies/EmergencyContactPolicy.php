<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\EmergencyContact;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmergencyContactPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:EmergencyContact', $this->getGuard());
    }

    public function view(AuthUser $authUser, EmergencyContact $emergencyContact): bool
    {
        return $authUser->can('View:EmergencyContact', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EmergencyContact', $this->getGuard());
    }

    public function update(AuthUser $authUser, EmergencyContact $emergencyContact): bool
    {
        return $authUser->can('Update:EmergencyContact', $this->getGuard());
    }

    public function delete(AuthUser $authUser, EmergencyContact $emergencyContact): bool
    {
        return $authUser->can('Delete:EmergencyContact', $this->getGuard());
    }

    public function restore(AuthUser $authUser, EmergencyContact $emergencyContact): bool
    {
        return $authUser->can('Restore:EmergencyContact', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, EmergencyContact $emergencyContact): bool
    {
        return $authUser->can('ForceDelete:EmergencyContact', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:EmergencyContact', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:EmergencyContact', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:EmergencyContact', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, EmergencyContact $emergencyContact): bool
    {
        return $authUser->can('Replicate:EmergencyContact', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:EmergencyContact', $this->getGuard());
    }

}
