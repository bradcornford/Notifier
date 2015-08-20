<?php namespace Cornford\Notifier\Listeners;

use Cornford\Notifier\Contracts\NotifierListenerInterface;
use Cornford\Notifier\Facades\NotifierFacade as Notifier;

class AfterListener implements NotifierListenerInterface
{
	/**
	 * Handle listener event.
	 *
	 * @param array $input
	 *
	 * @return void
	 */
	public function handle(array $input = [])
	{
		Notifier::storeNotifications();
	}
}
