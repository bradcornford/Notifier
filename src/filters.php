<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

use Illuminate\Support\Facades\Event;

App::before(function($request)
{
	Notifier::fetchNotifications();
//	Event::fire('notifier.before', [$request]);
});

App::after(function($request, $response)
{
	Notifier::storeNotifications();
//	Event::fire('notifier.after', [$request, $response]);
});