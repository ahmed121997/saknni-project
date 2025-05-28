<?php

namespace App\Http\Controllers\Api;

use App\Models\DescriptionProperty;
use App\Models\Governorate;
use App\Models\Image;
use App\Models\ListView;
use App\Models\Property;
use App\Models\TypeFinish;
use App\Models\TypePayment;
use App\Models\TypeProperty;
use App\Traits\GeneralApiResponseTreat;
use App\Traits\SaveImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Resources\PropertiesResource;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    protected $propertyService;
    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
        $this->middleware('auth:api')->except(['show','getCities','index','allSpecial']);
    }

    // traits
    use GeneralApiResponseTreat;
    use SaveImages;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse|AnonymousResourceCollection {
        try {
            $withs = ['images:id,source,property_id','des:id,title,property_id', 'typeProperty:id,name', 'view:id,name', 'finish:id,name', 'payment:id,name'];
            $properties = $this->propertyService->getAll([],$withs);
            return PropertiesResource::collection($properties);
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse| PropertiesResource {
        try {
            $property = $this->propertyService->findById($id);
            if(!$property)
                return $this->responseNotFound(__('property.property_not_found'));
            return new PropertiesResource($property);
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(): JsonResponse {
        $list_views = ListView::select('id', 'name')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        });
        $type_properties = TypeProperty::select('id', 'name')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        });
        $type_finishes  = TypeFinish::select('id', 'name')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        });
        $type_payments = TypePayment::select('id', 'name')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        });
        $govs = Governorate::select('id', 'name')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        });

        return $this->responseSuccessData([
            'list_views' => $list_views,
            'type_finish' => $type_finishes,
            'type_property' => $type_properties,
            'type_payment' => $type_payments,
            'govs' => $govs,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // store property
    public function store(StorePropertyRequest $request) : JsonResponse {

        try {
            $property = $this->propertyService->createProperty($request->all());
            return $this->responseSuccess(__('property.property_added_successfully!'));
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // update property
    public function update(StorePropertyRequest $request, $id): JsonResponse {
        try {
            $property = Property::find($id);
            if (!$property)
                return $this->responseNotFound(__('property not found'));

            $this->propertyService->updateProperty($id, $request->all());
            return $this->responseSuccess(__('property.update_successfully!'));
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id): JsonResponse {
        try {
            $user = Auth::guard('api')->user();
            $property = Property::where('user_id', $user->id)->find($id);
            if (!$property)
                return $this->responseNotFound(__('property not found'));

            $this->propertyService->deleteProperty($id);
            return $this->responseSuccess(__('property deleted successfully!'));
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }


    public function allSpecial() : AnonymousResourceCollection| JsonResponse {
        try {
            $withs = ['images','des', 'typeProperty:id,name', 'view:id,name', 'finish:id,name', 'payment:id,name','user'];
            $properties = Property::with($withs)->where('is_special', '=',1)->orderByDesc('created_at')->paginate(20);
            return PropertiesResource::collection($properties);
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * Get all governorates
     * This method retrieves all governorates from the database and returns them in a JSON response.
     * @throws \Exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGovs() : JsonResponse {
        try {
            $govs = Governorate::select('id', 'name')->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                ];
            });
            return $this->responseSuccessData([
                'govs' => $govs,
            ]);
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    // get cities by id gov
    public function getCities(Request $request, $id) : JsonResponse {
        try {
            $gov = Governorate::find($id);
            if (!$gov)
                return $this->responseNotFound(__('Governorate not found'));
            $cities = $gov->cities()->select('id', 'name')->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                ];
            });
            return $this->responseSuccessData([
                'cities' => $cities,
            ]);
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }

}
