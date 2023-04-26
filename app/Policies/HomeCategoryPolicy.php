<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HomeCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class HomeCategoryPolicy
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
        return $user->can('view_any_home::category');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HomeCategory  $homeCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, HomeCategory $homeCategory)
    {
        return $user->can('view_home::category');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_home::category');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HomeCategory  $homeCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, HomeCategory $homeCategory)
    {
        return $user->can('update_home::category');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HomeCategory  $homeCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, HomeCategory $homeCategory)
    {
        return $user->can('delete_home::category');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_home::category');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HomeCategory  $homeCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, HomeCategory $homeCategory)
    {
        return $user->can('force_delete_home::category');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_home::category');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HomeCategory  $homeCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, HomeCategory $homeCategory)
    {
        return $user->can('restore_home::category');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_home::category');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HomeCategory  $homeCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, HomeCategory $homeCategory)
    {
        return $user->can('replicate_home::category');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_home::category');
    }

}
