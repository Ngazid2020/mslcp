<?php

namespace App\Policies;

use App\Models\LotReactif;
use App\Models\User;

class LotReactifPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any LotReactif');
    }

    public function view(User $user, LotReactif $lotReactif): bool
    {
        return $user->checkPermissionTo('view LotReactif');
    }

    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create LotReactif');
    }

    public function update(User $user, LotReactif $lotReactif): bool
    {
        return $user->checkPermissionTo('update LotReactif');
    }

    public function delete(User $user, LotReactif $lotReactif): bool
    {
        return $user->checkPermissionTo('delete LotReactif');
    }

    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any LotReactif');
    }

    public function restore(User $user, LotReactif $lotReactif): bool
    {
        return $user->checkPermissionTo('restore LotReactif');
    }

    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any LotReactif');
    }

    public function replicate(User $user, LotReactif $lotReactif): bool
    {
        return $user->checkPermissionTo('replicate LotReactif');
    }

    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder LotReactif');
    }

    public function forceDelete(User $user, LotReactif $lotReactif): bool
    {
        return $user->checkPermissionTo('force-delete LotReactif');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any LotReactif');
    }
}
