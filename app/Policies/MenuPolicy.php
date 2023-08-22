<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function view(User $user, Menu $menu)
    {
      return $user->checkRead($menu);
    }

    /**
     * Determine whether the user can create menus.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Menu $menu)
    {
      return $user->checkCreate($menu);
    }

    /**
     * Determine whether the user can update the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function update(User $user, Menu $menu)
    {
      return $user->checkUpdate($menu);
    }

    /**
     * Determine whether the user can delete the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function delete(User $user, Menu $menu)
    {
      return $user->checkDelete($menu);
    }
}
