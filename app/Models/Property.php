<?php

namespace App\Models;

use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use Favoriteable;
    protected $table = 'properties';

    protected $fillable = [
        'user_id','type_property_id', 'list_section','type_rent',
        'area', 'list_view_id', 'num_floor','num_rooms', 'num_bathroom',
        'type_finish_id', 'governorate_id','city_id', 'location', 'des_property_id',
        'type_payment_id', 'price', 'link_youtube','status','trans_payment_id', 'is_special',
    ];
    protected $casts = [
        'is_special' => 'boolean',
        'status' => 'boolean',
    ];
########################### Relation with Property Model ########################
    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function des(){
        return $this->hasOne('App\Models\DescriptionProperty','property_id','id');
    }
    public function images(){
        return $this->HasMany('App\Models\Image', 'property_id','id');
    }
    public function typeProperty(){
        return $this->belongsTo('App\Models\TypeProperty','type_property_id','id');
    }

    public function view(){
        return $this->belongsTo('App\Models\ListView','list_view_id','id');
    }
    public function finish(){
        return $this->belongsTo('App\Models\TypeFinish','type_finish_id','id');
    }
    public function payment(){
        return $this->belongsTo('App\Models\TypePayment','type_payment_id','id');
    }
    public function governorate(){
        return $this->belongsTo('App\Models\Governorate','governorate_id','id');
    }
    public function city(){
        return $this->belongsTo('App\Models\City','city_id','id');
    }
    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->whereNull('parent_id');
    }
    ###########################  End Relation with Property Model ########################

    public function scopeActive($q, $id)
    {
        return $q->where('id',$id)->update(['status' => 1]);
    }

    public function scopeFilter($query, $filters)
    {
        return $query->when($filters['type_property_id'] ?? false, function ($query, $type_property_id) {
            return $query->where('type_property_id', $type_property_id);
        })->when($filters['type_rent'] ?? false, function ($query, $type_rent) {
            return $query->where('type_rent', $type_rent);
        })->when($filters['city_id'] ?? false, function ($query, $city_id) {
            return $query->where('city_id', $city_id);
        })->when($filters['list_view_id'] ?? false, function ($query, $list_view_id) {
            return $query->where('list_view_id', $list_view_id);
        })->when($filters['type_finish_id'] ?? false, function ($query, $type_finish_id) {
            return $query->where('type_finish_id', $type_finish_id);
        })->when($filters['type_payment_id'] ?? false, function ($query, $type_payment_id) {
            return $query->where('type_payment_id', $type_payment_id);
        })->when($filters['price'] ?? false, function ($query, $price) {
            return $query->where('price', $price);
        })->when($filters['area'] ?? false, function ($query, $area) {
            return $query->where('area', $area);
        })->when($filters['num_floor'] ?? false, function ($query, $num_floor) {
            return $query->where('num_floor', $num_floor);
        })->when($filters['num_rooms'] ?? false, function ($query, $num_rooms) {
            return $query->where('num_rooms', $num_rooms);
        })->when($filters['num_bathroom'] ?? false, function ($query, $num_bathroom) {
            return $query->where('num_bathroom', $num_bathroom);
        })->when($filters['location'] ?? false, function ($query, $location) {
            return $query->where('location', 'like', '%' . $location . '%');
        })->when($filters['is_special'] ?? false, function ($query, $is_special) {
            return $query->where('is_special', 1);
        })->when($filters['list_section'] ?? false, function ($query, $trans_payment_id) {
            return $query->where('list_section', $trans_payment_id);
        })->when($filters['min_price'] ?? false, function ($query, $min_price) {
            return $query->where('price', '>=', $min_price);
        })->when($filters['max_price'] ?? false, function ($query, $max_price) {
            return $query->where('price', '<=', $max_price);
        })->when($filters['min_area'] ?? false, function ($query, $min_area) {
            return $query->where('area', '>=', $min_area);
        })->when($filters['max_area'] ?? false, function ($query, $max_area) {
            return $query->where('area', '<=', $max_area);
        });
    }

}
