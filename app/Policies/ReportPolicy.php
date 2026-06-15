<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Report;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Report', $this->getGuard());
    }

    public function view(AuthUser $authUser, Report $report): bool
    {
        return $authUser->can('View:Report', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Report', $this->getGuard());
    }

    public function update(AuthUser $authUser, Report $report): bool
    {
        return $authUser->can('Update:Report', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Report $report): bool
    {
        return $authUser->can('Delete:Report', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Report $report): bool
    {
        return $authUser->can('Restore:Report', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Report $report): bool
    {
        return $authUser->can('ForceDelete:Report', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Report', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Report', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Report', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Report $report): bool
    {
        return $authUser->can('Replicate:Report', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Report', $this->getGuard());
    }

}
