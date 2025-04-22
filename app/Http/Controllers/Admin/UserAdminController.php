<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserAdminController extends Controller
{

    /**
     * user profile
     */
    public function user(){
        $users = User::select()->paginate(ENV('PAGINATION_COUNT','20'));
        return view('admin.user.index',compact(['users']));
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

    public function verify_user(Request $request){
        $res = User::find($request->id);
        if(!$res){
            return response('false',401);
        }
        $res->update(['email_verified_at' => now(),]);
        $res->save();
        return response('true',200);
    }


}
