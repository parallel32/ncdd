<?php
//////////////////////////////
// AUTHENTICATION FUNCTIONS //
//////////////////////////////

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

// requires minimum access level check
// if you're logged in you're already a member so if
// minAccessLevel is null then you'll be able to access
// if minAccesslevel is passed in then you need to have an
// access level that's atleast equal to or greater.
$checkPermissions = function (Request $request, $minAccessLevel=null) use ($app) {
    $user = Model\User::getUserAccessLevelBySession($app);
    //error_log('session:'.print_r($_SESSION,true));
    //error_log('user permissions:'.print_r($user,true));
    if(empty($minAccessLevel) && !empty($user['_id'])):
        return new Response('ok', 200,array('Content-Type' => 'text/html'));
    elseif (!empty($minAccessLevel) && !empty($user['accessLevel']) && ((float)$user['accessLevel'] >= $minAccessLevel)):
        return new Response('ok', 200,array('Content-Type' => 'text/html'));
    else:
        throw new Saw\Exceptions\PermissionException();
    endif;
};

$mustbeADMIN = function (Request $request) use ($app, $checkPermissions){
    $response = $checkPermissions($request, ADMIN);
    if(!$response->isOk()):
        return $response;
    endif;
};
$mustbeEDITOR = function (Request $request) use ($app, $checkPermissions){
    $response = $checkPermissions($request, EDITOR);
    if(!$response->isOk()):
        return $response;
    endif;
};
$mustbeMEMBER = function (Request $request) use ($app, $checkPermissions){
    $response = $checkPermissions($request, UNPAIDMEMBER);
    if(!$response->isOk()):
        return $response;
    endif;
};

$app['clientLogin'] = $app->protect(function ($app,$request) {
    try{
        // retrieve document from request
        $document = $request->get('doc');
        $user = new Model\Member($document, $app);
        // validate the model
        $app['validateModel']($app,$user,$groups=array('login'));
        
        if($user->findByEmailPassword()):
            $user->authenticate();
            return new Response(json_encode(array('message' => 'login successful')), 200,array('Content-Type' => 'application/json'));
        else:
            $response_arr = array('message'=>"Login failed<br>Email and password combination could not be found.",
                                  "invalidFields"=>array(array('name'=>'password','message'=>''),array('name'=>'email','message'=>'')));
            return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
        endif;
    } catch (Saw\Exceptions\SawException $e) {
        $http_status_code = $e->getHttpStatusCode();
        $abort_response = $e->getAbortResponse();  
        $app->abort($http_status_code, $abort_response);
    }
});

$app['adminLogin'] = $app->protect(function ($app,$request) {
    try{
        // retrieve document from request
        $document = $request->get('doc');
        $user = new Model\Member($document, $app);
        // validate the model
        $app['validateModel']($app,$user,$groups=array('login'));
        
        if($document['password'] == SAW_ADMIN_PASSWORD && $document['email'] == SAW_ADMIN_EMAIL):
            $sess_user['user_id']       = SAW_ADMIN_USER_ID;
            $sess_user['displayName']   = SAW_ADMIN_DISPLAY_NAME;
            $sess_user['accessLevel']   = ADMIN;
            $sess_user['status']        = USER_STATUS_ACTIVE;
            $app['session']->set('user',$sess_user);

            return new Response(json_encode(array('message' => 'login successful')), 200,array('Content-Type' => 'application/json'));
        else:
            $response_arr = array('message'=>"Login failed<br>Email and password combination could not validate.",
                                  "invalidFields"=>array(array('name'=>'password','message'=>''),array('name'=>'email','message'=>'')));
            return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
        endif;
    } catch (Saw\Exceptions\SawException $e) {
        $http_status_code = $e->getHttpStatusCode();
        $abort_response = $e->getAbortResponse();  
        $app->abort($http_status_code, $abort_response);
    }
});

return $app;