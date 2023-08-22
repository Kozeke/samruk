<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Templates;
use Illuminate\Auth\Access\HandlesAuthorization;

class TemplatesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the templates.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Templates  $templates
     * @return mixed
     */
    public function view(User $user, Templates $templates)
    {
      return $user->checkRead($templates);
    }

    /**
     * Determine whether the user can create templates.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->checkCreate(new Templates);
    }

    /**
     * Determine whether the user can update the templates.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Templates  $templates
     * @return mixed
     */
    public function update(User $user, Templates $templates)
    {
      return $user->checkUpdate($templates);
    }

    /**
     * Determine whether the user can delete the templates.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Templates  $templates
     * @return mixed
     */
    public function delete(User $user, Templates $templates)
    {
      return $user->checkDelete($templates);
    }
}
