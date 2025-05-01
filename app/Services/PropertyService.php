<?php
namespace App\Services;

use App\Models\Property;
use App\Repositories\Interfaces\PropertyRepositoryInterface;

class PropertyService
{
    protected $propertyRepository;
    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function getAll($filters = [], $withs = [])
    {
        return Property::with($withs)->filter($filters)->paginate(env('PAGINATION_COUNT', 20));
    }
    public function findById($id)
    {
        return Property::with(['images', 'des', 'typeProperty', 'view', 'finish', 'payment', 'user', 'comments'])->find($id);
    }

    public function createProperty($data)
    {
        $property = Property::create($data);
        $property->des()->create([
            'title' => $data['title'],
            'details' => $data['details'],
        ]);
        if(isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $nameFile = $image->getClientOriginalName();
                $name = time().$nameFile;
                $image->move(public_path().'/images/properties/', $name);
                $path = '/images/properties/'.$name;
                $property->images()->create([
                    'source' => $path,
                ]);
            }
        }
        return $property;
    }
    public function updateProperty($id, $data)
    {
        $property = Property::find($id);
        if ($property) {
            $property->update($data);
            if (isset($data['title']) && isset($data['details'])) {
                $property->des()->update([
                    'title' => $data['title'],
                    'details' => $data['details'],
                ]);
            }
            if (isset($data['images'])) {
                // Upload new images
                foreach ($data['images'] as $image) {
                    $nameFile = $image->getClientOriginalName();
                    $name = time().$nameFile;
                    $image->move(public_path().'/images/properties/', $name);
                    $path = '/images/properties/'.$name;
                    $property->images()->create([
                        'source' => $path,
                    ]);
                }
            }
            return $property;

        }
        return null;
    }
    public function deleteProperty($id)
    {
        $property = Property::find($id);
        if ($property) {
            // Delete associated images
            foreach ($property->images as $image) {
                if (file_exists(public_path($image->source))) {
                    unlink(public_path($image->source));
                }
                $image->delete();
            }
            // Delete associated description
            $property->des()->delete();
            // Delete the property itself
            $property->comments()->delete();
            $property->delete();
            return true;
        }
        return false;
    }
}
