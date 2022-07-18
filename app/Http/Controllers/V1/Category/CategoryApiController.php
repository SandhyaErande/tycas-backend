<?php

namespace App\Http\Controllers\V1\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryApiController extends Controller
{
    //create Category
    public function createCategory(Request $request){
        try{
            $validator=Validator::make($request->all(),[
                'name'=>'required',
                'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'client_id'=>'',
            ]);
            if($validator->fails()){
                return $this->sendError('Validator Error',$validator->errors());
            }

            $newCategory= new Category;
                $newCategory->name= $request->name;
                $newCategory->client_id= $request->client_id;
                $image = $request->file('image');
                    $filename = $image->getClientOriginalName();
                    $request->image->move(public_path('test_image_file/'), $filename);
                    $newCategory->image= env("IMAGE_PATH").$filename;
            
                    if(is_null($newCategory)){
                        return $this->sendResponse('','Failed to Upload Image',true);
                     }

                $newCategory->save();

                return $this->sendResponse(['Category' => $newCategory], 'Data Save Successfully', true);
            

        }
        catch(\Exception $e){
            return $this->sendError('Something Wents Wrong',$e,412);
        }
    }

    // get all Category
     public function getCategory(){
        $getCategory=Category::all();
        $count=Category::all()->count();
        
        try{
        if($count == 0)
        {
            return $this->sendResponse('','No Category Found',false);
        }
        if($getCategory){
        return $this->sendResponse(['Category'=>$getCategory,'Count'=>$count],'Data Fetched Successfully...',true);
     }
    }
     catch(\Exception $e){
        return $this->sendError('Something Wents Wrong',$e,412);
    }

    }
    // show Category by id
public function getCategoryById($id){
    $getCategory = Category::find($id);
    try{
        if(is_null($getCategory)){
            return $this->sendResponse(['Category'=>$getCategory],'No Category Found',false);
        }
        else{
            return $this->sendResponse(['Category'=>$getCategory] ,"Data Fetched Successfully..!",true);
        }
    }
    catch(\Exception $e){
        return $this->sendError('Something Went Wrong', $e, 413);
    } 
}

// update Category
public function updateCategory(Request $request,$id){
    try{
        $validator= Validator::make($request->all(),[
            'name'=>' ',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'client_id'=>'',
        ]);
        if($validator->fails())
        {
            return $this->sendError('Validation Error.',$validator->errors());
        }
       
        $getCategory=Category::find($id);
        if(is_null($getCategory)){
            return $this->sendResponse(['CCategory'=>$getCategory],'No CCategory Found',false);
        }
        if ($request->has('name')) {
            $getCategory->name = $request->name;
        }
        if ($request->has('client_id')) {
            $getCategory->client_id = $request->client_id;
        }
        if($request->has('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $request->image->move(public_path('test_image_file/'), $filename);
            $getCategory->image= env("IMAGE_PATH").$filename;
        }
            if(is_null($getCategory)){
                return $this->sendResponse('','Failed to Upload Image',true);
             }
       
        $getCategory->save();
                return $this->sendResponse(['Category'=>$getCategory],"Data Update Successfully..!",True);
    }
        catch(\Exception $e){
                return $this->sendError("Operation Failed",$e,413);
            }
}

 // delete Category
 public function  deleteCategory(Request $request ,$id){
    try{
        $getCategory= Category::find($id);
        if(is_null($getCategory)){
            return $this->sendResponse([],'No Category Found',false);
        }
        if($getCategory->delete()){
            return $this->sendResponse([],'Category Deleted Successfully..!');
        }
        else{
            return $this->sendResponse([],'Category Not Deleted',false);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}

// soft delete
// get Category only trash
public function getTrashCategory()
{
    try{
        $getCategory=Category::onlyTrashed()->get();
        $count=Category::onlyTrashed()->count();

        if(is_null($getCategory)){
            return $this->sendResponse([],'No Category Found',false);
        }
        else{
            return $this->sendResponse(['Category'=>$getCategory,'Count'=>$count] ,"Data Fetched Successfully..!",true);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}
// get Category with trash
public function getCategoryWithTrash()
{
    try{
        $getCategory=Category::withTrashed()->get();
        $count=Category::withTrashed()->count();

        if(is_null($getCategory)){
            return $this->sendResponse([],'No Category Found',false);
        }
        else{
            return $this->sendResponse(['Category'=>$getCategory,'Count'=>$count] ,"Data Fetched Successfully..!",true);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}

// Restore Category
public function restoreCategory(Request $request ,$id){
    try{
        $getCategory= Category::onlyTrashed()->find($id);
        if(is_null($getCategory)){
            return $this->sendResponse([],'No Category Found',false);
        }
        if($getCategory->Restore()){
            return $this->sendResponse([],'Category Restore Successfully..!');
        }
        else{
            return $this->sendResponse([],'Category Cant Restore',false);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}
// Category Delete permanent 
public function  deleteCategorypermanent(Request $request ,$id){
    try{
        $getCategory= Category::withTrashed()->find($id);
        if(is_null($getCategory)){
            return $this->sendResponse([],'No Category Found',false);
        }
        if($getCategory->forceDelete()){
            return $this->sendResponse([],'Category Deleted Permanent..!');
        }
        else{
            return $this->sendResponse([],'Category Cant Restore',false);
        }
    }
    catch(\Exception $e){
        return $this->sendError("Operation Failed",$e,413);
    }
}
}
