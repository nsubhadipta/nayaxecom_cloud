<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;
use App\sub_category;
use Storage;
use DB; 

class ProductController extends Controller
{
    //All Product By my method
    public function getAllProduct() {
        $prod = product::addSelect(['subCategory' => sub_category::select('name')
        ->whereColumn('product.sub_category_id', 'id')
        ->orderBy('id', 'desc')
        ->limit(1)
        ])->get();
        $output ['status']=1;
        $output ['message']='All Data Fetched Successfully';
        $output ['result']=$prod;
        return response($output, 200);
    }


    //Datatable
    public function filterProduct(request $request) {
       
        $columns = array( 
            0 =>'id', 
            1 =>'sub_category_id',
            2=> 'prod_name',
            3=> 'prod_info',
            4=> 'base_price',
            5=> 'url',
            6=> 'thumbnail',
        );
    
          
    
        $totalData = product::count();
    
         
    
        $totalFiltered = $totalData; 

        $limit =$request->input('length');
        $start =$request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // $order = $request->input('ord');
        // $dir = $request->input('ad');
    
          
         
        if(empty($request->input('search.0.value')))
        {
    
            $posts = product::offset($start)
              ->limit($limit)
              ->orderBy($order,$dir)
              ->get();
            
    
        }
        else {
    
            $search = $request->input('search.0.value');  
    
            $posts =  product::where('id','LIKE',"%{$search}%")
            ->orWhere('id', 'LIKE',"%{$search}%")
            ->orWhere('prod_name', 'LIKE',"%{$search}%")
            ->orWhere('prod_info', 'LIKE',"%{$search}%")
            ->orWhere('base_price', 'LIKE',"%{$search}%")
            ->orWhere('url', 'LIKE',"%{$search}%")
            ->orWhere('thumbnail', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
    
    
    
            $totalFiltered = product::where('id','LIKE',"%{$search}%")
                ->orWhere('id', 'LIKE',"%{$search}%")
                ->orWhere('prod_name', 'LIKE',"%{$search}%")
                ->orWhere('prod_info', 'LIKE',"%{$search}%")
                ->orWhere('base_price', 'LIKE',"%{$search}%")
                ->orWhere('url', 'LIKE',"%{$search}%")
                ->orWhere('thumbnail', 'LIKE',"%{$search}%")
                ->count();
        }
    
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
          
                $nestedData['id'] = $post->id;
                $nestedData['sub_category_id'] = $post->sub_category_id;
                $nestedData['prod_name'] = $post->prod_name;
                $nestedData['prod_info'] = $post->prod_info;
                $nestedData['base_price'] = $post->base_price;
                $nestedData['url'] = $post->url;
                $nestedData['thumbnail'] = $post->thumbnail;
        
                array_push($data,$nestedData);
    
            }
        }
    
        
    
        $allstudents = array(
        "draw"            => intval($request->input('draw')),  
        "Total"    => intval($totalData),  
        "Filtered" => intval($totalFiltered), 
        "data"            => $data 
        );
    
