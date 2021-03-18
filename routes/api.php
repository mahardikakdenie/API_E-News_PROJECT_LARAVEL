<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/login', function (Request $request) {
    return $request->user();
});
Route::post('/registrasi', 'userController@registrasi');
Route::get('/logout', 'UserController@logout');
Route::post('/login', 'UserController@login');
Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::post('/token/create', 'UserController@createToken');
    Route::patch('/password/{id}', 'UserController@updatePassword');
    Route::get('/me', 'UserController@me');
    Route::get('/logout', 'UserController@logout');
});
Route::get("/category/frontend", "CategoryController@index");
Route::get('/post/frontend', 'PostController@index');
Route::get("/post/frontend/{slug}", "PostController@showBySlug");
Route::patch('/post/{id}/approve', 'PostController@approve')->middleware('auth:sanctum');
Route::get('/post/{id}', 'PostController@showById')->middleware('auth:sanctum');
Route::get('/post/slugname/{slug}', 'PostController@showBySlug')->middleware('auth:sanctum');
Route::resource('thumbnail', "ThumbnailController")->middleware('auth:sanctum');
Route::resource('user', 'UserController')->middleware('auth:sanctum');
Route::resource('category', 'CategoryController')->middleware('auth:sanctum');
Route::resource('comment', 'CommentController')->middleware('auth:sanctum');
Route::resource('post', 'PostController')->middleware('auth:sanctum');
Route::resource('tag', 'TagController')->middleware('auth:sanctum');
Route::resource('related-site', 'RelatedSiteController')->middleware('auth:sanctum');
Route::resource('role', 'RoleController')->middleware('auth:sanctum');