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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('apps/add/order/address/{user_id}/{distance}/{duration}/{select_city}/{store_id}/{long}/{lat}/{place_name}/{landmark}/{alt_phone}','apps\AddressController@add_o_address');
Route::get('apps/add/account/address/{user_id}/{distance}/{duration}/{select_city}/{store_id}/{long}/{lat}/{place_name}/{landmark}/{alt_phone}','apps\AddressController@add_a_address');
//this route to show stores on app to select
Route::get('apps/store/show','admin\StoreController@show');