<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TicketReplie;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketRepliePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the ticketReplie can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list ticketreplies');
    }

    /**
     * Determine whether the ticketReplie can view the model.
     */
    public function view(User $user, TicketReplie $model): bool
    {
        return $user->hasPermissionTo('view ticketreplies');
    }

    /**
     * Determine whether the ticketReplie can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create ticketreplies');
    }

    /**
     * Determine whether the ticketReplie can update the model.
     */
    public function update(User $user, TicketReplie $model): bool
    {
        return $user->hasPermissionTo('update ticketreplies');
    }

    /**
     * Determine whether the ticketReplie can delete the model.
     */
    public function delete(User $user, TicketReplie $model): bool
    {
        return $user->hasPermissionTo('delete ticketreplies');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete ticketreplies');
    }

    /**
     * Determine whether the ticketReplie can restore the model.
     */
    public function restore(User $user, TicketReplie $model): bool
    {
        return false;
    }

    /**
     * Determine whether the ticketReplie can permanently delete the model.
     */
    public function forceDelete(User $user, TicketReplie $model): bool
    {
        return false;
    }
}