        return response()->json($allstudents);
    
    }

    //For All Users Use Product
    public function filterProd(request $request) {
                 
    
        $totalData = product::count();
    
         
    
        $totalFiltered = $totalData; 

        $limit =$request->input('length');
        $start =$request->input('start');
        $order = $request->input('order');
        $dir = $request->input('dir');

        
        if (empty($request->input('length')) && empty($request->input('start')) && empty($request->input('order')) && empty($request->input('order'))) {
            $posts = product::offset(0)
            ->limit(100)
            ->orderBy('id','asc')
            ->get();
        }
          
         
        elseif(empty($request->input('search')))
        {
    
            $posts = product::offset($start)
              ->limit($limit)
              ->orderBy($order,$dir)
              ->get();
            
    
        }
        else {
    
            $search = $request->input('search');  
    
            $posts =  product::where('id','LIKE',"%{$search}%")
            ->orWhere('id', 'LIKE',"%{$search}%")
            ->orWhere('prod_name', 'LIKE',"%{$search}%")
            ->orWhere('prod_info', 'LIKE',"%{$search}%")
            ->orWhere('base_price', 'LIKE',"%{$search}%")
            ->orWhere('url', 'LIKE',"%{$search}%")
            ->orWhere('thumbnail', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
    
    
    
            $totalFiltered = product::where('id','LIKE',"%{$search}%")
                ->orWhere('id', 'LIKE',"%{$search}%")
                ->orWhere('prod_name', 'LIKE',"%{$search}%")
                ->orWhere('prod_info', 'LIKE',"%{$search}%")
                ->orWhere('base_price', 'LIKE',"%{$search}%")
                ->orWhere('url', 'LIKE',"%{$search}%")
                ->orWhere('thumbnail', 'LIKE',"%{$search}%")
                ->count();
        }
    
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
          
                $nestedData['id'] = $post->id;
                $nestedData['sub_category_id'] = $post->sub_category_id;
                $nestedData['prod_name'] = $post->prod_name;
                $nestedData['prod_info'] = $post->prod_info;
                $nestedData['base_price'] = $post->base_price;
                $nestedData['url'] = $post->url;
                $nestedData['thumbnail'] = $post->thumbnail;
        
                array_push($data,$nestedData);
    
            }
        }
    
        
    
        $allstudents = array(
        "status"            => 1,  
        "message"            => "Data Fetched Successfully",  
        "Total"    => intval($totalData),
        "result"            => $data 
        );
    
        return response()->json($allstudents);
    
    }
 






    //Add Product
    public function createProduct(Request $request) {
        $prods = new product; 
        
        $prods->sub_category_id = $request->sub_category_id;
        $prods->prod_name = $request->prod_name;
        $prods->prod_info = $request->prod_info;
        $prods->base_price = $request->base_price;
        $prods->url = $request->url;
        // $prods->thumbnail = $request->thumbnail;
        
        // $validator = Validator::make($request->all(), [
        //     'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        //  ]);
        //  if ($validator->fails()) {
        //     return sendCustomResponse($validator->messages()->first(),  'error', 500);
        //  }
         $uploadFolder = 'prods';
         $image = $request->file('thumbnail');
         $image_uploaded_path = $image->store($uploadFolder, 'public');
         $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
         );
        //  return response('File Uploaded Successfully', 'success',   200, $uploadedImageResponse);

         $prods->thumbnail=$uploadedImageResponse['image_url'];



        $prods->save();
    
        return response()->json([
            "status"=> 1,
            "message" => "New Product added Successfully"
        ], 201);
    }
    //Edit Product
    public function updateProduct(Request $request, $id) {
        if (product::where('id', $id)->exists()) {
            $prods = product::find($id);
            $prods->sub_category_id = is_null($request->sub_category_id) ? $prods->sub_category_id : $request->sub_category_id;
            $prods->prod_name = is_null($request->prod_name) ? $prods->prod_name : $request->prod_name;
            $prods->prod_info = is_null($request->prod_info) ? $prods->prod_info : $request->prod_info;
            $prods->base_price = is_null($request->base_price) ? $prods->base_price : $request->base_price;
            $prods->url = is_null($request->url) ? $prods->url : $request->url;
            $prods->thumbnail = is_null($request->thumbnail) ? $prods->thumbnail : $request->thumbnail;

            // $uploadFolder = 'prods';
            // $image = is_null($request->file('thumbnail')) ? $prods->thumbnail : $request->file('thumbnail');
            // $image_uploaded_path = $image->store($uploadFolder, 'public'); 
            // $uploadedImageResponse = array(
            //     "image_name" => basename($image_uploaded_path),
            //     "image_url" => Storage::disk('public')->url($image_uploaded_path), 
            //     "mime" => $image->getClientMimeType()
            // );
            //  return response('File Uploaded Successfully', 'success',   200, $uploadedImageResponse);

            // $prods->thumbnail=$uploadedImageResponse['image_url'];
            $prods->save();
    
            return response()->json([
                "status"=> 1,
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "status"=> 0,
                "message" => "User not found"
            ], 404);
            
        }
    }


























    //Data Table For Testing Don't Use
    public function filterStudents(request $request) {
        // $users = student::get();
        
        // return response($users, 200);;exit;
       
        $columns = array( 
            0 =>'id', 
            1 =>'name',
            2=> 'email',
            3=> 'username',
            4=> 'phone',
            4=> 'dob',
        );
    
          
    
        $totalData = student::count();
    
         
    
        $totalFiltered = $totalData; 

        $limit =$request->input('length');
        $start =$request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // $order = $request->input('ord');
        // $dir = $request->input('ad');
    
          
         
        if(empty($request->input('search.value')))
        {
    
            $posts = student::offset($start)
              ->limit($limit)
              ->orderBy($order,$dir)
              ->get();
            
    
        }
        else {
    
            $search = $request->input('search.value'); 
    
            $posts =  student::where('id','LIKE',"%{$search}%")
            ->orWhere('id', 'LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhere('email', 'LIKE',"%{$search}%")
            ->orWhere('username', 'LIKE',"%{$search}%")
            ->orWhere('phone', 'LIKE',"%{$search}%")
            ->orWhere('dob', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
    
    
    
            $totalFiltered = student::where('id','LIKE',"%{$search}%")
                ->orWhere('id', 'LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('username', 'LIKE',"%{$search}%")
                ->orWhere('phone', 'LIKE',"%{$search}%")
                ->orWhere('dob', 'LIKE',"%{$search}%")
                ->count();
        }
    
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
         
                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['email'] = $post->email;
                $nestedData['username'] = $post->username;
                $nestedData['phone'] = $post->phone;
                $nestedData['dob'] = $post->dob;
        
                array_push($data,$nestedData);
    
            }
        }
    
          // $data =[];
    
          // $allstudents = array(
          //   "draw"            => intval($request->input('draw')),  
          //   "Total"    => 0,  
          //   "Filtered" => 0, 
          //   "data"            => $data 
          //   );
    
        $allstudents = array(
        "draw"            => intval($request->input('draw')),  
        "Total"    => intval($totalData),  
        "Filtered" => intval($totalFiltered), 
        "data"            => $data 
        );
    
        return response()->json($allstudents);
    
    }

     //Datatable
    public function getfilterProduct(request $request) {
       
        $columns = array( 
            0 =>'id', 
            1 =>'sub_category_id',
            2=> 'prod_name',
            3=> 'prod_info',
            4=> 'base_price',
            5=> 'url',
            6=> 'thumbnail',
        );
    
          
    
        $totalData = product::count();
    
         
    
        $totalFiltered = $totalData; 

        $limit =$request->input('length');
        $start =$request->input('start');
        /*$order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');*/

        // $order = $request->input('ord');
        // $dir = $request->input('ad');
    
          
         
        if(empty($request->input('search.0.value')))
        {
    
            $posts = product::offset($start)
              ->limit($limit)
              //->orderBy($order,$dir)
              ->get();
            
    
        }
        else {
    
            $search = $request->input('search.0.value');  
    
            $posts =  product::where('id','LIKE',"%{$search}%")
            ->orWhere('id', 'LIKE',"%{$search}%")
            ->orWhere('prod_name', 'LIKE',"%{$search}%")
            ->orWhere('prod_info', 'LIKE',"%{$search}%")
            ->orWhere('base_price', 'LIKE',"%{$search}%")
            ->orWhere('url', 'LIKE',"%{$search}%")
            ->orWhere('thumbnail', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            //->orderBy($order,$dir)
            ->get();
    
    
    
            $totalFiltered = product::where('id','LIKE',"%{$search}%")
                ->orWhere('id', 'LIKE',"%{$search}%")
                ->orWhere('prod_name', 'LIKE',"%{$search}%")
                ->orWhere('prod_info', 'LIKE',"%{$search}%")
                ->orWhere('base_price', 'LIKE',"%{$search}%")
                ->orWhere('url', 'LIKE',"%{$search}%")
                ->orWhere('thumbnail', 'LIKE',"%{$search}%")
                ->count();
        }
    
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
          
                $nestedData['id'] = $post->id;
                $nestedData['sub_category_id'] = $post->sub_category_id;
                $nestedData['prod_name'] = $post->prod_name;
                $nestedData['prod_info'] = $post->prod_info;
                $nestedData['base_price'] = $post->base_price;
                $nestedData['url'] = $post->url;
                $nestedData['thumbnail'] = $post->thumbnail;
        
                array_push($data,$nestedData);
    
            }
        }
    
          // $data =[];
    
          // $allstudents = array(
          //   "draw"            => intval($request->input('draw')),  
          //   "Total"    => 0,  
          //   "Filtered" => 0, 
          //   "data"            => $data 
          //   );
    
        $allstudents = array(
        "draw"            => intval($request->input('draw')),  
        "Total"    => intval($totalData),  
        "Filtered" => intval($totalFiltered), 
        "data"            => $data 
        );
    
        return response()->json($allstudents);
    
    }



 
    


}
