<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the sections.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Settings  $sections
     * @return mixed
     */
    public function view(User $user, Settings $settings)
    {
      return $user->checkRead($settings);
    }

    /**
     * Determine whether the user can create sections.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->checkCreate(new Settings);
    }

    /**
     * Determine whether the user can update the sections.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Settings  $sections
     * @return mixed
     */
    public function update(User $user, Settings $settings)
    {
      return $user->checkUpdate($settings);
    }

    /**
     * Determine whether the user can delete the sections.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Settings  $sections
     * @return mixed
     */
    public function delete(User $user, Settings $settings)
    {
      return $user->checkDelete($settings);
    }
}
