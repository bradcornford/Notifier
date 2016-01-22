<?php namespace Cornford\Notifier\Listeners;

use Cornford\Notifier\Contracts\NotifierListenerInterface;
use Cornford\Notifier\Facades\NotifierFacade as Notifier;
use \Illuminate\Http\Request;
use Closure;

class AfterListener implements NotifierListenerInterface
{
	/**
	 * Run the request filter.
	 *
	 * @param Request $request
	 * @param Closure $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$response = $next($request);

		Notifier::storeNotifications();

		return $response;
	}

	/**
	 * Run the request filter.
	 *
	 * @return void
	 */
	public function filter()
	{
		Notifier::storeNotifications();
	}
}
