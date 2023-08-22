<?php

namespace App\Policies;

use App\Models\{User, Gb};
use Illuminate\Auth\Access\HandlesAuthorization;

class GbPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the gb.
     *
     * @param  \App\Models\User  $user
     * @param  \App\odel=Models\Gb  $gb
     * @return mixed
     */
    public function view(User $user, Gb $gb)
    {
      return $user->checkRead($gb);
    }

    /**
     * Determine whether the user can create gbs.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->checkCreate(new Gb);
    }

    /**
     * Determine whether the user can update the gb.
     *
     * @param  \App\Models\User  $user
     * @param  \App\odel=Models\Gb  $gb
     * @return mixed
     */
    public function update(User $user, Gb $gb)
    {
      return $user->checkUpdate($gb);
    }

    /**
     * Determine whether the user can delete the gb.
     *
     * @param  \App\Models\User  $user
     * @param  \App\odel=Models\Gb  $gb
     * @return mixed
     */
    public function delete(User $user, Gb $gb)
    {
      return $user->checkDelete($gb);
    }
}
