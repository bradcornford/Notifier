<?php namespace Cornford\Notifier\Controllers;

use BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Cornford\Notifier\Facades\NotifierFacade as Notifier;
use Illuminate\Support\Facades\Route;

class NotifierController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if ((Request::ajax() && Route::is('notifier.index')) || !Request::ajax()) {
			Notifier::expireDisplayedNotifications();
		}

		$notifications = Notifier::getDisplayNotifications();

		if ((Request::ajax() && Route::is('notifier.index')) || !Request::ajax()) {
			Notifier::displayNotifications($notifications);
		}

		return Response::json(['notifications' => Notifier::toArray($notifications)]);
	}

}