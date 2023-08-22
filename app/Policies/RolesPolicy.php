<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolesPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the roles.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Roles  $roles
     * @return mixed
     */
    public function view(User $user, Roles $roles)
    {
      return $user->checkRead($roles);
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->checkCreate(new Roles);
    }

    /**
     * Determine whether the user can update the roles.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Roles  $roles
     * @return mixed
     */
    public function update(User $user, Roles $roles)
    {
      return $user->checkUpdate($roles);
    }

    /**
     * Determine whether the user can delete the roles.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Roles  $roles
     * @return mixed
     */
    public function delete(User $user, Roles $roles)
    {
      return $user->checkDelete($roles);
    }
}
