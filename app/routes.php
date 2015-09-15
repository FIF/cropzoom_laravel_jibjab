<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'ScreensController@getScreen01');
Route::controller('screens', 'ScreensController');
Route::post("resize_and_crop", 'CropController@resizeAndCrop');
Route::controller('facebook', 'FacebookController');

Route::get('youtube/get-access-token', 'YoutubeController@getAccessToken');
Route::get('youtube/oauth2callback', 'YoutubeController@getOAuth2callback');
Route::get('youtube', 'YoutubeController@getVideos');
Route::get('youtube/get-uploads/{maxResults?}', 'YoutubeController@getMaxResult');
Route::post('youtube/videos', 'YoutubeController@postVideos');
Route::get('youtube/logout', 'YoutubeController@getLogout');