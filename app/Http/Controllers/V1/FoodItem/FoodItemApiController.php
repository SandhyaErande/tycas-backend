<?php

namespace App\Http\Controllers\V1\FoodItem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FoodItem;
use Illuminate\Support\Facades\Auth;

class FoodItemApiController extends Controller
{
     //create FoodItem
     public function createFoodItem(Request $request){
        try{
            $validator=Validator::make($request->all(),[
                'name'=>'required',
                'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'base_price'=>'required',
                'item_status'=>'required',
                'is_drink'=>'required',
                'is_hard_drink'=>'required',
                // 'client_id'=>'',
                'category_id'=>'',
            ]);
            if($validator->fails()){
                return $this->sendError('Validator Error',$validator->errors());
            }

            $newFoodItem= new FoodItem;
            $newFoodItem->client_id= Auth::user()->id;

                $newFoodItem->name= $request->name;
                $image = $request->file('image');
                    $filename = $image->getClientOriginalName();
                    $request->image->move(public_path('test_image_file/'), $filename);
                    $newFoodItem->image= env("IMAGE_PATH").$filename;
                    if(is_null($newFoodItem)){
                        return $this->sendResponse('','Failed to Upload Image',true);
                     }
                     $newFoodItem->base_price= $request->base_price;
                     $newFoodItem->item_status= $request->item_status;
                     $newFoodItem->is_drink= $request->is_drink;
                     $newFoodItem->is_hard_drink= $request->is_hard_drink;
                    //  dd("test");
                     $newFoodItem->client_id= Auth::user()->id;
                     echo $newFoodItem;
                     $newFoodItem->category_id= $request->category_id;

                // $newFoodItem->save();

                return $this->sendResponse(['FoodItem' => $newFoodItem], 'Data Save Successfully', true);
            

        }
        catch(\Exception $e){
            return $this->sendError('Something Wents Wrong',$e->getMessage(),412);
        }
    }

    // get all FoodItem
     public function getFoodItem(){
        $getFoodItem=FoodItem::all();
        $count=FoodItem::all()->count();
        
        try{
        if($count == 0)
        {
            return $this->sendResponse('','No FoodItem Found',false);
        }
        if($getFoodItem){
        return $this->sendResponse(['FoodItem'=>$getFoodItem,'Count'=>$count],'Data Fetched Successfully...',true);
     }
    }
     catch(\Exception $e){
        return $this->sendError('Something Wents Wrong',$e,412);
    }

    }
    // show FoodItem by id
public function getFoodItemById($id){
    $getFoodItem = FoodItem::find($id);
    try{
        if(is_null($getFoodItem)){
            return $this->sendResponse(['FoodItem'=>$getFoodItem],'No FoodItem Found',false);
        }
        else{
            return $this->sendResponse(['FoodItem'=>$getFoodItem] ,"Data Fetched Successfully..!",true);
        }
    }
    catch(\Exception $e){
        return $this->sendError('Something Went Wrong', $e, 413);
    } 
}

// update FoodItem
public function updateFoodItem(Request $request,$id){
    try{
        $validator= Validator::make($request->all(),[
            'name'=>'',
            'image'=>'|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'base_price'=>'',
            'item_status'=>'',
            'is_drink'=>'',
            'is_hard_drink'=>'',
            'client_id'=>'',
            'category_id'=>'',
        ]);
        if($validator->fails())
        {
            return $this->sendError('Validation Error.',$validator->errors());
        }
       
        $getFoodItem=FoodItem::find($id);
        if(is_null($getFoodItem)){
            return $this->sendResponse(['CFoodItem'=>$getFoodItem],'No CFoodItem Found',false);
        }
        if ($request->has('name')) {
            $getFoodItem->name = $request->name;
        }
       
        if($request->has('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $request->image->move(public_path('test_image_file/'), $filename);
            $getFoodItem->image= env("IMAGE_PATH").$filename;
        }
            if(is_null($getFoodItem)){
                return $this->sendResponse('','Failed to Upload Image',true);
             }
             if ($request->has('base_price')) {
                $getFoodItem->base_price = $request->base_price;
            }
            if ($request->has('item_status')) {
                $getFoodItem->item_status = $request->item_status;
            }
            if ($request->has('is_drink')) {
                $getFoodItem->is_drink = $request->is_drink;
            }
            if ($request->has('is_hard_drink')) {
                $getFoodItem->is_hard_drink = $request->is_hard_drink;
            }
            if ($request->has('client_id')) {
                $getFoodItem->client_id = $request->client_id;
            }
            if ($request->has('category_id')) {
                $getFoodItem->category_id = $request->category_id;
            }
        $getFoodItem->save();
                return $this->sendResponse(['FoodItem'=>$getFoodItem],"Data Update Successfully..!",True);
    }
        catch(\Exception $e){
                return $this->sendError("Operation Failed",$e,413);
            }
}

 // delete FoodItem
 public function  deleteFoodItem(Request $request ,$id){
    try{
        $getFoodItem= FoodItem::find($id);
        if(is_null($getFoodItem)){
            return $this->sendResponse([],'No FoodItem Found',false);
        }
        if($getFoodItem->delete()){
            return $this->sendResponse([],'FoodItem Deleted Successfully..!');
        }
        else{
            return $this->sendResponse([],'FoodItem Not Deleted',false);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}

// soft delete
// get FoodItem only trash
public function getTrashFoodItem()
{
    try{
        $getFoodItem=FoodItem::onlyTrashed()->get();
        $count=FoodItem::onlyTrashed()->count();

        if(is_null($getFoodItem)){
            return $this->sendResponse([],'No FoodItem Found',false);
        }
        else{
            return $this->sendResponse(['FoodItem'=>$getFoodItem,'Count'=>$count] ,"Data Fetched Successfully..!",true);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}
// get FoodItem with trash
public function getFoodItemWithTrash()
{
    try{
        $getFoodItem=FoodItem::withTrashed()->get();
        $count=FoodItem::withTrashed()->count();

        if(is_null($getFoodItem)){
            return $this->sendResponse([],'No FoodItem Found',false);
        }
        else{
            return $this->sendResponse(['FoodItem'=>$getFoodItem,'Count'=>$count] ,"Data Fetched Successfully..!",true);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}

// Restore FoodItem
public function restoreFoodItem(Request $request ,$id){
    try{
        $getFoodItem= FoodItem::onlyTrashed()->find($id);
        if(is_null($getFoodItem)){
            return $this->sendResponse([],'No FoodItem Found',false);
        }
        if($getFoodItem->Restore()){
            return $this->sendResponse([],'FoodItem Restore Successfully..!');
        }
        else{
            return $this->sendResponse([],'FoodItem Cant Restore',false);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}
// FoodItem Delete permanent 
public function  deleteFoodItempermanent(Request $request ,$id){
    try{
        $getFoodItem= FoodItem::withTrashed()->find($id);
        if(is_null($getFoodItem)){
            return $this->sendResponse([],'No FoodItem Found',false);
        }
        if($getFoodItem->forceDelete()){
            return $this->sendResponse([],'FoodItem Deleted Permanent..!');
        }
        else{
            return $this->sendResponse([],'FoodItem Cant Restore',false);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}
}
