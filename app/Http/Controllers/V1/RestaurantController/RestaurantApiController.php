<?php

namespace App\Http\Controllers\V1\RestaurantController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RestaurantApiController extends Controller
{
    
    // Create User
    public function createRestaurantUser(Request $request){
        try{
            $validator=Validator::make($request->all(),[
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
                'mobile_no'=>'required|numeric | digits:10|unique:users,mobile_no',
                'user_type'=>' ',
                'client_id'=>''
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error',$validator->errors());
            }
            $newUser=new User;
                $newUser->name= $request->name;
                $newUser->email= $request->email;
                $newUser->mobile_no= $request->mobile_no;
                $newUser->user_type= 'restaurant';
                $newUser->client_id= $request->client_id;

                $newUser->save();

                return $this->sendResponse(['User'=>$newUser],"Data Save Successfully",true);

        }
        catch(\Exception $e){
            return $this->sendError('Something Went Wrong', $e, 413);
        }
    }


    // get all User
    public function getRestaurantUser(){
        $getUser = DB::table('users')->where('user_type', 'Restaurant')->get();
        $count= DB::table('users')->where('user_type', 'Restaurant')->count();
        try{
            if($count==0){
                return $this->sendResponse('',"No User Available..!",false,'');
            }
            if($getUser){
                return $this->sendResponse(['User'=> $getUser,'count' => $count] ,"Data Fetched Successfully..!",true);
            }
        }
            catch(\Exception $e){
                return $this->sendError('Something Went Wrong', $e, 413);
            }
    }

    // delete user
public function  deleteRestaurantUser(Request $request ,$id){
    try{
        $getUser= User::find($id);
        if(is_null($getUser)){
            return $this->sendResponse([],'No User Found',false);
        }
        if($getUser->delete()){
            return $this->sendResponse([],'User Deleted Successfully..!');
        }
        else{
            return $this->sendResponse([],'User Not Deleted',false);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}
}
