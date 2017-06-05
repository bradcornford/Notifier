<?php namespace Cornford\Notifier\Providers;


use Cornford\Notifier\Listeners\AfterListener;
use Cornford\Notifier\Listeners\BeforeListener;
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
	public function boot(\Illuminate\Routing\Router $router)
	{
		$this->publishes(
			[
				__DIR__ . '/../../../config/config.php' => config_path('notifier.php'),
				__DIR__ . '/../../../../public' => public_path('packages/cornford/notifier')
			],
			'notifier'
		);

		$this->loadViewsFrom(__DIR__ . '/../../../views', 'notifier');

		include __DIR__ . '/../../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/../../../config/config.php', 'notifier');

		$this->app['router']->middleware('NotifierBeforeListener', 'Cornford\\Notifier\\Listeners\\BeforeListener');
		$this->app['router']->middleware('NotifierAfterListener', 'Cornford\\Notifier\\Listeners\\AfterListener');

		$this->app['router']->before(BeforeListener::class);
		$this->app['router']->after(AfterListener::class);

		$this->app->singleton(
            'notifier',
            function($app)
            {
                $config = $app['config']->get('notifier');

                return new Notifier($this->app->view, $this->app->{'session.store'}, $config);
            }
		);
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
