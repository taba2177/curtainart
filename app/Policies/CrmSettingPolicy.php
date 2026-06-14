<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Taba\Crm\Models\CrmSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrmSettingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CrmSetting');
    }

    public function view(AuthUser $authUser, CrmSetting $crmSetting): bool
    {
        return $authUser->can('View:CrmSetting');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CrmSetting');
    }

    public function update(AuthUser $authUser, CrmSetting $crmSetting): bool
    {
        return $authUser->can('Update:CrmSetting');
    }

    public function delete(AuthUser $authUser, CrmSetting $crmSetting): bool
    {
        return $authUser->can('Delete:CrmSetting');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CrmSetting');
    }

    public function restore(AuthUser $authUser, CrmSetting $crmSetting): bool
    {
        return $authUser->can('Restore:CrmSetting');
    }

    public function forceDelete(AuthUser $authUser, CrmSetting $crmSetting): bool
    {
        return $authUser->can('ForceDelete:CrmSetting');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CrmSetting');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CrmSetting');
    }

    public function replicate(AuthUser $authUser, CrmSetting $crmSetting): bool
    {
        return $authUser->can('Replicate:CrmSetting');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CrmSetting');
    }

}