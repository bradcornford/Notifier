<?php namespace Cornford\Notifier\Facades;

use Illuminate\Support\Facades\Facade;

class NotifierFacade extends Facade {

	protected static function getFacadeAccessor() { return 'notifier'; }

}
