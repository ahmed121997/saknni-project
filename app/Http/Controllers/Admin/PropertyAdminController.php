<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PropertyAdminController extends Controller
{



    public function property(){
        return view('admin.property.index');
    }

    public function propertyDatatable(Request $request){
        if ($request->ajax()) {
            $properties = Property::with(['des','typeProperty:id,name']);
            return DataTables::of($properties)
                ->addColumn('title', function ($property) {
                    return @$property->des->title;
                })
                ->addColumn('type', function ($property) {
                    return $property->typeProperty->name;
                })
                ->editColumn('area', function ($property) {
                    return $property->area . " m²";
                })
                ->editColumn('price', function ($property) {
                    return $property->price . " EGP";
                })
                ->addColumn('status', function ($property) {
                    return view('admin.__datatable.property_status', ['property' => $property]);
                })
                ->addColumn('special', function ($property) {
                    return view('admin.__datatable.property_special', ['property' => $property]);
                })->make(true);
        }
        return response()->json(['error' => 'Invalid request'], 400);
    }


    public function verify_property(Request $request){
        $res = Property::find($request->id);
        if(!$res){
            return response('false',401);
        }
        $res->status = 1;
        $res->save();
        return response('true',200);
    }

    public function update_special_property(Request $request){
        $res = Property::find($request->id);
        if(!$res){
            return response('false',401);
        }
        $res->is_special = $request->is_special ? 1 : 0;
        $res->save();
        return response('true',200);
    }

}
