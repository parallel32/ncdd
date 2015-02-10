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

$app['applicationEmails'] = $app->protect(function ($app,$applicationId,$context,$request) {

	$apply = new Model\Apply(array('_id'=>$applicationId), $app);
	$apply_arr = $apply->findById();

	if($context == 'new-member-welcome'){
		switch ($apply_arr['class']) {
			case 'NewMemberApplication': // old deprecated
			case 'ApplyNewMember':
				$application = new Model\ApplyNewMember(array('_id'=>$applicationId), $app);
				$application->findById();
			    $member = $application->approve();
			    // email welcome message
				$subject = 'Welcome To NCDD';
				$to = $member->email;
				$view_vars = array('email'=>$member->email
									,'password'=>$member->password
									,'firstName'=>$member->firstName
									,'middleName'=>$member->middleName
									,'lastName'=>$member->lastName
									,'paymentId'=>$application->paymentId
				);
				$body = $app['view']->render('email/new-member-welcome','email', $view_vars);
				break;
			case 'ApplyNewSustainingMember':
				$application = new Model\ApplyNewSustainingMember(array('_id'=>$applicationId), $app);
				$application->findById();
			    $member = $application->approve();
			    // email welcome message
				$subject = 'Welcome To NCDD';
				$to = $member->email;
				$view_vars = array('email'=>$member->email
									,'password'=>$member->password
									,'firstName'=>$member->firstName
									,'lastName'=>$member->lastName
				);
				$body = $app['view']->render('email/new-sustaining-member-welcome','email', $view_vars);
				break;		
			case 'UpdateMember':
				$application = new Model\UpdateMember(array('_id'=>$applicationId), $app);
				$application->findById();
			    $member = $application->approve();
			    // email welcome message
				$subject = 'NCDD Membership Renewal Approved';
				$to = $member['email'];
				$view_vars = array('email'=>$member['email']
									,'firstName'=>$member['firstName']
									,'lastName'=>$member['lastName']
				);
				$body = $app['view']->render('email/update-member-approved','email', $view_vars);
				break;
			case 'UpdateFoundingMember':
				$application = new Model\UpdateFoundingMember(array('_id'=>$applicationId), $app);
				$application->findById();
			    $member = $application->approve();
			    // email welcome message
				$subject = 'NCDD Founding Membership Update Approved';
				$to = $member['email'];
				$view_vars = array('email'=>$member['email']
									,'name'=>$member['displayName']
				);
				$body = $app['view']->render('email/update-founding-member-approved','email', $view_vars);
				break;
			case 'UpdateSustainingMember':
				$application = new Model\UpdateSustainingMember(array('_id'=>$applicationId), $app);
				$application->findById();
			    $member = $application->approve();
			    // email welcome message
				$subject = 'NCDD Sustaining Membership Update Approved';
				$to = $member['email'];
				$view_vars = array('email'=>$member['email']
									,'name'=>$member['displayName']
				);
				$body = $app['view']->render('email/update-sustaining-member-approved','email', $view_vars);
				break;
			
		}
		$user = $app['session']->get('user');
		$user['suppress_emails'] = $request->get('suppress_emails');
		$app['session']->set('user',$user);

		if((is_array($user)) && array_key_exists('accessLevel', $user) && ($user['accessLevel'] == ADMIN  || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') ) ) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes'){
			switch ($apply_arr['class']) {
				case 'UpdateMember':
				case 'UpdateFoundingMember':
				case 'UpdateSustainingMember':
					return new Response(json_encode(array('message' => 'Approved successfully AND No emails sent to members.')), 200,array('Content-Type' => 'application/json'));
					break;
			}
		}else{
			$app['sendMail']($subject, $body, $to);	
		}
		
	    return new Response(json_encode(array('message' => 'Approved successfully')), 200,array('Content-Type' => 'application/json'));
	}
	if($context == 'new-member-trial'){
		switch ($apply_arr['class']) {
			case 'NewMemberApplication': // old deprecated
			case 'ApplyNewMember':
				$application = new Model\ApplyNewMember(array('_id'=>$applicationId), $app);
				$application->findById();
			    $member = $application->trial();
			    // email welcome message
				$subject = 'Welcome To NCDD';
				$to = $member->email;
				$view_vars = array('email'=>$member->email
									,'password'=>$member->password
									,'firstName'=>$member->firstName
									,'lastName'=>$member->lastName
									,'startDate'=>$application->trial['startDate']['fullMonth']
									,'endDate'=>$application->trial['endDate']['fullMonth']
				);
				$body = $app['view']->render('email/new-member-trial','email', $view_vars);
				break;
			case 'ApplyNewSustainingMember':
				$application = new Model\ApplyNewSustainingMember(array('_id'=>$applicationId), $app);
				$application->findById();
			    $member = $application->trial();
			    // email welcome message
				$subject = 'Welcome To NCDD';
				$to = $member->email;
				$view_vars = array('email'=>$member->email
									,'password'=>$member->password
									,'firstName'=>$member->firstName
									,'lastName'=>$member->lastName
									,'startDate'=>$application->trial['startDate']['fullMonth']
									,'endDate'=>$application->trial['endDate']['fullMonth']
				);
				$body = $app['view']->render('email/new-sustaining-member-trial','email', $view_vars);
				break;		
			
		}
		
		$app['sendMail']($subject, $body, $to);
	    return new Response(json_encode(array('message' => 'Approved successfully')), 200,array('Content-Type' => 'application/json'));
	}
	if($context == 'new-member-complete'){
		$member = new Model\Member(array('_id'=>$apply_arr['memberId']), $app);
	    $member->findById();

		switch ($apply_arr['class']) {
			case 'NewMemberApplication': // old deprecated
			case 'ApplyNewMember':
				// email welcome message
				$subject = 'Welcome To NCDD';
				$to = $member->email;
				$view_vars = array('email'=>$member->email
									,'firstName'=>$member->firstName
									,'lastName'=>$member->lastName
				);
				$body = $app['view']->render('email/new-member-welcome-complete','email', $view_vars);
				break;
			case 'ApplyNewSustainingMember':
			    // email welcome message
				$subject = 'Welcome To NCDD';
				$to = $member->email;
				$view_vars = array('email'=>$member->email
									,'firstName'=>$member->firstName
									,'lastName'=>$member->lastName
				);
				$body = $app['view']->render('email/new-sustaining-member-welcome-complete','email', $view_vars);
				break;		
			case 'UpdateMember':
				// email welcome message
				$subject = 'NCDD Membership Renewal Paid';
				$to = $member->email;
				$view_vars = array('email'=>$member->email
									,'firstName'=>$member->firstName
									,'middleName'=>$member->middleName
									,'lastName'=>$member->lastName
				);
				$body = $app['view']->render('email/update-member-paid','email', $view_vars);
				break;
			
		}
		// TODO no emails when ADMIN is approving -- temporary and should be removed after Hunter is done with the manual entry and payment of snail mailed renewals
		$user = $app['session']->get('user');
		$user['suppress_emails'] = $request->get('suppress_emails');
		$app['session']->set('user',$user);
		if((is_array($user)) && array_key_exists('accessLevel', $user) && ($user['accessLevel'] == ADMIN  || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes'){
			switch ($apply_arr['class']) {
				case 'UpdateMember':
					return new Response(json_encode(array('message' => 'Approved successfully AND No emails sent to members.')), 200,array('Content-Type' => 'application/json'));
					break;
			}
		}else{
			$app['sendMail']($subject, $body, $to);	
		}
	    return new Response(json_encode(array('message' => 'Approved successfully')), 200,array('Content-Type' => 'application/json'));
	}
});

///////////////////////
// APPLICATION FILES //
///////////////////////

$app->get('/application/downloads/{file}', function ($file, Request $request) use ($app) {

	$file = './../../../www/admin.ncdd.com/public_html/assets/membership-forms/'.$file;
    $file_contents = file_get_contents($file);
	return new Response($file_contents, 200, array('Content-Type' => 'application/octet-stream'));
});


////////////////////////////
// NEW MEMBER APPLICATION //
////////////////////////////
$app->post('/application/promocode', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    if(!empty($doc['promocode']) && (strtoupper($doc['promocode']) == 'NCDD2015' || strtoupper($doc['promocode']) == 'NCDD2014' || strtoupper($doc['promocode']) == 'TRIAL' || strtoupper($doc['promocode']) == 'DIVTRIAL' || strtoupper($doc['promocode']) == 'RFTRIAL' || strtoupper($doc['promocode']) == 'PDTRIAL')){
    	$valid = 'yes';
    	$message = 'Valid Promo Code.';
    	$type = (strtoupper($doc['promocode']) == 'NCDD2015' || strtoupper($doc['promocode']) == 'NCDD2014') ? 'discount'.'-'.strtoupper($doc['promocode']): 'trial';
    }else{
    	$type = '';
    	$valid = 'no';
    	$message = 'Invalid Promo Code.';
    }
    
    return new Response(json_encode(array('valid'=>$valid, 'type'=>$type,'message' => $message)), 200,array('Content-Type' => 'application/json'));
});

$app->get('/application/new-member', function (Request $request) use ($app) {

	foreach(Model\ApplyNewMember::$dues as $type => $amount){
		$apply = new Model\Apply(array('membershipDues'=>$amount),$app);
		$dues[$type]['amount'] = $amount;
		$dues[$type]['prorated'] = $apply->proRate('today');
	}
	
	return $app['view']->render('application/new-member', 'blank',array('dues'=>$dues));
});
$app->get('/application/new-member-admin', function (Request $request) use ($app) {

	foreach(Model\ApplyNewMember::$dues as $type => $amount){
		$apply = new Model\Apply(array('membershipDues'=>$amount),$app);
		$dues[$type]['amount'] = $amount;
		$dues[$type]['prorated'] = $apply->proRate('today');
	}
	$crumbs = array(array('name'=>'Applications','href'=>'/applications')
		,array('name'=>'(admin) Add New Member','href'=>'/applications/new-member-admin')
	);
	$view_vars = array(
						 'active'=>'Applications/New'
						,'page-plugin'=>'datatables'
						,'headline'=>'Add a new member'
						,'description'=>"<a class='btn ' href='/applications'><i class=''></i> Cancel</a>"
						,'crumbs'=>$crumbs
						,'dues'=>$dues
	);
	return $app['view']->render('application/new-member-admin', 'default', $view_vars);
});
/**

new member application submittal form - UPDATED

*/
$app->post('/application/new-member', function (Request $request) use ($app) {
	$user = $app['session']->get('user');
   	$is_admin = (is_array($user) && array_key_exists('accessLevel', $user) && $user['accessLevel'] == ADMIN) ? true : false;

	// retrieve document from request
    $doc = $request->get('doc');
    if(!array_key_exists('termsAcknowledgement', $doc)){
    	$doc['termsAcknowledgement'] = 'no';
    }
    if(!array_key_exists('twoSeminarsAcknowledgement', $doc)){
    	$doc['twoSeminarsAcknowledgement'] = 'no';
    }
    // promocode sanity check
    if(!array_key_exists('promocode', $doc)){
    	$doc['promocode'] = '';
    }else{
    	$doc['promocode'] = strtoupper(trim($doc['promocode']));
    }
    $doc['userAgent'] = $request->headers->get('User-Agent');

	$application = new Model\ApplyNewMember($doc, $app);
	if(!empty($doc['email']) && $application->findByEmail()){
    	$response_arr = array('message'=>"Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.",
                              "invalidFields"=>array(array('name'=>'email','message'=>'Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.')));
        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
    }

    // validate the application
    $app['validateModel']($app,$application);
    
    // re-calculate the amount in case the amount gets compromised on the way up to the server
	$dues = array();
	foreach(Model\ApplyNewMember::$dues as $type => $amount){
		$apply = new Model\Apply(array('membershipDues'=>$amount),$app);
		$dues[$type]['amount'] = $amount;
		$dues[$type]['prorated'] = $apply->proRate('today');
	}
	$yilp = $application->yearsInLawPractice;
	$now = date('Y',strtotime('today'));
	if($now - $yilp >= 6){
		$amt = ($doc['promocode'] == 'NCDD2015') ? $dues[6]['amount']-50: $dues[6]['prorated']['a'];
	}elseif ($now - $yilp < 6){
		$amt = ($doc['promocode'] == 'NCDD2015') ? $dues[1]['amount']-50: $dues[1]['prorated']['a'];
	}
	if($application->publicDefender == 'yes'){
		$amt = $dues['publicDefender']['prorated']['a'];
		/* NCDD2015 promo doesn't apply to public defenders
		$amt = (empty($doc['promocode']) || $doc['promocode'] == 'NCDD2015') ? $dues['publicDefender']['amount']: $dues['publicDefender']['prorated']['a'];
		//*/
	}



	if($doc['promocode'] == 'TRIAL' || $doc['promocode'] == 'DIVTRIAL' || $doc['promocode'] == 'PDTRIAL' || $doc['promocode'] == 'RFTRIAL'){
		$trial_doc['startDate'] = 'now';
		$trial_doc['endDate'] = "+1 year";
		$trial_doc['referredBy'] = $doc['referredBy'];
		
		$trial = new Model\Trial($trial_doc,$app);

		
		$applicationId = $application->insert();
		$_POST['applicationId'] = $applicationId->__toString();


		$application = new Model\Apply(array('_id'=>$applicationId,'referredBy'=>$doc['referredBy'],'trial'=>$trial->__toArray()), $app);
		$application->saveEdit();

		// approve as trial
		$response = $app['applicationEmails']($app,$applicationId,$context='new-member-trial',$request);
	}else{
		// approve
		// sends email/new-member-welcome which now combines:
		// email/new-member-applicant-submission + 
		// email/new-member-welcome + 
		// email/new-member-welcome-complete + 
		// email/payment-thankyou
		if($is_admin){
			$application->currentStatus = Model\Apply::$status['APPROVED'];
			$applicationId = $application->insert();
			$_POST['applicationId'] = $applicationId->__toString();
		}
		

		if($is_admin == false):
		    // payment stuff BEGIN
		    $paymentId = new \stdClass();
			$validation_group = ($doc['payment']['currentPaymentType'] == Model\Payment::$paymentType['CREDIT']) ? 'cc' : 'check';		
			$doc['payment']['ownerId'] = new \MongoId(); // temporary to get past validation
			$doc['payment']['ownerClass'] = 'ApplyNewMember';
		endif;
		
		if($is_admin == false):
			$doc['amount'] = $amt;
			$doc['payment']['amount'] = $amt;
			$payment = new Model\Payment($doc['payment'],$app);

			// validate the payment
			$app['validateModel']($app, $payment,$groups=array($validation_group));
			
			// insert the application
			$applicationId = $application->insert();
			$_POST['applicationId'] = $applicationId->__toString();

			// redo the payment object to fill in all attributes just before charge.
			$doc['payment']['ownerId'] = $applicationId;
			$doc['payment']['ownerClass'] = 'ApplyNewMember';
			$doc['amount'] = $amt;
			$doc['payment']['amount'] = $amt;
			$payment = new Model\Payment($doc['payment'],$app);
			try {

				$application->paymentId = $payment->charge();	
			} catch (Exception $e) {
				$app_remove = new Model\ApplyNewMember(array('_id'=>$applicationId), $app);
				$app_remove->remove();
				throw new \Saw\Exceptions\SawException(new \Saw\Exceptions\PaymentException(),$e->getMessage());
			}
			
			// payment stuff END

			// save the application
			//$app_id = $application->insert();			
			if(array_key_exists('payByCheck',$doc) && strpos($doc['payByCheck'], 'no') !== false){
				// save the card 
				$paymentlite->number = $paymentlite->number.'.x';
				$paymentlite->expYear = substr($paymentlite->expYear, -2);
				$memberobj = new Model\Member(array('_id'=>$memberId,'payment'=>$paymentlite),$app);
				$memberobj->saveSafe();
			}
		endif;


		
		// the member is created here via the approve() method called in the email sending logic
		$response = $app['applicationEmails']($app,$applicationId,$context='new-member-welcome',$request);

		// save the card by getting the memberId first

		$papply = new Model\ApplyNewMember(array('_id'=>$applicationId), $app);
		$papplication = $papply->findById();
		$paymentlite = new Model\PaymentLite($doc['payment'],$app);
		$paymentlite->renewalREUSE = ($doc['termsAcknowledgement'] == 'yes') ? 'yes' : 'no';

		$member = new Model\Member(array('_id'=>$papplication['memberId'],'payment'=>$paymentlite),$app);
		$member->saveSafe();

		// for generating the invoice block
			$member = $member->findById();		
			$location = new Model\Location(array('member'=>array('_id'=>$papplication['memberId'])), $app);
			$location = $location->getByMemberId();
			
			switch ($papplication['class']) {
				case 'NewMemberApplication': // old deprecated
				case 'ApplyNewMember':
				case 'ApplyNewSustainingMember':
					$pro_rate = $papply->proRate();
				    break;		
				case 'UpdateMember':
				case 'UpdateFoundingMember':
				case 'UpdateSustainingMember':
					$pro_rate = array('q'=>0,'a'=>0);
					break;
			}
		// end for generating the invoice block
		$ppayment = new Model\Payment(array(
			'_id'=>$application->paymentId
			,'memberId'=>$papplication['memberId']
			,'invoiceBlock'=>$app['view']->element('invoice-block',array('application'=>$papplication,'member'=>$member,'location'=>$location,'pro_rated_membership_dues'=>$pro_rate))
		),$app);
		$ppayment->saveSafe();
		

		if($is_admin == false):
			// marking the application paid
			$application = new Model\Apply(array('_id'=>$applicationId, 'paymentId'=>$application->paymentId), $app);
			$application->markPaid(false);
		endif;

	}

	

	$label = 'Your application was received.  Thank you.';
	$message = 'Thank you for your interest in NCDD.  Your application has been submitted.  Please check your inbox for your receipt and log-in information.';
	$response_status = 200;
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));
})->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
			$user = $app['session']->get('user');
			$user['suppress_emails'] = $request->get('suppress_emails');
			$app['session']->set('user',$user);
			$suppress = (!empty($user) && (is_array($user)) && array_key_exists('accesslevel', $user) && ($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes') ? true: false;


	    	$doc = $request->get('doc');
	    	// send admin the email notification
	    	$subject = 'General Member Application Form Submitted';
	    	$to = SAW_ADMIN_EMAIL;
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'middleName'=>$doc['middleName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    	);
	    	$body = $app['view']->render('email/new-member','email', $view_vars);
	    	if(!$suppress){$app['sendMail']($subject, $body, $to);}

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
});
///////////////////////////////////////
// NEW SUSTAINING MEMBER APPLICATION //
///////////////////////////////////////
$app->get('/application/new-sustaining-member', function (Request $request) use ($app) {
	return $app['view']->render('application/new-sustaining-member', 'blank');
});
$app->post('/application/new-sustaining-member', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    if(!array_key_exists('termsAcknowledgement', $doc)){
    	$doc['termsAcknowledgement'] = 'no';
    }
    if(!array_key_exists('twoSeminarsAcknowledgement', $doc)){
    	$doc['twoSeminarsAcknowledgement'] = 'no';
    }
    $doc['userAgent'] = $request->headers->get('User-Agent');
    $application = new Model\ApplyNewSustainingMember($doc, $app);

    if($application->findByEmail()){
    	$response_arr = array('message'=>"Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.",
                              "invalidFields"=>array(array('name'=>'email','message'=>'Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.')));
        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
    }else{
        // validate the model
	    $app['validateModel']($app,$application);

    	$applicationId = $application->insert();
    	$_POST['applicationId'] = $applicationId->__toString();
    	$label = 'Your application was received.  Thank you.';
    	$message = 'Thank you for your interest in NCDD.  Your application has been submitted.  You will be notified by the College when it is approved or if there are any questions.';
    	$response_status = 200;
    }
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));
})->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
	    	$user = $app['session']->get('user');
			$user['suppress_emails'] = $request->get('suppress_emails');
			$app['session']->set('user',$user);
			$suppress = (!empty($user) && (is_array($user)) && array_key_exists('accesslevel', $user) && ($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') ) ) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes') ? true: false;
			
	    	$doc = $request->get('doc');
	    	// send admin the email notification
	    	$subject = 'Sustaining Member Application Form Submitted';
	    	$to = SAW_ADMIN_EMAIL;
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'middleName'=>$doc['middleName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    	);
	    	$body = $app['view']->render('email/new-sustaining-member','email', $view_vars);
	    	if(!$suppress){$app['sendMail']($subject, $body, $to);}

	    	// send applicant the email notification
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
	    	$body = $app['view']->render('email/new-sustaining-member-applicant-submission','email', $view_vars);
	    	if(!$suppress){$app['sendMail']($subject, $body, $to);}
	    endif;
});

