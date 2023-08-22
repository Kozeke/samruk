<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Langs;
use Illuminate\Auth\Access\HandlesAuthorization;

class LangsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the langs.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Langs  $langs
     * @return mixed
     */
    public function view(User $user, Langs $langs)
    {
      return $user->checkRead($langs);
    }

    /**
     * Determine whether the user can create langs.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->checkCreate(new Langs);
    }

    /**
     * Determine whether the user can update the langs.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Langs  $langs
     * @return mixed
     */
    public function update(User $user, Langs $langs)
    {
      return $user->checkUpdate($langs);
    }

    /**
     * Determine whether the user can delete the langs.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Langs  $langs
     * @return mixed
     */
    public function delete(User $user, Langs $langs)
    {
      return $user->checkDelete($langs);
    }
}
