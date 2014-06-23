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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/requirements', ['as' => 'requirement.index', 'uses' => 'RequirementController@index']);
Route::get('/requirement/create', ['as' => 'requirement.create', 'uses' => 'RequirementController@create']);
Route::post('/requirement', ['as' => 'requirement.store', 'uses' => 'RequirementController@store']);
Route::get('/requirement/{requirement}', ['as' => 'requirement.show', 'uses' => 'RequirementController@show']);
Route::post('/requirement/{requirement}/comment', ['as' => 'requirement.comment.store', 'uses' => 'RequirementController@storeComment']);

Route::model('requirement', 'Requirement');
