<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\category;
use App\product;
use App\sub_category;
use Storage;
use DB;

class CategoryController extends Controller
{   
    //Category With Subcategory
    public function getAllCategory() {        
        $cat = category::with('subCategory')->get();
        $output ['status']=1;
        $output ['message']='All Data Fetched Successfully';
        $output ['result']=$cat;
        return response($output, 200);
    }


    public function filterCategory(request $request) {
                 
    
        $totalData = category::count();
    
          
    
        $totalFiltered = $totalData;  

        $limit =$request->input('length');
        $start =$request->input('start');
        $order = $request->input('order');
        $dir = $request->input('dir');

        
        if (empty($request->input('length')) && empty($request->input('start')) && empty($request->input('order')) && empty($request->input('order'))) {
            $posts = category::with('subCategory')->get();
        }elseif ($request->input('search')) {
          $search = $request->input('search'); 

          $posts =  category::with('subCategory')->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhere('description', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();  
          }
        
        
        else{
            $posts = category::with('subCategory')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
          
         
        
        
    
        $allstudents = array( 
        "status"            => 1,  
        "message"            => "Data Fetched Successfully",  
        "Total"    => intval($totalData),
        "result"            => $posts 
        );
    
        return response()->json($allstudents);
    
    }





    public function createCategory(Request $request) {
        $cats = new category; 
         
        $cats->name = $request->name;
        $cats->description = $request->description;
        
         $uploadFolder = 'cats';
         $image = $request->file('thumbnail');
         $image_uploaded_path = $image->store($uploadFolder, 'public');
         $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
         );

         $cats->thumbnail=$uploadedImageResponse['image_url'];



        $cats->save();
    
        return response()->json([
            "status"=> 1,
            "message" => "New Category added Successfully"
        ], 201);
    }
    public function updateCategory(Request $request, $id) {
        if (category::where('id', $id)->exists()) {
            $cats = category::find($id);
            $cats->name = is_null($request->name) ? $cats->name : $request->name;
            $cats->description = is_null($request->description) ? $cats->description : $request->description;
            $cats->thumbnail = is_null($request->thumbnail) ? $cats->thumbnail : $request->thumbnail;

            $cats->save();
    
            return response()->json([
                "status"=> 1,
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "status"=> 0,
                "message" => "Category not found"
            ], 404);
            
        }
    }
    public function deleteCategory ($id) {
	    if(category::where('id', $id)->exists()) {
	      $employe = category::find($id);
	      $employe->delete();

	      return response()->json([
	        "message" => "records deleted"
	      ], 202);
	    } else {
	      return response()->json([
	        "message" => "Category not found"
	      ], 404);
	    }
    }


     

    public function createSubcategory(Request $request) {
        $scats = new sub_category; 
         
        $scats->category_id = $request->category_id;
        $scats->name = $request->name;
        $scats->description = $request->description;
        
         $uploadFolder = 'subcats';
         $image = $request->file('thumbnail');
         $image_uploaded_path = $image->store($uploadFolder, 'public');
         $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
         );

         $scats->thumbnail=$uploadedImageResponse['image_url'];



        $scats->save();
    
        return response()->json([
            "status"=> 1,
            "message" => "New Sub Category added Successfully"
        ], 201);
    }
    public function updateSubcategory(Request $request, $id) {
        if (sub_category::where('id', $id)->exists()) {
            $scats = sub_category::find($id);
            $scats->category_id = is_null($request->category_id) ? $scats->category_id : $request->category_id;
            $scats->name = is_null($request->name) ? $scats->name : $request->name;
            $scats->description = is_null($request->description) ? $scats->description : $request->description;
            $scats->thumbnail = is_null($request->thumbnail) ? $scats->thumbnail : $request->thumbnail;

            $scats->save();
    
            return response()->json([
                "status"=> 1,
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "status"=> 0,
                "message" => "Sub Category not found"
            ], 404);
            
        }
    }
    public function deleteSubcategory ($id) {
	    if(sub_category::where('id', $id)->exists()) {
	      $employe = sub_category::find($id);
	      $employe->delete();

	      return response()->json([
	        "message" => "records deleted"
	      ], 202);
	    } else {
	      return response()->json([
	        "message" => "Sub Category not found"
	      ], 404);
	    }
    }

    
    
    
    
    
    
    
    
    ///R&D
    public function index(Request $request)
    {
        $type = request('type');
        $age = request('age');
        $status = request('status');
        $id = request('id');
        $l = request('limit');
        // $types = request();
        // echo $type; 
        // echo $status; 
        // echo $l; 
        $bid='';
        if ($id) {
            $bid='and id="'.$id.'"';
        };

        $limit='';
        if ($l) {
            $limit='LIMIT '.$l.'';
        };


        $kuchbhi=DB::select('select id,name, email, gender,status from user where status="'.$status.'" '.$bid.'  '.$limit.' ');
        return response($kuchbhi, 200);
        exit;
        $users = DB::select('select * from category where status = ?', [1]);
        return response($users, 200);
        // return view('user.index', ['users' => $users]);

        
    }

    //Testing  
    public function getAllCatSubcatProd() {        
      $posts = category::with('subCategory')
      // ->with('products')
      ->get();
      //get subcategory
      $r=$posts[0]->subCategory[0]->id;
      $product = product::get();
      // print_r($product);exit;
      $data = array();
      if(!empty($posts)) {
      foreach ($posts as $post) {  
      $sub_arr=[];

      if($product) {
        foreach($product as $prod) {
          if($r == $prod->sub_category_id) {
            // print_r('ffddf');exit;
            array_push($sub_arr,$prod);
            
          }
        }
      }

      $nestedData=$posts;
      $nestedData['product']=$sub_arr;

        array_push($data,$nestedData);
      }
      }
      $output ['status']=1;
      $output ['message']='All Data Fetched Successfully';
      $output ['result']=$data;
      return response($output, 200);
    }

    //Create Category and Subcategory in same Api
    public function createcategorytest(Request $request) {
        $cat = new category;
        $cat->name = $request->name;        
        $cat->description = $request->description;
        $cat->thumbnail = $request->thumbnail;
        
        //Save The category Now
       $cat->save();
        
        foreach ($request->sub_catagories as $sub_cat) {
          $catdetRecord = new sub_category;   
          $catdetRecord->category_id = $cat->id;     
          $catdetRecord->name =  $sub_cat['name'];
          $catdetRecord->description =  $sub_cat['description'];
          $catdetRecord->thumbnail =  $sub_cat['thumbnail'];
          $cats= $catdetRecord;
          // $cat->sub_catagories[] = $catdetRecord;
          // print_r($cat->sub_catagories[]);exit;
            
          $cats->push();
        }   
        
        return response()->json([
          "status" => 1,
          "message" => "Category record created Successfully"
        ], 201);
    }


}
