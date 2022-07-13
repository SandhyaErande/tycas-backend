<?php

namespace App\Http\Controllers\V1\CustomerController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class Authentication extends Controller
{
    public function sendOtp(Request $request){
        try{
            $validator=Validator::make($request->all(),[
                'mobile_no'=>'required|numeric | digits:10|unique:users,mobile_no',
            ]);
            if($validator->fails()){
                return $this->sendError(array("Mobile number not valid".$request->mobile_no));
            }
            $otp =rand(1000,9999);

            $user=User::where([
                'mobile_no'=>$request->mobile_no,
                'otp'=>$otp,
            ]);
            return $this->sendResponse('',"Your registration OTP pin is $otp",true);

        }

        catch(\Exception $e){
            return $this->sendError('Something Went Wrong', $e, 413);
        }
    }
}
