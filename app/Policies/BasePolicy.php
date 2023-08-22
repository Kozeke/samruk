<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
     public function before($user, $ability)
     {
         if ($user->role->name == 'admin') {
             return true;
         }
     }
}
