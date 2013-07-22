<?php
$app = require __DIR__.'/bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

///////////////////////////
// Register View Service //
///////////////////////////
$app->register(new Saw\Provider\View\ViewServiceProvider(), array(
    'saw.view_path'      => __DIR__.'/views/public/',
    'saw.layout_path'    => __DIR__.'/views/_layouts/public/',
	'saw.element_path'   => __DIR__.'/views/_elements/public/'
));

//////////////////////////////
// Register Session Service //
//////////////////////////////
require_once __DIR__.'/bootstrap.public.constants.php';
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MongoDbSessionHandler;
$app->register(new Silex\Provider\SessionServiceProvider());
$app['session.storage.options'] = array(
    'name'      		=> SAW_SESSION_NAME,
    'cookie_lifetime'	=> SAW_SESSION_COOKIE_LIFETIME,
    'cookie_path'   	=> SAW_SESSION_COOKIE_PATH,
    'cookie_domain' 	=> SAW_SESSION_COOKIE_DOMAIN,
	'cookie_secure'		=> SAW_SESSION_COOKIE_SECURE,
	'cookie_httponly'	=> SAW_SESSION_COOKIE_HTTPONLY
);

try {
	$mongoObj = new \MongoClient('mongodb://'.SAW_SESSION_DATABASE_MONGO_SERVERS, 
									array(	'connect'=>true,
											'replicaSet'=>SAW_SESSION_DATABASE_MONGO_REPLICASET,
											'readPreference'=>\MongoClient::RP_PRIMARY_PREFERRED)
								  );
	$app['session.storage.handler'] = $app->share(function () use ($app, $mongoObj) {
	    return new MongoDbSessionHandler(
	        $mongoObj,
	        array('collection'=>SAW_SESSION_DATABASE_MONGO_COLLECTION,
				  'database'=>SAW_SESSION_DATABASE_MONGO_DATABASE)
	    );
	});
} catch (\MongoConnectionException $e){
	$exception = new Saw\Exceptions\SawException($e,"Couldn't connect to mongo..catastrophe!".$e->getMessage());
}

// include the before, after filters along with all the controller files
$app = require __DIR__.'/app.public.php';

return $app;