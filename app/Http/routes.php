<?php

Route::auth();
Route::get('/', 'HomeController@index');
Route::get('post/{id}', 'PostController@show');
Route::get('posts', 'PostController@lists');
Route::get('posts/topic/{id}', 'PostController@listsByTopicId');
Route::get('topics', 'TopicController@all'); // like stackoverflow (show posts number of every topics)

Route::group(['middleware' => 'auth'], function() {
    Route::get('profile', 'UserController@profile');
    Route::get('post', 'PostController@create');
    Route::post('post', 'PostController@store');
    Route::post('posts/update', 'PostController@storeWithUpdate');
    Route::get('post/{id}/update', 'PostController@update');
    Route::post('upload/postImage', 'PostController@uploadPostImage');
});

//admin routes
Route::group(['prefix' => 'admin', 'namespace' => 'Admin\Auth'], function() {
    Route::get('login', 'AuthController@getLogin');
    Route::post('login', 'AuthController@postLogin');
    Route::get('register', 'AuthController@getRegister');
    Route::post('register', 'AuthController@postRegister');
    Route::get('logout', 'AuthController@logout');
});

Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', 'HomeController@index');

    Route::get('/topics', 'TopicController@all');
});
