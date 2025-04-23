<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Analyse;
use App\Models\User;

class AnalysePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Analyse');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Analyse $analyse): bool
    {
        return $user->checkPermissionTo('view Analyse');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Analyse');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Analyse $analyse): bool
    {
        return $user->checkPermissionTo('update Analyse');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Analyse $analyse): bool
    {
        return $user->checkPermissionTo('delete Analyse');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Analyse');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Analyse $analyse): bool
    {
        return $user->checkPermissionTo('restore Analyse');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Analyse');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Analyse $analyse): bool
    {
        return $user->checkPermissionTo('replicate Analyse');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Analyse');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Analyse $analyse): bool
    {
        return $user->checkPermissionTo('force-delete Analyse');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Analyse');
    }
}
