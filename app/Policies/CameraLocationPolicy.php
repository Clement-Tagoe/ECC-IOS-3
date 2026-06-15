<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CameraLocation;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class CameraLocationPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CameraLocation', $this->getGuard());
    }

    public function view(AuthUser $authUser, CameraLocation $cameraLocation): bool
    {
        return $authUser->can('View:CameraLocation', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CameraLocation', $this->getGuard());
    }

    public function update(AuthUser $authUser, CameraLocation $cameraLocation): bool
    {
        return $authUser->can('Update:CameraLocation', $this->getGuard());
    }

    public function delete(AuthUser $authUser, CameraLocation $cameraLocation): bool
    {
        return $authUser->can('Delete:CameraLocation', $this->getGuard());
    }

    public function restore(AuthUser $authUser, CameraLocation $cameraLocation): bool
    {
        return $authUser->can('Restore:CameraLocation', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, CameraLocation $cameraLocation): bool
    {
        return $authUser->can('ForceDelete:CameraLocation', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CameraLocation', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CameraLocation', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CameraLocation', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, CameraLocation $cameraLocation): bool
    {
        return $authUser->can('Replicate:CameraLocation', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CameraLocation', $this->getGuard());
    }

}
