<?php namespace spec\Cornford\Notifier;

use Cornford\Notifier\Models\Notification;
use DateTime;
use PhpSpec\ObjectBehavior;
use Mockery;

class NotifierSpec extends ObjectBehavior {

	const STRING = 'message';
	const INTEGER = 0;

	const TYPE = Notification::NOTIFICATION_TYPE_NONE;

	public function getMatchers()
	{
		return [
			'haveArrayItemType' => function ($subject, $key) {
				if (!is_array($subject)) {
					return false;
				}

				if (!count($subject)) {
					return false;
				}

				return $subject[$key[0]] instanceof $key[1];
			},
			'haveArrayItemNotificationType' => function ($subject, $key) {
				if (!is_array($subject)) {
					return false;
				}

				if (!count($subject)) {
					return false;
				}

				return (is_object($subject[$key[0]]) ? $subject[$key[0]]->getType() == $key[1] : $subject[$key[0]]['type'] == $key[1]);
			},
			'haveArrayItemNotificationDisplayed' => function ($subject, $key) {
					if (!is_array($subject)) {
						return false;
					}

					if (!count($subject)) {
						return false;
					}

					return (is_object($subject[$key[0]]) ? $subject[$key[0]]->getDisplayed() == $key[1] : $subject[$key[0]]['displayed'] == $key[1]);
				},
		];
	}

