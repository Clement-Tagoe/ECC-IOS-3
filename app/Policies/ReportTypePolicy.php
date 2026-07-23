<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ReportType;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportTypePolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ReportType', $this->getGuard());
    }

    public function view(AuthUser $authUser, ReportType $reportType): bool
    {
        return $authUser->can('View:ReportType', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ReportType', $this->getGuard());
    }

    public function update(AuthUser $authUser, ReportType $reportType): bool
    {
        return $authUser->can('Update:ReportType', $this->getGuard());
    }

    public function delete(AuthUser $authUser, ReportType $reportType): bool
    {
        return $authUser->can('Delete:ReportType', $this->getGuard());
    }

    public function restore(AuthUser $authUser, ReportType $reportType): bool
    {
        return $authUser->can('Restore:ReportType', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, ReportType $reportType): bool
    {
        return $authUser->can('ForceDelete:ReportType', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ReportType', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ReportType', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ReportType', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, ReportType $reportType): bool
    {
        return $authUser->can('Replicate:ReportType', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ReportType', $this->getGuard());
    }

}
