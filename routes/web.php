<?php

Auth::routes();

Route::post('/api/friends/request/add', 'Api\RequestController@add');
Route::post('/api/friends/request/accept', 'Api\RequestController@accept');
Route::post('/api/friends/request/remove', 'Api\RequestController@remove');
Route::post('/api/friends/request/reject', 'Api\RequestController@reject');
Route::post('/api/friends/request/take-back', 'Api\RequestController@take_back');
Route::post('/api/form/setting/update', 'Api\SettingController@update');
Route::post('/api/chat/message', 'Api\ChatController@get_message');
Route::post('/api/chat/message/submit',  'Api\ChatController@submit_message');

Route::group(['middleware' => ['auth', 'isactive']], function () {
    
    Route::get('/', 'Web\IndexController@index');
    
    Route::get('/requests', 'Web\IndexController@requests');
    Route::get('/friends', 'Web\IndexController@friends');

    Route::get('/profile/{id}', 'Web\ProfileController@index');
    Route::get('/settings', 'Web\SettingController@index');

    Route::get('/chat', 'Web\ChatController@index');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
});