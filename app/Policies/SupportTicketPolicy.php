<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SupportTicket;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupportTicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the supportTicket can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list supporttickets');
    }

    /**
     * Determine whether the supportTicket can view the model.
     */
    public function view(User $user, SupportTicket $model): bool
    {
        return $user->hasPermissionTo('view supporttickets');
    }

    /**
     * Determine whether the supportTicket can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create supporttickets');
    }

    /**
     * Determine whether the supportTicket can update the model.
     */
    public function update(User $user, SupportTicket $model): bool
    {
        return $user->hasPermissionTo('update supporttickets');
    }

    /**
     * Determine whether the supportTicket can delete the model.
     */
    public function delete(User $user, SupportTicket $model): bool
    {
        return $user->hasPermissionTo('delete supporttickets');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete supporttickets');
    }

    /**
     * Determine whether the supportTicket can restore the model.
     */
    public function restore(User $user, SupportTicket $model): bool
    {
        return false;
    }

    /**
     * Determine whether the supportTicket can permanently delete the model.
     */
    public function forceDelete(User $user, SupportTicket $model): bool
    {
        return false;
    }
}
