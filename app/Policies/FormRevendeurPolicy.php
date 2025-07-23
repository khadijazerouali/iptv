<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FormRevendeur;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormRevendeurPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the formRevendeur can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list formrevendeurs');
    }

    /**
     * Determine whether the formRevendeur can view the model.
     */
    public function view(User $user, FormRevendeur $model): bool
    {
        return $user->hasPermissionTo('view formrevendeurs');
    }

    /**
     * Determine whether the formRevendeur can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create formrevendeurs');
    }

    /**
     * Determine whether the formRevendeur can update the model.
     */
    public function update(User $user, FormRevendeur $model): bool
    {
        return $user->hasPermissionTo('update formrevendeurs');
    }

    /**
     * Determine whether the formRevendeur can delete the model.
     */
    public function delete(User $user, FormRevendeur $model): bool
    {
        return $user->hasPermissionTo('delete formrevendeurs');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete formrevendeurs');
    }

    /**
     * Determine whether the formRevendeur can restore the model.
     */
    public function restore(User $user, FormRevendeur $model): bool
    {
        return false;
    }

    /**
     * Determine whether the formRevendeur can permanently delete the model.
     */
    public function forceDelete(User $user, FormRevendeur $model): bool
    {
        return false;
    }
}
