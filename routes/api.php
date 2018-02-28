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

/* Product List API */
Route::get('product/{tenant_id}/get-product-list', 'MasterData\ProductController@getProductList');
Route::post('product/{tenant_id}/filter-product-list', 'MasterData\ProductController@filterProductList');

/* Complaint Product List API */
Route::get('complaint_product/{complaint_id}/get-complaint-product', 'Complaint\ComplaintProductController@getComplaintProduct');

/* Complaint Product Replies API */
Route::get('complaint_product_reply/{complaint_product_id}/get-complaint-product-replies', 'Complaint\ComplaintProductReplyController@getComplaintProductReplies');
Route::post('complaint_product_reply/{complaint_product_id}/post-reply', 'Complaint\ComplaintProductReplyController@postReply');
Route::post('complaint_product_reply/delete-reply', 'Complaint\ComplaintProductReplyController@deleteReply');

/* Suggestion Product List API */
Route::get('suggestion_product/{suggestion_product_id}/get-suggestion-product', 'Suggestion\SuggestionProductController@getSuggestionProduct');

/* Service List API */
Route::get('service/{tenant_id}/get-service-list', 'MasterData\ServiceController@getServiceList');
Route::post('service/{tenant_id}/filter-service-list', 'MasterData\ServiceController@filterServiceList');

/* Complaint Service List API */
Route::get('complaint_service/{complaint_id}/get-complaint-service', 'Complaint\ComplaintServiceController@getComplaintService');

/* Complaint Service Replies API */
Route::get('complaint_service_reply/{complaint_service_id}/get-complaint-service-replies', 'Complaint\ComplaintServiceReplyController@getComplaintServiceReplies');
Route::post('complaint_service_reply/{complaint_service_id}/post-reply', 'Complaint\ComplaintServiceReplyController@postReply');
Route::post('complaint_service_reply/delete-reply', 'Complaint\ComplaintServiceReplyController@deleteReply');

/* Suggestion Service List API */
Route::get('suggestion_service/{suggestion_service_id}/get-suggestion-service', 'Suggestion\SuggestionServiceController@getSuggestionService');

/* Tag List API */
Route::get('tag/{tenant_id}/get-tag-list', 'MasterData\TagController@getTagList');

/* Complaint Product Report API */
Route::post('complaint_product_report/get-all-statistic/{year}', 'Report\ComplaintProductReportController@getAllStatistic');

/* Complaint Service Report API */
Route::get('complaint_service_report/get-all-statistic', 'Report\ComplaintServiceReportController@getAllStatistic');