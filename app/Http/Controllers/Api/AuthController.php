<?php

namespace App\Http\Controllers\Api;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Traits\GeneralApiResponseTreat;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\PropertiesResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    use GeneralApiResponseTreat;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','forgot_password','register']]);
    }

    /*
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        try {
            //login
            $credentials = $request->only(['email','password']) ;

            if(!Auth::attempt($credentials))
                return $this->responseNotAuthenticated(__('data login is not correct'), 401);

            $user = User::find(Auth::id());
            $user->token = $user->createToken('User Token')->accessToken;
            //return token
            return $this ->responseSuccessData(['user' => $user],__('login successfully'));

        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }


    }


    public function register(Request $request) : JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string'
        ]);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            $user->token = $user->createToken('User Token')->accessToken;
            //return token
            return $this ->responseSuccessData(['user' => $user],__('register successfully'));
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }


    /*
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() : JsonResponse
    {
        $user = User::find(@Auth::guard('api')->user()->id);
        if ($user) {
            $user->tokens()->delete();
            return $this->responseSuccess(__('logout successfully'));
        }
        else {
            return $this->responseNotAuthenticated('you are not logged in !', 401);
        }

    }


    public function me() : JsonResponse
    {
        $user = User::find(Auth::id());
        $withs = ['images', 'des', 'typeProperty', 'view', 'finish', 'payment'];
        $properties = PropertiesResource::collection( Property::with($withs)->where('user_id',$user->id)->get());

        return $this->responseSuccessData(
            [
                'user' => $user,
                'properties' => $properties
            ]
        );
    }


    // Forget password Function
    public function forgot_password(Request $request) : JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->responseNotFound(__('email not found'), 404);
        }
        try {
            $response = Password::sendResetLink($request->only('email'));
            if ($response == Password::RESET_LINK_SENT) {
                return $this->responseSuccess(__('reset link sent successfully'));
            } else {
                return $this->responseError(__('failed to send reset link'), 400);
            }
        } catch (\Exception $ex) {
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }



    public function change_password(Request $request) : JsonResponse
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        try{
            $user = User::find(Auth::guard('api')->user()->id);
            if (!$user) {
                return $this->responseNotFound(__('user not found'), 404);
            }
            if(!Hash::check($request->old_password, $user->password)){
                return $this->responseError(__('old password is not correct'), 400);
            }
            if($request->old_password == $request->new_password){
                return $this->responseError(__('new password should not be same as old password'), 400);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            return $this->responseSuccess(__('password changed successfully'));
        }catch (\Exception $ex){
            return $this->responseError($ex->getMessage(), $ex->getCode());
        }
    }


    /**
     * @param $user_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function verify($user_id, Request $request) : JsonResponse | RedirectResponse{
        if (!$request->hasValidSignature()) {
            return $this->responseError("Invalid/Expired url provided.");
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->to('/');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend() : JsonResponse
    {
        $user = User::find(Auth::id());
        if ($user->hasVerifiedEmail()) {
            return $this->responseError("Email already verified.");
        }
        $user->sendEmailVerificationNotification();
        return $this->responseSuccess("Email verification link sent on your email.");
    }

}
