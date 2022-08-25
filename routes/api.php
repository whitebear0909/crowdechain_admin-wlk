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

Route::post('user/signup', 'UserController@signup');
Route::post('user/login', 'UserController@login');
Route::post('/user/signup/complete', 'UserController@profileComplete');
Route::post('/user/verify/email', 'UserController@verifyEmail');

//External API
Route::get('/web/external/product/participants/{id}', 'ExternalApiController@getPossiblePartecipants');
Route::get('/web/external/product/hasvehicle/{id}/{adults}/{youths}/{children}/{date?}', 'ExternalApiController@hasVehicle');
Route::get('/web/external/product/getvariations/{id}/{day}/{adults}/{youths}/{children}', 'ExternalApiController@getVariation');
Route::get('/web/external/product/getcalendar/{id}/{month}/{year?}', 'ExternalApiController@getCalendar');
Route::get('/web/external/voucher/{id}', 'ExternalApiController@printVoucher');
Route::get('/web/external/product/getavailabilitybyday/{id}/{date}', 'ExternalApiController@getAvailabityByDay');


Route::post('/web/external/order/storecart', 'ExternalApiController@storecart');
Route::put('/web/external/order/updatecart/{id}', 'ExternalApiController@updatecart');
Route::get('/web/external/product/{id}', 'ExternalApiController@getProduct');
Route::get('/web/external/products', 'ExternalApiController@getProducts');
Route::get('/web/external/product/participants/{id}', 'ExternalApiController@getPartecipants');
Route::get('/web/external/product/search/{date}/{adults}/{youths}/{children}', 'ExternalApiController@searchProducts');
Route::put('/web/external/transaction/{id}', 'ExternalApiController@updateTransaction');
Route::put('/web/external/order/updatecustomercart/{id}', 'ExternalApiController@updateCustomerCart');

Route::get('/web/external/expertGuides', 'ExternalApiController@expertGuides');
Route::get('/web/external/blogs', 'ExternalApiController@blogs');











//WEB API
Route::get('/web/products/{type?}', 'WebProductController@getAllProducts');
Route::get('/web/product/{id}', 'WebProductController@getProductDetail');
Route::get('/web/transaction/{id}', 'WebProductController@getTransaction');
Route::get('/web/aboutus', 'AboutController@getAboutus');
Route::get('/web/faqs/{id}', 'FaqController@getAllFaqs');
Route::get('/web/faqs', 'FaqController@getFaqList');
Route::get('/web/reviews', 'WebProductController@getReviews');
Route::get('/web/totalReviews', 'WebProductController@getTotalReviews');



//WEB Hall of fame
Route::get('web/halloffames/{id}', 'HalloffameController@search');
Route::get('web/halloffames', 'HalloffameController@index');


Route::post('/web/contact/us', 'ContactController@contactUs');

Route::post('/upload/file', 'ProductController@uploadImageFile');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('profile', 'UserController@getLoginProfile');
    Route::put('profile', 'UserController@updateProfile');
    Route::post('profile/upload', 'UserController@uploadProfilePicture');

    //ADMIN API
    Route::get('/product', 'ProductController@getAllProducts');
    Route::post('/product', 'ProductController@addProduct');
    Route::get('/product/{id}', 'ProductController@getProductDetail');
    Route::delete('/product/{id}', 'ProductController@deleteProduct');
    Route::put('/product/{id}', 'ProductController@updateProduct');

    Route::post('/faqs', 'FaqController@addFaq');
    Route::get('/faqs/{id}', 'FaqController@getFaq');
    Route::delete('/faqs/{id}', 'FaqController@deleteFaq');
    Route::put('/faqs/{id}', 'FaqController@updateFaq');

    Route::get('/aboutus', 'AboutController@getAboutus');
    Route::post('/aboutus', 'AboutController@addAboutus');
    Route::put('/aboutus/{id}', 'AboutController@updateAboutus');

    // Hall of Fame section
    Route::get('halloffames', 'HalloffameController@index');
    Route::get('halloffame/{id}', 'HalloffameController@show');
    Route::post('halloffame', 'HalloffameController@store');
    Route::put('halloffame', 'HalloffameController@store');
    Route::delete('halloffame/{id}', 'HalloffameController@destroy');
    


});
