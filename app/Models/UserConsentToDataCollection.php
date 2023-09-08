<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string $base64
 * @property string $cmsSign
 * @property int $user_id
 */
class UserConsentToDataCollection extends Model
{
    protected $table = "user_consent_to_data_collection";


}
