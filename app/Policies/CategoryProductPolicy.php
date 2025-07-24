<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CategoryProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the categoryProduct can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list categoryproducts');
    }

    /**
     * Determine whether the categoryProduct can view the model.
     */
    public function view(User $user, CategoryProduct $model): bool
    {
        return $user->hasPermissionTo('view categoryproducts');
    }

    /**
     * Determine whether the categoryProduct can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create categoryproducts');
    }

    /**
     * Determine whether the categoryProduct can update the model.
     */
    public function update(User $user, CategoryProduct $model): bool
    {
        return $user->hasPermissionTo('update categoryproducts');
    }

    /**
     * Determine whether the categoryProduct can delete the model.
     */
    public function delete(User $user, CategoryProduct $model): bool
    {
        return $user->hasPermissionTo('delete categoryproducts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete categoryproducts');
    }

    /**
     * Determine whether the categoryProduct can restore the model.
     */
    public function restore(User $user, CategoryProduct $model): bool
    {
        return false;
    }

    /**
     * Determine whether the categoryProduct can permanently delete the model.
     */
    public function forceDelete(User $user, CategoryProduct $model): bool
    {
        return false;
    }
}
