<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Services;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServecesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the rubrics.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Services  $services
     * @return mixed
     */
    public function view(User $user, Services $services)
    {
      return $user->checkRead($services);
    }

    /**
     * Determine whether the user can create rubrics.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->checkCreate(new Services);
    }

    /**
     * Determine whether the user can update the rubrics.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Services  $services
     * @return mixed
     */
    public function update(User $user, Services $services)
    {
      return $user->checkUpdate($services);
    }

    /**
     * Determine whether the user can delete the rubrics.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Services  $services
     * @return mixed
     */
    public function delete(User $user, Services $services)
    {
      return $user->checkDelete($services);
    }
}
