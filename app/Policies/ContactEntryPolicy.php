<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Taba\Crm\Models\ContactEntry;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactEntryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ContactEntry');
    }

    public function view(AuthUser $authUser, ContactEntry $contactEntry): bool
    {
        return $authUser->can('View:ContactEntry');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ContactEntry');
    }

    public function update(AuthUser $authUser, ContactEntry $contactEntry): bool
    {
        return $authUser->can('Update:ContactEntry');
    }

    public function delete(AuthUser $authUser, ContactEntry $contactEntry): bool
    {
        return $authUser->can('Delete:ContactEntry');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ContactEntry');
    }

    public function restore(AuthUser $authUser, ContactEntry $contactEntry): bool
    {
        return $authUser->can('Restore:ContactEntry');
    }

    public function forceDelete(AuthUser $authUser, ContactEntry $contactEntry): bool
    {
        return $authUser->can('ForceDelete:ContactEntry');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ContactEntry');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ContactEntry');
    }

    public function replicate(AuthUser $authUser, ContactEntry $contactEntry): bool
    {
        return $authUser->can('Replicate:ContactEntry');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ContactEntry');
    }

}