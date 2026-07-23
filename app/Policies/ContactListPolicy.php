<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ContactList;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactListPolicy
{
    use HandlesAuthorization;

    protected function getGuard(): ?string
    {
        return Filament::getCurrentPanel()?->getAuthGuard();
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ContactList', $this->getGuard());
    }

    public function view(AuthUser $authUser, ContactList $contactList): bool
    {
        return $authUser->can('View:ContactList', $this->getGuard());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ContactList', $this->getGuard());
    }

    public function update(AuthUser $authUser, ContactList $contactList): bool
    {
        return $authUser->can('Update:ContactList', $this->getGuard());
    }

    public function delete(AuthUser $authUser, ContactList $contactList): bool
    {
        return $authUser->can('Delete:ContactList', $this->getGuard());
    }

    public function restore(AuthUser $authUser, ContactList $contactList): bool
    {
        return $authUser->can('Restore:ContactList', $this->getGuard());
    }

    public function forceDelete(AuthUser $authUser, ContactList $contactList): bool
    {
        return $authUser->can('ForceDelete:ContactList', $this->getGuard());
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ContactList', $this->getGuard());
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ContactList', $this->getGuard());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ContactList', $this->getGuard());
    }

    public function replicate(AuthUser $authUser, ContactList $contactList): bool
    {
        return $authUser->can('Replicate:ContactList', $this->getGuard());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ContactList', $this->getGuard());
    }

}
