<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Task;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Task', $this->getGuard());
    }

    public function view(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('View:Task', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Task', $this->getGuard());
    }

    public function update(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('Update:Task', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('Delete:Task', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('Restore:Task', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('ForceDelete:Task', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Task', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Task', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Task', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('Replicate:Task', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Task', $this->getGuard());
    }

}
