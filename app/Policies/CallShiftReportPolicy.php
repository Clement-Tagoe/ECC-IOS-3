<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CallShiftReport;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class CallShiftReportPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CallShiftReport', $this->getGuard());
    }

    public function view(AuthUser $authUser, CallShiftReport $callShiftReport): bool
    {
        return $authUser->can('View:CallShiftReport', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CallShiftReport', $this->getGuard());
    }

    public function update(AuthUser $authUser, CallShiftReport $callShiftReport): bool
    {
        return $authUser->can('Update:CallShiftReport', $this->getGuard());
    }

    public function delete(AuthUser $authUser, CallShiftReport $callShiftReport): bool
    {
        return $authUser->can('Delete:CallShiftReport', $this->getGuard());
    }

    public function restore(AuthUser $authUser, CallShiftReport $callShiftReport): bool
    {
        return $authUser->can('Restore:CallShiftReport', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, CallShiftReport $callShiftReport): bool
    {
        return $authUser->can('ForceDelete:CallShiftReport', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CallShiftReport', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CallShiftReport', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CallShiftReport', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, CallShiftReport $callShiftReport): bool
    {
        return $authUser->can('Replicate:CallShiftReport', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CallShiftReport', $this->getGuard());
    }

}
