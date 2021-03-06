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

Route::get('/account/{user_id}', [
  'uses' => 'PostController@indexUser',
  'as' => 'account'
]);

Route::get('/home', [
  'uses' => 'PostController@index',
  'as' => 'home'
]);

Route::get('/new',[
  'uses' => 'PostController@indexNew',
  'as' => 'new'
]);

Route::get('/trending', [
  'uses' => 'PostController@indexTrending',
  'as' => 'trending'
]);

Route::get('/tag/{tag_id}', [
  'uses' => 'PostController@indexTag',
  'as' => 'tag'
]);

Route::post('/createpost', [
  'uses' => 'PostController@postCreatePost',
  'as' => 'post.create'
]);

Route::post('/post-delete', [
  'uses' => 'PostController@postDeletePost',
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
  'uses' => 'PostController@postWriteComment',
  'as' => 'comment'
]);

Route::post('/addtag', [
  'uses' => 'PostController@postAddTag',
  'as' => 'add.tag'
]);

Route::any('/search',function(){
    $q = Request::get( 'srch-term' );
    $post = App\Post::where('body','LIKE','%'.$q.'%')->get();
    if(count($post) > 0)
        return view('search')->withDetails($post)->withQuery( $q );
    else return view ('search')->withMessage('No Details found. Try to search again !');
});
