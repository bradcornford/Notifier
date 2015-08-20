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

use Cornford\Notifier\Facades\NotifierFacade as Notifier;

Route::group(array('prefix' => 'notifier', 'namespace' => 'Cornford\Notifier\Controllers'), function()
{
	Route::get(
		'notifications',
		['as' => 'notifier.index', 'uses' => 'NotifierController@index']
	);
});


