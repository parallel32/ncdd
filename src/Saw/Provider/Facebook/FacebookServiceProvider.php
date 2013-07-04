<?php

namespace Saw\Provider\Facebook;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FacebookServiceProvider implements ServiceProviderInterface
{
	
	public function register(Application $app)
	{
		/* @TODO: Use proper autoloading when/if Facebook fixes compliance.
        $app['autoloader']->registerPrefix(
            'Facebook',
            __DIR__.'/../../vendor/facebook/src'
        );
        */

        $app['facebook'] = $app->share(function () use ($app) {
            // @TODO: Use proper autoloading when/if Facebook fixes compliance.
            require_once $app['facebook.class_file'];

            return new \Facebook(array(
                'appId'  => $app['facebook.app_id'],
                'secret' => $app['facebook.secret'],
            ));
        });
	}
	public function boot(Application $app)
	{
		
	}

}