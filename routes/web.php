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

Auth::routes();

Route::get('transaction/availabledistricts', 'transactionController@getavailabledistricts')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');;


Route::resource('data','addDataController')->middleware('auth');;
Route::resource('transaction','transactionController')->middleware('auth');

/*Routes for dependency dropdown starts*/
Route::get('data/getdistricts/{id}','addDataController@getDistricts');
Route::get('data/getupazilas/{id}','addDataController@getUpazilas');
Route::get('data/getunions/{id}','addDataController@getUnions');
/*Routes for dependency dropdown end*/

/*Routes for dependency dropdown starts for transaction*/
Route::get('transaction/getdistricts/{id}','transactionController@getDistricts');
Route::get('transaction/getupazilas/{id}','transactionController@getUpazilas');
Route::get('transaction/getunions/{id}','transactionController@getUnions');


Route::get('transaction/getnumoftrans/{id}','transactionController@numberOfTrans');


Route::get('data/totalmm/{id}','addDataController@getTotalMm');
Route::get('data/activemm/{id}','addDataController@getActiveMm');



/*Routes for dependency dropdown for transaction end*/

