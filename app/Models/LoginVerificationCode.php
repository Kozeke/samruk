<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $user_id
 * @property mixed $otp
 */

class LoginVerificationCode extends Model
{
    use ModelTrait;

    protected $table = 'login_verification_code';

    protected $fillable = ["user_id", "otp", "expire_at"];

}
