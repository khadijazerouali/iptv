<?php

namespace App\Policies;

use App\Models\Vod;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the vod can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list vods');
    }

    /**
     * Determine whether the vod can view the model.
     */
    public function view(User $user, Vod $model): bool
    {
        return $user->hasPermissionTo('view vods');
    }

    /**
     * Determine whether the vod can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create vods');
    }

    /**
     * Determine whether the vod can update the model.
     */
    public function update(User $user, Vod $model): bool
    {
        return $user->hasPermissionTo('update vods');
    }

    /**
     * Determine whether the vod can delete the model.
     */
    public function delete(User $user, Vod $model): bool
    {
        return $user->hasPermissionTo('delete vods');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete vods');
    }

    /**
     * Determine whether the vod can restore the model.
     */
    public function restore(User $user, Vod $model): bool
    {
        return false;
    }

    /**
     * Determine whether the vod can permanently delete the model.
     */
    public function forceDelete(User $user, Vod $model): bool
    {
        return false;
    }
}
