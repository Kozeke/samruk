<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;

class Sections extends Model
{
    use ModelTrait;

    protected $table = 'sections';

    protected $modelName = __CLASS__;

    protected $fillable = [
        'name_ru', 'type', 'template', 'good', 'menu', 'col', 'parent_id', 'alias'
    ];

    protected $lang = null;

    public function __construct()
    {
        $this->lang = LaravelLocalization::getCurrentLocale();
    }

    public function children()
    {
        return $this->hasMany('App\Models\Sections', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Sections::class, 'parent_id', 'id');
    }

    public function parents()
    {
        return $this->hasMany('App\Models\Sections', 'id', 'parent_id');
    }

    public function current_template()
    {
        return $this->hasOne('App\Models\Templates', 'id', 'template');
    }

    public function templates()
    {
        return $this->hasMany('App\Models\Templates', 'template', 'type');
    }

    public function rubrics()
    {
        return $this->hasMany('App\Models\Rubrics', 'section_id', 'id');
    }

    public function galleries()
    {
        return $this->hasMany('App\Models\Galleries', 'section_id', 'id');
    }

    public function services()
    {
        return $this->hasMany('App\Models\Services', 'section_id', 'id');
    }

    public function page()
    {
        return $this->hasOne('App\Models\Pages', 'section_id', 'id');
    }

    public function configuration()
    {
        return $this->hasOne('App\Models\Configuration', 'section_id', 'id');
    }

    public function news()
    {
        return $this->hasMany('App\Models\News', 'section_id', 'id');
    }

    public function objects()
    {
        return $this->hasMany(Objects::class, 'section_id', 'id');
    }

    public function links()
    {
        return $this->hasMany('App\Models\Links', 'section_id', 'id');
    }

    public function gb()
    {
        return $this->hasMany(Gb::class, 'section_id', 'id');
    }

    public function calculator()
    {
        return $this->hasMany('App\Models\CalculatorComplex', 'section_id', 'id');
    }

    public function polls()
    {
        return $this->hasMany(Polls::class, 'section_id', 'id');
    }

    public function getNameAttribute($value, $lang = null)
    {
        $name = (!is_null($lang)) ? $lang : $this->lang;

        return ($this->{'name_' . $name}) ? $this->{'name_' . $name} : $this->name_ru;
    }

    public function getPathAttribute($value, $lang = null)
    {
        return '/' . $this->lang . '/' . $this->type . '/' . $this->alias;
    }

}
