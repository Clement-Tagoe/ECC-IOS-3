<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ForensicReport;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForensicReportPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ForensicReport', $this->getGuard());
    }

    public function view(AuthUser $authUser, ForensicReport $forensicReport): bool
    {
        return $authUser->can('View:ForensicReport', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ForensicReport', $this->getGuard());
    }

    public function update(AuthUser $authUser, ForensicReport $forensicReport): bool
    {
        return $authUser->can('Update:ForensicReport', $this->getGuard());
    }

    public function delete(AuthUser $authUser, ForensicReport $forensicReport): bool
    {
        return $authUser->can('Delete:ForensicReport', $this->getGuard());
    }

    public function restore(AuthUser $authUser, ForensicReport $forensicReport): bool
    {
        return $authUser->can('Restore:ForensicReport', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, ForensicReport $forensicReport): bool
    {
        return $authUser->can('ForceDelete:ForensicReport', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ForensicReport', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ForensicReport', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ForensicReport', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, ForensicReport $forensicReport): bool
    {
        return $authUser->can('Replicate:ForensicReport', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ForensicReport', $this->getGuard());
    }

}
