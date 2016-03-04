<?php namespace Cornford\Notifier\Listeners;

use Cornford\Notifier\Contracts\NotifierListenerInterface;
use Cornford\Notifier\Facades\NotifierFacade as Notifier;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request as HandleRequest;
use Illuminate\Http\Response as HandleResponse;

class AfterListener implements NotifierListenerInterface
{
	/**
	 * Handle listener event.
	 *
	 * @param HandleRequest  $request
	 * @param HandleResponse $response
	 *
	 * @return void
	 */
	public function handle(HandleRequest $request = null, HandleResponse $response = null)
	{
		foreach (Notifier::getOptions()['urlExceptions'] as $urlException) {
			if (stristr($request->path(), $urlException)) {
				return;
			}
		}

		Notifier::storeNotifications();
	}
}

