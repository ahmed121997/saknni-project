<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Translatable\HasTranslations;

class TypePayment extends Model
{
    use HasTranslations;
    protected $table = 'type_payments';
    protected $fillable = ['name'];
    public $translatable = ['name'];

    public function property(): HasOne
    {
        return $this->hasOne('App\Models\Property','type_payment_id','id');
    }
}
