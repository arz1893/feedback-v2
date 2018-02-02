<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/faq', function () {
    return view('faq.faq_selection');
});

Route::get('/complaint', function () {
    return view('complaint.complaint_selection');
});

Route::get('/suggestion', function () {
    return view('suggestion.suggestion_selection');
});

/* Authentication Routes */
Auth::routes();
Route::get('/company-login', 'Auth\LoginController@companyLogin')->name('company_login');
Route::post('/check-tenant', 'Auth\LoginController@checkTenant')->name('check_tenant');
/* end of authentication routes */

/* Password Reset Routes */
//Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password_reset');
//Route::post('password/email', 'Auth\ResetPasswordController@sendResetLinkEmail');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');
/* end of password reset routes */

/* Product Routes */
Route::resource('product', 'MasterData\ProductController');
Route::put('product/change-picture/{Product}', 'MasterData\ProductController@changePicture')->name('change_product_picture');
Route::post('product/delete-product', 'MasterData\ProductController@deleteProduct')->name('delete_product');
/* end of product routes */

/* Product Category Routes */
Route::post('product_category/get-category', 'MasterData\ProductCategoryController@getProductCategory');
Route::post('product_category/update-category', 'MasterData\ProductCategoryController@updateProductCategory');
Route::post('product_category/get-childs', 'MasterData\ProductCategoryController@getChilds');
Route::post('product_category/get-trees', 'MasterData\ProductCategoryController@getTrees');
Route::post('product_category/get-category', 'MasterData\ProductCategoryController@getCategory');
Route::post('product_category/add-child-node', 'MasterData\ProductCategoryController@addChildNode');
Route::post('product_category/rename-node', 'MasterData\ProductCategoryController@renameNode');
Route::post('product_category/delete-node', 'MasterData\ProductCategoryController@removeNode');
Route::post('product_category/delete-product-category', 'MasterData\ProductCategoryController@deleteProductCategory');
Route::resource('product_category', 'MasterData\ProductCategoryController');
/* end of product category route */

/* Service Routes */
Route::resource('service', 'MasterData\ServiceController');
Route::put('service/change-picture/{Service}', 'MasterData\ServiceController@changePicture')->name('change_service_picture');
Route::post('service/delete-service', 'MasterData\ServiceController@deleteService')->name('delete_service');
/* end of service routes */

/* Service Category Routes */
Route::post('service_category/get-trees', 'MasterData\ServiceCategoryController@getTrees');
Route::post('service_category/get-childs', 'MasterData\ServiceCategoryController@getChilds');
Route::post('service_category/get-category', 'MasterData\ServiceCategoryController@getCategory');
Route::post('service_category/rename-category', 'MasterData\ServiceCategoryController@renameServiceCategory');
Route::post('service_category/delete-category', 'MasterData\ServiceCategoryController@deleteServiceCategory');
Route::post('service_category/add-child-node', 'MasterData\ServiceCategoryController@addChildNode');
Route::post('service_category/rename-node', 'MasterData\ServiceCategoryController@renameNode');
Route::post('service_category/delete-node', 'MasterData\ServiceCategoryController@deleteNode');
Route::resource('service_category', 'MasterData\ServiceCategoryController');
/* end of service category route */

/* Faq Product Routes */
Route::resource('faq_product', 'Faq\FaqProductController');
Route::post('faq_product/delete-faq-product', 'Faq\FaqProductController@deleteFaqProduct')->name('delete_faq_product');
/* end of faq product routes */

/* Faq Service Routes */
Route::resource('faq_service', 'Faq\FaqServiceController');
Route::post('faq_service/delete-faq-service', 'Faq\FaqServiceController@deleteFaqService')->name('delete_faq_service');
/* end of faq service routes */

/* Complaint Product Routes */
Route::resource('complaint_product', 'Complaint\ComplaintProductController');
Route::get('complaint_product/show-product/{Product}/{CurrentNodeId}', 'Complaint\ComplaintProductController@showProduct')->name('show_complaint_product');
/* end of complaint product routes */

