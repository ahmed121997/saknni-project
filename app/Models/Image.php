<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{

    protected $table = 'images';
    protected $fillable = ['id','source', 'type','property_id'];
    protected $appends = ['url'];
    public function property() : BelongsTo
    {
        return $this->belongsTo('App\Models\Property','property_id','id');
    }
    public function getUrlAttribute() : string
    {
        return asset( $this->source);
    }

    //boot
    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($model) {
            if (file_exists(public_path($model->source))) {
                unlink(public_path($model->source));
            }
        });
    }
}
