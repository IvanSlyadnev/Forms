<?php

namespace App\Policies;

use App\Models\Form;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Form  $form
     * @return mixed
     */
    public function view(User $user, Form $form)
    {
        return $user->id == $form->user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Form  $form
     * @return mixed
     */
    public function update(User $user, Form $form)
    {
        return $user->id == $form->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Form  $form
     * @return mixed
     */
    public function delete(User $user, Form $form)
    {
        return $user->id == $form->user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Form  $form
     * @return mixed
     */
    public function forceDelete(User $user, Form $form)
    {
        //
    }

    public function viewAnyQuestion(User  $user, Form $form) {
        return $user->id == $form->user_id;
    }

    public function createQuestion(User  $user, Form $form) {
        return $user->id == $form->user_id;
    }

    public function fill(?User $user, Form $form) {
        if (!$form->is_public && $user == null) return false;
        return true;
    }
}
