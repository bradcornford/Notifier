<?php namespace spec\Cornford\Notifier\Listeners;

use Cornford\Notifier\Listeners\BeforeListener;
use PhpSpec\ObjectBehavior;
use Mockery;

class BeforeListenerSpec extends ObjectBehavior {

	function it_is_initializable()
	{
		$this->shouldHaveType('Cornford\Notifier\Contracts\NotifierListenerInterface');
	}

}
