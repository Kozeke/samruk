<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rubrics;
use Illuminate\Auth\Access\HandlesAuthorization;

class RubricsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the rubrics.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Rubrics  $rubrics
     * @return mixed
     */
    public function view(User $user, Rubrics $rubrics)
    {
      return $user->checkRead($rubrics);
    }

    /**
     * Determine whether the user can create rubrics.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->checkCreate(new Rubrics);
    }

    /**
     * Determine whether the user can update the rubrics.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Rubrics  $rubrics
     * @return mixed
     */
    public function update(User $user, Rubrics $rubrics)
    {
      return $user->checkUpdate($rubrics);
    }

    /**
     * Determine whether the user can delete the rubrics.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Rubrics  $rubrics
     * @return mixed
     */
    public function delete(User $user, Rubrics $rubrics)
    {
      return $user->checkDelete($rubrics);
    }
}
