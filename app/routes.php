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

Route::group(['before' => 'account', 'domain' => '{account}.requirements.dev'], function()
{
  Route::get('login', ['as' => 'login', 'uses' => 'LoginController@login']);
  Route::post('login', ['as' => 'login.post', 'uses' => 'LoginController@postLogin']);
  Route::get('register', ['as' => 'register', 'uses' => 'LoginController@register']);
  Route::post('register', ['as' => 'register.post', 'uses' => 'LoginController@postRegister']);
  Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
});

Route::group(['before' => ['account', 'auth'], 'domain' => '{account}.requirements.dev', 'prefix' => '{project}'], function()
{
  Route::get('tags', ['as' => 'tags', 'uses' => 'TagController@index']);
  Route::post('tags', ['as' => 'tags', 'uses' => 'TagController@store']);

  Route::get('requirements', ['as' => 'requirement.index', 'uses' => 'RequirementController@index']);
  Route::get('requirement/create', ['as' => 'requirement.create', 'uses' => 'RequirementController@create']);
  Route::post('requirement', ['as' => 'requirement.store', 'uses' => 'RequirementController@store']);
  Route::get('requirement/{requirement}', ['as' => 'requirement.show', 'uses' => 'RequirementController@show']);
  Route::post('requirement/{requirement}/comment', ['as' => 'requirement.comment.store', 'uses' => 'RequirementController@storeComment']);
  Route::post('requirement/{requirement}/comment/{comment}/highlight', ['as' => 'highlight.store', 'uses' => 'RequirementController@storeHighlight']);
  Route::get('requirement/{requirement}/comment/{comment}/highlight/{highlight}/delete', ['as' => 'highlight.delete', 'uses' => 'RequirementController@deleteHighlight']);
});

Route::group(['before' => ['account', 'auth'], 'domain' => '{account}.requirements.dev'], function()
{
  Route::get('settings', ['as' => 'settings.index', 'uses' => 'SettingsController@index']);

  Route::get('settings/users', ['as' => 'settings.users', 'uses' => 'SettingsController@users']);
  Route::post('settings/users', ['as' => 'settings.postUser', 'uses' => 'SettingsController@postUser']);

  Route::get('settings/projects', ['as' => 'settings.projects', 'uses' => 'SettingsController@projects']);
  Route::post('settings/projects', ['as' => 'settings.postProject', 'uses' => 'SettingsController@postProject']);

  Route::get('invite/request', ['as' => 'invite.request', 'uses' => 'InviteController@request']);
  Route::get('invite/approve/{user}', ['as' => 'invite.approve', 'uses' => 'InviteController@approve']);
  Route::get('invite/accept/{inviteCode}', ['as' => 'invite.accept', 'uses' => 'InviteController@accept']);
});

Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('highlight', 'Highlight');
Route::bind('project', function($value, $route) {
  return Project::where('slug', '=', $value)->firstOrFail();
});
Route::bind('requirement', function($value, $route) {
  return $route->parameters()['project']->requirements()->findOrFail($value);
});
Route::bind('account', function($value, $route) {
  return Account::where('subdomain', '=', $value)->firstOrFail();
});
Route::bind('inviteCode', function($value, $route) {
  return Invite::where('code', '=', $value)->firstOrFail();
});
