<?php namespace AlfredNutileInc\Fixturizer;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class FixturizerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * Booting
     */
    public function boot()
    {
//        $this->package('alfred-nutile-inc/fixturizer_base');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('fixturize.writer', function($app, $name) {
            
            $fixturize = new Writer(new Filesystem());
            $path = Config::get('fixturizer::config.fixture_storage_folder');
            $fixturize->setDestination($path . '/');
            $fixturize->setYmlParser(new Yaml());
            return $fixturize;
        });

        $this->app->bind('fixturize.reader', function($app) {
            $fixturize = new Reader(new Filesystem());
            $fixturize->setYmlParser(new Yaml());
            return $fixturize;
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('fixturize.reader', 'fixturize.writer');
	}

}
