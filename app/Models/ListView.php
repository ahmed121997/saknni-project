<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ListView extends Model
{
    use HasTranslations;
    protected $table = 'list_views';
    protected $fillable = ['name'];
    public $translatable = ['name'];

    public function property(){
        return $this->hasOne('App\Models\Property','list_view_id','id');
    }
}
