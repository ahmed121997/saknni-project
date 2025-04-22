<?php
namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use App\Models\Governorate;
use App\Models\Property;
use App\Models\TypePayment;
use App\Models\TypeProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
class WelcomeController extends Controller
{
    //
    public function index(){
        $type_properties = TypeProperty::select(['id', 'name'])->get();
        $type_payments = TypePayment::select(['id', 'name'])->get();
        $govs = Governorate::select(['id', 'name'])->get();


        // return 6 special property
        $withs = ['images','des', 'typeProperty:id,name', 'view:id,name', 'finish:id,name', 'payment:id,name','user'];
        $properties = Property::with($withs)->where('is_special', '=',1)->limit(6)->orderByDesc('created_at')->get();

        return view('welcome',compact(['properties','type_properties','type_payments','govs']));
    }


    /***
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allSpecial(){
        // return 3 special property
        $withs = ['images','des', 'typeProperty:id,name', 'view:id,name', 'finish:id,name', 'payment:id,name','user'];
        $properties = Property::with($withs)->where('is_special', '=',1)->orderByDesc('created_at')->paginate(20);
        return view('property.allSpecial',compact('properties'));
    }


    public function lang(Request $request, $locale){
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