	function let()
	{
		$view = Mockery::mock('Illuminate\View\Factory');
		$view->shouldReceive('make')->andReturn($view);
		$view->shouldReceive('withOptions')->andReturn($view);
		$view->shouldReceive('withJavascripts')->andReturn($view);
		$view->shouldReceive('render')->andReturn(self::STRING);
		$session = Mockery::mock('Illuminate\Session\Store');
		$session->shouldReceive('get')->andReturn([new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, [])]);
		$session->shouldReceive('put');
		$session->shouldReceive('forget');
		$this->beConstructedWith($view, $session, []);
	}

	public function it_is_initializable()
	{
		$this->shouldHaveType('Cornford\Notifier\Notifier');
	}

	public function it_can_create_a_notification()
	{
		$this->setNotifications([]);
		$this->notification(self::STRING, self::TYPE, self::INTEGER);
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'message']);
	}

	public function it_can_create_a_none_notification()
	{
		$this->setNotifications([]);
		$this->none(self::STRING, self::INTEGER);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemType([0, 'Cornford\Notifier\Models\Notification']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'message']);
	}

	public function it_can_create_an_info_notification()
	{
		$this->setNotifications([]);
		$this->info(self::STRING, self::INTEGER);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemType([0, 'Cornford\Notifier\Models\Notification']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'info']);
	}

	public function it_can_create_a_success_notification()
	{
		$this->setNotifications([]);
		$this->success(self::STRING, self::INTEGER);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemType([0, 'Cornford\Notifier\Models\Notification']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'success']);
	}

	public function it_can_create_a_warning_notification()
	{
		$this->setNotifications([]);
		$this->warning(self::STRING, self::INTEGER);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemType([0, 'Cornford\Notifier\Models\Notification']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'warn']);
	}

	public function it_can_create_a_danger_notification()
	{
		$this->setNotifications([]);
		$this->danger(self::STRING, self::INTEGER);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemType([0, 'Cornford\Notifier\Models\Notification']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'error']);
	}

	public function it_can_set_and_get_options()
	{
		$value = ['options' => 'value'];
		$this->setOptions($value);
		$this->getOptions()->shouldBeArray();
		$this->getOptions()->shouldReturn($value);
	}

	public function it_can_set_and_get_notifications()
	{
		$this->setNotifications([
			new Notification(self::STRING, self::TYPE, new DateTime('now'), self::INTEGER, [])
		]);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemType([0, 'Cornford\Notifier\Models\Notification']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'message']);
	}

	public function it_can_render_required_assets()
	{
		$this->assets()->shouldReturn(self::STRING);
	}

	public function it_can_return_an_array_of_displayable_notifications()
	{
		$notification = new Notification(self::STRING, 'error', new DateTime('now'), new DateTime('yesterday'), []);
		$notification->setDisplayed(true);
		$this->setNotifications([
			$notification,
			new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, [])
		]);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(2);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'error']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([1, 'success']);
		$this->getDisplayNotifications()->shouldBeArray();
		$this->getDisplayNotifications()->shouldHaveCount(1);
		$this->getDisplayNotifications()->shouldHaveArrayItemNotificationType([0, 'success']);
	}

	public function it_can_update_an_array_of_notifications_to_displayed()
	{
		$notification = new Notification(self::STRING, 'error', new DateTime('now'), new DateTime('yesterday'), []);
		$notification->setDisplayed(true);
		$this->setNotifications([
			$notification,
			new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, [])
		]);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(2);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'error']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([1, 'success']);
		$this->getNotifications()->shouldHaveArrayItemNotificationDisplayed([0, true]);
		$this->getNotifications()->shouldHaveArrayItemNotificationDisplayed([1, false]);
		$this->displayNotifications($this->getNotifications())->shouldReturn($this);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(2);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'error']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([1, 'success']);
		$this->getNotifications()->shouldHaveArrayItemNotificationDisplayed([0, true]);
		$this->getNotifications()->shouldHaveArrayItemNotificationDisplayed([1, true]);
	}

	public function it_should_mark_displayable_notifications_as_displayed()
	{
		$notification = new Notification(self::STRING, 'error', new DateTime('now'), new DateTime('yesterday'), []);
		$notification->setDisplayed(true);
		$this->setNotifications([
			$notification,
			new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, [])
		]);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(2);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'error']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([1, 'success']);
		$this->getNotifications()->shouldHaveArrayItemNotificationDisplayed([0, true]);
		$this->getNotifications()->shouldHaveArrayItemNotificationDisplayed([1, false]);
		$this->displayedDisplayableNotifications()->shouldReturn($this);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(2);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'error']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([1, 'success']);
		$this->getNotifications()->shouldHaveArrayItemNotificationDisplayed([0, true]);
		$this->getNotifications()->shouldHaveArrayItemNotificationDisplayed([1, true]);
	}

	public function it_should_mark_all_notifications_as_displayed()
	{
		$this->setNotifications([
			new Notification(self::STRING, 'error', new DateTime('now'), self::INTEGER, []),
			new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, []),
		]);
		$this->displayedAllNotifications()->shouldReturn($this);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(2);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'error']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([1, 'success']);
	}

	public function it_can_update_an_array_of_notifications_to_expired()
	{
		$notification = new Notification(self::STRING, 'error', new DateTime('now'), new DateTime('yesterday'), []);
		$notification->setDisplayed(true);
		$this->setNotifications([
				$notification,
				new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, [])
			]);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(2);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'error']);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([1, 'success']);
		$this->getNotifications()->shouldHaveArrayItemNotificationDisplayed([0, true]);
		$this->getNotifications()->shouldHaveArrayItemNotificationDisplayed([1, false]);
		$this->expireNotifications($this->getNotifications())->shouldReturn($this);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(0);
	}

	public function it_should_expire_displayed_notifications()
	{
		$notification = new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, []);
		$notification->setDisplayed(true);
		$this->setNotifications([
			new Notification(self::STRING, 'error', new DateTime('now'), self::INTEGER, []),
			$notification
		]);
		$this->expireDisplayedNotifications()->shouldReturn($this);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'error']);
	}

	public function it_should_expire_all_notifications_as_displayed()
	{
		$notification = new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, []);
		$notification->setDisplayed(true);
		$this->setNotifications([
			new Notification(self::STRING, 'error', new DateTime('now'), self::INTEGER, []),
			$notification
		]);
		$this->expireAllNotifications()->shouldReturn($this);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(0);
	}

	public function it_should_fetch_notifications_from_a_session()
	{
		$this->fetchNotifications()->shouldReturn($this);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'success']);
	}

	public function it_should_fetch_notifications_from_a_passed_array()
	{
		$notification = new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, []);
		$this->fetchNotifications([$notification])->shouldReturn($this);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'success']);
	}

	public function it_should_store_notifications_into_a_session()
	{
		$notification = new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, []);
		$this->setNotifications([$notification]);
		$this->storeNotifications()->shouldReturn($this);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'success']);
	}

	public function it_should_store_notifications_into_a_session_from_a_passed_array()
	{
		$notification = new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, []);
		$this->storeNotifications([$notification])->shouldReturn($this);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(1);
		$this->getNotifications()->shouldHaveArrayItemNotificationType([0, 'success']);
	}

	public function it_should_convert_an_array_of_notification_objects_to_an_array_of_arrays()
	{
		$notification = new Notification(self::STRING, 'success', new DateTime('now'), self::INTEGER, []);
		$notification->setDisplayed(true);
		$this->setNotifications([
			new Notification(self::STRING, 'error', new DateTime('now'), self::INTEGER, []),
			$notification
		]);
		$this->getNotifications()->shouldBeArray();
		$this->getNotifications()->shouldHaveCount(2);
		$this->toArray($this->getNotifications())->shouldBeArray();
		$this->toArray($this->getNotifications())->shouldHaveCount(2);
	}

}
