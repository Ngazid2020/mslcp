<?php

namespace App\Policies;

use App\Models\Element;
use App\Models\User;

class ElementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Element');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Element $element): bool
    {
        return $user->checkPermissionTo('view Element');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Element');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Element $element): bool
    {
        return $user->checkPermissionTo('update Element');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Element $element): bool
    {
        return $user->checkPermissionTo('delete Element');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Element');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Element $element): bool
    {
        return $user->checkPermissionTo('restore Element');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Element');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Element $element): bool
    {
        return $user->checkPermissionTo('replicate Element');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Element');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Element $element): bool
    {
        return $user->checkPermissionTo('force-delete Element');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Element');
    }
}
