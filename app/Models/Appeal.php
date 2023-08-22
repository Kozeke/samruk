<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Appeal
 * @package App\Models
 *
 * @author Kozy-Korpesh Tolep
 */
class Appeal extends Model
{

    protected $table = "appeal_templates";

    /**
     * @var int[]
     */
    const STATUS = [
        'PRINT' => self::STATUS_PRINT,
        'VIEW' => self::STATUS_VIEW,
        'EDIT' => self::STATUS_EDIT
    ];

    /**
     * @var int
     */
    const STATUS_PRINT = 2;

    /**
     * @var int
     */
    const STATUS_VIEW = 0;

    /**
     * @var int
     */
    const STATUS_EDIT = 1;

}
