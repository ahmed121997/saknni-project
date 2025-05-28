<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertiesResource;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Traits\GeneralApiResponseTreat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SearchController extends Controller
{
    use GeneralApiResponseTreat;

    public function mainSearch(Request $request) : AnonymousResourceCollection|JsonResponse
    {
        try{
            $withs = ['images','des', 'typeProperty', 'view', 'finish', 'payment','user'];
            $properties = Property::filter([
                    'city_id' => $request->city,
                    'type_property_id' => $request->type_property,
                    'type_finish_id' => $request->type_finish,
                    'type_payment_id' => $request->type_pay,
                    'list_section' => $request->sell_rent,
                    'min_price' => $request->min_price,
                    'max_price' => $request->max_price,
                    'min_area' => $request->min_area,
                    'max_area' => $request->max_area,
                    'type_rent' => $request->daily_monthly,
                ])->with($withs)->get();
            return PropertiesResource::collection($properties);
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }

    }



}
