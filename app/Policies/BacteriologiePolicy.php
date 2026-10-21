<?php

namespace App\Policies;

use App\Models\Bacteriologie;
use App\Models\User;

class BacteriologiePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Bacteriologie');
    }

    public function view(User $user, Bacteriologie $bacteriologie): bool
    {
        return $user->checkPermissionTo('view Bacteriologie');
    }

    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Bacteriologie');
    }

    public function update(User $user, Bacteriologie $bacteriologie): bool
    {
        return $user->checkPermissionTo('update Bacteriologie');
    }

    public function delete(User $user, Bacteriologie $bacteriologie): bool
    {
        return $user->checkPermissionTo('delete Bacteriologie');
    }

    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Bacteriologie');
    }

    public function restore(User $user, Bacteriologie $bacteriologie): bool
    {
        return $user->checkPermissionTo('restore Bacteriologie');
    }

    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Bacteriologie');
    }

    public function replicate(User $user, Bacteriologie $bacteriologie): bool
    {
        return $user->checkPermissionTo('replicate Bacteriologie');
    }

    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Bacteriologie');
    }

    public function forceDelete(User $user, Bacteriologie $bacteriologie): bool
    {
        return $user->checkPermissionTo('force-delete Bacteriologie');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Bacteriologie');
    }
}
