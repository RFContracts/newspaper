<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:api', 'json.response'])->get('user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->middleware('json.response')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
});

Route::prefix('posts')->middleware('json.response')->group(function () {
    Route::get('', 'PostController@index');
    Route::post('', 'PostController@store')->middleware('auth:api');
});
