<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Bilan;
use App\Models\User;

class BilanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Bilan');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Bilan $bilan): bool
    {
        return $user->checkPermissionTo('view Bilan');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Bilan');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Bilan $bilan): bool
    {
        return $user->checkPermissionTo('update Bilan');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bilan $bilan): bool
    {
        return $user->checkPermissionTo('delete Bilan');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Bilan');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Bilan $bilan): bool
    {
        return $user->checkPermissionTo('restore Bilan');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Bilan');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Bilan $bilan): bool
    {
        return $user->checkPermissionTo('replicate Bilan');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Bilan');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Bilan $bilan): bool
    {
        return $user->checkPermissionTo('force-delete Bilan');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Bilan');
    }


    public function download(User $user, Bilan $bilan): bool
    {
        return $user->checkPermissionTo('download Bilan');
    }
}
