<?php namespace Cornford\Notifier;

use Cornford\Notifier\Contracts\NotifierInterface;
use DateTime;

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
				($notification->isDisplayed() && !$notification->getExpiry() instanceof DateTime && $notification->getExpiry() == 0)
			) {
				$notifications[] = $notification;
			}
		}

		return $notifications;
	}

	/**
	 *  Update displayed status for passed notification messages.
	 *
	 * @param array $notifications
	 *
	 * @return self
	 */
	public function displayNotifications(array $notifications = [])
	{
		foreach ($notifications as $notification) {
			$notification->setDisplayed(true);
		}

		return $this;
	}

	/**
	 *  Update displayed status for displayable notification messages.
	 *
	 * @return self
	 */
	public function displayedDisplayableNotifications()
	{
		foreach ($this->getDisplayNotifications() as $notification) {
			$notification->setDisplayed(true);
		}

		return $this;
	}

	/**
	 *  Update displayed status for all notification messages.
	 *
	 * @return self
	 */
	public function displayedAllNotifications()
	{
		foreach ($this->getNotifications() as $notification) {
			$notification->setDisplayed(true);
		}

		return $this;
	}

	/**
	 * Expire passed notification messages.
	 *
	 * @param array $notifications
	 *
	 * @return self
	 */
	public function expireNotifications(array $notifications = [])
	{
		foreach ($notifications as $key => $notification) {
			unset(self::$notifications[$key]);
		}

		return $this;
	}

	/**
	 * Expire displayed notification messages.
	 *
	 * @return self
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
	 * @return self
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
	 * @return self
	 */
	public function fetchNotifications(array $notifications = [])
	{
		if (empty($notifications)) {
			$notifications = $this->session->get('notifier.notifications', []);
		}

		foreach ($notifications as $notification) {
			if ($notification->getId() > self::$notificationId) {
				self::$notificationId = $notification->getId();
			}
		}

		$this->setNotifications($notifications);

		return $this;
	}

	/**
	 * Store notifications in Session.
	 *
	 * @param array $notifications
	 *
	 * @return self
	 */
	public function storeNotifications(array $notifications = [])
	{
		if (empty($notifications)) {
			$notifications = $this->getNotifications();
		}

		foreach ($notifications as $notification) {
			if ($notification->getId() > self::$notificationId) {
				self::$notificationId = $notification->getId();
			}
		}

		$this->session->put('notifier.notifications', $notifications);

		return $this;
	}

	/**
	 * Convert an array of Notification objects to an array of arrays.
	 *
	 * @param array $notifications
	 *
	 * @return array
	 */
	public function toArray(array $notifications = [])
	{
		$result = [];

		foreach ($notifications as $notification) {
			$result[] = $notification->__toArray();
		}

		return $result;
	}

}