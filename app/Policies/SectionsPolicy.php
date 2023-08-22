<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sections;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the sections.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sections  $sections
     * @return mixed
     */
    public function view(User $user, Sections $sections)
    {
      return $user->checkRead($sections);
    }

    /**
     * Determine whether the user can create sections.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Sections $sections)
    {
      return $user->checkCreate($sections);
    }

    /**
     * Determine whether the user can update the sections.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sections  $sections
     * @return mixed
     */
    public function update(User $user, Sections $sections)
    {
      return $user->checkUpdate($sections);
    }

    /**
     * Determine whether the user can delete the sections.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sections  $sections
     * @return mixed
     */
    public function delete(User $user, Sections $sections)
    {
      return $user->checkDelete($sections);
    }
}
