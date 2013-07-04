<?php

namespace Saw\Provider\View;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewServiceProvider implements ServiceProviderInterface
{
	
	public function register(Application $app)
	{
		$app['view'] = $app->share(function() use($app){
			$view = new ViewWrapper(
				$app['saw.layout_path'], 
				$app['saw.view_path'],
				$app['saw.element_path'],
				$app
			);
			return $view;
		});
	}
	public function boot(Application $app)
	{
		
	}

}