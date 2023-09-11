<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppealHistory extends Model
{
    protected $table = "appeal_history";

    const STATUS_DONE = "Выполнено";
    const STATUS_SENT = "Отправлено";
    const STATUS_DRAFT = "Черновик";

    protected $modelName = __CLASS__;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'link',
        'status',
        'reply',
        'user_id',
        'cms_pdf',
        'base_pdf'
    ];
}
