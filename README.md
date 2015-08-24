# An easy way to send notification messages to a client using AJAX in Laravel.

[![Latest Stable Version](https://poser.pugx.org/cornford/notifier/version.png)](https://packagist.org/packages/cornford/notifier)
[![Total Downloads](https://poser.pugx.org/cornford/notifier/d/total.png)](https://packagist.org/packages/cornford/notifier)
[![Build Status](https://travis-ci.org/bradcornford/Notifier.svg?branch=master)](https://travis-ci.org/bradcornford/notifier)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bradcornford/Notifier/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bradcornford/Notifier/?branch=master)

Think of Notifier as an easy way to send notification messages to a client using AJAX in Laravel. These include:

- `Notifier::notification`
- `Notifier::none`
- `Notifier::info`
- `Notifier::success`
- `Notifier::warning`
- `Notifier::danger`
- `Notifier::setOptions`
- `Notifier::getOptions`
- `Notifier::setNotifications`
- `Notifier::getNotifications`
- `Notifier::assets`
- `Notifier::getDisplayNotifications`
- `Notifier::displayNotifications`
- `Notifier::displayedDisplayableNotifications`
- `Notifier::displayedAllNotifications`
- `Notifier::expireNotifications`
- `Notifier::expireDisplayedNotifications`
- `Notifier::expireAllNotifications`
- `Notifier::fetchNotifications`
- `Notifier::storeNotifications`
- `Notifier::toArray`

## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `cornford/notifier`.

	"require": {
		"cornford/notifier": "1.*"
	}

Next, update Composer from the Terminal:

	composer update

Once this operation completes, the next step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

	'Cornford\Notifier\Providers\NotifierServiceProvider',

The next step is to introduce the facade. Open `app/config/app.php`, and add a new item to the aliases array.

	'Notifier'         => 'Cornford\Notifier\Facades\NotifierFacade',

We then need to introduce the configuration files into your application/

	php artisan config:publish cornford/notifier

Finally we need to introduce the packages JavaScripts and Stylesheets, by running the following command.

	php artisan asset:publish cornford/notifier

That's it! You're all set to go.

## Usage

It's really as simple as using the Logical class in any Controller / Model / File you see fit with:

`Notifier::`

This will give you access to

- [Notification](#notification)
- [None](#none)
- [Info](#info)
- [Success](#success)
- [Warning](#warning)
- [Danger](#danger)
- [Set Options](#set-options)
- [Get Options](#get-options)
- [Set Notifications](#set-notifications)
- [Get Notifications](#get-notifications)
- [Assets](#assets)
- [Get Display Notifications](#get-display-notifications)
- [Display Notifications](#display-notifications)
- [Displayed Displayable Notifications](#displayed-displayable-notifications)
- [Displayed All Notifications](#displayed-all-notifications)
- [Expire Notifications](#expire-notifications)
- [Expire Displayed Notifications](#expire-displayed-notifications)
- [Expire All Notifications](#expire-all-notifications)
- [Fetch Notifications](#fetch-notifications)
- [Store Notifications](#store-notifications)
- [To Array](#to-array)

### Notification

The `notification` method allows you to create a notification, with parameters for message, type and expiry as an integer of minutes or DateTime object.

	Notifier::notification('This is a message', Notification::NOTIFICATION_TYPE_INFO, 0);
	Notifier::notification('This is a message', Notification::NOTIFICATION_TYPE_NONE, new DateTime('tomorrow'));

### None

The `none` method allows you to create a none notification, with parameters for message and expiry as an integer of minutes or DateTime object.

	Notifier::none('This is a message', 0);
	Notifier::none('This is a message', new DateTime('tomorrow'));

### Info

The `info` method allows you to create an information notification, with parameters for message and expiry as an integer of minutes or DateTime object.

	Notifier::info('This is a message', 0);
	Notifier::info('This is a message', new DateTime('tomorrow'));

### Success

The `success` method allows you to create a success notification, with parameters for message and expiry as an integer of minutes or DateTime object.

	Notifier::success('This is a message', 0);
	Notifier::success('This is a message', new DateTime('tomorrow'));

### Warning

The `warning` method allows you to create a warning notification, with parameters for message and expiry as an integer of minutes or DateTime object.

	Notifier::warning('This is a message', 0);
	Notifier::warning('This is a message', new DateTime('tomorrow'));

### Danger

The `danger` method allows you to create a danger notification, with parameters for message and expiry as an integer of minutes or DateTime object.

	Notifier::danger('This is a message', 0);
	Notifier::danger('This is a message', new DateTime('tomorrow'));

### Danger

The `danger` method allows you to create a danger notification, with parameters for message and expiry as an integer of minutes or DateTime object.

	Notifier::danger('This is a message', 0);
	Notifier::danger('This is a message', new DateTime('tomorrow'));

### Set Options

The `setOptions` method allows you to set the current set of Notifier options using a parameter for options as an array.

	Notifier::setOptions(['option' => 'value']);

### Get Options

The `getOptions` method allows you to fetch the current set of Notifier options as an array.

	$options = Notifier::getOptions();

### Set Notifications

The `setNotifications` method allows you to the current set of notifications with an array of notifications objects.

	Notifier::setNotifications([new Notification('This is a message', Notification::NOTIFICATION_TYPE_NONE, new DateTime('now'), 1)]);

### Get Notifications

The `getNotifications` method allows you to the fetch the current set of notifications as an array of notifications objects.

	$notifications = Notifier::getNotifications();

### Assets

The `assets` method allows you to the include the necessary Notifier assets to your template files, with an optional parameter for type.

	{{ Notifier::assets() }}
	{{ Notifier::assets('cdn') }}

### Get Display Notifications

The `getDisplayNotifications` method allows you to get the current set of displayable notifications.

	$notifications = Notifier::getDisplayNotifications();

### Display Notifications

The `displayNotifications` method allows you to mark an array of passed notifications as displayed.

	$notifications = Notifier::getNotifications();
	Notifier::displayNotifications($notifications);

### Displayed Displayable Notifications

The `displayedDisplayableNotifications` method allows you to mark displayable notifications as displayed.

	Notifier::displayedDisplayableNotifications();

### Displayed All Notifications

The `displayedAllNotifications` method allows you to mark all notifications as displayed.

	Notifier::displayedAllNotifications();

### Expire Notifications

The `expireNotifications` method allows you to expire an array of passed notifications.

	$notifications = Notifier::getNotifications();
	Notifier::expireNotifications($notifications);

### Expire Displayed Notifications

The `expireDisplayedNotifications` method allows you to expire all displayed notifications.

	Notifier::expireDisplayedNotifications();

### Expire All Notifications

The `expireAllNotifications` method allows you to expire all notifications.

	Notifier::expireAllNotifications();

### Fetch Notifications

The `fetchNotifications` method allows you to fetch all notifications from the session.

	Notifier::fetchNotifications();

### Store Notifications

The `storeNotifications` method allows you to store all notifications into the session.

	Notifier::storeNotifications();

### To Array

The `toArray` method allows you convert an array of Notification objects to an array of arrays.

	$notifications = Notifier::getNotifications();
	Notifier::toArray($notifications);

### License

Notifier is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)