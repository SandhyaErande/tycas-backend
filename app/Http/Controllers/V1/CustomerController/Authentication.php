<?php

namespace App\Http\Controllers\V1\CustomerController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use TwilIo\Rest\Clent;
use PHPUnit\Framework\Constraint\IsNull;

class Authentication extends Controller
{
    // public function sendOtp(Request $request){
    //     try{

    //         $validator=Validator::make($request->all(),[
    //             'mobile_no'=>'required|numeric | digits:10|unique:users,mobile_no',
    //         ]);
    //         if($validator->fails()){
    //             return $this->sendError(array("Mobile number not valid".$request->mobile_no));
    //         }
    //         $otp =rand(1000,9999);

    //         $user=User::where('mobile_no'->$request->mobile_no)->first();
          
    //         return $this->sendResponse('',"Your registration OTP is $otp",true);

    //     }

    //     catch(\Exception $e){
    //         return $this->sendError('Something Went Wrong', $e, 413);
    //     }
    // }
    
    public function verifyOtp(Request $request)
    {
        try{
            $validator=Validator::make($request->all(),[
                            'otp'=>'required|numeric | digits:4',
                        ]);
             if(is_null('otp')){
                    return $this->sendError(array("OTP not valid".$request->otp));
            }
    
            if ($request->input('otp') === '1234') {
            return $this->sendResponse('',"OTP Verified",true);
            }
            else{
                return $this->sendResponse('',"OTP Not Valid",false);
            }
        }
   
    catch(\Exception $e){
                return $this->sendError('Something Went Wrong', $e, 413);
            }

}

}