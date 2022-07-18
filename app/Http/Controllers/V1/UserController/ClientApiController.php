<?php

namespace App\Http\Controllers\V1\UserController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;

class ClientApiController extends Controller
{
    public function clientRegistration(Request $request){
        try{
            $validator=Validator::make($request->all(),[
                'restaurant_name'=>'required',
                'unique_code'=>'required | numeric | digits:6|unique:client,unique_code',
                'gst_number'=>'required | min:15 |max:15|unique:client,gst_number',
                'primary_contact_no'=>'required | numeric | digits:10|unique:client,primary_contact_no',
                'secondary_contact_no'=>'required | numeric | digits:10',
                'address'=>'required',
                'is_razorpay_allowed'=>'required',
                'is_cred_allowed'=>'required',
            ]);
            if($validator->fails()){
                return $this->sendError('Validator Error',$validator->errors());
            }

            $newClient= new Client;
                $newClient->restaurant_name= $request->restaurant_name;
                $newClient->unique_code= $request->unique_code;
                $newClient->gst_number= $request->gst_number;
                $newClient->primary_contact_no= $request->primary_contact_no;
                $newClient->secondary_contact_no= $request->secondary_contact_no;
                $newClient->address= $request->address;
                $newClient->is_razorpay_allowed= $request->is_razorpay_allowed;
                $newClient->is_cred_allowed= $request->is_cred_allowed;

                $newClient->save();

                return $this->sendResponse(['Client' => $newClient], 'Data Save Successfully', true);
            

        }
        catch(\Exception $e){
            return $this->sendError('Something Wents Wrong',$e,412);
        }
    }

    // get all Client
     public function getClient(){
        $getClient=Client::all();
        $count=Client::all()->count();
        
        try{
        if($count == 0)
        {
            return $this->sendResponse('','No Client Found',false);
        }
        if($getClient){
        return $this->sendResponse(['Client'=>$getClient,'Count'=>$count],'Data Fetched Successfully...',true);
     }
    }
     catch(\Exception $e){
        return $this->sendError('Something Wents Wrong',$e,412);
    }

    }
    // show client by id
public function getClientById($id){
    $getClient = Client::find($id);
    try{
        if(is_null($getClient)){
            return $this->sendResponse(['Client'=>$getClient],'No Client Found',false);
        }
        else{
            return $this->sendResponse(['Client'=>$getClient] ,"Data Fetched Successfully..!",true);
        }
    }
    catch(\Exception $e){
        return $this->sendError('Something Went Wrong', $e, 413);
    } 
}

// update Client
public function updateClient(Request $request,$id){
    try{
        $validator= Validator::make($request->all(),[
            'restaurant_name'=>' ',
            'unique_code'=>' numeric | digits:6',
            'gst_number'=>' min:15 |max:15',
            'primary_contact_no'=>' numeric | digits:10',
            'secondary_contact_no'=>' numeric | digits:10',
            'address'=>' ',
            'is_razorpay_allowed'=>' ',
            'is_cred_allowed'=>' ',
        ]);
        if($validator->fails())
        {
            return $this->sendError('Validation Error.',$validator->errors());
        }
       
        $getClient=Client::find($id);
        if(is_null($getClient)){
            return $this->sendResponse(['Client'=>$getClient],'No Client Found',false);
        }
        if ($request->has('restaurant_name')) {
            $getClient->restaurant_name = $request->restaurant_name;
        }
        if ($request->has('unique_code')) {
            $getClient->unique_code = $request->unique_code;
        }
        if ($request->has('gst_number')) {
            $getClient->gst_number = $request->gst_number;
        }
        if ($request->has('primary_contact_no')) {
            $getClient->primary_contact_no = $request->primary_contact_no;
        }
        if ($request->has('secondary_contact_no')) {
            $getClient->secondary_contact_no = $request->secondary_contact_no;
        }
        if ($request->has('address')) {
            $getClient->address = $request->address;
        }
        if ($request->has('is_razorpay_allowed')) {
            $getClient->is_razorpay_allowed = $request->is_razorpay_allowed;
        }
        if ($request->has('is_cred_allowed')) {
            $getClient->is_cred_allowed = $request->is_cred_allowed;
        }
        $getClient->save();
                return $this->sendResponse(['Client'=>$getClient],"Data Update Successfully..!",True);
    }
        catch(\Exception $e){
                return $this->sendError("Operation Failed",$e,413);
            }
}

 // delete Client
 public function  deleteClient(Request $request ,$id){
    try{
        $getClient= Client::find($id);
        if(is_null($getClient)){
            return $this->sendResponse([],'No Client Found',false);
        }
        if($getClient->delete()){
            return $this->sendResponse([],'Client Deleted Successfully..!');
        }
        else{
            return $this->sendResponse([],'Client Not Deleted',false);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}
// soft delete

// get client only trash
public function getTrashClient()
{
    try{
        $getClient=Client::onlyTrashed()->get();
        $count=Client::onlyTrashed()->count();

        if(is_null($getClient)){
            return $this->sendResponse([],'No Client Found',false);
        }
        else{
            return $this->sendResponse(['Client'=>$getClient,'Count'=>$count] ,"Data Fetched Successfully..!",true);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}
// get client with trash
public function getClientWithTrash()
{
    try{
        $getClient=Client::withTrashed()->get();
        $count=Client::withTrashed()->count();

        if(is_null($getClient)){
            return $this->sendResponse([],'No Client Found',false);
        }
        else{
            return $this->sendResponse(['Client'=>$getClient,'Count'=>$count] ,"Data Fetched Successfully..!",true);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}

// Restore Client
public function restoreClient(Request $request ,$id){
    try{
        $getClient= Client::onlyTrashed()->find($id);
        if(is_null($getClient)){
            return $this->sendResponse([],'No Client Found',false);
        }
        if($getClient->Restore()){
            return $this->sendResponse([],'Client Restore Successfully..!');
        }
        else{
            return $this->sendResponse([],'Client Cant Restore',false);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}
// Client Delete permanent 
public function  deleteClientpermanent(Request $request ,$id){
    try{
        $getClient= Client::withTrashed()->find($id);
        if(is_null($getClient)){
            return $this->sendResponse([],'No Client Found',false);
        }
        if($getClient->forceDelete()){
            return $this->sendResponse([],'Client Deleted Permanent..!');
        }
        else{
            return $this->sendResponse([],'Client Cant Restore',false);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}
}
