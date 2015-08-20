<?php namespace Cornford\Notifier;

use Cornford\Notifier\Models\Notification;
use DateTime;
use Illuminate\View\Factory as View;
use Illuminate\Session\Store as Session;

abstract class NotifierAbstract {

	/**
	 * View instance.
	 *
	 * @var \Illuminate\View\Factory
	 */
	protected $view;

	/**
	 * Session instance.
	 *
	 * @var \Illuminate\Session\Store
	 */
	protected $session;

	/**
	 * Options.
	 *
	 * @var array
	 */
	protected $options;

	/**
	 * Notifications array.
	 *
	 * @var array
	 */
	protected static $notifications = [];

	/**
	 * Construct Notifier.
	 *
	 * @param View    $view
	 * @param Session $session
	 * @param array   $options
	 */
	public function __construct(View $view, Session $session, array $options = [])
	{
		$this->view = $view;
		$this->session = $session;
		$this->options = $options;
	}

	/**
	 * Create a notification.
	 *
	 * @param string  $message
	 * @param string  $type
	 * @param integer $expiry
	 *
	 * @return void
	 */
	public function notification($message, $type, $expiry = 0)
	{
		self::$notifications[] = new Notification($message, $type, new DateTime('now'), $expiry);
	}

	/**
	 * Create a default notification.
	 *
	 * @param string  $message
	 * @param integer $expiry
	 *
	 * @return void
	 */
	public function none($message, $expiry = 0)
	{
		$this->notification($message, Notification::NOTIFICATION_TYPE_NONE, $expiry);
	}

	/**
	 * Create an info notification.
	 *
	 * @param string  $message
	 * @param integer $expiry
	 *
	 * @return void
	 */
	public function info($message, $expiry = 0)
	{
		$this->notification($message, Notification::NOTIFICATION_TYPE_INFO, $expiry);
	}

	/**
	 * Create a success notification.
	 *
	 * @param string  $message
	 * @param integer $expiry
	 *
	 * @return void
	 */
	public function success($message, $expiry = 0)
	{
		$this->notification($message, Notification::NOTIFICATION_TYPE_SUCCESS, $expiry);
	}

	/**
	 * Create a warning notification.
	 *
	 * @param string  $message
	 * @param integer $expiry
	 *
	 * @return void
	 */
	public function warning($message, $expiry = 0)
	{
		$this->notification($message, Notification::NOTIFICATION_TYPE_WARNING, $expiry);
	}

	/**
	 * Create a danger notification.
	 *
	 * @param string  $message
	 * @param integer $expiry
	 *
	 * @return void
	 */
	public function danger($message, $expiry = 0)
	{
		$this->notification($message, Notification::NOTIFICATION_TYPE_DANGER, $expiry);
	}

	/**
	 * Set notifications.
	 *
	 * @param array $value
	 *
	 * @return void
	 */
	public function setNotifications(array $value)
	{
		self::$notifications = $value;
	}

	/**
	 * Get notifications.
	 *
	 * @return array
	 */
	public function getNotifications()
	{
		return self::$notifications;
	}

	/**
	 *  Render assets.
	 *
	 * @return string
	 */
	public function assets()
	{
		return $this->view->make('notifier::assets')->withOptions(json_encode($this->options))->render();
	}

}