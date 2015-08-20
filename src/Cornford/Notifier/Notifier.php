<?php namespace Cornford\Notifier;

use Cornford\Notifier\Contracts\NotifierInterface;
use Cornford\Notifier\Exceptions\NotifierException;
use DateTime;
use Exception;

class Notifier extends NotifierAbstract implements NotifierInterface {

	/**
	 * Get display notification messages.
	 *
	 * @return array
	 */
	public function getDisplayNotifications()
	{
		$notifications = [];

		foreach ($this->getNotifications() as $notification) {
			if (!$notification->isDisplayed() ||
				($notification->isDisplayed() && !$notification->isExpired()) ||
				($notification->isDisplayed() && !$notification->getExpiry() instanceof DateTime && $notification->isExpired() == 0)
			) {
				$notifications[] = $notification->__toArray();
			}
		}

		return $notifications;
	}

	/**
	 *  Update displayed status for notification messages.
	 *
	 * @return Notifier
	 */
	public function displayedAllNotifications()
	{
		foreach ($this->getNotifications() as $notification) {
			$notification->setDisplayed(true);
		}

		return $this;
	}

	/**
	 *  Expire displayed notification messages.
	 *
	 * @return Notifier
	 */
	public function expireDisplayedNotifications()
	{
		foreach ($this->getNotifications() as $key => $notification) {
			if ($notification->isExpired() && $notification->isDisplayed()) {
				unset(self::$notifications[$key]);
			}
		}

		return $this;
	}

	/**
	 *  Expire all notification messages.
	 *
	 * @return Notifier
	 */
	public function expireAllNotifications()
	{
		$this->setNotifications([]);

		return $this;
	}

	/**
	 * Fetch notifications from Session.
	 *
	 * @param array $notifications
	 *
	 * @return Notifier
	 */
	public function fetchNotifications(array $notifications = [])
	{
		if (empty($notifications)) {
			$notifications = $this->session->get('notifier.notifications', []);
		}

		$this->setNotifications($notifications);

		return $this;
	}

	/**
	 * Store notifications in Session.
	 *
	 * @param array $notifications
	 *
	 * @return Notifier
	 */
	public function storeNotifications(array $notifications = [])
	{
		if (empty($notifications)) {
			$notifications = $this->getNotifications();
		}

		$this->session->put('notifier.notifications', $notifications);

		return $this;
	}

}