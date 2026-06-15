<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CameraAudit;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class CameraAuditPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CameraAudit', $this->getGuard());
    }

    public function view(AuthUser $authUser, CameraAudit $cameraAudit): bool
    {
        return $authUser->can('View:CameraAudit', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CameraAudit', $this->getGuard());
    }

    public function update(AuthUser $authUser, CameraAudit $cameraAudit): bool
    {
        return $authUser->can('Update:CameraAudit', $this->getGuard());
    }

    public function delete(AuthUser $authUser, CameraAudit $cameraAudit): bool
    {
        return $authUser->can('Delete:CameraAudit', $this->getGuard());
    }

    public function restore(AuthUser $authUser, CameraAudit $cameraAudit): bool
    {
        return $authUser->can('Restore:CameraAudit', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, CameraAudit $cameraAudit): bool
    {
        return $authUser->can('ForceDelete:CameraAudit', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CameraAudit', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CameraAudit', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CameraAudit', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, CameraAudit $cameraAudit): bool
    {
        return $authUser->can('Replicate:CameraAudit', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CameraAudit', $this->getGuard());
    }

}
