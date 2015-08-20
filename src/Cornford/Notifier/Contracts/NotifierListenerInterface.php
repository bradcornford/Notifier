<?php namespace Cornford\Notifier\Contracts;

use Exception;
use Illuminate\View\Factory as View;
use Illuminate\Session\Store as Session;

interface NotifierListenerInterface {

	/**
	 * Handle listener event.
	 *
	 * @param array $input
	 *
	 * @return void
	 */
	public function handle(array $input = []);

}
