<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Areas;
use Illuminate\Auth\Access\HandlesAuthorization;

class AreasPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the areas.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Areas  $areas
     * @return mixed
     */
    public function view(User $user, Areas $areas)
    {
        return $user->checkRead($areas);
    }

    /**
     * Determine whether the user can create areas.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->checkCreate(new Areas);
    }

    /**
     * Determine whether the user can update the areas.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Areas  $areas
     * @return mixed
     */
    public function update(User $user, Areas $areas)
    {
        return $user->checkUpdate($areas);
    }

    /**
     * Determine whether the user can delete the areas.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\Areas  $areas
     * @return mixed
     */
    public function delete(User $user, Areas $areas)
    {
        return $user->checkDelete($areas);
    }
}
