<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Saw\Model;
use Saw\Component\Connect;

/**
 * Render our custom facebook connecting screen
 * and start the OAuth Process
 */
$app->get('/connect/facebook', function (Request $request) use ($app) {
	
	// this is here to allow them to redirect back to where they came from when finished with the OAuth flow
	$app['session']->set('connect.referer', $request->headers->get('referer'));
	
	$conn = new Connect\FacebookConnect($app);
	$oauth_token = $conn->requestToken();
	// slightly different approach because the facebook SDK helps out a lot
	$redirect = $app['facebook']->getLoginUrl(array('redirect_uri'=>$conn->redirectUri,'scope'=>$conn->permissions));
    return $app['view']->render('connect/facebook/connect','connect',array('redirect'=>$redirect));
	
});

/**
 * call back which facebook invokes if the user accepts the authorization
 */
$app->get('/access/facebook', function (Request $request) use ($app) {
    
	$denied = null;
	
	$error = $request->get('error');
	
	if(!empty($error)):
		switch ($error) {
			case 'access_denied':
				$result = 403;
				break;
			case 'deauthorize':
				$result = 301;
				break;
		}
	else:
		$conn = new Connect\FacebookConnect($app);
		$result = $conn->accessToken($oauth_token='');
	endif;
	
	switch ($result) {
		case '200':
			$app['facebookAuth']($app);
			// success welcome back you've authenticated properly. 
			// within this page initiate an xhr to grab their basic info while they're reading this message.
			// upon succesful response redirect them to the dashboard
            return $app['view']->render('connect/facebook/access','connect');
			break;
		case '403':
			// user decided not to allow the app access to their account
            return $app['view']->render('connect/facebook/access_denied','connect');
			break;
		case '301':
			// user de-authorized the app
            return $app['view']->render('connect/facebook/access_deauthorize','connect');
			break;
		case '500':
			// Swapping request token with access token failed. see application_log for error details
            return $app['view']->render('connect/facebook/access_failed','connect');
			break;
	}

});
// Auth Logic
// check if access_token is present
// if so update the new access token?  
// if not then new user so pull the user details insert
// either way authenticate
$app['facebookAuth'] = $app->protect(function ($app) {
    
    $conn = new Connect\FacebookConnect($app);
    $valid = $conn->validate();
    
    return $valid;
});

// Grape Logic
$app['facebookGrape'] = $app->protect(function ($app,$post) {
    // prepare additional elements for a facebook post
	$grapeObj = new Model\Grape($doc=array('shortCode'=>$post['shortCode']),$app);
	$grape = $grapeObj->findByShortCode();
	$post['description'] = $grape['offerLite']['description'];
	$post['name'] = $grape['offerLite']['headline'];
	$post['caption'] = $grape['offerLite']['profileLite']['displayName'];
    if(!empty($grape['offerLite']['image'])) {
        $image = $grape['offerLite']['image'];
        $url = $image['base'].'/'.$image['context'].'/large/'.$image['imageId']->__toString();
    }
	$post['picture'] = $url;

	$user = Model\Consumer::getAccountBySession($app);
    
    if(empty($user['connections']) || empty($user['connections']['facebook'])) {
        $http_status_code = 401; //ref: 10.4.2 401 Unauthorized
        $response_message = "Facebook tells us you must re-authenticate. Please re-connect to Facebook from the Account Settings screen.";
        $resolve_link = "/connect/facebook";
        $result = array('message'=>$response_message, 'http_status_code'=>$http_status_code, 'resolve_link'=>$resolve_link);   
        return $result;
    }     
    
    if(!empty($_SESSION['SAW_SITE_MODE']) && $_SESSION['SAW_SITE_MODE'] == SAW_MODE_DEMO) {
        $result = array('id'=>100);
    }
    else {
        $conn = new Connect\FacebookConnect($app, $user['connections']['facebook']['accessToken']);
        $result = $conn->grape($post['grapeText'],$post['grapeLink'],$post['picture'],$post);
    }    
    
    if(!empty($result['id'])):
		$app['onGrape']($app, $post['shortCode'], $referredUserId=null, $source='facebook.com', $grapeText=$post['grapeText']);
    endif;
    
    return $result;
});

// grape route
$app->post('/access/facebook/grape', function () use ($app) {
    $post = $app['request']->get('doc');
    $result = $app['facebookGrape']($app,$post);
    
    if(!empty($result['id'])):
        return new Response(json_encode(array('message'=>"Grape successful:".$result['id'])), 201,array('Content-Type' => 'application/json'));
    else:
        return new Response(json_encode(array(  'message'=>$result['message'],
                                                'resolve_link'=>$result['resolve_link'])), intval($result['http_status_code']),array('Content-Type' => 'application/json'));
    endif;
});

return $app;