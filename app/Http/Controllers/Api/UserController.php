<?php

namespace App\Http\Controllers\Api;
use App\Traits\GeneralApiResponseTreat;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function __construct(){
        $this->middleware('auth:api');
    }
    //
    use GeneralApiResponseTreat;
    public function update(Request $request) : JsonResponse
    {
        $user = User::find(Auth::id());
        if(!$user){
            return $this->responseNotFound(__('user not found !'));
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'digits_between:11,20'
        ]);
        try{
            $user->update($request->only(['name','email','phone']));
            return $this->responseSuccessData(['user' => $user],__('user data is updated'));
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }
}
