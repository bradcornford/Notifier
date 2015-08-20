<?php namespace Cornford\Notifier\Providers;


use Cornford\Notifier\Notifier;
use Illuminate\Support\ServiceProvider;

class NotifierServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var boolean
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cornford/notifier', 'notifier',  __DIR__ . '/../../../');

		include __DIR__ . '/../../../routes.php';
		include __DIR__ . '/../../../filters.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['events']->listen('notifier.before', 'Cornford\\Notifier\\Listeners\\AfterListener');
		$this->app['events']->listen('notifier.after', 'Cornford\\Notifier\\Listeners\\BeforeListener');

		$this->app['notifier'] = $this->app->share(function($app)
		{
			$config = $app['config']->get('notifier::config');

			return new Notifier($this->app->view, $this->app->{'session.store'}, $config);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return string[]
	 */
	public function provides()
	{
		return ['notifier'];
	}

}
