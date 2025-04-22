<?php
namespace App\Repositories;
use App\Models\Property;
use App\Repositories\Interfaces\PropertyRepositoryInterface;

class PropertyRepository implements PropertyRepositoryInterface
{
    public function all($request){
        $properties = Property::with(['images','des','typeProperty','view','finish','payment','city'])
        ->paginate(env('PAGINATION_COUNT','20'));
        return $properties;
    }
    public function find($id){
        $property = Property::with(['images','des','typeProperty','view','finish','payment','city'])
        ->find($id);
        return $property;
    }
    public function create($data){
        $property = Property::create($data);
        return $property;
    }
    public function update($id, $data){
        $property = Property::find($id);
        if(!$property){
            return null;
        }
        $property->update($data);
        return $property;
    }
    public function delete($id){
        $property = Property::find($id);
        if(!$property){
            return null;
        }
        $property->delete();
        return $property;
    }
}
