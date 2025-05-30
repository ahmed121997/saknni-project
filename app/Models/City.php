<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasTranslations;
    protected $table = 'cities';
    protected $fillable = ['name','governorate_id'];
    public $translatable = ['name'];

    public function governorate() : BelongsTo
    {
        return $this->belongsTo('App\Models\Governorate','governorate_id','id');
    }
    public function property() : HasOne
    {
        return $this->hasOne('App\Models\Property','city_id','id');
    }
}
