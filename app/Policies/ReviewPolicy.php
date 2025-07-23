<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Review;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the review can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list reviews');
    }

    /**
     * Determine whether the review can view the model.
     */
    public function view(User $user, Review $model): bool
    {
        return $user->hasPermissionTo('view reviews');
    }

    /**
     * Determine whether the review can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create reviews');
    }

    /**
     * Determine whether the review can update the model.
     */
    public function update(User $user, Review $model): bool
    {
        return $user->hasPermissionTo('update reviews');
    }

    /**
     * Determine whether the review can delete the model.
     */
    public function delete(User $user, Review $model): bool
    {
        return $user->hasPermissionTo('delete reviews');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete reviews');
    }

    /**
     * Determine whether the review can restore the model.
     */
    public function restore(User $user, Review $model): bool
    {
        return false;
    }

    /**
     * Determine whether the review can permanently delete the model.
     */
    public function forceDelete(User $user, Review $model): bool
    {
        return false;
    }
}
