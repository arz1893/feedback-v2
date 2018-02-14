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


Route::get('product/{tenant_id}/get-product-list', 'MasterData\ProductController@getProductList');
Route::post('product/{tenant_id}/filter-product-list', 'MasterData\ProductController@filterProductList');

Route::get('service/{tenant_id}/get-service-list', 'MasterData\ServiceController@getServiceList');
Route::post('service/{tenant_id}/filter-service-list', 'MasterData\ServiceController@filterServiceList');

Route::get('tag/{tenant_id}/get-tag-list', 'MasterData\TagController@getTagList');