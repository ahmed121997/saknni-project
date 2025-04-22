<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasTranslations;
    protected $table = 'cities';
    protected $fillable = ['name','governorate_id'];
    public $translatable = ['name'];

    public function govs(){
        return $this->belongsTo('App\Models\Governorate','governorate_id','id');
    }
    public function property(){
        return $this->hasOne('App\Models\Property','city_id','id');
    }
}
