<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Http\Requests\StorePropertyRequest;
use App\Models\Governorate;
use App\Models\Property;
use App\Models\TypeFinish;
use App\Models\TypePayment;
use App\Models\TypeProperty;
use Illuminate\Http\Request;
use App\Models\ListView;
use App\Services\PropertyService;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    protected $propertyService;
    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
        $this->middleware('auth')->except('show','getCities', 'index');
    }

    public function index(){
        $withs = ['images:id,source,property_id','des:id,title,property_id', 'typeProperty:id,name', 'view:id,name', 'finish:id,name', 'payment:id,name'];
        $properties = $this->propertyService->getAll([],$withs);

        return view('property.index',compact('properties'));
    }


    public function show($id){
        $property = $this->propertyService->findById($id);
        if(!$property){
            return redirect()->back()->with('fail',__('property.property_not_found'));
        }
        return view('property.show',compact(['property']));
    }

    /***
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $list_views = ListView::select(['id', 'name'])->get();
        $type_properties = TypeProperty::select(['id', 'name'])->get();
        $type_finishes  = TypeFinish::select(['id', 'name'])->get();
        $type_payments = TypePayment::select(['id', 'name'])->get();
        $govs = Governorate::select(['id', 'name'])->get();
        return view('property.create',compact(['list_views', 'type_finishes','type_properties', 'type_payments','govs']));
    }

    /***
     * @param PropertyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePropertyRequest $request){
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $this->propertyService->createProperty($data);
        return redirect()->back()->with('success_add',__('property.property_added_successfully!'));
    }

    public function edit($id){
        $property = Property::with('city','des','images')->findOrFail($id);
        $cities = @Governorate::find($property->city->governorate_id)->cities;
        $list_views = ListView::select(['id', 'name'])->get();
        $type_properties = TypeProperty::select(['id', 'name'])->get();
        $type_finishes  = TypeFinish::select(['id', 'name'])->get();
        $type_payments = TypePayment::select(['id', 'name'])->get();
        $govs = Governorate::select(['id', 'name'])->get();
        return view('property.edit',compact(['property','cities','list_views', 'type_finishes','type_properties', 'type_payments','govs']));
    }

    /***
     * @param PropertyRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StorePropertyRequest $request){
       $this->propertyService->updateProperty($request->id, $request->all());
       return redirect('user')->with('success_update',__('property.property_updated_successfully!'));
    }

    public function delete($id){
        $this->propertyService->deleteProperty($id);
        return back()->with(['message' => 'delete successfully !']);
    }



    ///////////////////////////////////////////////////////////////
    public function getCities(Request $request){
        $govs = Governorate::find($request->id);
        if(!$govs){
            return response()->json('mgs','not found');
        }
        return $govs->cities->map(function($city){
            return [
                'id' => $city->id,
                'name' => $city->name,
            ];
        });
    }

    public function favorite(Request $request){
        $property = Property::find($request->id);
        $property->toggleFavorite();
    }

}
