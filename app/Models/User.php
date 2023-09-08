<?php
    namespace App\Models;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasOne;
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

        /**
         * @var string
         */
        protected $modelName = __CLASS__;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        // protected $fillable = [
        //     'name', 'email', 'password', 'role_id', 'good', 'admin'
        // ];

        /**
         * @var array
         */
        protected $guarded = [];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
         * @return HasOne
         */
        public function role(): HasOne
        {
            return $this->hasOne('App\Models\Roles', 'id', 'role_id');
        }

        /**
         * @return HasOne
         */
        public function area(): HasOne
        {
            return $this->hasOne('App\Models\Areas', 'id', 'area_id');
        }

        /**
         * @return HasOne
         */
        public function profile(): HasOne
        {
            return $this->hasOne('App\Models\Profile', 'user_id', 'id');
        }

        /* Список обращений конкретного пользователя */
        /**
         * @return HasMany
         */
        public function treatments(): HasMany
        {
            return $this->hasMany('App\Models\Virtual', 'user_id', 'id');
        }

        /* Список обращений модератора */
        /**
         * @return HasMany
         */
        public function moderator_treatments(): HasMany
        {
            return $this->hasMany('App\Models\Virtual', 'moderator_id', 'id');
        }

        /**
         * @return string
         */
        public function getFioAttribute(): string
        {
            return $this->surname . ' ' . $this->name . ' ' . $this->patronymic;
        }

        /**
         * @param $pass
         * @return void
         */
        public function setPasswordAttribute($pass)
        {
            $this->attributes['password'] = \Hash::make($pass);
        }

        /**
         * @return array|string|string[]|null
         */
        public function routeNotificationForSmscru()
        {
            $new_mob = str_replace('+7', '8', $this->mobile);
            $patterns[0] = '/\s+/';
            $patterns[1] = '/[^a-zA-Z0-9 ]/m';
            return preg_replace($patterns, '', $new_mob);
        }

        /**
         * @return bool
         */
        public static function profileCheckWasMadeBeforeTwoMonths(): bool
        {
//        if (auth()->user()->last_profile_check_at < auth()->user()->created_at) {
//            $user = User::find(auth()->user()->id);
//            $user->last_profile_check_at = $user->created_at;
//            $user->save();
//        }
            if (is_null(auth()->user()->last_profile_check_at) && auth()->user()->last_profile_check_at < Carbon::now(
                )->subMonths(2)) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * @return HasMany
         */
        public function userConsentToDataCollection(): HasMany
        {
            return $this->hasMany('App\Models\UserConsentToDataCollection', 'user_id', 'id');
        }
    }
