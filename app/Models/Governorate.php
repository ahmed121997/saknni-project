<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Governorate extends Model
{
    use HasTranslations;
    protected $table = 'governorates';
    protected $fillable = ['name'];
    public $translatable = ['name'];


    public function cities() : HasMany
    {
        return $this->hasMany('App\Models\City','governorate_id','id');
    }
}
