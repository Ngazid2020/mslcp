<?php

namespace App\Policies;

use App\Models\BilanUrinaire;
use App\Models\User;

class BilanUrinairePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BilanUrinaire');
    }

    public function view(User $user, BilanUrinaire $bilan): bool
    {
        return $user->checkPermissionTo('view BilanUrinaire');
    }

    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BilanUrinaire');
    }

    public function update(User $user, BilanUrinaire $bilan): bool
    {
        return $user->checkPermissionTo('update BilanUrinaire');
    }

    public function delete(User $user, BilanUrinaire $bilan): bool
    {
        return $user->checkPermissionTo('delete BilanUrinaire');
    }

    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any BilanUrinaire');
    }

    public function download(User $user, BilanUrinaire $bilan): bool
    {
        return $user->checkPermissionTo('download Bilan');
    }
}
