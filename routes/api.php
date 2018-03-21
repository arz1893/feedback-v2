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
Route::get('product/{tenant_id}/filter-product-list/{tags}', 'MasterData\ProductController@filterProductList');
Route::get('product/{tenant_id}/filter-by-name/{searchString}', 'MasterData\ProductController@filterByName');

/* Complaint Product List API */
Route::get('complaint_product/{complaint_id}/get-complaint-product', 'Complaint\ComplaintProductController@getComplaintProduct');
Route::get('complaint_product/{tenant_id}/get-all-complaint-product', 'Complaint\ComplaintProductController@getAllComplaintProduct');
Route::get('complaint_product/{tenant_id}/filter-by-date/{from}/{to}', 'Complaint\ComplaintProductController@filterByDate');
Route::get('complaint_product/{tenant_id}/filter-by-product/{product_id}', 'Complaint\ComplaintProductController@filterByProduct');

/* Complaint Product Replies API */
Route::get('complaint_product_reply/{complaint_product_id}/get-complaint-product-replies', 'Complaint\ComplaintProductReplyController@getComplaintProductReplies');
Route::post('complaint_product_reply/{complaint_product_id}/post-reply', 'Complaint\ComplaintProductReplyController@postReply');
Route::post('complaint_product_reply/delete-reply', 'Complaint\ComplaintProductReplyController@deleteReply');

/* Suggestion Product List API */
Route::get('suggestion_product/{suggestion_product_id}/get-suggestion-product', 'Suggestion\SuggestionProductController@getSuggestionProduct');
Route::get('suggestion_product/{tenant_id}/get-all-suggestion-product', 'Suggestion\SuggestionProductController@getAllSuggestionProduct');
Route::get('suggestion_product/{tenant_id}/filter-by-date/{from}/{to}', 'Suggestion\SuggestionProductController@filterByDate');
Route::get('suggestion_product/{tenant_id}/filter-by-product/{product_id}', 'Suggestion\SuggestionProductController@filterByProduct');

/* Service List API */
Route::get('service/{tenant_id}/get-service-list', 'MasterData\ServiceController@getServiceList');
Route::get('service/{tenant_id}/filter-service-list/{tags}', 'MasterData\ServiceController@filterServiceList');
Route::get('service/{tenant_id}/filter-by-name/{searchString}', 'MasterData\ServiceController@filterByName');

/* Complaint Service List API */
Route::get('complaint_service/{complaint_id}/get-complaint-service', 'Complaint\ComplaintServiceController@getComplaintService');
Route::get('complaint_service/{tenant_id}/get-all-complaint-service', 'Complaint\ComplaintServiceController@getAllComplaintService');
Route::get('complaint_service/{tenant_id}/filter-by-date/{from}/{to}', 'Complaint\ComplaintServiceController@filterByDate');
Route::get('complaint_service/{tenant_id}/filter-by-service/{service_id}', 'Complaint\ComplaintServiceController@filterByService');

/* Complaint Service Replies API */
Route::get('complaint_service_reply/{complaint_service_id}/get-complaint-service-replies', 'Complaint\ComplaintServiceReplyController@getComplaintServiceReplies');
Route::post('complaint_service_reply/{complaint_service_id}/post-reply', 'Complaint\ComplaintServiceReplyController@postReply');
Route::post('complaint_service_reply/delete-reply', 'Complaint\ComplaintServiceReplyController@deleteReply');

/* Suggestion Service List API */
Route::get('suggestion_service/{tenant_id}/get-all-suggestion-service', 'Suggestion\SuggestionServiceController@getAllSuggestionService');
Route::get('suggestion_service/{tenant_id}/filter-by-date/{from}/{to}', 'Suggestion\SuggestionServiceController@filterByDate');
Route::get('suggestion_service/{suggestion_service_id}/get-suggestion-service', 'Suggestion\SuggestionServiceController@getSuggestionService');
Route::get('suggestion_service/{tenant_id}/filter-by-service/{service_id}', 'Suggestion\SuggestionServiceController@filterByService');

/* Tag List API */
Route::get('tag/{tenant_id}/get-tag-list', 'MasterData\TagController@getTagList');

/* Complaint Product Report API */
Route::get('complaint_report/{tenantId}/get-all-complaint/yearly/', 'Report\Complaint\ComplaintReportController@getAllComplaintYearly');

/* Customer API */
Route::post('customer/add-customer', 'Customer\CustomerController@addCustomer');
Route::post('customer/get-customer', 'Customer\CustomerController@getCustomer');
Route::post('customer/update-customer', 'Customer\CustomerController@updateCustomer');

/* Complaint Product API */
Route::get('complaint_product_report/show-all-report/{tenantId}/yearly/{year}', 'Report\Complaint\Product\ComplaintProductReportController@showDataComplaintProductYearly');
Route::get('complaint_product_report/show-all-report/{tenantId}/monthly/{year}/{month}', 'Report\Complaint\Product\ComplaintProductReportController@showDataComplaintProductMonthly');

/* Complaint Service API */
Route::get('complaint_service_report/show-all-report/{tenantId}/yearly/{year}', 'Report\Complaint\Service\ComplaintServiceReportController@showDataComplaintServiceYearly');
Route::get('complaint_service_report/show-all-report/{tenantId}/monthly/{year}/{month}', 'Report\Complaint\Service\ComplaintServiceReportController@showDataComplaintServiceMonthly');