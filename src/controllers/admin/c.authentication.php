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
$app->get('/login/{e}/{pp}', function ($e, $pp, Request $request) use ($app) {
	$view_vars = array(
		'flash'=>Model\User::getFlash($app)
		,'e'=>$request->get('e')
		,'pp'=>$request->get('pp')
	);
	
	return $app['view']->render('','login',$view_vars);	
})->value('e','')->value('pp','');
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
    return $clientResponse;
});
$app->get('/logout', function (Request $request) use ($app) {
	$accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$app);
	if($accessLevel == ADMIN){
		session_unset();
	}else{
		$user_id = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$app);
		if(!empty($user_id)) {
		    $document = array('_id'=>$user_id);
		    $user = new Model\Member($document, $app);
	        $user->deauthenticate();
		}
	}
	return new RedirectResponse('/login');
});

$app->post('/member/forgotpassword', function (Request $request) use ($app) {
	
	$doc = $request->get('doc');
	// get the member to embed
	$member = new Model\Member($doc, $app);
	$app['validateModel']($app,$member,$groups=array('forgot-password'));
	$member = $member->findById('email');

	if(!empty($member)){
		$arr = array('_id'=>$member['_id'],'password'=>substr(time(),-4));

		$member = new Model\Member($arr, $app);
		$member->saveSafe();

		// email new password
		$subject = 'NCDD Member Portal Password Reset';
		$to = $doc['email'];
		$view_vars = array('email'=>$doc['email']
							,'password'=>$arr['password']
		);
		$body = $app['view']->render('email/member-password-reset','email', $view_vars);
		$app['sendMail']($subject, $body, $to);
		return new Response(json_encode(array('message' => 'Your email has been found and your password has been reset.  We\'ve sent you an email with your new password.')), 200,array('Content-Type' => 'application/json'));
	}

	return new Response(json_encode(array('message' => 'We could not find this email address. Please try again.')), 400,array('Content-Type' => 'application/json'));
});

// sets the flash message and redirect if an access denied happens.
$app->post('/flash/set', function (Request $request) use ($app) {
	$doc = $request->get('doc');
	Model\User::setFlash($app,$doc['message'],$doc['redirect']);
	return new Response(json_encode(array('message' => '')), 200,array('Content-Type' => 'application/json'));
});

return $app;