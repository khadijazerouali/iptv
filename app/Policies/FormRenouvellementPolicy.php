<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FormRenouvellement;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormRenouvellementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the formRenouvellement can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list formrenouvellements');
    }

    /**
     * Determine whether the formRenouvellement can view the model.
     */
    public function view(User $user, FormRenouvellement $model): bool
    {
        return $user->hasPermissionTo('view formrenouvellements');
    }

    /**
     * Determine whether the formRenouvellement can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create formrenouvellements');
    }

    /**
     * Determine whether the formRenouvellement can update the model.
     */
    public function update(User $user, FormRenouvellement $model): bool
    {
        return $user->hasPermissionTo('update formrenouvellements');
    }

    /**
     * Determine whether the formRenouvellement can delete the model.
     */
    public function delete(User $user, FormRenouvellement $model): bool
    {
        return $user->hasPermissionTo('delete formrenouvellements');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete formrenouvellements');
    }

    /**
     * Determine whether the formRenouvellement can restore the model.
     */
    public function restore(User $user, FormRenouvellement $model): bool
    {
        return false;
    }

    /**
     * Determine whether the formRenouvellement can permanently delete the model.
     */
    public function forceDelete(User $user, FormRenouvellement $model): bool
    {
        return false;
    }
}
