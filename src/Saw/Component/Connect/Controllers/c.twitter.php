<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Saw\Model;
use Saw\Component\Connect;

/**
 * Render our custom twitter connecting screen
 * and start the OAuth Process
 */
$app->get('/connect/twitter', function (Request $request) use ($app) {
	
	try{
		// this is here to allow them to redirect back to where they came from when finished with the OAuth flow
		$app['session']->set('connect.referer', $request->headers->get('referer'));
	
	
		$conn = new Connect\TwitterConnect($app);
		$oauth_token = $conn->requestToken();
	
		// with the access token (oauth_token) redirect the user to authorize the app and/or login .. whereas facebook only requires an app_id for the authorize dialog
		$redirect = $conn->authorizeEndPoint.'?oauth_token=' . $oauth_token;
       	return $app['view']->render('connect/twitter/connect','connect',array('redirect'=>$redirect));

		//NOTE: oauth_token + oauth_token_secret both make the reqeust token: in facebook world it's the $app_id(client_id) + $code(oauth_token) + $app_secret
	} catch (Saw\Exceptions\SawException $e) {
		$http_status_code = $e->getHttpStatusCode();
		$abort_response = $e->getAbortResponse();  
		$app->abort($http_status_code, $abort_response);
	}
});

/**
 * call back which twitter invokes if the user accepts the authorization
 */
$app->get('/access/twitter', function (Request $request) use ($app) {
    
	$denied = null;
	$oauth_token = null;
	
	$oauth_token = $request->get('oauth_token');
	$denied = $request->get('denied');
	
	if(!empty($oauth_token)):
		$conn = new Connect\TwitterConnect($app);
		$result = $conn->accessToken($oauth_token);
	endif;
	if(!empty($denied)):
		$result = 403;
	endif;
	switch ($result) {
		case '200':
			$app['twitterAuth']($app);
			// success welcome back you've authenticated properly. 
			// within this page initiate an xhr to grab their basic info while they're reading this message.
			// upon succesful response redirect them to the dashboard
            return $app['view']->render('connect/twitter/access','connect');
			break;
		case '403':
			// Either OAuth Token did not match ours or it was not returned
            return $app['view']->render('connect/twitter/access_denied','connect');
			break;
		case '500':
			// Swapping request token with access token failed. see application_log for error details
            return $app['view']->render('connect/twitter/access_failed','connect');
			break;
	}

});

// Auth Logic
// check if access_token is present
// if so update the new access token?  
// if not then new user so pull the user details insert
// either way authenticate
$app['twitterAuth'] = $app->protect(function ($app) {
    
    $conn = new Connect\TwitterConnect($app);
    $valid = $conn->validate();
    
    return $valid;
});

// Grape Logic
$app['twitterGrape'] = $app->protect(function ($app,$post) {
    
	$user = Model\Consumer::getAccountBySession($app);
    if(empty($user['connections']) || empty($user['connections']['twitter'])) {
        $http_status_code = 401; //ref: 10.4.2 401 Unauthorized
        $response_message = "Twitter tells us you must re-authenticate. Please re-connect to Twitter from the Account Settings screen.";
        $resolve_link = "/connect/twitter";
        $result = array('message'=>$response_message, 'http_status_code'=>$http_status_code, 'resolve_link'=>$resolve_link);
        return $result;
    }
    	
    if(!empty($_SESSION['SAW_SITE_MODE']) && $_SESSION['SAW_SITE_MODE'] == SAW_MODE_DEMO) {
        $result = array('id'=>100);
    }
    else {
        $conn = new Connect\TwitterConnect($app, $user['connections']['twitter']['accessToken']);
        $result = $conn->grape($post['grapeText'],$post['grapeLink']);
    }        

    if(!empty($result['id'])):
		$app['onGrape']($app, $post['shortCode'], $referredUserId=null, $source='twitter.com', $grapeText=$post['grapeText']);
    endif;    
    
    return $result;
});

// Grape Route
$app->post('/access/twitter/grape', function () use ($app) {
    $post = $app['request']->get('doc');
	$result = $app['twitterGrape']($app,$post);
    
    if(!empty($result['id'])):
        return new Response(json_encode(array('message'=>"Grape successful:".$result['id'])), 201,array('Content-Type' => 'application/json'));
    else:
        return new Response(json_encode(array(  'message'=>$result['message'],
                                                'resolve_link'=>$result['resolve_link'])), intval($result['http_status_code']),array('Content-Type' => 'application/json'));
    endif;    
});

return $app;