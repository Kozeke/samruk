<?php

namespace App\Policies;

use App\Models\User;
use App\Models\News;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the sections.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\News  $sections
     * @return mixed
     */
    public function view(User $user, News $news)
    {
      return $user->checkRead($news);
    }

    /**
     * Determine whether the user can create sections.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->checkCreate(new News);
    }

    /**
     * Determine whether the user can update the sections.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\News  $sections
     * @return mixed
     */
    public function update(User $user, News $news)
    {
      return $user->checkUpdate($news);
    }

    /**
     * Determine whether the user can delete the sections.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\News  $sections
     * @return mixed
     */
    public function delete(User $user, News $news)
    {
      return $user->checkDelete($news);
    }
}
