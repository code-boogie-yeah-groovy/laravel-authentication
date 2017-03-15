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

Route::group(['prefix' => 'auth/{provider}'], function () {
  Route::get('/', 'Auth\LoginController@redirectToProvider');
  Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
});

Route::get('/edit-account',[
  'uses' => 'UserController@getEditAccount',
  'as' => 'account.edit'
]);

Route::post('/updateaccount', [
  'uses' => 'UserController@postSaveAccount',
  'as' => 'account.save'
]);

Route::get('/account', [
  'uses' => 'UserController@getAccount',
  'as' => 'account'
]);

Route::get('/home', [
  'uses' => 'PostController@index',
  'as' => 'home'
]);

Route::post('/createpost', [
  'uses' => 'PostController@postCreatePost',
  'as' => 'post.create'
]);

Route::get('/post-delete/{post_id}', [
  'uses' => 'PostController@getPostDelete',
  'as' => 'post.delete'
]);

Route::post('/edit', [
  'uses' => 'PostController@postEditPost',
  'as' => 'edit'
]);

Route::post('/vote', [
  'uses' => 'PostController@postVotePost',
  'as' => 'vote'
]);

Route::get('/writecomment', [
  'uses' => 'PostController@getWriteComment',
  'as' => 'comment.write'
]);
