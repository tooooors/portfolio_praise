<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'guest'], function(){
    
    Route::get('/top',[
            'uses' => 'UserController@getTop',
            'as' => 'top'
        ]);
    Route::get('/userSignup', 'UserController@getUserSignup');
    Route::post('/userSignup', 'UserController@postUserSignup');
    Route::get('/userRegister', 'UserController@getUserRegister');
    Route::get('/companySignup', 'CompanyController@getCompanySignup');
    Route::post('/companySignup', 'CompanyController@postCompanySignup');
    Route::get('/companyRegister', 'CompanyController@getCompanyRegister');
    Route::post('/signin', 'UserController@signin');
    
});

// ログインしていなかったらトップページにリダイレクト
Route::group(['middleware' => 'auth'], function(){
    
    Route::get('/mypage', 'MessageController@getMypage');
    Route::get('/list', 'UserController@getList');
    Route::get('/praise', 'MessageController@getPraise');
    Route::post('/praise', 'MessageController@postPraise');
    Route::get('/logout', 'UserController@getLogout');
    Route::post('/report', 'MessageController@postReport');
    Route::get('/rank', 'UserController@getRank');
    Route::get('/manage', 'UserController@getManage');
    Route::post('/manage', 'UserController@postManage');
});