///////////////////////////////
// UPDATE MEMBER APPLICATION //
///////////////////////////////
$app->get('/application/update-member/{memberId}', function ($memberId, Request $request) use ($app) {

	//get the user logged in
	if(empty($memberId)){
		$user = $app['session']->get('user');
		$memberId = $user['user_id'];
	}
	

	$location = new Model\Location($doc=array('member'=>array('_id'=>$memberId)), $app);
	$location = $location->getByMemberId();

	$member = new Model\Member($doc=array('_id'=>$memberId), $app);
	$member = $member->findById();
	
	// prepare the card payment fields
	if(is_array($member) && array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('number', $member['payment'])){
		$member['payment']['cvc'] = str_replace('.x', '', $member['payment']['cvc']);
		$member['payment']['number'] = str_replace('.x', '', $member['payment']['number']);
		$member['payment']['number'] = (!empty($member['payment']['number'])) ? '...'.substr($member['payment']['number'], -4) :'';
		$payment = $member['payment'];
	}else{
		$payment = array();
	}
	
	$crumbs = array(array('name'=>'Dashboard','href'=>'/')
					,array('name'=>'Membership Renewal','href'=>'/application/update-member')
					);
	$view_vars = array(
						 'active'=>'Dashboard'
						,'page-plugin'=>'datatables'
						,'headline'=>'Membership Renewal Form'
						,'description'=>"Fill in and submit this application to begin your membership renewal process."
						,'crumbs'=>$crumbs
						,'member'=>$member
						,'location'=>$location
						,'payment'=>$payment
						);
		
	return $app['view']->render('application/update-member', 'default', $view_vars);
})->value('memberId','');

