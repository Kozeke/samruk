<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\UserTrait;
use App\Traits\ModelTrait;

/**
 * @property mixed $mobile
 */

class User extends Authenticatable
{
    use Notifiable, UserTrait, ModelTrait;

    protected $modelName = __CLASS__;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password', 'role_id', 'good', 'admin'
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role ()
    {
        return $this->hasOne('App\Models\Roles', 'id', 'role_id');
    }

    public function area ()
    {
        return $this->hasOne('App\Models\Areas', 'id', 'area_id');
    }

    public function profile ()
    {
        return $this->hasOne('App\Models\Profile', 'user_id', 'id');
    }

    /* Список обращений конкретного пользователя */
    public function treatments ()
    {
      return $this->hasMany('App\Models\Virtual', 'user_id', 'id');
    }

    /* Список обращений модератора */
    public function moderator_treatments ()
    {
      return $this->hasMany('App\Models\Virtual', 'moderator_id', 'id');
    }

    public function getFioAttribute()
    {
        return $this->surname . ' ' . $this->name . ' ' .$this->patronymic;
    }

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = \Hash::make($pass);
    }

    public function routeNotificationForSmscru()
    {
        $new_mob = str_replace('+7','8', $this->mobile);
        $patterns[0] = '/\s+/';
        $patterns[1] = '/[^a-zA-Z0-9 ]/m';
        return preg_replace($patterns, '', $new_mob);
    }

    public static function profileCheckWasMadeBeforeTwoMonths(): bool
    {
        if (auth()->user()->last_profile_check_at < auth()->user()->created_at) {
            $user = User::find(auth()->user()->id);
            $user->last_profile_check_at = $user->created_at;
            $user->save();
        }
        if (auth()->user()->last_profile_check_at > Carbon::now()->subMonths(2)) {
            return false;
        } else {
            return true;
        }
    }
}
