<?php

namespace Saw\Provider\Upload;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadServiceProvider implements ServiceProviderInterface
{
	
	public function register(Application $app)
	{
		/*
        $app['upload-s3'] = $app->share(function() use($app){
            $upload = new UploadWrapperS3($app);
            return $upload;
        });
		//*/
		$app['upload-mongo'] = $app->share(function() use($app){
            $upload_mongo = new UploadWrapperMongo($app);
            return $upload_mongo;
        });
	}
	public function boot(Application $app)
	{
		
	}

}