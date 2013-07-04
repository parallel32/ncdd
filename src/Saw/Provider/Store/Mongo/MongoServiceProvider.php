<?php

namespace Saw\Provider\Store\Mongo;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MongoServiceProvider implements ServiceProviderInterface
{
	
	public function register(Application $app)
	{
		$app['mongo'] = $app->share(function() use($app){
			$mongo = new MongoWrapper($app);
			return $mongo;
		});
	}
	public function boot(Application $app)
	{
		
	}
	
}