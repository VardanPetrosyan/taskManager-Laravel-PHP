<?php

use Illuminate\Http\Request;

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

Route::prefix('auth')->group(function(){
    // Registration Routes...
    Route::post('register', 'RegisterController@register');

    // JWT Routes
    Route::post('login', 'AuthController@login');
//    Route::post('login', function (Request $request){
//        dd($request);
//    });
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::post('/user/change', 'UserController@change');
    Route::post('/my/users', 'UserController@getUsers');
    Route::post('/update/users', 'UserController@updateUsers');
    Route::post('/delete/users', 'UserController@deleteUsers');
    Route::post('/add/users', 'UserController@addUsers');
    Route::post('/user/get', "UserController@select");
    Route::post('/category', 'categoryController@getCategories');

    Route::get('/getFurnitureCategories', 'categoryController@getFurnitureCategories');

    Route::post('/getFurnitures', 'FurnituresController@getFurnitures');
    Route::get('/getUsernames/{id}', 'UserController@getUsernames');
    Route::post('/my/furniture', 'FurnituresController@getMyFurnitures');
    Route::post('/orderAll/furniture', 'FurnituresController@getOrderAllFurnitures');
    Route::post('/confirmOrder/furniture', 'FurnituresController@confirmOrderFurnitures');
    Route::post('/cancelOrder/furniture', 'FurnituresController@cancelOrderFurnitures');
    Route::post('/deleteOrder/furniture', 'FurnituresController@deleteOrderFurnitures');
    Route::get('/getWorkers/{id}', 'FurnituresController@getWorkers');
    Route::post('/add/furniture', 'FurnituresController@addFurniture');
    Route::post('/delete/furniture', 'FurnituresController@deleteFurniture');
    Route::post('/send/furniture', 'FurnituresController@sendFurniture');
    Route::post('/update/furniture', 'FurnituresController@updateFurniture');
    Route::post('/updateTransfer/furniture', 'FurnituresController@updateFurnitureTransfer');
    Route::post('/updateStatus/furniture', 'FurnituresController@updateStatusFurniture');
    Route::post('/confirm/furniture', 'FurnituresController@confirmFurniture');
    Route::post('/order/furniture', 'FurnituresController@orderFurniture');
    Route::post('/cancel/order/furniture', 'FurnituresController@cancelOrderFurniture');

    Route::post('/products', 'productController@getProduct');

    Route::post('/productsAndFurnitures', 'productController@getProductsAndFurnitures');



    Route::post('/products/units', 'productController@getUnits');
    Route::post('/search', 'searchController@index');

    Route::post('/order', 'orderController@index');
    Route::post('/my/orders', 'orderController@myOrders');
    Route::post('/my/orders/cancel', 'orderController@cancelOrder');
    Route::post('/my/orders/reorder', 'orderController@reorder');
    Route::post('/my/orders/archive', 'orderController@toArchive');

    Route::post('/products/reserve', 'orderController@reserve');

    Route::post('/categoriesStructure', 'SchoolController@index');

});




//
//Route::middleware('auth:api')->group(function () {
//    Route::ApiResource('tasks', 'TasksController');
//    Route::delete('tasks', 'TasksController@deleteCompletedTasks');
//});
//
//Route::apiResource('companies', 'CompanyController');
