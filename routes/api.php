<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/allUser', array('middleware' => 'cors','uses'=>'UserController@getAllUser'));
Route::post('/signup',array('middleware' => 'cors','uses'=>'UserController@createUser' ));
Route::get('/getUser/{id}',array('middleware' => 'cors','uses'=>'UserController@getUser' ));
Route::post('/login',array('middleware' => 'cors','uses'=>'UserController@login' )); 

// Route::get('/alluff/{name?}', [UserController::class, 'alluff']);
// Route::get('/search/{query?}', [UserController::class, 'search']);
 

Route::get('/getUserDetails/{id}', array('middleware' => 'cors','uses'=>'UserController@getUserDetails'));
Route::post('/AddUserDetails/{user_id}', array('middleware' => 'cors','uses'=>'UserController@AddUserDetails'));
Route::delete('/deleteUserDetails/{id}',array('middleware' => 'cors','uses'=>'UserController@deleteUserDetails' ));
Route::put('/editUserDetails/{id}',array('middleware' => 'cors','uses'=>'UserController@updateUser_details' ));



// Route::get('/getAllCategory', [CategoryController::class, 'getAllCategory']);
Route::get('/getAllCategory',array('middleware' => 'cors', 'uses' => 'CategoryController@getAllCategory') );
Route::get('/categoryFilter',array('middleware' => 'cors', 'uses' => 'CategoryController@filterCategory') ); 
Route::get('/index',array('middleware' => 'cors','uses'=>'CategoryController@index' ));      
Route::post('/addCategory',array('middleware' => 'cors','uses'=>'CategoryController@createCategory' ));  
Route::put('/editCategory/{id}',array('middleware' => 'cors','uses'=>'CategoryController@updateCategory' ));      
Route::delete('/deleteCategory/{id}',array('middleware' => 'cors','uses'=>'CategoryController@deleteCategory' ));  
 
Route::post('/addSubcategory',array('middleware' => 'cors','uses'=>'CategoryController@createSubcategory' ));      
Route::put('/editSubcategory/{id}',array('middleware' => 'cors','uses'=>'CategoryController@updateSubcategory' ));      
Route::delete('/deleteSubcategory/{id}',array('middleware' => 'cors','uses'=>'CategoryController@deleteSubcategory' ));      
 


// Route::get('/getAllProduct', [ProductController::class, 'getAllProduct']);
Route::get('/getAllProduct',array('middleware' => 'cors', 'uses' => 'ProductController@getAllProduct') );
Route::post('/product_list',array('middleware' => 'cors','uses'=>'ProductController@filterProduct' ));
// Route::get('/getproduct_list',array('middleware' => 'cors','uses'=>'ProductController@getfilterProduct' ));

Route::get('/productFilter',array('middleware' => 'cors','uses'=>'ProductController@filterProd' )); 

Route::post('/addProduct',array('middleware' => 'cors','uses'=>'ProductController@createProduct' )); 
Route::put('/editProduct/{id}',array('middleware' => 'cors','uses'=>'ProductController@updateProduct' ));   



// Route::get('example', array('middleware' => 'cors', 'uses' => 'ExampleController@dummy'));

Route::get('/getCartDetails/{uid}', array('middleware' => 'cors','uses'=>'CartController@getCart')); 
Route::post('/cart', array('middleware' => 'cors','uses'=>'CartController@cart')); 
Route::delete('/deleteCart/{id}', array('middleware' => 'cors','uses'=>'CartController@deleteCartItem')); 


Route::post('/order', array('middleware' => 'cors','uses'=>'OrderController@createOrder'));   





Route::post('/addPayment', array('middleware' => 'cors','uses'=>'PaymentController@createPayment'));   
Route::get('/getAllPayments', array('middleware' => 'cors','uses'=>'PaymentController@getAllPayments'));   
Route::put('/editPayments/{id}', array('middleware' => 'cors','uses'=>'PaymentController@updatePayment'));   
Route::delete('/deletePayments/{id}', array('middleware' => 'cors','uses'=>'PaymentController@deletePayment'));   

 










Route::get('/getAllCatSubcatProd',array('middleware' => 'cors', 'uses' => 'CategoryController@getAllCatSubcatProd') );

Route::post('/createcategorytest',array('middleware' => 'cors','uses'=>'CategoryController@createcategorytest' ));  

