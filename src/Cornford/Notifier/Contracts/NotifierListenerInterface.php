<?php namespace Cornford\Notifier\Contracts;

use Illuminate\Http\Request as HandleRequest;
use Illuminate\Http\Response as HandleResponse;

interface NotifierListenerInterface {

	/**
	 * Handle listener event.
	 *
	 * @param HandleRequest  $request
	 * @param HandleResponse $response
	 *
	 * @return void
	 */
	public function handle(HandleRequest $request = null, HandleResponse $response = null);

}

