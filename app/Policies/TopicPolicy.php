<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Topic;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Topic', $this->getGuard());
    }

    public function view(AuthUser $authUser, Topic $topic): bool
    {
        return $authUser->can('View:Topic', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Topic', $this->getGuard());
    }

    public function update(AuthUser $authUser, Topic $topic): bool
    {
        return $authUser->can('Update:Topic', $this->getGuard());
    }

    public function delete(AuthUser $authUser, Topic $topic): bool
    {
        return $authUser->can('Delete:Topic', $this->getGuard());
    }

    public function restore(AuthUser $authUser, Topic $topic): bool
    {
        return $authUser->can('Restore:Topic', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, Topic $topic): bool
    {
        return $authUser->can('ForceDelete:Topic', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Topic', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Topic', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Topic', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, Topic $topic): bool
    {
        return $authUser->can('Replicate:Topic', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Topic', $this->getGuard());
    }

}