/**

RENEWAL SUBMISSIONS HERE

*/
$app->post('/application/update-member/{memberId}', function ($memberId, Request $request) use ($app) {

	//get the user logged in
	if(empty($memberId)){
		$user = $app['session']->get('user');
		$memberId = $user['user_id'];
	}
	
	$location = new Model\Location($doc=array('member'=>array('_id'=>$memberId)), $app);
	$location = $location->getByMemberId();
	$member = new Model\Member($doc=array('_id'=>$memberId), $app);
	$member = $member->findById();
	if(empty($location)){
		$location['city'] = '';
		$location['state'] = '';
	}


    // retrieve document from request
	$doc = $request->get('doc');
	$doc['userAgent'] = $request->headers->get('User-Agent');

	if(array_key_exists('termsAcknowledgement', $doc) && $doc['termsAcknowledgement'] == 'yes'){
    	$doc['payByCheck'] = 'no-store';
    }

	// add name, email and area to the application for identification
	$doc['memberId'] = new \MongoId($memberId);

	$doc['firstName'] = (empty($doc['firstName'])) ? $member['firstName'] : $doc['firstName'];
	$doc['middleName'] = (empty($doc['middleName'])) ? (array_key_exists('middleName',$member)) ? $member['middleName']: '' : $doc['middleName'];
	$doc['lastName'] = (empty($doc['lastName'])) ? $member['lastName'] : $doc['lastName'];
	$doc['email'] = (empty($doc['email'])) ? $member['email'] : $doc['email'];
	$doc['city'] = (empty($doc['city'])) ? $location['city'] : $doc['city'];
	$doc['state'] = (empty($doc['state'])) ? $location['state'] : $doc['state'];
	// everything is automatically approved now
	$doc['currentStatus'] = Model\Apply::$status['APPROVED'];
	$doc['approvedDate'] = new Model\Date($app, 'now');
	$doc['submittedDate'] = new Model\Date($app, 'now');

	$paymentId = null;	
	$app_id = new \stdClass();	

	switch ($member['currentMembership']) {
		case Model\Member::$membership['PUBLIC DEFENDER']:
		case Model\Member::$membership['GENERAL MEMBER']:
			$application = new Model\UpdateMember($doc, $app);
			break;
		case Model\Member::$membership['FOUNDING MEMBER']:
			$application = new Model\UpdateFoundingMember($doc, $app);
			break;
		case Model\Member::$membership['SUSTAINING MEMBER']:
			$application = new Model\UpdateSustainingMember($doc, $app);
			break;
		
	}
    
    // validate the model
    $app['validateModel']($app,$application,$groups=array('update_member'));
    if(array_key_exists('payByCheck',$doc) && strpos($doc['payByCheck'], 'no') !== false){
    	if($doc['payByCheck'] == 'no-store'){
    		$doc['paymentlite']['renewalREUSE'] = 'yes';
    	}
    	// prepare to save the credit card information 
	    $paymentlite = new Model\PaymentLite($doc['paymentlite'], $app);
    	$validate[] = array('model'=>$paymentlite,'groups'=>array('cc'));
    	$app['validateModel']($app,$validate);
    }
    
    
    // save the application
	$app_id = $application->insert();		
	if(array_key_exists('payByCheck',$doc) && strpos($doc['payByCheck'], 'no') !== false){
		// save the card - retain membership credit if exists!
		$tmpmem = new Model\Member(array('_id'=>$memberId),$app);
		$tmpmem = $tmpmem->findById();
		$tmprenewalcredit = (is_array($tmpmem['payment']) && array_key_exists('renewalCredit', $tmpmem['payment'])) ? $tmpmem['payment']['renewalCredit']: '';
		if(!empty($tmprenewalcredit))
			$paymentlite->renewalCredit = $tmprenewalcredit;
		$paymentlite->number = $paymentlite->number.'.x';
		$paymentlite->expYear = substr($paymentlite->expYear, -2);
		$memberobj = new Model\Member(array('_id'=>$memberId,'payment'=>$paymentlite),$app);
		$memberobj->saveSafe();
	}
	

	if ($doc['contributionCheck'] == 'yes') {
		
		$doc['payment']['ownerId'] = $app_id;
		$doc['payment']['ownerClass'] = 'UpdateMember';

		$payment = new Model\Payment($doc['payment'],$app);
		
		$validate[] = array('model'=>$payment,'groups'=>array('cc'));
		$app['validateModel']($app,$validate);
		$paymentId = $payment->charge();

		// thank you receipt message
		$subject = 'NCDD Payment Received';
		$to = $payment->email;

		$view_vars = array('payment'=>$payment->__toArray()
							,'paymentId'=>$paymentId
							,'email'=>$member['email']
		);
		$body = $app['view']->render('email/payment-thankyou','email', $view_vars);
		
		$user = $app['session']->get('user');
		$user['suppress_emails'] = $request->get('suppress_emails');
		$app['session']->set('user',$user);
		if( ($user['accessLevel'] == ADMIN  || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && $user['suppress_emails'] == 'yes'){
			// do nothing
		}else{
			$app['sendMail']($subject, $body, $to);
		}		

		// update the newly created payment record
		$payment = new Model\Payment(array('_id'=>$paymentId,'ownerId'=>$app_id),$app);
		$payment->saveSafe();


	}
	
	
	
	$member['renewal']['currentStatus'] = Model\Renewal::$status['APPROVED'];
	$member['renewal']['submittedDate'] = new Model\Date($app, 'now'); 
	$member['renewal']['approvedDate'] = new Model\Date($app, 'now'); 
	$member['renewal']['applicationId'] = $app_id; 
	$member['renewal']['contributionPaymentId'] = $paymentId; 
	$member['renewal']['payByCheck'] = (array_key_exists('payByCheck', $doc)) ? $doc['payByCheck']: '';

	$renewal = new Model\Renewal($member['renewal'],$app);
	$renewal->setRenewalByMember($member['_id']);
	

	

	return new Response(json_encode(array(
		'label'=>'Your application was received.  Thank you.',
		'message'=>'Thank you for your interest in NCDD.  Your application has been submitted.  You will be notified by the College if there are any questions or concerns that need to be addressed.')), 200,array('Content-Type' => 'registration/json')
	);


})->value('memberId','')
->after(function (Request $request, Response $response, Silex\Application $app) {
		
});
////////////////////////////////////////
// UPDATE FOUNDING MEMBER APPLICATION //
////////////////////////////////////////
$app->get('/application/update-founding-member/{memberId}', function ($memberId, Request $request) use ($app) {

	//get the user logged in
	if(empty($memberId)){
		$user = $app['session']->get('user');
		$memberId = $user['user_id'];
	}

	$location = new Model\Location($doc=array('member'=>array('_id'=>$memberId)), $app);
	$location = $location->getByMemberId();
	$member = $location['member'];

	$crumbs = array(array('name'=>'Dashboard','href'=>'/')
					,array('name'=>'Founding Member Update','href'=>'/application/update-founding-member')
					);
	$view_vars = array(
						 'active'=>'Dashboard'
						,'page-plugin'=>'datatables'
						,'headline'=>'Membership Update Form'
						,'description'=>"Fill in and submit this application to begin your membership update process."
						,'crumbs'=>$crumbs
						,'member'=>$member
						,'location'=>$location);
		
	return $app['view']->render('application/update-founding-member', 'default', $view_vars);
})->value('memberId','');

//////////////////////////////////////////
// UPDATE SUSTAINING MEMBER APPLICATION //
//////////////////////////////////////////
$app->get('/application/update-sustaining-member/{memberId}', function ($memberId, Request $request) use ($app) {

	//get the user logged in
	if(empty($memberId)){
		$user = $app['session']->get('user');
		$memberId = $user['user_id'];
	}

	$location = new Model\Location($doc=array('member'=>array('_id'=>$memberId)), $app);
	$location = $location->getByMemberId();
	$member = $location['member'];

	$crumbs = array(array('name'=>'Dashboard','href'=>'/')
					,array('name'=>'Sustaining Membership Update','href'=>'/application/update-sustaining-member')
					);
	$view_vars = array(
						 'active'=>'Dashboard'
						,'page-plugin'=>'datatables'
						,'headline'=>'Membership Update Form'
						,'description'=>"Fill in and submit this application to begin your membership update process."
						,'crumbs'=>$crumbs
						,'member'=>$member
						,'location'=>$location);
		
	return $app['view']->render('application/update-sustaining-member', 'default', $view_vars);
})->value('memberId','');


///////////////////////
// GENERAL FUNCTIONS //
///////////////////////
$app->get('/application/{id}/view-public', function ($id, Request $request) use ($app) {
	
	$application = new Model\Apply($doc=array('_id'=>$id), $app);
	$application = $application->findById();

	$location = new Model\Location($doc=array('member'=>array('_id'=>$application['memberId'])), $app);
	$location = $location->getByMemberId();
	$member = $location['member'];
	
	$crumbs = array(array('name'=>'Applications','href'=>'#')
					,array('name'=>$application['firstName'].' '.$application['lastName'],'href'=>'#')
					,array('name'=>$application['type'],'href'=>'#')
					);
	$view_vars = array(
						 'active'=>'Application'
						,'page-plugin'=>'datatables'
						,'headline'=>'Private Application View'
						,'description'=>""
						,'crumbs'=>$crumbs
						,'application'=>$application
						,'location'=>$location
						,'member'=>$member
						);
	switch ($application['class']) {
		case 'NewMemberApplication': // old deprecated
		case 'ApplyNewMember':
			return $app['view']->render('application/view-new-member-public', 'blank', $view_vars);		
			break;
		case 'ApplyNewSustainingMember':
			return $app['view']->render('application/view-new-sustaining-member-public', 'blank', $view_vars);		
			break;
		case 'UpdateMember':
			return $app['view']->render('application/view-update-member-public', 'blank', $view_vars);		
			break;
		case 'UpdateFoundingMember':
			return $app['view']->render('application/view-update-founding-member-public', 'blank', $view_vars);		
			break;
		case 'UpdateSustainingMember':
			return $app['view']->render('application/view-update-sustaining-member-public', 'blank', $view_vars);		
			break;
		default:
			$msg = new \stdClass();
			$msg->message = 'This Application cannot be found.';
			$msg->resolveMessage = 'Please go back and try again or contact the Administrator if this problem persists.';
			return $app['view']->render('errors/404','error', array('error'=>$msg));
			break;
	}
	
})->value('id','');

$app->get('/application/{id}/view', function ($id, Request $request) use ($app) {
	
	$application = new Model\Apply($doc=array('_id'=>$id), $app);
	$application = $application->findById();

	$reference = new Model\Reference($doc=array('_id'=>$id), $app);
	$references = $reference->fetch(0,50,array('applicationId'=>$application['_id']));

	$location = new Model\Location($doc=array('member'=>array('_id'=>$application['memberId'])), $app);
	$location = $location->getByMemberId();
	$member = $location['member'];
	
	$crumbs = array(array('name'=>'Applications','href'=>'/applications')
					,array('name'=>$application['firstName'].' '.$application['lastName'],'href'=>'/application/'.$id.'/view')
					,array('name'=>$application['type'],'href'=>'/application/'.$id.'/view')
					);
	$view_vars = array(
						 'active'=>'Application'
						,'page-plugin'=>'datatables'
						,'headline'=>'Applications'
						,'description'=>"View all application here."
						,'crumbs'=>$crumbs
						,'application'=>$application
						,'location'=>$location
						,'member'=>$member
						,'references'=>$references
						);
	switch ($application['class']) {
		case 'NewMemberApplication': // old deprecated
		case 'ApplyNewMember':
			return $app['view']->render('application/view-new-member', 'default', $view_vars);		
			break;
		case 'ApplyNewSustainingMember':
			return $app['view']->render('application/view-new-sustaining-member', 'default', $view_vars);		
			break;
		case 'UpdateMember':
			return $app['view']->render('application/view-update-member', 'default', $view_vars);		
			break;
		case 'UpdateFoundingMember':
			return $app['view']->render('application/view-update-founding-member', 'default', $view_vars);		
			break;
		case 'UpdateSustainingMember':
			return $app['view']->render('application/view-update-sustaining-member', 'default', $view_vars);		
			break;
		default:
			$msg = new \stdClass();
			$msg->message = 'This Application cannot be found.';
			$msg->resolveMessage = 'Please go back and try again or contact the Administrator if this problem persists.';
			return $app['view']->render('errors/404','error', array('error'=>$msg));
			break;
	}
	
})->value('id','')
->before($mustbeADMIN);

$app->get('/application/{id}/edit', function ($id, Request $request) use ($app) {
	
	$application = new Model\Apply($doc=array('_id'=>$id), $app);
	$application = $application->findById();

	$location = new Model\Location($doc=array('member'=>array('_id'=>$application['memberId'])), $app);
	$location = $location->getByMemberId();
	$member = $location['member'];

	$crumbs = array(array('name'=>'Applications','href'=>'/applications')
					,array('name'=>$application['firstName'].' '.$application['lastName'],'href'=>'/application/'.$id.'/view')
					,array('name'=>$application['type'],'href'=>'/application/'.$id.'/view')
					,array('name'=>'Edit','href'=>'/application/'.$id.'/edit')
					);
	$view_vars = array(
						 'active'=>'Application'
						,'page-plugin'=>'datatables'
						,'headline'=>'Applications'
						,'description'=>"Edit Application."
						,'crumbs'=>$crumbs
						,'application'=>$application
						,'location'=>$location
						,'member'=>$member
						);
	switch ($application['class']) {
		case 'NewMemberApplication': // old deprecated
		case 'ApplyNewMember':
			return $app['view']->render('application/edit-new-member', 'default', $view_vars);		
			break;
		case 'ApplyNewSustainingMember':
			return $app['view']->render('application/edit-new-sustaining-member', 'default', $view_vars);		
			break;
		case 'UpdateMember':
			return $app['view']->render('application/edit-update-member', 'default', $view_vars);		
			break;
		case 'UpdateFoundingMember':
			return $app['view']->render('application/edit-update-founding-member', 'default', $view_vars);		
			break;
		case 'UpdateSustainingMember':
			return $app['view']->render('application/edit-update-sustaining-member', 'default', $view_vars);		
			break;
		
	}
	
})->value('id','')
->before($mustbeADMIN);

$app->post('/application/edit', function (Request $request) use ($app) {

	// retrieve document from request
    $doc = $request->get('doc');
    if(!array_key_exists('termsAcknowledgement', $doc)){
    	$doc['termsAcknowledgement'] = 'no';
    }
    if(!array_key_exists('twoSeminarsAcknowledgement', $doc)){
    	$doc['twoSeminarsAcknowledgement'] = 'no';
    }
    $endTrial = $request->get('endTrial');
    $startTrial = $request->get('startTrial');
    
	switch ($doc['class']) {
		case 'NewMemberApplication': // old deprecated
		case 'ApplyNewMember':
			$application = new Model\ApplyNewMember($doc, $app);
		    break;
		case 'ApplyNewSustainingMember':
			$application = new Model\ApplyNewSustainingMember($doc, $app);
		    break;		
		case 'UpdateMember':
			$application = new Model\UpdateMember($doc, $app);
			break;
		case 'UpdateFoundingMember':
			$application = new Model\UpdateFoundingMember($doc, $app);
			break;
		case 'UpdateSustainingMember':
			$application = new Model\UpdateSustainingMember($doc, $app);
			break;
	}
	if(!empty($endTrial)){
		$appArr = $application->findOne($query=array('_id'=>new \MongoId($doc['_id'])),$fields=array('trial'=>true));

		$newEndDate = new Model\Date($app,$endTrial, $appArr['trial']['timeZone']);
		$newStartDate = new Model\Date($app,$startTrial, $appArr['trial']['timeZone']);
		
		$appArr['trial']['referredBy'] = $doc['referredBy'];
		$appArr['trial']['startDate'] = $newStartDate;
		$appArr['trial']['endDate'] = $newEndDate;
		$new_trial = new Model\Trial($appArr['trial'],$app);
		$app['validateModel']($app,$new_trial);

		$application->trial = $new_trial->__toArray();
		$application->trial['endDate'] = $newEndDate;
		$application->trial['startDate'] = $newStartDate;
	}
	
	

	switch ($doc['class']) {
		case 'NewMemberApplication': // old deprecated
		case 'ApplyNewMember':
		case 'ApplyNewSustainingMember':
			// validate the model
			$app['validateModel']($app,$application);
	
			$application_id = $application->checkEmailExists();
			if(!empty($application_id) && $application_id != $application->_id){
		    	$label = 'Warning:';
		    	$message = "The email address you're trying to update is already in use on another application.  Please use a different email and try again.";
		    	$response_status = 400;
		    }else{
		    	$member = $application->saveEdit();	
		    	// now need to update the payment type on the original member record
		    	if(array_key_exists('payByCheck', $doc)){
		    		$apply = new Model\Apply(array('_id'=>$doc['_id']),$app);
		    		$apply = $apply->findById();
		    		$mem = new Model\Member(array('_id'=>$apply['memberId']),$app);
		    		$mem->updateByCriteria(array('$set'=>array('renewal.payByCheck'=>$doc['payByCheck'])), array('_id'=>$apply['memberId']));
		    	}
		    	$label = 'Application Saved';
		    	$message = 'Application Successfully Saved.';
		    	$response_status = 200;
		    }
		    break;		
		case 'UpdateMember':
		case 'UpdateFoundingMember':
		case 'UpdateSustainingMember':
			// validate the model
			$app['validateModel']($app,$application,$groups=array('update_member'));
	
			$member = $application->saveEdit();	
			// now need to update the payment type on the original member record
	    	if(array_key_exists('payByCheck', $doc)){
	    		$apply = new Model\Apply(array('_id'=>$doc['_id']),$app);
	    		$apply = $apply->findById();
	    		$mem = new Model\Member(array('_id'=>$apply['memberId']),$app);
	    		$mem->updateByCriteria(array('$set'=>array('renewal.payByCheck'=>$doc['payByCheck'])), array('_id'=>$apply['memberId']));
	    	}
	    	$label = 'Application Saved';
	    	$message = 'Application Successfully Saved.';
	    	$response_status = 200;
			break;
	}
	
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));

})->before($mustbeADMIN);
// REFERENCES SAVE
$app->post('/application/references', function (Request $request) use ($app) {

	$id = $request->get('id');
	$value = $request->get('value');

	$application = new Model\Apply(array('_id'=>$id,'references'=>$value), $app);
	$application->saveEdit();
	return new Response(json_encode(array('message' => 'success')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);

//////////////////
// EXPIRE TRIAL //
//////////////////
$app->get('/application/expire-trial', function (Request $request) use ($app) {
	
	$appl = new Model\Apply($doc=array(), $app);
	$applications = $appl->fetchByStatus('TRIAL',0,100,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
	
	$total = count($applications);
	$count = 0;	
	foreach($applications as $application):
		$appArr = $appl->findOne($query=array('_id'=>new \MongoId($application['_id'])),$fields=array('trial'=>true));

		$start = \Carbon\Carbon::createFromTimeStamp(strtotime($appArr['trial']['startDate']['fullMonth']), $appArr['trial']['timeZone']);
		$end = \Carbon\Carbon::createFromTimeStamp(strtotime($appArr['trial']['endDate']['fullMonth']), $appArr['trial']['timeZone']);
		$days = $start->diffInDays($end);
		if($days <= 0){

			// set the trial to expired
			$appArr['trial']['startDate'] = $appArr['trial']['startDate']['fullMonth'];
			$appArr['trial']['endDate'] = $appArr['trial']['endDate']['fullMonth'];
			$appArr['trial']['currentStatus'] = Model\Trial::$status['EXPIRED'];
			$new_trial = new Model\Trial($appArr['trial'],$app);

			$appObj = new Model\Apply(array('_id'=>$application['_id'],'trial'=>$new_trial->__toArray()), $app);
			$appObj->saveEdit();

			// update the member access level to UNPAIDMEMBER
			$member = new Model\Member(array('_id'=>$application['memberId'],'accessLevel'=>UNPAIDMEMBER),$app);
			$member->saveEdit();
			$count++;
		}
		
	endforeach;
	return new Response("Expired ".$count." out of ".$total." applications in Trial Mode", 200,array('Content-Type' => 'text/html'));
});
///////////////
// SET TRIAL //
///////////////
$app->post('/application/{id}/trial', function ($id, Request $request) use ($app) {
	
	// retrieve document from request
	$doc = $request->get('doc');
	$doc['startDate'] = 'now';
	
	$trial = new Model\Trial($doc,$app);
	$app['validateModel']($app, $trial);

	$application = new Model\Apply(array('_id'=>$id,'referredBy'=>$doc['referredBy'],'trial'=>$trial->__toArray()), $app);
	$application->saveEdit();

	return $app['applicationEmails']($app,$id,$context='new-member-trial',$request);
})->before($mustbeADMIN);

/////////////
// APPROVE //
/////////////
$app->get('/application/{id}/approve/{type}', function ($id,$type, Request $request) use ($app) {
	//error_log('type:'.$type);
	$user = $app['session']->get('user');
	$user['suppress_emails'] = $request->get('suppress_emails');
	$app['session']->set('user',$user);
	return $app['applicationEmails']($app,$id,$context='new-member-welcome',$request);
})->before($mustbeADMIN);

///////////////
// MARK PAID //
///////////////
$app->get('/application/{id}/pay', function ($id, Request $request) use ($app) {
	
	$apply = new Model\Apply($doc=array('_id'=>$id), $app);
	$application = $apply->findById();
	
	$location = new Model\Location($doc=array('member'=>array('_id'=>$application['memberId'])), $app);
	$location = $location->getByMemberId();

	$member = new Model\Member($doc=array('_id'=>$application['memberId']), $app);
	$member = $member->findById();

	switch ($application['class']) {
		case 'NewMemberApplication': // old deprecated
		case 'ApplyNewMember':
		case 'ApplyNewSustainingMember':
			$pro_rate = $apply->proRate();
		    break;		
		case 'UpdateMember':
		case 'UpdateFoundingMember':
		case 'UpdateSustainingMember':
			$pro_rate = array('q'=>0,'a'=>0);
			break;
	}
	
	$crumbs = array(array('name'=>'Applications','href'=>'/applications')
					,array('name'=>$application['firstName'].' '.$application['lastName'],'href'=>'/application/'.$id.'/view')
					,array('name'=>$application['type'],'href'=>'/application/'.$id.'/view')
					,array('name'=>'Submit Payment','href'=>'/application/'.$id.'/pay')
					);
	$view_vars = array(
						 'active'=>'Application'
						,'page-plugin'=>'datatables,invoice'
						,'headline'=>'Membership Application Payment'
						,'description'=>"Pay membership Dues."
						,'crumbs'=>$crumbs
						,'application'=>$application
						,'location'=>$location
						,'member'=>$member
						,'pro_rated_membership_dues'=>$pro_rate);
	return $app['view']->render('application/pay', 'default', $view_vars);
})->value('id','')
->before($mustbeMEMBER);

$app->get('/application/{id}/pay-other', function ($id, Request $request) use ($app) {
	
	$apply = new Model\Apply($doc=array('_id'=>$id), $app);
	$application = $apply->findById();
	
	$location = new Model\Location($doc=array('member'=>array('_id'=>$application['memberId'])), $app);
	$location = $location->getByMemberId();
	$member = new Model\Member($doc=array('_id'=>$application['memberId']), $app);
	$member = $member->findById();

	switch ($application['class']) {
		case 'NewMemberApplication': // old deprecated
		case 'ApplyNewMember':
		case 'ApplyNewSustainingMember':
			$pro_rate = $apply->proRate();
		    break;		
		case 'UpdateMember':
		case 'UpdateFoundingMember':
		case 'UpdateSustainingMember':
			$pro_rate = array('q'=>0,'a'=>0);
			break;
	}
	
	$crumbs = array(array('name'=>'Applications','href'=>'/applications')
					,array('name'=>$application['firstName'].' '.$application['lastName'],'href'=>'/application/'.$id.'/view')
					,array('name'=>$application['type'],'href'=>'/application/'.$id.'/view')
					,array('name'=>'Submit Another Form of Payment ','href'=>'/application/'.$id.'/pay')
					);
	$view_vars = array(
						 'active'=>'Application'
						,'page-plugin'=>'datatables,invoice'
						,'headline'=>'Membership Application Payment'
						,'description'=>"Pay membership Dues."
						,'crumbs'=>$crumbs
						,'application'=>$application
						,'location'=>$location
						,'member'=>$member
						,'pro_rated_membership_dues'=>$pro_rate);
	return $app['view']->render('application/pay-other', 'default', $view_vars);
})->value('id','')
->before($mustbeADMIN);

// this is posted to by the applications/pay-other.php view
// mark the application paid and create a payment record, which is the receipt
// the credit card charging view has it's routes stored in the Payment.js.php file
$app->post('/application/payment', function (Request $request) use ($app) {
	// retrieve document from request
	$doc = $request->get('doc');

	// prepare the invoice for the payment record
	$apply = new Model\Apply(array('_id'=>$doc['ownerId']), $app);
	$application = $apply->findById();
	if(!empty($application) && is_array($application)){	
		$location = new Model\Location(array('member'=>array('_id'=>$application['memberId'])), $app);
		$location = $location->getByMemberId();
		$member = new Model\Member(array('_id'=>$application['memberId']), $app);
		$member = $member->findById();

		switch ($application['class']) {
			case 'NewMemberApplication': // old deprecated
			case 'ApplyNewMember':
			case 'ApplyNewSustainingMember':
				$pro_rate = $apply->proRate();
			    break;		
			case 'UpdateMember':
			case 'UpdateFoundingMember':
			case 'UpdateSustainingMember':
				$pro_rate = array('q'=>0,'a'=>0);
				break;
		}
		$doc['invoiceBlock'] = $app['view']->element('invoice-block',array('application'=>$application,'member'=>$member,'location'=>$location,'pro_rated_membership_dues'=>$pro_rate));
	}


	$payment = new Model\Payment($doc,$app);
	$app['validateModel']($app, $payment,$groups=array('manual'));
	$paymentId = $payment->manualCharge();

	// thank you receipt message
	$subject = 'NCDD Payment Received';
	$to = $payment->email;
	$view_vars = array('payment'=>$payment->__toArray()
						,'paymentId'=>$paymentId
						,'email'=>$payment->email
	);
	$body = $app['view']->render('email/payment-thankyou','email', $view_vars);
	
	$user = $app['session']->get('user');
	$user['suppress_emails'] = $request->get('suppress_emails');
	$app['session']->set('user',$user);
	if( ($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && $user['suppress_emails'] == 'yes'){
		// do nothing
	}else{
		$app['sendMail']($subject, $body, $to);
	}	
	return new Response(json_encode(array('paymentId'=>$paymentId,'message'=>"success")), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);

// both credit card and pay by check XHR call this route to mark the application as paid.
// resetSession is passed in when the member is using the credit card payment screen and not used when the admin 
// is making a payment on behalf of the member using the same credit card screen
$app->get('/application/{paymentId}/pay/{applicationId}/{resetSession}', function ($paymentId, $applicationId, $resetSession, Request $request) use ($app) {
    

    $apply = new Model\Apply($doc=array('_id'=>$applicationId), $app);
	$application = $apply->findById();

	switch ($application['class']) {
		case 'NewMemberApplication': // old deprecated
		case 'ApplyNewMember':
		case 'ApplyNewSustainingMember':
			$application = new Model\Apply(array('_id'=>$applicationId, 'paymentId'=>$paymentId), $app);
		    break;		
		case 'UpdateMember':
			$application = new Model\UpdateMember(array('_id'=>$applicationId, 'paymentId'=>$paymentId,'memberId'=>$application['memberId']), $app);
			break;
		case 'UpdateFoundingMember':
			$application = new Model\UpdateFoundingMember(array('_id'=>$applicationId, 'paymentId'=>$paymentId,'memberId'=>$application['memberId']), $app);
			break;
		case 'UpdateSustainingMember':
			$application = new Model\UpdateSustainingMember(array('_id'=>$applicationId, 'paymentId'=>$paymentId,'memberId'=>$application['memberId']), $app);
			break;
	}
    
    if($resetSession=='no')
    	$application->markPaid(false);
    else
    	$application->markPaid();

    return $app['applicationEmails']($app,$applicationId,$context='new-member-complete',$request);
})->value('resetSession','yes')->before($mustbeMEMBER);


$app->get('/application/{id}/delete', function ($id, Request $request) use ($app) {
    $application = new Model\Apply(array('_id'=>$id), $app);
    $application = $application->findById();
    
	switch ($application['class']) {
		case 'UpdateMember':
			$application = new Model\UpdateMember(array('_id'=>$application['_id'],'memberId'=>$application['memberId']), $app);
			break;
		case 'UpdateFoundingMember':
			$application = new Model\UpdateFoundingMember(array('_id'=>$application['_id'],'memberId'=>$application['memberId']), $app);
			break;
		case 'UpdateSustainingMember':
			$application = new Model\UpdateSustainingMember(array('_id'=>$application['_id'],'memberId'=>$application['memberId']), $app);
			break;
		case 'ApplyNewMember':
				$application = new Model\ApplyNewMember(array('_id'=>$application['_id'],'memberId'=>$application['memberId']), $app);
				break;
		case 'ApplyNewSustainingMember':
			$application = new Model\ApplyNewSustainingMember(array('_id'=>$application['_id'],'memberId'=>$application['memberId']), $app);
			break;		
		
	}

    $application->remove();
    return new Response(json_encode(array('message' => 'Successfully Deleted')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);

$app->get('/applications/all/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$application = new Model\Apply($doc=array(), $app);
	$paid = $application->fetchByStatus('PAID', $offset=0,$limit=$limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
	$crumbs = array(array('name'=>'Applications','href'=>'/applications')
					,array('name'=>'All Paid','href'=>'/applications/all')
	);
	$view_vars = array(
						 'active'=>'Application'
						,'page-plugin'=>'datatables'
						,'headline'=>'Applications'
						,'description'=>"View all PAID application here."
						,'crumbs'=>$crumbs
						,'paid'=>$paid);
	return $app['view']->render('application/all-paid', 'default', $view_vars);
})
->value('offset','0')
->value('limit','10000')
->before($mustbeADMIN);

$app->get('/applications/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$application = new Model\Apply($doc=array(), $app);
	$approved = $application->fetchByStatus('APPROVED',$offset, $limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
	$trial = $application->fetchByStatus('TRIAL',$offset, $limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
	$paid = $application->fetchByDatePaid(90, $offset, $limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));

	$ncddtrialpromocode = $application->fetchByStatus('TRIAL',$offset, $limit,$filter=array('promocode'=>array('$in'=>array('TRIAL','DIVTRIAL','PDTRIAL','RFTRIAL'))));
	$ncdd2015promocode = $application->fetchByStatus('PAID',$offset, $limit,$filter=array('promocode'=>'NCDD2015'));
	$ncdd2014promocode = $application->fetchByStatus('PAID',$offset, $limit,$filter=array('promocode'=>'NCDD2014'));
	if(!empty($ncdd2015promocode)):
	for ($i=0; $i < count($ncdd2015promocode); $i++) { 
		switch ($ncdd2015promocode[$i]['class']) {
	    	case 'ApplyNewMember':
	    		$reference = new Model\ReferenceMember(array('applicationId'=>$ncdd2015promocode[$i]['_id']), $app);
	    		break;
	    	case 'ApplyNewSustainingMember':
	    		$reference = new Model\ReferenceSustainingMember(array('applicationId'=>$ncdd2015promocode[$i]['_id']), $app);
	    		break;
	    	
	    }
	    $ncdd2015promocode[$i]['new_references'] = array('total'=>$reference->getTotalSubmissions(),'max'=>$reference->getMaxSubmissions());
	}
	endif;
	if(!empty($ncdd2014promocode)):
	for ($i=0; $i < count($ncdd2014promocode); $i++) { 
		switch ($ncdd2014promocode[$i]['class']) {
	    	case 'ApplyNewMember':
	    		$reference = new Model\ReferenceMember(array('applicationId'=>$ncdd2014promocode[$i]['_id']), $app);
	    		break;
	    	case 'ApplyNewSustainingMember':
	    		$reference = new Model\ReferenceSustainingMember(array('applicationId'=>$ncdd2014promocode[$i]['_id']), $app);
	    		break;
	    	
	    }
	    $ncdd2014promocode[$i]['new_references'] = array('total'=>$reference->getTotalSubmissions(),'max'=>$reference->getMaxSubmissions());
	}
	endif;
	$date = new Model\Date($app,'9/16/2014 5:00 PM');
	$newlypaid = $application->fetchByStatus('PAID',$offset, $limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION')),'promocode'=>array('$nin'=>array('NCDD2015','NCDD2014','TRIAL','DIVTRIAL','PDTRIAL','RFTRIAL')),'paidDate.date'=>array('$gte'=> new \MongoDate(strtotime($date->iso)))));
	if(!empty($newlypaid)):
	for ($i=0; $i < count($newlypaid); $i++) { 
		switch ($newlypaid[$i]['class']) {
	    	case 'NewMemberApplication':
	    	case 'ApplyNewMember':
	    		$reference = new Model\ReferenceMember(array('applicationId'=>$newlypaid[$i]['_id']), $app);
	    		$total = $reference->getTotalSubmissions();
	    		$max = $reference->getMaxSubmissions();
	    		break;
	    	case 'ApplyNewSustainingMember':
	    		$reference = new Model\ReferenceSustainingMember(array('applicationId'=>$newlypaid[$i]['_id']), $app);
	    		$total = $reference->getTotalSubmissions();
	    		$max = $reference->getMaxSubmissions();
	    		break;
	    	default:
	    		$total = 0;
	    		$max = 0;
	    		break;	    	
	    }
	    $newlypaid[$i]['new_references'] = array('total'=>$total,'max'=>$max);
	}
	endif;
	$crumbs = array(array('name'=>'Applications','href'=>'/applications'));
	$view_vars = array(
						 'active'=>'Applications/New'
						,'page-plugin'=>'datatables'
						,'headline'=>'Applications'
						,'description'=>"<a class='btn green ' href='/application/new-member-admin'><i class='icon-plus'></i> New Member</a>"
						,'crumbs'=>$crumbs
						,'approved'=>$approved
						,'trial'=>$trial
						,'paid'=>$paid
						,'ncdd2015promocode'=>$ncdd2015promocode
						,'ncdd2014promocode'=>$ncdd2014promocode
						,'ncddtrialpromocode'=>$ncddtrialpromocode
						,'newlypaid'=>$newlypaid
	);
	return $app['view']->render('application/index', 'default', $view_vars);
})
->value('offset','0')
->value('limit','10000')
->before($mustbeADMIN);
//////////////////////////////////////////////////////////
// RENEWALS - MEMBERS WITH A CREDIT FOR MEMBERSHIP FEES //
//////////////////////////////////////////////////////////
$app->get('/renewalscredits/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$member = new Model\Member($doc=array(), $app);
	$renewals = $member->fetchByRenewalCredit($offset, $limit);
	
	$crumbs = array(array('name'=>'Renewals','href'=>'/renewals')
					,array('name'=>'Renewals - Credits','href'=>'/renewalscredits'));
	$view_vars = array(
						 'active'=>'Applications/RenewalContacts'
						,'page-plugin'=>'datatables'
						,'headline'=>'Renewals with credits'
						,'description'=>"View all renewals whose contact information has been updated."
						,'crumbs'=>$crumbs
						,'renewals'=>$renewals
						);
	return $app['view']->render('application/index-renewalscredits', 'default', $view_vars);
})
->value('offset','0')
->value('limit','20000')
->before($mustbeADMIN);
////////////////////////////////////////////
// RENEWALS - CONTACT INFORMATION UPDATES //
////////////////////////////////////////////
$app->get('/renewalscontacts/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$member = new Model\Member($doc=array(), $app);
	$renewals = array(
		'submitted'=>$member->fetchByRenewalStatus('SUBMITTED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit)
		,'approved'=>$member->fetchByRenewalStatus('APPROVED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit)
		,'paid'=>$member->fetchByRenewalStatus('PAID',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']), $offset, $limit)
	);
	$renewalsc = array();
	$cnt = 0;
	for ($i=0; $i < count($renewals['submitted']); $i++) { 
		$renewalsc[$cnt]['applicationId'] = $renewals['submitted'][$i]['renewal']['applicationId'];
		$renewalsc[$cnt]['_id'] = $renewals['submitted'][$i]['_id'];
		$cnt++;
	}
	for ($i=0; $i < count($renewals['approved']); $i++) { 
		$renewalsc[$cnt]['applicationId'] = $renewals['approved'][$i]['renewal']['applicationId'];
		$renewalsc[$cnt]['_id'] = $renewals['approved'][$i]['_id'];
		$cnt++;
	}
	for ($i=0; $i < count($renewals['paid']); $i++) { 
		$renewalsc[$cnt]['applicationId'] = $renewals['paid'][$i]['renewal']['applicationId'];
		$renewalsc[$cnt]['_id'] = $renewals['paid'][$i]['_id'];
		$cnt++;
	}
	// retrieve applications whose contact info has been updated
	$r = array();
	for ($i=0; $i < count($renewalsc); $i++) { 
		
		$apply = new Model\Apply($doc=array('_id'=>$renewalsc[$i]['applicationId']), $app);
		$a = $apply->findById();
		
		if(!empty($a)){
			$member = new Model\Member($doc=array('_id'=>$renewalsc[$i]['_id']), $app);
			$member = $member->findById();

			$location = new Model\Location($doc=array('member'=>array('_id'=>$renewalsc[$i]['_id'])), $app);
			$location = $location->getByMemberId();

			
			/* field map...

			$member['displayName'] == $a['firstName'].' '.$a['middleName'].' '.$a['lastName']
			$member['email'] == $a['email']
			$member['barNumber'] == $a['barNumber']
			$a['addToListServ']
			$member['listServEmail'] == $a['listServEmail']
			

			$location['name'] == $a['firmName']
			$location['addressLine1'] == $a['address1']
			$location['addressLine2'] == $a['address2']
			$location['city'] == $a['city']
			$location['state'] == $a['state']
			$location['zip'] == $a['postalCode']
			$location['country'] == $a['country']
			$location['phone'] == $a['phone']
			$location['fax'] == $a['fax']
			
			*/
			if($member['email'] == 'pewittlaw@gmail.com'){
				//echo '<pre>';print_r($a);echo '</pre>';
				//echo '<pre>';print_r($member);echo '</pre>';
			}
			// remove applications from the list which are false positives meaning the update is pointless because it's an update of the same values
			// what remains should be the applications that truly have updated contact information
			$popfalse = 0;
			$popfalse_email = 0;
			$popfalse_bar = 0;
			$popfalse_listserv = 0;
			$popfalse_firmname = 0;
			$popfalse_address = 0;
			$popfalse_phone = 0;
			if(!empty($a['firstName']) || !empty($a['middleName']) || !empty($a['lastName'])){ 
				
				$tmp = explode(' ', $member['displayName']);
				if(count($tmp) > 2){
					if($member['displayName'] != $a['firstName'].' '.$a['middleName'].' '.$a['lastName']){
						$popfalse++;
					}
				}elseif(count($tmp) <= 2){
					if($member['displayName'] != $a['firstName'].' '.$a['lastName']){
						$popfalse++;
					}
				}

				
			}
			if(!empty($a['email']) 
				&& $member['email'] != $a['email']){
				$popfalse++;
				$popfalse_email++;
			}
			if(!empty($a['barNumber']) 
				&& $member['barNumber'] != $a['barNumber']){
				$popfalse++;
				$popfalse_bar++;
			}
			if((!empty($a['listServEmail']) 
				&& $member['listServEmail'] != $a['listServEmail'])
				|| ($a['addToListServ'] == 'yes') && !empty($a['listServEmail']) && $member['listServEmail'] == $a['listServEmail']){
				$popfalse++;
				$popfalse_listserv++;
			}
			if(!empty($a['firmName']) 
				&& $location['name'] != $a['firmName']){
				$popfalse++;
				$popfalse_firmname++;
			}

			if(!empty($a['address1']) 
				&& $location['addressLine1'] != $a['address1']){
				$popfalse++;
				$popfalse_address++;
			}
			if(!empty($a['address2']) 
				&& $location['addressLine2'] != $a['address2']){
				$popfalse++;
				$popfalse_address++;
			}
			if(!empty($a['city']) 
				&& $location['city'] != $a['city']){
				$popfalse++;
				$popfalse_address++;
			}
			if(!empty($a['state']) 
				&& $location['state'] != $a['state']){
				$popfalse++;
				$popfalse_address++;
			}
			if(!empty($a['postalcode']) 
				&& $location['zip'] != $a['postalCode']){
				$popfalse++;
				$popfalse_address++;
			}
			if(!empty($a['country']) 
				&& $location['country'] != $a['country']){
				$popfalse++;
				$popfalse_address++;
			}

			if(!empty($a['phone']) 
				&& $location['phone'] != $a['phone']){
				$popfalse++;
				$popfalse_phone++;
			}
			if(!empty($a['fax']) 
				&& $location['fax'] != $a['fax']){
				$popfalse++;
				$popfalse_phone++;
			}

			if($popfalse > 0){
				$r[] = $member;
			}
			if($popfalse_email > 0){
				$r_email[] = $member;
			}
			if($popfalse_bar > 0){
				$r_bar[] = $member;
			}
			if($popfalse_listserv > 0){
				$r_listserv[] = $member;
			}
			if($popfalse_firmname > 0){
				$r_firmname[] = $member;
			}
			if($popfalse_address > 0){
				$r_address[] = $member;
			}
			if($popfalse_phone > 0){
				$r_phone[] = $member;
			}

		}
	}
	
	
	$crumbs = array(array('name'=>'Renewals','href'=>'/renewals')
					,array('name'=>'Renewals - C','href'=>'/renewalscontacts'));
	$view_vars = array(
						 'active'=>'Applications/RenewalContacts'
						,'page-plugin'=>'datatables'
						,'headline'=>'Renewals - Contact Info Updates'
						,'description'=>"View all renewals whose contact information has been updated."
						,'crumbs'=>$crumbs
						,'renewals'=>$r
						,'renewals_email'=>$r_email
						,'renewals_bar'=>$r_bar
						,'renewals_listserv'=>$r_listserv
						,'renewals_firmname'=>$r_firmname
						,'renewals_address'=>$r_address
						,'renewals_phone'=>$r_phone
						);
	return $app['view']->render('application/index-renewalscontacts', 'default', $view_vars);
})
->value('offset','0')
->value('limit','20000')
->before($mustbeADMIN);
//////////////
// RENEWALS //
//////////////
$app->get('/renewals/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$member = new Model\Member($doc=array(), $app);
	$renewals = array(
		'unsubmitted'=>$member->fetchByRenewalStatus('UNSUBMITTED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit)
		,'submitted'=>$member->fetchByRenewalStatus('SUBMITTED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit)
		,'approved'=>$member->fetchByRenewalStatus('APPROVED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit)
		,'paid'=>$member->fetchByRenewalStatus('PAID',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']), $offset, $limit)
		,'unpaidbycheck'=>$member->fetchByPaymentStatus('unpaid-PAYBYCHECK',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']), $offset, $limit)
		,'paidbycheck'=>$member->fetchByPaymentStatus('paid-PAYBYCHECK',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']), $offset, $limit)
		,'paidbycc'=>$member->fetchByPaymentStatus('paid-CC',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']), $offset, $limit)
		,'paidbyccrecurr'=>$member->fetchByPaymentStatus('paid-CCRECUR',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']), $offset, $limit)
	);
	
	$updates_founding = array(
		'unsubmitted'=>$member->fetchByRenewalStatus('UNSUBMITTED',array(Model\Member::$membership['FOUNDING MEMBER']),$offset, $limit)
		,'submitted'=>$member->fetchByRenewalStatus('SUBMITTED',array(Model\Member::$membership['FOUNDING MEMBER']),$offset, $limit)
		,'approved'=>$member->fetchByRenewalStatus('APPROVED',array(Model\Member::$membership['FOUNDING MEMBER']),$offset, $limit)
	);
	$updates_sustaining = array(
		'unsubmitted'=>$member->fetchByRenewalStatus('UNSUBMITTED',array(Model\Member::$membership['SUSTAINING MEMBER']),$offset, $limit)
		,'submitted'=>$member->fetchByRenewalStatus('SUBMITTED',array(Model\Member::$membership['SUSTAINING MEMBER']),$offset, $limit)
		,'approved'=>$member->fetchByRenewalStatus('APPROVED',array(Model\Member::$membership['SUSTAINING MEMBER']),$offset, $limit)
	);
	$donations = $member->fetchByRenewalDonations($offset, $limit);

	$crumbs = array(array('name'=>'Renewals','href'=>'/renewals'));
	$view_vars = array(
						 'active'=>'Applications/Renewal'
						,'page-plugin'=>'datatables'
						,'headline'=>'Renewals'
						,'description'=>"View all renewal applications here."
						,'crumbs'=>$crumbs
						,'donations'=>$donations
						,'renewals'=>$renewals
						,'updates_founding'=>$updates_founding
						,'updates_sustaining'=>$updates_sustaining
						);
	return $app['view']->render('application/index-renewals', 'default', $view_vars);
})
->value('offset','0')
->value('limit','20000')
->before($mustbeADMIN);


$app->get('/applications/activate/renewals/{activate}', function ($activate, Request $request) use ($app) {
	$member = new Model\Member($doc=array(), $app);
	
	if($activate == 'yes'){
		// prepare to remove trial members from the lists by updating them after the renewals run
		$application = new Model\Apply($doc=array(), $app);
		$trial = $application->fetchByStatus('TRIAL',0, 10000,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
		

		// find all the active members who aren't already active and create the renewal attribute
		$renewal = new Model\Renewal(array(),$app);
		$renewal->prepareInsert();
		$renewal = $renewal->__toArray();

		// get the count of the updates to occur  /// $type 10 means a null type value
		// actuall query db.member.find({$or:[{renewal:{$exists:false}},{renewal:{$exists:true,$type:10}},{renewal:{}}],status:2,currentMembership:10}).count();
		$common_query = array('$or'=>array(array('renewal'=>array('$exists'=>false)),array('renewal'=>array('$exists'=>true,'$type'=>10)),array('renewal'=>new \stdClass())));		
		//$common_query = array();

		$gm_query = array('currentMembership'=>Model\Member::$membership['GENERAL MEMBER'],'status'=>USER_STATUS_ACTIVE);
		$sm_query = array('currentMembership'=>Model\Member::$membership['SUSTAINING MEMBER'],'status'=>USER_STATUS_ACTIVE);
		$fm_query = array('currentMembership'=>Model\Member::$membership['FOUNDING MEMBER'],'status'=>USER_STATUS_ACTIVE);
		$pd_query = array('currentMembership'=>Model\Member::$membership['PUBLIC DEFENDER'],'status'=>USER_STATUS_ACTIVE);
		$gm_query = array_merge($common_query, $gm_query);
		$sm_query = array_merge($common_query, $sm_query);
		$fm_query = array_merge($common_query, $fm_query);
		$pd_query = array_merge($common_query, $pd_query);
		
		$gm_count = $member->count($gm_query);
		$sm_count = $member->count($sm_query);
		$fm_count = $member->count($fm_query);
		$pd_count = $member->count($pd_query);
		
		$gm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>$renewal)), $gm_query);
		$sm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>$renewal)), $sm_query);
		$fm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>$renewal)), $fm_query);
		$pd_update = $member->updateByCriteria(array('$set'=>array('renewal'=>$renewal)), $pd_query);

		$tr_count = 0;
		if(!empty($trial) && is_array($trial)){
			foreach ($trial as $record):
				$trial_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), array('_id'=>$record['memberId']));
				$tr_count++;
			endforeach;
		}

		// one-time - prepare the folks who paid 2015 with a promo code - their renewal needs to be marked paid automatically
		$application = new Model\Apply($doc=array(), $app);
		$ncdd2014promocode = $application->fetchByStatus('PAID',0, 10000,$filter=array('promocode'=>'NCDD2014'));
		$promo_count = 0;
		if(!empty($trial) && is_array($trial)){
			foreach ($ncdd2014promocode as $record):
				$doc['currentStatus'] = Model\Renewal::$status['PAID'];
				$doc['applicationId'] = new \MongoId($record['_id']);
				$doc['submittedDate'] = $record['submittedDate'];
				$doc['approvedDate']  = $record['approvedDate'];
				$doc['paidDate'] 	  = $record['paidDate'];
				$doc['paymentId'] 	  = $record['paymentId'];

				$renewal = new Model\Renewal($doc,$app);
				$renewal->prepareInsert();
				$renewal = $renewal->__toArray();

				$ncdd2014promocode_update = $member->updateByCriteria(array('$set'=>array('renewal'=>$renewal)), array('_id'=>$record['memberId']));

				$promo_count++;
			endforeach;
		}
		



		$label = 'Renewal Activation Successful.';
    	$message = $gm_count.' General Members were activated<br><br>'.$sm_count.' Sustaining Members were activated<br><br>'.$fm_count.' Founding Members were activated<br><br>'.$pd_count.' Public Defenders were activated<br><br>'.$tr_count.' Trial Members were ignored<br><br>'.$promo_count.' Promo Members were marked PAID<br><br>Note: only active members\' renewals were activated.  Non-active members who are activated during the renewal process will have to be manually activated.';
    	
	}elseif($activate == 'clear'){
		// clear all active members' renewal attribute
		$gm_query = array('currentMembership'=>Model\Member::$membership['GENERAL MEMBER']);
		$sm_query = array('currentMembership'=>Model\Member::$membership['SUSTAINING MEMBER']);
		$fm_query = array('currentMembership'=>Model\Member::$membership['FOUNDING MEMBER']);
		$pd_query = array('currentMembership'=>Model\Member::$membership['PUBLIC DEFENDER']);
		
		$gm_count = $member->count($gm_query);
		$sm_count = $member->count($sm_query);
		$fm_count = $member->count($fm_query);
		$pd_count = $member->count($pd_query);
		
		$gm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $gm_query);
		$sm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $sm_query);
		$fm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $fm_query);
		$pd_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $pd_query);

		$label = 'Renewal Clear Successful.';
    	$message = $gm_count.' General Members were cleared<br><br>'.$sm_count.' Sustaining Members were cleared<br><br>'.$fm_count.' Founding Members were cleared<br><br>'.$pd_count.' Public Defenders were cleared<br><br>Note: both active and non active members\' renewals were cleared.  Non-active members who are activated during the renewal process will have to be manually cleared.';
    	
	}

    return new Response(json_encode(array('message' => $message,'label'=>$label)),200,array('Content-Type' => 'application/json'));

})->value('acitvate','')
->before($mustbeADMIN);








/**
AUTOPAY
*/
//////////////////////////////////////
// auto-payment system for renewals //
//////////////////////////////////////
// this is called via xhr from the index-renewals.php view every 8 seconds 
// and processes 3 records each time
$app->get('/application/autopay', function (Request $request) use ($app) {
	$limit = 3;
	////////////////////////////////////////////////////////////////////////
	// get all the applications that must be paid and prepare the objects //
	////////////////////////////////////////////////////////////////////////
	$member = new Model\Member($doc=array(), $app);	
	$query = array('status'=>USER_STATUS_ACTIVE,
					'renewal.currentStatus'=>Model\Renewal::$status['APPROVED'],
					'renewal.payByCheck'=>array('$in'=>array('no','no-store','')),
					'currentMembership'=>array('$in'=>array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER'])));
	$approved_count = $member->count($query);

	$offset = $app['session']->get('autopay-offset');
	$offset = (empty($offset)) ? 0 : $offset;
	
	$approved = $member->fetchByRenewalStatusPaymentType('APPROVED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit);
	$approvedc = count($approved);
	$new_offset = ($offset+$limit > $approved_count) ? 0: $offset+$limit;
	$app['session']->set('autopay-offset',$new_offset);
	error_log(__FILE__.' '.__LINE__.' for variable: offset  ==>'.print_r($offset,true));
	error_log(__FILE__.' '.__LINE__.' for variable: limit  ==>'.print_r($limit,true));
	error_log(__FILE__.' '.__LINE__.' for variable: approvedc  ==>'.print_r($approvedc,true));
	error_log(__FILE__.' '.__LINE__.' for variable: approved_count  ==>'.print_r($approved_count,true));
	error_log(__FILE__.' '.__LINE__.' for variable: new_offset  ==>'.print_r($new_offset,true));
	$apps_paid = array();
	if(!empty($approved)):
	foreach($approved as $record):
		$apply = new Model\Apply($doc=array('_id'=>$record['renewal']['applicationId']), $app);
		$application = $apply->findById();
		
		$location = new Model\Location($doc=array('member'=>array('_id'=>$application['memberId'])), $app);
		$location = $location->getByMemberId();

		$member = new Model\Member($doc=array('_id'=>$application['memberId']), $app);
		$member = $member->findById();
		

		if(!empty($member)
			&& is_array($member)
			&& array_key_exists('payment',$member)
		    && !empty($member['payment'])
		    && is_array($member['payment'])
		    && array_key_exists('number',$member['payment'])
		    && !empty($member['payment']['number'])):

			/////////////////////////////////
			// prepare their correct total //
			/////////////////////////////////
			$pro_rate = array('q'=>0,'a'=>0);
			switch ($application['class']) {
				case 'NewMemberApplication': // old deprecated
				case 'ApplyNewMember':
				case 'ApplyNewSustainingMember':
					$pro_rate = $apply->proRate();
				    break;		
				case 'UpdateMember':
				case 'UpdateFoundingMember':
				case 'UpdateSustainingMember':
					$pro_rate = array('q'=>0,'a'=>0);
					break;
			}

			// EARLY BIRD DISCOUNT FOR 2014 -- is not over..
			$discount = 0;
			//*
			if($application['type'] == 'UPDATE MEMBER APPLICATION'
			    //&& strtotime($application['approvedDate']['iso']) < strtotime('December 31, 2014')
			    && array_key_exists('payment', $member) && array_key_exists('renewalREUSE', $member['payment']) && $member['payment']['renewalREUSE'] == 'yes'
			    && $application['membershipDues'] > 50
			): 
				$discount = 50;
			endif;
			//*/
			 // CREDIT DISCOUNT FOR MEMBERS WHO HOLD A CREDIT WITH US
			$discount2 = 0;
			if(array_key_exists('payment',$member) 
			      && !empty($member['payment'])
			      && is_array($member['payment'])
			      && array_key_exists('renewalCredit',$member['payment'])
			      && !empty($member['payment']['renewalCredit'])
			      && $member['payment']['renewalCredit'] > 0
			): 
			   $discount2  = $member['payment']['renewalCredit'];
			endif;
		                       
		    if($pro_rate['q'] > 1): 
		    	$amount = $pro_rate['a'];
		    else: 
		       $amount = $application['membershipDues'];
		    endif;
		    
		    $new_renewal_credit = null;
		    $amount = $amount-$discount-$discount2;
		    if($amount < 0 && !empty($discount2)){
		    	$new_renewal_credit = abs($amount);
		    }else if($amount > 0 && !empty($discount2)){
		    	$new_renewal_credit = '-';
		    }
		    $amount = ($amount <= 0) ? 0:$amount;
		    
		    ////////////////////////////////////////////////////////////////////////////////
			// activate a manual charge and create receipt - only if the declineCount = 0 //
			// if it's more than zero then the card must be updated 					  //
			////////////////////////////////////////////////////////////////////////////////

		    if(array_key_exists('payment', $member) && array_key_exists('declineCount', $member['payment']) && ($member['payment']['declineCount'] == 0 || empty($member['payment']['declineCount']))){
				$doc['memberId'] = $application['memberId'];
				$doc['ownerId'] = $application['_id'];
				$doc['ownerClass'] = $application['class'];
				$doc['description'] = 'INV-'.time();
				$doc['title'] = $application['type'];
				$doc['firstName'] = $application['firstName'];
				$doc['lastName'] = $application['lastName'];
				$doc['email'] = $application['email'];
				$doc['phone'] = (!empty($application['phone'])) ? $application['phone']: $location['phone'];
				$doc['addressLine1'] = (!empty($application['address1'])) ? $application['address1']: $member['payment']['addressLine1'];
				$doc['addressLine2'] = (!empty($application['address2'])) ? $application['address2']: $member['payment']['addressLine2'];
				$doc['city'] = (!empty($application['city'])) ? $application['city']: $member['payment']['city'];
				$doc['stateProvinceRegion'] = (!empty($application['state'])) ? $application['state']: $member['payment']['stateProvinceRegion'];
				$doc['zipPostalCode'] = (!empty($application['postalCode'])) ? $application['postalCode']: $member['payment']['zipPostalCode'];
				$doc['country'] = (!empty($application['country'])) ? $application['country']: $member['payment']['country'];
				$doc['amount'] = $amount;
				$doc['expMonth'] = $member['payment']['expMonth'];
				$doc['expYear'] = $member['payment']['expYear'];
				$doc['number'] = str_replace('.x', '', $member['payment']['number']);
				//$doc['number'] = $member['payment']['number'];
				$doc['cvc'] = str_replace('.x', '', $member['payment']['cvc']);
				$doc['name'] = $member['payment']['name'];
				// prepare the invoice
			   	$doc['invoiceBlock'] = $app['view']->element('invoice-block',array('application'=>$application,'member'=>$member,'location'=>$location,'pro_rated_membership_dues'=>$pro_rate));
				$payment = new Model\Payment($doc,$app);
				if($amount <= 0){
					$app['validateModel']($app, $payment,$groups=array('manual'));
					$paymentId = $payment->manualCharge();
					$tpaymnt = $member['payment'];
			    	$tpaymnt['declineCount'] = 0;
			    	if(!is_null($new_renewal_credit))
			    		$tpaymnt['renewalCredit'] = $new_renewal_credit;
			    	$tmem = new Model\Member(array('_id'=>$application['memberId'],'payment'=>$tpaymnt),$app);
			    	$tmem->saveSafe();
				}else{
					try {
						$app['validateModel']($app, $payment,$groups=array('cc'));	
					} catch (Exception $e) {
						error_log(__FILE__.' '.__LINE__.' for variable: payment  ==>'.print_r($payment,true));
						throw new \Saw\Exceptions\SawException(new \Saw\Exceptions\PaymentException(),$e->getMessage());
					}
					
					try {
						$paymentId = $payment->charge();	
						$tpaymnt = $member['payment'];
				    	$tpaymnt['declineCount'] = 0;
				    	if(!is_null($new_renewal_credit))
				    		$tpaymnt['renewalCredit'] = $new_renewal_credit;
				    	$tmem = new Model\Member(array('_id'=>$application['memberId'],'payment'=>$tpaymnt),$app);
				    	$tmem->saveSafe();
					} catch (Exception $e) {
						$tpaymnt = $member['payment'];
				    	$tpaymnt['declineCount'] = (array_key_exists('declineCount', $tpaymnt)) ? $tpaymnt['declineCount']+1: 1;
				    	$tmem = new Model\Member(array('_id'=>$application['memberId'],'payment'=>$tpaymnt),$app);
				    	$tmem->saveSafe();
						return new Response(json_encode(array('message'=>"appId:".$application['_id']." failed due to invalid card")), 400,array('Content-Type' => 'application/json'));
					}
					
				}

				///////////////////////////////
				// mark the application paid //
				///////////////////////////////
				switch ($application['class']) {
					case 'NewMemberApplication': // old deprecated
					case 'ApplyNewMember':
					case 'ApplyNewSustainingMember':
						$appl = new Model\Apply(array('_id'=>$application['_id'], 'paymentId'=>$paymentId), $app);
					    break;		
					case 'UpdateMember':
						$appl = new Model\UpdateMember(array('_id'=>$application['_id'], 'paymentId'=>$paymentId,'memberId'=>$application['memberId']), $app);
						break;
					case 'UpdateFoundingMember':
						$appl = new Model\UpdateFoundingMember(array('_id'=>$application['_id'], 'paymentId'=>$paymentId,'memberId'=>$application['memberId']), $app);
						break;
					case 'UpdateSustainingMember':
						$appl = new Model\UpdateSustainingMember(array('_id'=>$application['_id'], 'paymentId'=>$paymentId,'memberId'=>$application['memberId']), $app);
						break;
				}
			   	$appl->markPaid(false);


				// return the application id to the xhr
				$apps_paid[] = $application['_id'];
			}// endif delineCount == 0
		endif;
	endforeach;
	endif;

	return new Response(json_encode(array('apps_paid'=>$apps_paid,'new_offset'=>$new_offset,'message'=>"success")), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);



return $app;