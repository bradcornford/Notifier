<?php namespace Cornford\Notifier\Contracts;

use DateTime;
use Exception;
use Illuminate\View\Factory as View;
use Illuminate\Session\Store as Session;

interface NotifierInterface {

	/**
	 * Construct Notifier.
	 *
	 * @param View    $view
	 * @param Session $session
	 * @param array   $options
	 */
	public function __construct(View $view, Session $session, array $options = []);

	/**
	 * Create a notification.
	 *
	 * @param string           $message
	 * @param string           $type
	 * @param DateTime|integer $expiry
	 *
	 * @return void
	 */
	public function notification($message, $type, $expiry = 0);

	/**
	 * Create a default notification.
	 *
	 * @param string           $message
	 * @param DateTime|integer $expiry
	 *
	 * @return void
	 */
	public function none($message, $expiry = 0);

	/**
	 * Create an info notification.
	 *
	 * @param string           $message
	 * @param DateTime|integer $expiry
	 *
	 * @return void
	 */
	public function info($message, $expiry = 0);

	/**
	 * Create a success notification.
	 *
	 * @param string           $message
	 * @param DateTime|integer $expiry
	 *
	 * @return void
	 */
	public function success($message, $expiry = 0);

	/**
	 * Create a warning notification.
	 *
	 * @param string           $message
	 * @param DateTime|integer $expiry
	 *
	 * @return void
	 */
	public function warning($message, $expiry = 0);

	/**
	 * Create a danger notification.
	 *
	 * @param string           $message
	 * @param DateTime|integer $expiry
	 *
	 * @return void
	 */
	public function danger($message, $expiry = 0);

	/**
	 * Set notifications.
	 *
	 * @param array $value
	 *
	 * @return void
	 */
	public function setNotifications(array $value);

	/**
	 * Get notifications.
	 *
	 * @return array
	 */
	public function getNotifications();

	/**
	 *  Render assets.
	 *
	 * @return string
	 */
	public function assets();

	/**
	 * Get display notification messages.
	 *
	 * @return array
	 */
	public function getDisplayNotifications();

	/**
	 *  Update displayed status for notification messages.
	 *
	 * @return self
	 */
	public function displayedAllNotifications();

	/**
	 *  Expire displayed notification messages.
	 *
	 * @return void
	 */
	public function expireDisplayedNotifications();

	/**
	 *  Expire all notification messages.
	 *
	 * @return void
	 */
	public function expireAllNotifications();

	/**
	 * Fetch notifications from Session.
	 *
	 * @param array $notifications
	 *
	 * @return void
	 */
	public function fetchNotifications(array $notifications = []);

	/**
	 * Store notifications in Session.
	 *
	 * @param array $notifications
	 *
	 * @return void
	 */
	public function storeNotifications(array $notifications = []);

}
