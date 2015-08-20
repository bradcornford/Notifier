<?php namespace Cornford\Notifier\Models;

use Cornford\Notifier\Contracts\NotifierNotificationInterface;
use Cornford\Notifier\Exceptions\NotifierNotificationArgumentException;
use DateInterval;
use DateTime;

class Notification implements NotifierNotificationInterface {

	const NOTIFICATION_TYPE_NONE = 'message';
	const NOTIFICATION_TYPE_INFO = 'info';
	const NOTIFICATION_TYPE_SUCCESS = 'success';
	const NOTIFICATION_TYPE_WARNING = 'warning';
	const NOTIFICATION_TYPE_DANGER = 'error';

	/**
	 * Options.
	 *
	 * @var array
	 */
	protected $options = [];

	/**
	 * Notification message.
	 *
	 * @var string
	 */
	protected $message;

	/**
	 * Notification message type.
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Notification message types.
	 *
	 * @var array
	 */
	private $types = [
		self::NOTIFICATION_TYPE_NONE,
		self::NOTIFICATION_TYPE_INFO,
		self::NOTIFICATION_TYPE_SUCCESS,
		self::NOTIFICATION_TYPE_WARNING,
		self::NOTIFICATION_TYPE_DANGER
	];

	/**
	 * Notification message date time.
	 *
	 * @var DateTime
	 */
	protected $datetime;

	/**
	 * Notification message expiry in minutes.
	 *
	 * @var DateTime|integer
	 */
	protected $expiry;

	/**
	 * Notification message displayed status.
	 *
	 * @var boolean
	 */
	protected $displayed = false;

	/**
	 * Constructor.
	 *
	 * @param string           $message
	 * @param string           $type
	 * @param DateTime         $datetime
	 * @param DateTime|integer $expiry
	 * @param array            $options
	 *
	 * @throws NotifierNotificationArgumentException
	 */
	public function __construct($message, $type, $datetime, $expiry = 0, array $options = [])
	{
		if (empty($message) || !is_string($message)) {
			throw new NotifierNotificationArgumentException('Invalid message supplied.');
		}

		if (empty($message) || !in_array($type, $this->types)) {
			throw new NotifierNotificationArgumentException('Invalid message type supplied.');
		}

		if (!$datetime instanceof DateTime) {
			throw new NotifierNotificationArgumentException('Invalid message date time supplied.');
		}

		if (!is_numeric($expiry) && !$expiry instanceof DateTime) {
			throw new NotifierNotificationArgumentException('Invalid message expiry supplied.');
		}

		$this->setMessage($message);
		$this->setType($type);
		$this->setDatetime($datetime);
		$this->setExpiry($expiry);
		$this->setOptions($options);
	}

	/**
	 * Set the notification message.
	 *
	 * @param string $value
	 *
	 * @return void
	 */
	public function setMessage($value)
	{
		$this->message = $value;
	}

	/**
	 * Get the notification message.
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * Set the notification message type.
	 *
	 * @param string $value
	 *
	 * @return void
	 */
	public function setType($value)
	{
		$this->type = $value;
	}

	/**
	 * Get the notification message.
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Set the notification message date time.
	 *
	 * @param DateTime $value
	 *
	 * @return void
	 */
	public function setDatetime($value)
	{
		$this->datetime = $value;
	}

	/**
	 * Get the notification message date time.
	 *
	 * @return DateTime
	 */
	public function getDatetime()
	{
		return $this->datetime;
	}

	/**
	 * Set the notification message expiry in minutes or with a DateTime object.
	 *
	 * @param DateTime|integer $value
	 *
	 * @return void
	 */
	public function setExpiry($value)
	{
		$this->expiry = $value;
	}

	/**
	 * Get the notification message expiry in minutes or a DateTime object.
	 *
	 * @return DateTime|integer
	 */
	public function getExpiry()
	{
		return $this->expiry;
	}

	/**
	 * Calculate the number of minutes between now and the given duration.
	 *
	 * @param DateTime|integer $duration
	 *
	 * @return integer
	 */
	protected function getMinutes($duration)
	{
		if ($duration instanceof DateTime) {
			$dateNow = new DateTime('now');

			if (($duration->format('U')) < ($dateNow->format('U'))) {
				return 0;
			}

			$interval = $dateNow->diff($duration);

			return $interval->format('%i');
		}

		return $duration;
	}

	/**
	 * Is notification message expired.
	 *
	 * @return boolean
	 */
	public function isExpired()
	{
		$expiryInSeconds = ($this->getMinutes($this->getExpiry()) * 60);

		if (($this->getDatetime()->add(new DateInterval('PT' . $expiryInSeconds . 'S'))->format('U')) > ((new DateTime('now'))->format('U'))) {
			return false;
		}

		return true;
	}

	/**
	 * Set the notification message displayed status.
	 *
	 * @param boolean $value
	 *
	 * @return void
	 */
	public function setDisplayed($value)
	{
		$this->displayed = $value;
	}

	/**
	 * Get the notification message displayed status.
	 *
	 * @return boolean
	 */
	public function getDisplayed()
	{
		return $this->displayed;
	}

	/**
	 * Get the notification message displayed status.
	 *
	 * @return boolean
	 */
	public function isDisplayed()
	{
		return $this->displayed;
	}

	/**
	 * Set the notification message options.
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
	 * Get the notification message options.
	 *
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}

	/**
	 * To array method.
	 *
	 * @return array
	 */
	public function __toArray()
	{
		return [
			'options' => $this->getOptions(),
			'message' => $this->getMessage(),
			'type' => $this->getType(),
			'datetime' => $this->getDatetime(),
			'expiry' => $this->getExpiry(),
			'displayed' => $this->getDisplayed(),
		];
	}

}