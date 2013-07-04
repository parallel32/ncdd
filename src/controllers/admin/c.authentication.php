<?php
////////////////////
// AUTHENTICATION //
////////////////////

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;


// login view
$app->get('/login', function (Request $request) use ($app) {
	return $app['view']->render('','login');	
});
// login post
$app->post('/login', function (Request $request) use ($app) {
	
	$clientResponse = $app['clientLogin']($app,$request);
    if($clientResponse->isForbidden()){
    	// client login failed so try admin login in case it's admin trying to login
    	$adminResponse = $app['adminLogin']($app,$request);
    	if($adminResponse->isSuccessful()){
    		return $adminResponse;
    	}else{
    		return $clientResponse;
    	}
    }
});
$app->get('/logout', function (Request $request) use ($app) {
	$accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$app);
	if($accessLevel == ADMIN){
		session_unset();
	}else{
		$user_id = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$app);
		if(!empty($user_id)) {
		    $document = array('_id'=>$user_id);
		    $user = new Model\Consumer($document, $app);
	        $user->deauthenticate();
		}
	}
	return new RedirectResponse('/login');
});

return $app;