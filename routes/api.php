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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::resource('buyer','Buyer\BuyerController',['only'=>['index','show']]); // just index and show
//Route::resource('buyer','Buyer\BuyerController',['except'=>['index','show']]); // all without  index and show


/**
 * User
 */
Route::resource('user','User\UserController',['except'=>['create','edit']]);


/**
 * Buyer
 */
Route::resource('buyer','Buyer\BuyerController',['only'=>['index','show']]);


/**
 * Seller
 */
Route::resource('seller','Seller\SellerController',['only'=>['index','show']]);


/**
 * Product
 */
Route::resource('product','Product\ProductController',['only'=>['index','show']]);


/**
 * Transaction
 */
Route::resource('transaction','Transaction\TransactionController',['only'=>['index','show']]);


/**
 * Category
 */
Route::resource('category','Category\CategoryController',['only'=>['index','show']]);

