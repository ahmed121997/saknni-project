<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Image;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['adminLogin','adminCheck']);
    }
    public function username(){
        return 'email';
    }


    public function dashboard(){
        $now = now();
        $user_count = User::count();

        // Active users seen within the last 2 minutes
        $user_active = User::whereBetween('last_seen', [$now->subMinutes(2), $now])->count();

        $property_count = Property::count();

        // Properties that are not active
        $not_active = Property::where('status', 0)->count();

        // Count of images in storage
        $count_images = Image::count();

        // Data for charts
        $months = [];
        $users = [];
        $properties = [];
        $max_month = 6;
        $start = now()->startOfMonth()->subMonths($max_month - 1);

        for ($i = 0; $i < $max_month; $i++) {
            $end = $start->copy()->endOfMonth();
            $month_name = $start->format('F');

            $users[$month_name] = User::whereBetween('created_at', [$start, $end])->count();
            $properties[$month_name] = Property::whereBetween('created_at', [$start, $end])->count();
            $months[] = $month_name;

            $start->addMonth();
        }
        return view('admin.dashboard',compact(['user_count','property_count','not_active','months','users','properties','user_active','count_images']));
    }


    /**
     * user profile
     */
    public function user(){
        $users = User::select()->paginate(ENV('PAGINATION_COUNT','20'));
        return view('admin.user',compact(['users']));
    }

    public function userDatatable(Request $request){
        if ($request->ajax()) {
            $users = User::select();
            return DataTables::of($users)
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('Y-m-d H:i:s');
                })
                ->editColumn('updated_at', function ($user) {
                    return $user->updated_at->format('Y-m-d H:i:s');
                })
                ->addColumn('status', function ($user) {
                    return view('admin.__datatable.user_status', ['user' => $user]);
                })
                ->addColumn('last_seen', function ($user) {
                    return view('admin.__datatable.user_last_seen', ['user' => $user]);
                })
                ->rawColumns(['status', 'last_seen'])
                ->make(true);
        }
        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function property(){
        return view('admin.property');
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

    public function adminLogin(){
        return view('admin.login');
    }
    public function adminCheck(Request $request){
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/admin');
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'password' => __('auth.password'),
            ]);

    }

    public function logout(Request $request)
    {

        Auth::logout();
        return redirect('/');
    }




    /**
     * profile admin
     *
     */

     public function profile(){
        return view('admin.profile.admin');
     }
     public function profile_edit(){
        $user = Auth::guard('admin')->user();
        return view('admin.profile.edit',compact('user'));
     }

     public function profile_update(Request $request,$id){
        $res = Admin::findorfail($id);
        if($res->email == $request->email){
            $validator  = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone' => 'digits_between:11,20',
            ]);
        }else{
            $validator  = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => 'digits_between:11,20'
            ]);
        }
        if($validator->passes()) {
            $res->update($request->all());
            return redirect()->route('admin.profile')->with('success_update','data is updated successfully');
        }
        return redirect()->back()->withErrors($validator)->withInput($request->all());
    }



    public function verify_user(Request $request){
        $res = User::find($request->id);
        if(!$res){
            return response('false',401);
        }
        $res->update(['email_verified_at' => now(),]);
        $res->save();
        return response('true',200);
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
