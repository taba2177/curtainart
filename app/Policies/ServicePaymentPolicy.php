<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Taba\Crm\Models\ServicePayment;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePaymentPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ServicePayment');
    }

    public function view(AuthUser $authUser, ServicePayment $servicePayment): bool
    {
        return $authUser->can('View:ServicePayment');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ServicePayment');
    }

    public function update(AuthUser $authUser, ServicePayment $servicePayment): bool
    {
        return $authUser->can('Update:ServicePayment');
    }

    public function delete(AuthUser $authUser, ServicePayment $servicePayment): bool
    {
        return $authUser->can('Delete:ServicePayment');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ServicePayment');
    }

    public function restore(AuthUser $authUser, ServicePayment $servicePayment): bool
    {
        return $authUser->can('Restore:ServicePayment');
    }

    public function forceDelete(AuthUser $authUser, ServicePayment $servicePayment): bool
    {
        return $authUser->can('ForceDelete:ServicePayment');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ServicePayment');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ServicePayment');
    }

    public function replicate(AuthUser $authUser, ServicePayment $servicePayment): bool
    {
        return $authUser->can('Replicate:ServicePayment');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ServicePayment');
    }

}