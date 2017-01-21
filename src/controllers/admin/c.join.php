<?php
////////////////////////////
// APPLICATION MANAGEMENT //
////////////////////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

// join us page
$app->get('/join', function (Request $request) use ($app) {

	return $app['view']->render('', 'landing', $view_vars=array());
});


// join us page submit
$app->post('/join', function (Request $request) use ($app) {

	$user = $app['session']->get('user');
   	$is_admin = (is_array($user) && array_key_exists('accessLevel', $user) && $user['accessLevel'] == ADMIN) ? true : false;
	// retrieve document from request
    $doc = $request->get('doc');
    // try to get the User-Agent to record it
    $doc['userAgent'] = $request->headers->get('User-Agent');

    if(!array_key_exists('tosAcknowledgement', $doc)){
    	$doc['tosAcknowledgement'] = 'no';
    }

	$application = new Model\ApplyNewMember($doc, $app);
	$mem = new Model\Member(array('email'=>$doc['email']),$app);

	// validate the email address in case they already signed up
	if(!empty($doc['email']) && $application->findByEmail()){
    	$response_arr = array('message'=>"Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.",
                              "invalidFields"=>array(array('name'=>'email','message'=>'Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.')));
        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
    }
    if(!empty($doc['email']) && $mem->findByEmail()){
    	$response_arr = array('message'=>"Our records indicate you are already a member.  Please Log-in or contact NCDD directly.",
                              "invalidFields"=>array(array('name'=>'email','message'=>'Our records indicate you are already a member.  Please Log-in or contact NCDD directly.')));
        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
    }

    // validate the application form fields
    $app['validateModel']($app,$application,$groups=array('join'));
    
    // validate the promotion
    $app['validatePromotion']($app,$doc);
    
    // process the payment



	$label = 'Thank you for your interest to the NCDD.  We extend our warmest welcome';
	$message = 'Your payment has been processed.  Please check your inbox for your receipt and further instructions.  As a precaution, be sure to also check your inbox\'s SPAM folder.';
	$response_status = 200;
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));


})->after(function (Request $request, Response $response, Silex\Application $app) {
	if(false):
		if((int)$response->getStatusCode() == 200):
			$user = $app['session']->get('user');
			$user['suppress_emails'] = $request->get('suppress_emails');
			$app['session']->set('user',$user);
			$suppress = (!empty($user) && (is_array($user)) && array_key_exists('accesslevel', $user) && ($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes') ? true: false;

	    	$doc = $request->get('doc');
	    	// send admin the email notification
	    	$subject = 'General Member Application Form Submitted';
	    	$to = SAW_ADMIN_EMAIL;
	    	// cc state delegate and regional delegate if exists.
	    	$delegate = new Model\Delegate(array(),$app);
	    	$state = strtolower($doc['state']);
	    	$country = ($doc['country'] == 'US') ? 'usa':'canada';
	    	$res = $delegate->fetchByState($state,$country);
	    	if(!empty($res) && is_array($res)):
	    		if(array_key_exists('regionalDelegateEmail', $res) && !empty($res['regionalDelegateEmail'])){
	    			$to.=', '.$res['regionalDelegateEmail'];
	    		}
	    		foreach ($res['members'] as $member) {
	    			$to.=', '.$member['email'];
	    		}
	    	endif;
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'middleName'=>$doc['middleName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    						,'phone'=>$doc['phone']
	    	);
	    	$body = $app['view']->render('email/new-member','email', $view_vars);
	    	if(!$suppress){
	    		$app['sendMail']($subject, $body, $to);
	    	}

	    	// send applicant the email notification
	    	// deprecated - all emails are handeled in the controller body except the for the admin email above
	    	/*
	    	$subject = 'Your Application for NCDD Membership has been Received';
	    	$to = $doc['email'];
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'middleName'=>$doc['middleName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    						,'applicationId'=>$_POST['applicationId']
	    	);
	    	$body = $app['view']->render('email/new-member-applicant-submission','email', $view_vars);
	    	if(!$suppress){$app['sendMail']($subject, $body, $to);}
	    	//*/
	    endif;
	endif;
});

// xhr validate the membership fee
$app->post('/join/membershipfee-validate', function (Request $request) use ($app) {
	
	// retrieve document from request
    $doc = $request->get('doc');
    $app['validateMembershipFee']($app,$doc);

    $fee = ;
	$response_status = 200;
    return new Response(json_encode(array('fee' => $fee)), $response_status,array('Content-Type' => 'application/json'));
});
// xhr validate the promotion when other fields change
$app->post('/join/promocode-validate', function (Request $request) use ($app) {
	
	// retrieve document from request
    $doc = $request->get('doc');
    $app['validatePromotion']($app,$doc);

    $label = 'Promo is Valid';
	$message = 'The promo code is valid';
	$response_status = 200;
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));
});
return $app;