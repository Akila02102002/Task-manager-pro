<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('task_manager/list', "App\Http\Controllers\TaskManagerController@list");
Route::post('task_manager/listAll', "App\Http\Controllers\TaskManagerController@getList");
Route::post('task_manager/save', "App\Http\Controllers\TaskManagerController@save");
Route::delete('task_manager/delete/{id}', "App\Http\Controllers\TaskManagerController@delete");
Route::get('task_manager/view/{id}', "App\Http\Controllers\TaskManagerController@view");



