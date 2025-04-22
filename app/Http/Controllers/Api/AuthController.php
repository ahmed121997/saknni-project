<?php

namespace App\Http\Controllers\Api;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Traits\GeneralApiTreat;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    use GeneralApiTreat;
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

        try {
            $rules = [
                "email" => "required",
                "password" => "required"

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //login
            $credentials = $request->only(['email','password']) ;

            if(!Auth::attempt($credentials))
                return $this->responseError('E001',__('data login is not correct'));

            $user = User::find(Auth::id());
            $user->token = $user->createToken('User Token')->accessToken;
            //return token
            return $this -> responseWithData('user' , $user,__('success send data'));

        }catch (\Exception $ex){
            return $this->responseError($ex->getCode(), $ex->getMessage());
        }


    }


    public function register(Request $request)
    {
        try {
            $rules = [
                "name" => "required",
                "email" => "required",
                "password" => "required",
                "phone" => "required"
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            $user->token = $user->createToken('User Token')->accessToken;
            //return token
            return $this -> responseWithData('user' , $user,__('success send data'));
        }catch (\Exception $ex){
            return $this->responseError($ex->getCode(), $ex->getMessage());
        }
    }


    /*
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = User::find(Auth::guard('api')->user()->id);
        if ($user) {
            $user->tokens()->delete();
            return $this->responseSuccess('S001','you loged out successfully !');
        }
        else {
            return $this->responseError('E001','you are not logged in !');
        }

    }


    public function me()
    {
        $user = User::find(Auth::id());
        $properties = Property::with(['des','typeProperty' => function ($q) {
            $q->select('id', 'type_' . app()->getLocale() . ' as type');
        },'view' => function ($q) {
            $q->select('id', 'list_' . app()->getLocale() . ' as list');
        },'finish' => function ($q) {
            $q->select('id', 'type_' . app()->getLocale() . ' as type');
        },'payment'])->where('user_id',$user->id)->get();
        $not_active = 0;

        foreach ($properties as $property){
            $not_active = $property->status == 0 ? ++$not_active: $not_active;
            $property->status = $property->status ==  1 ? 'Active' : 'Not active';
            $property->images->source = unserialize($property->images->source);
        }
        return $this->responseWithData('data',['user'=> $user,
            'properties'=> $properties,
        ]);
    }


    // Forget password Function
    public function forgot_password(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'email' => "required|email",
        );
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        } else {
            try {
                $response = Password::sendResetLink($request->only('email'), function ($message) {
                    $message->subject($this->getEmailSubject());
                });
                switch ($response) {
                    case Password::RESET_LINK_SENT:
                        return $this->responseSuccess('S001',$response);
                    case Password::INVALID_USER:
                        return  $this->responseError('E001',$response);
                }
            } catch (\Illuminate\Validation\ValidationException $ex) {
                return $this->responseError($ex->getCode(), $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->responseError($ex->getCode(), $ex->getMessage());
            }
        }
    }



    public function change_password(Request $request)
    {
        $input = $request->all();
        $userid = Auth::guard('api')->user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    return  $this->responseError('E001','Check your old password.');
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    return  $this->responseError('E001','Please enter a password which is not similar then current password.');
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    return $this->responseSuccess('S001',"Password updated successfully.");
                }
            } catch (\Exception $ex) {
                $msg = $ex->getMessage();
                $arr = array("status" => 400, "message" => $msg, "data" => array());
                return $this->responseError($ex->getCode(), $msg);
            }
        }
    }


    /**
     * @param $user_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function verify($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            return $this->responseError('E001',"Invalid/Expired url provided.");
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
    public function resend() {
        $user = User::find(Auth::id());
        if ($user->hasVerifiedEmail()) {
            return $this->responseError('E001',"Email already verified.");
        }
        $user->sendEmailVerificationNotification();
        return $this->responseSuccess('S001',"Email verification link sent on your email.");
    }

}
