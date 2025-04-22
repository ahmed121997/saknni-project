<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Translatable\HasTranslations;

class TypeProperty extends Model
{
    use HasTranslations;
    protected $table = 'type_properties';
    protected $fillable = ['name'];
    protected $translatable = ['name'];

    public function property() : HasOne
    {
        return $this->hasOne('App\Models\Property','type_property_id','id');
    }
}