/* Complaint Product List Routes */
Route::resource('complaint_product_list', 'Complaint\ComplaintProductListController');
Route::post('complaint_product_list/delete-complaint-product', 'Complaint\ComplaintProductListController@deleteComplaintProduct')->name('delete_complaint_product');
Route::post('complaint_product_list/{id}/change-attachment', 'Complaint\ComplaintProductListController@changeAttachment')->name('change_complaint_product_attachment');
Route::post('complaint_product_list/delete-attachment', 'Complaint\ComplaintProductListController@deleteAttachment')->name('delete_complaint_product_attachment');
/* end of complaint product list routes */

/* Complaint Product Reply Routes */
Route::resource('complaint_product_reply', 'Complaint\ComplaintProductReplyController');
Route::post('complaint_product_reply/delete-reply', 'Complaint\ComplaintProductReplyController@deleteReply');
/* end of complaint product reply routes */

/* Complaint Service Routes */
Route::resource('complaint_service', 'Complaint\ComplaintServiceController');
Route::get('complaint_service/show-service/{Service}/{CurrentNodeId}', 'Complaint\ComplaintServiceController@showService')->name('show_complaint_service');
/* end of complaint service routes */

/* Complaint Service List Routes */
Route::resource('complaint_service_list', 'Complaint\ComplaintServiceListController');
Route::post('complaint_service_list/delete-complaint-service', 'Complaint\ComplaintServiceListController@deleteComplaintService')->name('delete_complaint_service');
Route::post('complaint_service_list/{id}/change-attachment', 'Complaint\ComplaintServiceListController@changeAttachment')->name('change_complaint_service_attachment');
/* end of complaint service list routes */

/* Complaint Service Reply Routes */
Route::resource('complaint_service_reply', 'Complaint\ComplaintServiceReplyController');
Route::post('complaint_service_reply/delete-reply', 'Complaint\ComplaintServiceReplyController@deleteReply');
/* end of complaint service reply routes */

/* Suggestion Product Routes */
Route::resource('suggestion_product', 'Suggestion\SuggestionProductController');
Route::get('suggestion_product/show-product/{Product}/{CurrentNodeId}', 'Suggestion\SuggestionProductController@showProduct')->name('show_suggestion_product');
/* end of suggestion product routes */

/* Suggestion Product List Routes */
Route::resource('suggestion_product_list', 'Suggestion\SuggestionProductListController');
Route::post('suggestion_product_list/delete-suggestion-product', 'Suggestion\SuggestionProductListController@deleteSuggestionProduct')->name('delete_suggestion_product');
/* end of suggestion product list routes */

/* Suggestion Service Routes */
Route::resource('suggestion_service', 'Suggestion\SuggestionServiceController');
Route::get('suggestion_service/show-service/{Service}/{CurrentNodeId}', 'Suggestion\SuggestionServiceController@showService')->name('show_suggestion_service');
/* end of suggestion service routes */

/* Suggestion Service List Routes */
Route::resource('suggestion_service_list', 'Suggestion\SuggestionServiceListController');
Route::post('suggestion_service_list/delete-suggestion-service', 'Suggestion\SuggestionServiceListController@deleteSuggestionService')->name('delete_suggestion_service');
/* end of suggestion service list routes */

/* Question Routes */
Route::resource('question', 'Question\QuestionController');
/* end of question routes */

/* Question List Routes */
Route::resource('question_list', 'Question\QuestionListController');
Route::post('question_list/delete-question', 'Question\QuestionListController@deleteQuestion');
/* end of question list routes */

/* Customer Complaint Routes */
Route::resource('customer', 'Customer\CustomerController');
/* end of customer routes */

/* User Management Routes */
Route::resource('user', 'User\UserController');
Route::post('user/invite', 'User\UserController@sendInvitation');
Route::get('register/accept/{token}', 'Auth\RegisterController@acceptInvitation');
Route::post('register/via-invitation/{id}', 'Auth\RegisterController@registerViaEmail')->name('register_via_invitation');
/* end of user management */
