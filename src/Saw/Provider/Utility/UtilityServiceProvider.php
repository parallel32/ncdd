<?php

namespace Saw\Provider\Utility;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UtilityServiceProvider implements ServiceProviderInterface
{
	
	public function register(Application $app)
	{
		$app['utility'] = $app->share(function() use($app){
			$utility = new Utility($app);
			return $utility;
		});
	}
	public function boot(Application $app)
	{
		
	}

}