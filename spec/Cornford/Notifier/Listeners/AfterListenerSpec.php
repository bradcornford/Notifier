<?php namespace spec\Cornford\Notifier\Listeners;

use Cornford\Notifier\Listeners\AfterListener;
use PhpSpec\ObjectBehavior;
use Mockery;

class AfterListenerSpec extends ObjectBehavior {

	function it_is_initializable()
	{
		$this->shouldHaveType('Cornford\Notifier\Contracts\NotifierListenerInterface');
	}

}
