<?php

namespace App\Http\Controllers\V1\UserController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    // public function registration(Request $request){
    //     try{
    //         $validator= Validator::make($request->all(),[
    //             'name'=>'required',
    //             'mobile_no'=>'required | numeric |unique:users,mobile_no| digits:10 ',
    //             'email'=>'required | regex:/(.+)@(.+)\.(.+)/i |unique:users,email',
    //             'password' => 'required|string|min:6|confirmed',
    //             'user_type'=>' '
    //         ]);
    //         if($validator->fails())
    //         {
    //             return response()->json($validator->errors(),404);
    //         }
    //         $user=new User;
    //             $user->email= $request->email;
    //             $user->name=$request->name;
    //             $user->mobile_no= $request->mobile_no;
    //             $user->user_type= 'system';
    //             $user ->password = bcrypt($request->password);
                        
    //             $user->save();
    //             $token = JWTAuth::fromUser($user);
    //             $response = ['token' => $token];
    //             $response['userData'] = $user;
               
    //              return $this->sendResponse($response,"Registration Successfully..!",true);
    //     }
    //     catch(\Exception $e){
    //         return $this->sendError('Something Went Wrong..!',$e,412);
    //     }
    // }
    public function login(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $user = User::where('email', $request->email)->first();
    
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    
                        $token = JWTAuth::fromUser($user);
                        $response = ['token' => $token];
                        $response['userData'] = $user;

                        return $this->sendResponse($response,"Login Successfully..!",true);
                    } else {
                    return $this->sendError('Password mismatch',[], 422);
                }
                
            } 
            else {
                $response = ["message" =>''];
                return $this->sendError('User does not exist',[], 200);
            }
        }
        catch (\Exception $e){
           return $this->sendError('Something Went Wrong', $e,413);
        }
    }
    public function getAuthenticatedUser()
            {
                    try {
    
                            if (! $user = JWTAuth::parseToken()->authenticate()) {
                                    return response()->json(['user_not_found'], 404);
                            }
    
                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
    
                            return response()->json(['token_expired'], $e->getStatusCode());
    
                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    
                            return response()->json(['token_invalid'], $e->getStatusCode());
    
                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
    
                            return response()->json(['token_absent'], $e->getStatusCode());
    
                    }
    
                    return response()->json(compact('user'));
            }
}
