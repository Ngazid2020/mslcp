<?php

namespace App\Policies;

use App\Models\Reactif;
use App\Models\User;

class ReactifPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Reactif');
    }

    public function view(User $user, Reactif $reactif): bool
    {
        return $user->checkPermissionTo('view Reactif');
    }

    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Reactif');
    }

    public function update(User $user, Reactif $reactif): bool
    {
        return $user->checkPermissionTo('update Reactif');
    }

    public function delete(User $user, Reactif $reactif): bool
    {
        return $user->checkPermissionTo('delete Reactif');
    }

    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Reactif');
    }

    public function restore(User $user, Reactif $reactif): bool
    {
        return $user->checkPermissionTo('restore Reactif');
    }

    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Reactif');
    }

    public function replicate(User $user, Reactif $reactif): bool
    {
        return $user->checkPermissionTo('replicate Reactif');
    }

    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Reactif');
    }

    public function forceDelete(User $user, Reactif $reactif): bool
    {
        return $user->checkPermissionTo('force-delete Reactif');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Reactif');
    }
}
