<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use App\Models\ListView;
use App\Models\Property;
use App\Models\City;
use App\Models\TypeFinish;
use App\Models\TypePayment;
use App\Models\TypeProperty;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(){
        $list_views = ListView::select(['id', 'name'])->get();
        $type_properties = TypeProperty::select(['id', 'name'])->get();
        $type_finishes  = TypeFinish::select(['id', 'name'])->get();
        $type_payments = TypePayment::select(['id', 'name'])->get();
        $govs = Governorate::select(['id', 'name'])->get();
        return view('search.search',compact(['list_views', 'type_finishes','type_properties', 'type_payments','govs']));
    }

    public function process(Request $request)
    {
        $city = $request->city;
        $type = $request->type_property;
        $finish = $request->type_finish;
        $pay = $request->type_payment;

        $withs = ['images','des', 'typeProperty', 'view', 'finish', 'payment','user'];
        $properties = Property::filter([
            'city_id' => $city,
            'type_property_id' => $type,
            'type_finish_id' => $finish,
            'type_payment_id' => $pay,
        ])->with($withs)->get();
        $html = view('search.search_result', compact('properties'))->render();
        return response()->json(['html' => $html]);
    }
    public function mainSearch(Request $request){

        $type_properties = TypeProperty::select(['id', 'name'])->get();
        $type_payments = TypePayment::select(['id', 'name'])->get();
        $govs = Governorate::select(['id', 'name'])->get();

        $sell_rent = $request->sell_rent;
        $city_name =$request->city ? @City::find($request->city)->name : null;

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
        return view('search.mainSearch',compact(['properties','sell_rent','city_name','type_properties','type_payments','govs']));
    }

}
