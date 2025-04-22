<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $table = 'images';
    protected $fillable = ['id','source', 'type','property_id'];

    public function property(){
        return $this->belongsTo('App\Models\Property','property_id','id');
    }
}
