<?php namespace Cornford\Notifier\Contracts;

interface NotifierNotificationInterface {

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
	public function __construct($message, $type, $datetime, $expiry = 0, array $options = []);

	/**
	 * Set the notification message.
	 *
	 * @param string $value
	 *
	 * @return void
	 */
	public function setMessage($value);

	/**
	 * Get the notification message.
	 *
	 * @return string
	 */
	public function getMessage();

	/**
	 * Set the notification message type.
	 *
	 * @param string $value
	 *
	 * @return void
	 */
	public function setType($value);

	/**
	 * Get the notification message.
	 *
	 * @return string
	 */
	public function getType();
	/**
	 * Set the notification message date time.
	 *
	 * @param DateTime $value
	 *
	 * @return void
	 */
	public function setDatetime($value);

	/**
	 * Get the notification message date time.
	 *
	 * @return integer
	 */
	public function getDatetime();

	/**
	 * Set the notification message expiry in minutes.
	 *
	 * @param integer $value
	 *
	 * @return void
	 */
	public function setExpiry($value);

	/**
	 * Get the notification message expiry in minutes.
	 *
	 * @return integer
	 */
	public function getExpiry();

	/**
	 * Is notification message expired.
	 *
	 * @return boolean
	 */
	public function isExpired();

	/**
	 * Set the notification message displayed status.
	 *
	 * @param boolean $value
	 *
	 * @return void
	 */
	public function setDisplayed($value);

	/**
	 * Get the notification message displayed status.
	 *
	 * @return boolean
	 */
	public function getDisplayed();

	/**
	 * Get the notification message displayed status.
	 *
	 * @return boolean
	 */
	public function isDisplayed();

	/**
	 * Set the notification message options.
	 *
	 * @param array $value
	 *
	 * @return void
	 */
	public function setOptions(array $value);
	/**
	 * Get the notification message options.
	 *
	 * @return boolean
	 */
	public function getOptions();

	/**
	 * To array method.
	 *
	 * @return array
	 */
	public function __toArray();

}
