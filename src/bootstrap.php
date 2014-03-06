<?php
///////////////////////
// Instantiate Silex //
///////////////////////
$app = new Silex\Application();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

////////////////////////
// Register Constants //
////////////////////////
require_once __DIR__.'/bootstrap.constants.php';

//////////////////////////////
// Register Mailing Service //
//////////////////////////////
/*
$app->register(new Silex\Provider\SwiftmailerServiceProvider(), array(
	'swiftmailer.options'	  => array(
									'host'		=>SAW_MAILER_HOST,
									'port'		=>SAW_MAILER_PORT,
									'username'	=>SAW_MAILER_USERNAME,
									'password'	=>SAW_MAILER_PASSWORD,
									'encryption'=>SAW_MAILER_ENCRYPTION
								 )
));
//*/

///////////////////////////////////
// Register Facebook SDK Service //
///////////////////////////////////
/*
$app->register(new Saw\Provider\Facebook\FacebookServiceProvider(), array(
    'facebook.class_file' => __DIR__.'/../vendor/facebook/php-sdk/src/facebook.php',
    'facebook.app_id'     => SAW_FACEBOOK_API_ID,
    'facebook.secret'     => SAW_FACEBOOK_SECRET
));
*/

////////////////////////////
// Register Store Service //
////////////////////////////
$app->register(new Saw\Provider\Store\Mongo\MongoServiceProvider());

//////////////////////////////
// Register Utility Service //
//////////////////////////////
$app->register(new Saw\Provider\Utility\UtilityServiceProvider());

/////////////////////////////
// Register Upload Service //
/////////////////////////////
$app->register(new Saw\Provider\Upload\UploadServiceProvider());

////////////////////////////////
// Register Validator Service //
////////////////////////////////
$app->register(new Silex\Provider\ValidatorServiceProvider(), array());

/////////////////////////////////
// Register Amazon Web Servces //
/////////////////////////////////
require __DIR__.'/../vendor/amazonwebservices/aws-sdk-for-php/sdk.class.php';

//////////////////////////////////////////////////
// Silex built-in error handler for controllers //
//////////////////////////////////////////////////
$app['errorExceptionHandler'] = $app->protect(function (\Exception $e, $http_status_code) use ($app) {
	$msg = json_decode($e->getMessage());
	$headers = array('Content-Type' => 'text/html');
	if(is_array($msg) || is_object($msg)){
		$message = $e->getMessage();
	}else{
		// so since $msg is just a string we need to instantiate a SawException to get the abort response structure
		// also because symfony internals threw this abort which abort itself is really a thrown
		// Symfony\Component\HttpKernel\Exception\HttpException
		$SAW_exception = new \Saw\Exceptions\SawException($e, $e->getMessage(), (method_exists($e, 'getInvalidFields')) ? $e->getInvalidFields() : array());
		$message = $SAW_exception->getAbortResponse();
		$http_status_code = $SAW_exception->getHttpStatusCode();
		$headers = array_merge($SAW_exception->getHeaders(),$headers);
	}
	
	if($app['request']->isXmlHttpRequest()):
		$headers['Content-Type'] = 'application/json';
		return new Response($message, $http_status_code,$headers);
	else:
		$siteKey = SAW_SITE_KEY;
		if(!empty($siteKey)){ // want to render the templates error page types
			error_log(' in here: '.$http_status_code.' message:'.$e->getMessage());
			$page_contents_html = $app['view']->renderPageTypeByRoute('/'.$http_status_code,SAW_SITE_KEY);
    		return new Response($page_contents_html,$http_status_code,array('Content-Type' => 'text/html'));
		}else{
			return new Response($app['view']->render('errors/'.$http_status_code,'error', array('error'=>json_decode($message)))
							,$http_status_code
							,$headers);
		}
	endif;
});
$app->error(function (\Exception $e, $http_status_code) use ($app) {
	return $app['errorExceptionHandler']($e,$http_status_code);
}, Silex\Application::EARLY_EVENT);
return $app;