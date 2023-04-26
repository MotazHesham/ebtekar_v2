<?php

namespace App\Policies;

use App\Models\User;
use App\Models\QualityResponsible;
use Illuminate\Auth\Access\HandlesAuthorization;

class QualityResponsiblePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_quality::responsible');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QualityResponsible  $qualityResponsible
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, QualityResponsible $qualityResponsible)
    {
        return $user->can('view_quality::responsible');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_quality::responsible');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QualityResponsible  $qualityResponsible
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, QualityResponsible $qualityResponsible)
    {
        return $user->can('update_quality::responsible');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QualityResponsible  $qualityResponsible
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, QualityResponsible $qualityResponsible)
    {
        return $user->can('delete_quality::responsible');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_quality::responsible');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QualityResponsible  $qualityResponsible
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, QualityResponsible $qualityResponsible)
    {
        return $user->can('force_delete_quality::responsible');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_quality::responsible');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QualityResponsible  $qualityResponsible
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, QualityResponsible $qualityResponsible)
    {
        return $user->can('restore_quality::responsible');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_quality::responsible');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QualityResponsible  $qualityResponsible
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, QualityResponsible $qualityResponsible)
    {
        return $user->can('replicate_quality::responsible');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_quality::responsible');
    }

}
