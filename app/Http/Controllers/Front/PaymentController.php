<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    public function activation($id){

        if(request('id') && request('resourcePath')){
            $payment_status = $this->paymentService->getPaymentStatus(request('id'),request('resourcePath'));
            if(isset($payment_status['id'])){
                $success_payment = true;
                $property = Property::findorfail($id);
                $property->update([
                    'status'=> 1,
                    'trans_payment_id'=>$payment_status['id'],
                ]);
                return view('property.activation')->with(['id'=>$id,'success_payment' =>'تم الدفع بنجاح']);
            }else{
                $fail_payment = true;
                return view('property.activation')->with(['id'=>$id,'fail_payment'=>'فشل الدفع']);
            }

        }
        return view('property.activation')->with(['id'=>$id]);
    }

    public function getCheckId(Request $request){
        $res = $this->paymentService->getCheckId();
        $view = view('property.payForm')->with(['res'=>$res,'id' =>$request->id])->render();
        return response()->json([
           'status' => true,
            'content' =>$view['main'],
        ]);

    }
}
