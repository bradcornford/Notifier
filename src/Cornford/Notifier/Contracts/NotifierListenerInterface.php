<?php namespace Cornford\Notifier\Contracts;

use \Illuminate\Http\Request;
use Closure;

interface NotifierListenerInterface {

	/**
	 * Run the request filter.
	 *
	 * @param Request $request
	 * @param Closure $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next);

}
