<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Formiptv;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormiptvPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the formiptv can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list formiptvs');
    }

    /**
     * Determine whether the formiptv can view the model.
     */
    public function view(User $user, Formiptv $model): bool
    {
        return $user->hasPermissionTo('view formiptvs');
    }

    /**
     * Determine whether the formiptv can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create formiptvs');
    }

    /**
     * Determine whether the formiptv can update the model.
     */
    public function update(User $user, Formiptv $model): bool
    {
        return $user->hasPermissionTo('update formiptvs');
    }

    /**
     * Determine whether the formiptv can delete the model.
     */
    public function delete(User $user, Formiptv $model): bool
    {
        return $user->hasPermissionTo('delete formiptvs');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete formiptvs');
    }

    /**
     * Determine whether the formiptv can restore the model.
     */
    public function restore(User $user, Formiptv $model): bool
    {
        return false;
    }

    /**
     * Determine whether the formiptv can permanently delete the model.
     */
    public function forceDelete(User $user, Formiptv $model): bool
    {
        return false;
    }
}
