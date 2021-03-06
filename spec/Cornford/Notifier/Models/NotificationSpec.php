<?php namespace spec\Cornford\Notifier\Models;

use Cornford\Notifier\Models\Notification;
use DateTime;
use PhpSpec\ObjectBehavior;
use Mockery;

class NotificationSpec extends ObjectBehavior {

	const STRING = 'message';
	const INTEGER = 1;

	const TYPE = Notification::NOTIFICATION_TYPE_NONE;

	function it_is_initializable()
	{
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), self::INTEGER, array());
		$this->shouldHaveType('Cornford\Notifier\Contracts\NotifierNotificationInterface');
	}

	function it_throws_an_exception_when_constructed_with_an_invalid_id()
	{
		$this->shouldThrow('Cornford\Notifier\Exceptions\NotifierNotificationArgumentException')->during('__construct', ['', '', '', '', '', array()]);
	}

	function it_throws_an_exception_when_constructed_with_an_invalid_message()
	{
		$this->shouldThrow('Cornford\Notifier\Exceptions\NotifierNotificationArgumentException')->during('__construct', [self::INTEGER, '', '', '', '', array()]);
	}

	function it_throws_an_exception_when_constructed_with_an_invalid_type()
	{
		$this->shouldThrow('Cornford\Notifier\Exceptions\NotifierNotificationArgumentException')->during('__construct', [self::INTEGER, self::STRING, '', '', '', array()]);
	}

	function it_throws_an_exception_when_constructed_with_an_invalid_datetime()
	{
		$this->shouldThrow('Cornford\Notifier\Exceptions\NotifierNotificationArgumentException')->during('__construct', [self::INTEGER, self::STRING, self::TYPE, '', '', array()]);
	}

	function it_throws_an_exception_when_constructed_with_an_invalid_expiry()
	{
		$this->shouldThrow('Cornford\Notifier\Exceptions\NotifierNotificationArgumentException')->during('__construct', [self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), '', array()]);
	}

	function it_throws_an_exception_when_constructed_with_an_invalid_options()
	{
		$this->shouldThrow('PhpSpec\Exception\Example\ErrorException')->during('__construct', [self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), self::INTEGER, '']);
	}

	function it_should_set_and_get_an_id()
	{
		$value = 1;
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), self::INTEGER, []);
		$this->setMessage($value);
		$this->getMessage()->shouldReturn($value);
	}

	function it_should_set_and_get_a_message()
	{
		$value = 'this is a message';
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), self::INTEGER, []);
		$this->setMessage($value);
		$this->getMessage()->shouldReturn($value);
	}

	function it_should_set_and_get_a_type()
	{
		$value = Notification::NOTIFICATION_TYPE_DANGER;
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), self::INTEGER, []);
		$this->setType($value);
		$this->getType()->shouldReturn($value);
	}

	function it_should_set_and_get_a_datetime()
	{
		$value = new DateTime('now');
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, new DateTime('01-01-2001'), self::INTEGER, []);
		$this->setDatetime($value);
		$this->getDatetime()->shouldReturn($value);
	}

	function it_should_set_and_get_an_expiry_as_a_datetime()
	{
		$value = new DateTime('now');
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), new DateTime('01-01-2001'), []);
		$this->setExpiry($value);
		$this->getExpiry()->shouldReturn($value);
	}

	function it_should_set_and_get_an_expiry_as_an_integer()
	{
		$value = 2;
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), self::INTEGER, []);
		$this->setExpiry($value);
		$this->getExpiry()->shouldReturn($value);
	}

	function it_should_determine_a_notification_is_expired()
	{
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), 0, []);
		$this->isExpired()->shouldReturn(true);
	}

	function it_should_determine_a_notification_is_not_expired()
	{
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), new DateTime('tomorrow'), []);
		$this->isExpired()->shouldReturn(false);
	}

	function it_should_set_and_get_a_displayed_status()
	{
		$value = true;
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), self::INTEGER, []);
		$this->setDisplayed($value);
		$this->getDisplayed()->shouldReturn($value);
	}

	function it_should_set_and_get_an_array_of_options()
	{
		$value = ['option' => true];
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, new DateTime('now'), self::INTEGER, []);
		$this->setOptions($value);
		$this->getOptions()->shouldReturn($value);
	}

	function it_should_covert_a_notification_to_an_array()
	{
		$dateTime = new DateTime('now');
		$value = [
			'id' => self::INTEGER,
			'message' => self::STRING,
			'options' => [],
			'type' => self::TYPE,
			'datetime' => $dateTime,
			'expiry' => self::INTEGER,
			'displayed' => false,
			'expired' => false
		];
		$this->beConstructedWith(self::INTEGER, self::STRING, self::TYPE, $dateTime, self::INTEGER, []);
		$this->__toArray()->shouldReturn($value);
	}
}
