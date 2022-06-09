<?php

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\EmailVerificationController;
use Illuminate\Support\Facades\Mail;



// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);


Route::get('allusers','Api\UserController@index');
Route::get('show/{id}','Api\UserController@show');
Route::post('userstore','Api\UserController@store');
Route::post('userupdate/{id}','Api\UserController@update');

Route::group (['prefix'=>'Products'], function()
{
    Route::get('/', 'Api\ProductController@index');
    Route::post('/store', 'Api\ProductController@store');
    Route::post('update/{id}', 'Api\ProductController@update');
    Route::get('delete/{id}', 'Api\ProductController@destroy');
    Route::get('productsUsers','Api\ProductController@productsUsers');
});


Route::group (['prefix'=>'productImages'], function()
{
    Route::post('/store', 'Api\ImageController@store');
});


Route::get('send-mail', function () {

    // Email data details
    $details = [
        'title' => 'Email to Multiple Users with products info',
        'body' => 'This is sample content we have added for this test mail sending to multiple users.'
    ];

    // Email to users
    $users = [
        "waleed@gmail.com",
    ];

    foreach ($users as $user) { // sending mail to users.

        Mail::to($user)->send(new \App\Mail\productMail($details));
    }

    dd("Email is Sent, please check your inbox."); // to check about sending
});