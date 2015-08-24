<?php namespace Cornford\Notifier;

use Cornford\Notifier\Models\Notification;
use DateTime;
use Illuminate\View\Factory as View;
use Illuminate\Session\Store as Session;

abstract class NotifierAbstract {

	const JS_JQUERY_CDN = '//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js';
	const JS_JQUERY_LOCAL = 'packages/cornford/notifier/assets/js/jquery.min.js';

	const JS_NOTIFY_CDN = '//cdnjs.cloudflare.com/ajax/libs/notify/0.3.2/notify.min.js';
	const JS_NOTIFY_LOCAL = 'packages/cornford/notifier/assets/js/notify.min.js';

	const JS_NOTIFYER_CDN = 'packages/cornford/notifier/assets/js/notifier.min.js';
	const JS_NOTIFYER_LOCAL = 'packages/cornford/notifier/assets/js/notifier.min.js';

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
	 * @param string           $message
	 * @param string           $type
	 * @param DateTime|integer $expiry
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
	 * @param string           $message
	 * @param DateTime|integer $expiry
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
	 * @param string           $message
	 * @param DateTime|integer $expiry
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
	 * @param string           $message
	 * @param DateTime|integer $expiry
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
	 * @param string           $message
	 * @param DateTime|integer $expiry
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
	 * @param DateTime|integer $expiry
	 *
	 * @return void
	 */
	public function danger($message, $expiry = 0)
	{
		$this->notification($message, Notification::NOTIFICATION_TYPE_DANGER, $expiry);
	}

	/**
	 * Set options.
	 *
	 * @param array $value
	 *
	 * @return void
	 */
	public function setOptions(array $value)
	{
		$this->options = $value;
	}

	/**
	 * Get options.
	 *
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
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
	 * Include the CDN JS / Local JS files.
	 *
	 * @param string $type
	 *
	 * @return array
	 */
	protected function js($type = 'local')
	{
		$return = [];

		switch ($type) {
			case 'cdn':
				$return[] = self::JS_JQUERY_CDN;
				$return[] = self::JS_NOTIFY_CDN;
				$return[] = self::JS_NOTIFYER_CDN;
				break;
			case 'local':
			default:
				$return[] = self::JS_JQUERY_LOCAL;
				$return[] = self::JS_NOTIFY_LOCAL;
				$return[] = self::JS_NOTIFYER_LOCAL;
		}

		return $return;
	}

	/**
	 * Render assets.
	 *
	 * @param string $type
	 *
	 * @return string
	 */
	public function assets($type = 'local')
	{
		return $this->view->make('notifier::assets')
			->withOptions(json_encode($this->options))
			->withJavascripts($this->js($type))
			->render();
	}

}