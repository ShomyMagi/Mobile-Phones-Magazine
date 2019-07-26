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

Route::get('/', 'UredjajController@index');
Route::get('/about', 'UserController@about');
Route::get('/archive/{id?}', 'UredjajController@archive');
Route::post('/about/sendMail', 'UserController@sendMail');
Route::get('/search/{id?}', 'UredjajController@search');
Route::get('/register', 'FrontEndController@getRegister');
Route::post('/register/reg', 'UserController@register');
Route::post('/register/log', 'UserController@login');
Route::get('/onePost/{id}/{cId?}', 'UredjajController@onePost');

Route::group(['middleware' => 'user'], function()
{
    Route::get('/user', 'UserController@userPage');
    Route::get('/user/show/{id}', 'UserController@showUser');
    Route::post('/user/update/{id}', 'UserController@editUser');
    Route::post('/onePost/{id}/post', 'CommentController@insertComment');
    Route::get('/onePost/{id}/delete/{cId}', 'CommentController@deleteComment');
    Route::post('/onePost/{id}/{cId}', 'CommentController@editComment');
    Route::get('/logout', 'UserController@logout')->name('logout');
});

Route::group(['middleware' => 'admin'], function()
{
    Route::get('/admin/users/{id?}', 'AdminController@getUsers')->name('admin_users');
    Route::get('/admin/posts/{id?}', 'AdminController@getPosts')->name('admin_posts');
    Route::get('/admin/images/{id?}', 'AdminController@getImages')->name('admin_images');
    Route::get('/admin/comments/{id?}', 'AdminController@getComments')->name('admin_comments');
    Route::get('/admin/navigation/{id?}', 'AdminController@getNavigation')->name('admin_navigation');
    Route::get('/admin/roles/{id?}', 'AdminController@getRoles')->name('admin_roles');
    
    Route::post('/admin/user/insert', 'UserController@insertUser');
    Route::post('/admin/post/insert', 'UredjajController@insertPost');
    Route::post('/admin/image/insert', 'SlikaController@insertImage');
    Route::post('/admin/comment/insert', 'CommentController@insertAdminComment');
    Route::post('/admin/navigation/insert', 'NavigationController@insertNavigation');
    Route::post('/admin/role/insert', 'UlogaController@insertRole');
    
    Route::post('/admin/user/update/{id}', 'UserController@updateUser');
    Route::post('/admin/post/update/{id}', 'UredjajController@updatePost');
    Route::post('/admin/image/update/{id}', 'SlikaController@updateSlika');
    Route::post('/admin/comment/update/{id}', 'CommentController@updateComment');
    Route::post('/admin/navigation/update/{id}', 'NavigationController@updateNavigation');
    Route::post('/admin/role/update/{id}', 'UlogaController@updateRole');
    
    Route::get('/admin/user/delete/{id}', 'UserController@deleteUser');
    Route::get('/admin/post/delete/{id}', 'UredjajController@deletePost');
    Route::get('/admin/image/delete/{id}', 'SlikaController@deleteImage');
    Route::get('/admin/comment/delete/{id}', 'CommentController@deleteAdminComment');
    Route::get('/admin/navigation/delete/{id}', 'NavigationController@deleteNavigation');
    Route::get('/admin/role/delete/{id}', 'UlogaController@deleteRole');
});
