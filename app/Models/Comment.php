<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'comments';
    protected $fillable = ['user_id', 'property_id', 'parent_id', 'body'];

    /*
     * The belongs to Relationship
     *
     * @var array
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    /*
     * The has Many Relationship
     *
     * @var array
     */
    public function replies() : HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
