<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Galleries;
use Illuminate\Auth\Access\HandlesAuthorization;

class GalleriesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the galleries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Galleries  $galleries
     * @return mixed
     */
    public function view(User $user, Galleries $galleries)
    {
      return $user->checkRead($galleries);
    }

    /**
     * Determine whether the user can create galleries.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->checkCreate(new Galleries);
    }

    /**
     * Determine whether the user can update the galleries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Galleries  $galleries
     * @return mixed
     */
    public function update(User $user, Galleries $galleries)
    {
        return $user->checkUpdate($galleries);
    }

    /**
     * Determine whether the user can delete the galleries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Galleries  $galleries
     * @return mixed
     */
    public function delete(User $user, Galleries $galleries)
    {
        return $user->checkDelete($galleries);
    }
}
