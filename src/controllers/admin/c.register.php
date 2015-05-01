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


$app['seminarConfirmationEmail'] = $app->protect(function ($app,$registrationId) {

	$registration = new Model\Registration(array('_id'=>$registrationId), $app);
	$registration = $registration->findById($id='_id', $slaveOkay=false);
	$seminar = new Model\Seminar(array('_id'=>$registration['seminarId']),$app);
	$seminar = $seminar->findById();
	$seminar['description'] = $app['prepare_content']($seminar['description']);
    // email welcome message
	$subject = 'NCDD Seminar Registration Details';
	$to = $registration['email'];
	$view_vars = array('seminar'=>$seminar
						,'registration'=>$registration
	);
	$body = $app['view']->render('email/registration-seminar-customer-confirmation','email', $view_vars);
	$body = str_replace("#total#", '$'.$registration['total'], $body);

	if($registration['currentStatus'] == Model\Registration::$status['DEPOSIT'] || $registration['currentStatus'] == Model\Registration::$status['DEPOSITBALANCE']){
		$body = str_replace("#balance_due#", '$'.((int)$registration['registrationFeeOriginal'] - (int)$registration['deposit']), $body);
		$body = str_replace("#balance_due_date#", $registration['depositDueDate'], $body);
		$body = str_replace("#payment_link#", '<a href="https://'.SAW_ADMIN_WEBSITE.'/registration/seminar/deposit/'.$registrationId.'">https://'.SAW_ADMIN_WEBSITE.'/registration/seminar/deposit/'.$registrationId.'</a>', $body);
	}
	
	$user = $app['session']->get('user');
    if(is_array($user) && array_key_exists('accessLevel', $user) && ($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes'){
		// don't send the email		
	}else{
		$app['sendMail']($subject, $body, $to);
	}

});
////////////////////////////
// DEPOSIT BLANCE PAYMENT //
////////////////////////////
$app->get('/registration/seminar/deposit/{registrationId}', function ($registrationId, Request $request) use ($app) {
	
	$registration = new Model\Registration($doc=array('_id'=>$registrationId), $app);
	$registration = $registration->findById();
	
	$seminar = new Model\Seminar(array('_id'=>$registration['seminarId']),$app);
	$seminar = $seminar->findById();

	
	// attempt to determine if the user is logged in
	// admin will always return an empty set here because 
	// his id is not stored in the database
	$member = Model\User::getUserBySession($app,'member');
	if(!empty($member)){
		$location = new Model\Location(array('ownerId'=>$member['_id']),$app);
		$location = $location->findById('ownerId');
	}else{
		$location = '';
	}

	$view_vars = array('seminar'=>$seminar,
						'member'=>$member,
						'location'=>$location,
						'registration'=>$registration,
						'layout_title'=>'Registration for '.$seminar['headline']
	);
	return $app['view']->render('registration/seminar-deposit-balance', 'blank',$view_vars);
})->value('registrationId','');
$app->post('/registration/seminar/deposit', function (Request $request) use ($app) {
	// retrieve document from request
	$doc = $request->get('doc'); 

	$registration = new Model\Registration(array('_id'=>$doc['registrationId']), $app);
	$registration = $registration->findById();
	
	//*
	$payment = new Model\Payment($doc['payment'],$app);
	$app['validateModel']($app, $payment,$groups=array('cc'));
	$paymentId = $payment->charge();
	
	//*/
	return new Response(json_encode(array(
		'paymentId'=>$paymentId,
		'registrationId'=>$registration['_id'],
		'label'=>'Successful Seminar Deposit Balance Payment',
		'message'=>"Thank you, your deposit balance payment was recieved successfully.  You will receive a receipt in the email address you provided.")), 200,array('Content-Type' => 'registration/json')
	);

});
///////////////////////
// PAYMENT FUNCTIONS //
///////////////////////
$app->get('/registration/seminar/{id}/pay-other', function ($id, Request $request) use ($app) {
	
	$registration = new Model\Registration($doc=array('_id'=>$id), $app);
	$registration = $registration->findById();
	
	$seminar = new Model\Seminar(array('_id'=>$registration['seminarId']),$app);
	$seminar = $seminar->findById();

	$crumbs = array(array('name'=>'Registrations','href'=>'/registrations/seminar/'.$seminar['_id'])
					,array('name'=>$registration['name'],'href'=>'/registration/'.$id.'/view')
					,array('name'=>$registration['type'],'href'=>'/registration/'.$id.'/view')
					,array('name'=>'Submit Another Form of Payment ','href'=>'/registration/'.$id.'/pay')
					);
	$view_vars = array(
						 'active'=>'Registration'
						,'page-plugin'=>'datatables,invoice'
						,'headline'=>'Seminar Registration Payment'
						,'description'=>"Pay seminar registration."
						,'crumbs'=>$crumbs
						,'registration'=>$registration
						,'seminar'=>$seminar
						);
	return $app['view']->render('registration/seminar-pay-other', 'default', $view_vars);
})->value('id','')
->before($mustbeADMIN);
$app->get('/registration/seminar/{id}/pay', function ($id, Request $request) use ($app) {
	
	$registration = new Model\Registration($doc=array('_id'=>$id), $app);
	$registration = $registration->findById();
	
	$seminar = new Model\Seminar(array('_id'=>$registration['seminarId']),$app);
	$seminar = $seminar->findById();

	$crumbs = array(array('name'=>'Registrations','href'=>'/registrations/seminar/'.$seminar['_id'])
					,array('name'=>$registration['name'],'href'=>'/registration/'.$id.'/view')
					,array('name'=>$registration['type'],'href'=>'/registration/'.$id.'/view')
					,array('name'=>'Submit Another Form of Payment ','href'=>'/registration/'.$id.'/pay')
					);
	$view_vars = array(
						 'active'=>'Registration'
						,'page-plugin'=>'datatables,invoice'
						,'headline'=>'Seminar Registration Payment'
						,'description'=>"Pay seminar registration."
						,'crumbs'=>$crumbs
						,'registration'=>$registration
						,'seminar'=>$seminar
						);
	return $app['view']->render('registration/seminar-pay', 'default', $view_vars);
})->value('id','');

// this is posted to by the registrations/pay-other.php view
// mark the registration paid and create a payment record, which is the receipt
$app->post('/registration/payment', function (Request $request) use ($app) {
	// retrieve document from request
	$doc = $request->get('doc');

	// get and set the suppress email check
	$user = $app['session']->get('user');
	$user['suppress_emails'] = $request->get('suppress_emails');
	$user = $app['session']->set('user',$user);
	
	$payment = new Model\Payment($doc,$app);
	$app['validateModel']($app, $payment,$groups=array('manual'));
	$paymentId = $payment->manualCharge();

	if (!empty($doc['donationamount']) && is_numeric($doc['donationamount'])) {
		
		$doc['title'] = $doc['title'].' - DONATION';
		$doc['amount'] = $doc['donationamount'];

		$payment = new Model\Payment($doc,$app);
		$paymentId = $payment->manualCharge();
		// update contribution payment id on the registration record
		$registration = new Model\Registration($doc=array('_id'=>$doc['ownerId'],'contributionPaymentId'=>$paymentId), $app);
		
	}
	
	/*
	// thank you receipt message
	$subject = 'NCDD Payment Received';
	$to = $payment->email;
	$view_vars = array('payment'=>$payment->__toArray()
						,'paymentId'=>$paymentId
						,'email'=>$payment->email
	);
	$body = $app['view']->render('email/payment-thankyou','email', $view_vars);
		
	$app['sendMail']($subject, $body, $to);
	//*/
	return new Response(json_encode(array('paymentId'=>$paymentId,'message'=>"success")), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);

// both credit card and pay by check XHR call this route to mark the registration as paid.
// resetSession is passed in when the member is using the credit card payment screen and not used when the admin 
// is making a payment on behalf of the member using the same credit card screen
$app->get('/registration/{paymentId}/pay/{registrationId}', function ($paymentId, $registrationId, Request $request) use ($app) {
    
    $registration = new Model\RegistrationSeminar(array('_id'=>$registrationId), $app);
    $registration->markPaid($paymentId);
 	
    return new Response(json_encode(array('message' => 'Paid successfully')), 200,array('Content-Type' => 'application/json'));
});

/**
//////////////////////////////
// NEW SEMINAR REGISTRATION //
//////////////////////////////
*/
$app->get('/registration/seminar/{seminarId}/{slug}', function ($seminarId, $slug, Request $request) use ($app) {
	
	// attempt to determine if the user is logged in
	// admin will always return an empty set here because 
	// his id is not stored in the database
	$member = Model\User::getUserBySession($app,'member');
	if(!empty($member)){
		$location = new Model\Location(array('ownerId'=>$member['_id']),$app);
		$location = $location->findById('ownerId');

		// determine if the member, who is signed in, has already made a deposit to this seminar and is coming back to do a balance payment
		$registration = new Model\RegistrationSeminar($doc=array(), $app);
		$depositbalance = $registration->fetchDepositStatus($seminarId,0, 10000);
		if(!empty($depositbalance) && is_array($depositbalance)){
			foreach ($depositbalance as $record) {
				if($record['memberId'] == $member['_id']){
					return $app->redirect('/registration/seminar/deposit/'.$record['_id']);		
				}
			}
		}
		
		
	}else{
		$location = '';
	}

	$seminar = new Model\Seminar(array('_id'=>$seminarId),$app);
	$seminar = $seminar->findById();
	$registration = new Model\RegistrationSeminar($doc=array(), $app);
	$depositbalance = $registration->fetchDepositStatus($seminarId,$offset=0, $limit=10000);
	$paid = $registration->fetchByStatusSeminar($seminarId,'PAID',$offset=0, $limit=10000);
	
	$paid = (!empty($paid)) ? count($paid) : 0;
    $deposit = (!empty($depositbalance)) ? count($depositbalance) : 0;
    $total = $paid + $deposit;
    if(array_key_exists('maxRegistrations', $seminar['register']) 
       && !empty($seminar['register']['maxRegistrations']) 
       && $seminar['register']['maxRegistrations'] == $total):
    	$activate_waitlist = true;
    else:
    	$activate_waitlist = false;
    endif;

	$view_vars = array('seminar'=>$seminar
						,'member'=>$member
						,'location'=>$location
						,'layout_title'=>'Registration for '.$seminar['headline']
						,'activate_waitlist'=>$activate_waitlist
	);
	// attempt to get the promo querystring variable
	$view_vars['nlpro'] = $request->get('nlpro');

	return $app['view']->render('registration/seminar', 'blank',$view_vars);
});
/**
POST NEW REGISTRATION
*/
$app->post('/registration/seminar', function (Request $request) use ($app) {
	// retrieve document from request
	$doc = $request->get('doc'); 
	$doc['userAgent'] = $request->headers->get('User-Agent');
	// get and set the suppress email check
	$user = $app['session']->get('user');
	$user['suppress_emails'] = $request->get('suppress_emails');
	$app['session']->set('user',$user);


	///////////////
	// wait list //
	///////////////
	$seminar = new Model\Seminar(array('_id'=>$doc['seminarId']),$app);
	$seminar = $seminar->findById();
	$registration = new Model\RegistrationSeminar(array(), $app);
	$depositbalance = $registration->fetchDepositStatus($doc['seminarId'],$offset=0, $limit=10000);
	$paid = $registration->fetchByStatusSeminar($doc['seminarId'],'PAID',$offset=0, $limit=10000);
	
	$paid = (!empty($paid)) ? count($paid) : 0;
    $deposit = (!empty($depositbalance)) ? count($depositbalance) : 0;
    $total = $paid + $deposit;
    if(array_key_exists('maxRegistrations', $seminar['register']) 
       && !empty($seminar['register']['maxRegistrations']) 
       && $seminar['register']['maxRegistrations'] == $total){
    	$activate_waitlist = true;
    	$_POST['activate_waitlist'] = true;

    	// need to validate the credit card information to be sure it's not blank
    	if(empty($doc['payment']['number']) || empty($doc['payment']['cvc'])){
	    	$response_arr = array('message'=>"Please fill out the credit card information to secure your spot on the wait list.");
	    	$response_arr['invalidFields'] = array();
	    	if(empty($doc['payment']['number'])){
	    		$response_arr['invalidFields'][] = array('name'=>'number','message'=>'Credit card number is required.');
	    	}
	        if(empty($doc['payment']['cvc'])){
	    		$response_arr['invalidFields'][] = array('name'=>'cvc','message'=>'Credit card security code is required.');
	    	}
	        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json')); 
	    }

    }else{
    	$activate_waitlist = false;
	    $_POST['activate_waitlist'] = false;
    }


    if($activate_waitlist == false):

		$registrationFee = $doc['registrationFee'];
		$hardCopy = (array_key_exists('hardCopy',$doc)) ? $doc['hardCopy'] : '';
		$hardCopyFee = (array_key_exists('hardCopyFee',$doc)) ? $doc['hardCopyFee'] : '';
		if($hardCopy == 'NO'){
			$hardCopyFee = 0;
		}
		$depositQuestion = (array_key_exists('depositQuestion',$doc)) ? $doc['depositQuestion'] : '';
		if($depositQuestion == 'yes'){
			$registrationFee = $doc['deposit'];
		}

		$doc['total'] = (int)$hardCopyFee+(int)$registrationFee;
		$paymentId = new \stdClass();

		$rs = new Model\RegistrationSeminar($doc,$app);
		if(!empty($doc['email']) && $rs->findByEmail()){
	    	$response_arr = array('message'=>"Our records indicate you have already submitted a registration.  If you believe this message is in error please contact NCDD directly.",
	                              "invalidFields"=>array(array('name'=>'email','message'=>'Our records indicate you have already submitted a registration.  If you believe this message is in error please contact NCDD directly.')));
	        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json')); 
	    }

		$app['validateModel']($app, $rs);
		$rs_id = '';


		if ($doc['currentPaymentType'] == Model\Registration::$paymentType['CREDIT']) {
				$doc['payment']['ownerId'] = '';
				$doc['payment']['ownerClass'] = 'RegistrationSeminar';
				$payment = new Model\Payment($doc['payment'],$app);
				$app['validateModel']($app, $payment,$groups=array('cc'));
			try {
				$paymentId = $payment->charge();
				$rs_id = $rs->insert();
				$payment_update = new Model\Payment(array('ownerId'=>$rs_id,'_id'=>$paymentId),$app);
				$payment_update->saveSafe();
			} catch (Exception $e) {
				error_log(__FILE__.' '.__LINE__.' for variable: e  ==>'.print_r($e->getMessage(),true));
				//$rgis = new Model\Registration(array('_id'=>$rs_id),$app);			
				//$rgis->remove();
				throw new \Saw\Exceptions\SawException(new \Saw\Exceptions\PaymentException(),"The transaction failed.  Please check your card information and try again.");
			}		
			
		}
		if ($doc['currentPaymentType'] == Model\Registration::$paymentType['CHECK']) {
			$doc['payment']['ownerId'] = '';
			$doc['payment']['ownerClass'] = 'RegistrationSeminar';

			try {
				$rs_id = $rs->insert();
				//*
		    	// send registrant the email notification only if pay by check has been selected.
	    		$app['seminarConfirmationEmail']($app,$rs_id);
				//*/
			} catch (Exception $e) {
				error_log(__FILE__.' '.__LINE__.' for variable: e  ==>'.print_r($e->getMessage(),true));
				//$rgis = new Model\Registration(array('_id'=>$rs_id),$app);			
				//$rgis->remove();
				throw new \Saw\Exceptions\SawException(new \Saw\Exceptions\PaymentException(),"The transaction failed.  Please check your card information and try again.");
			}		
			
		}
		if ($doc['currentPaymentType'] == Model\Registration::$paymentType['SCHOLARSHIP']) {
			$doc['payment']['ownerId'] = '';
			$doc['payment']['ownerClass'] = 'RegistrationSeminar';

			// add the registration fields
			$doc['scholarship']['for'] = $seminar['headline'];
			$doc['scholarship']['barNumber'] = $doc['barNumber'];
			$doc['scholarship']['name'] = $doc['name'];
			$doc['scholarship']['phone'] = $doc['phone'];
			$doc['scholarship']['fax'] = $doc['fax'];
			$doc['scholarship']['email'] = $doc['email'];
			$doc['scholarship']['address1'] = $doc['address1'];
			$doc['scholarship']['address2'] = $doc['address2'];
			$doc['scholarship']['city'] = $doc['city'];
			$doc['scholarship']['state'] = $doc['state'];
			$doc['scholarship']['postalCode'] = $doc['postalCode'];
			$doc['scholarship']['country'] = $doc['country'];
		    $scholarship = new Model\Scholarship($doc['scholarship'], $app);
		    // validate the scholarship model
		    $app['validateModel']($app,$scholarship);

		    $doc['currentStatus'] = Model\Registration::$status['SCHOLARSHIP'];
		    $doc['total'] = 0;
		    $rs = new Model\RegistrationSeminar($doc,$app);
			try {
				$rs->scholarshipId = $scholarship->insert();
				$rs_id = $rs->insert();

			    if(is_array($user) && array_key_exists('accessLevel', $user) && ($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes'){
					// don't send the email
				}else{
					$app['seminarConfirmationEmail']($app,$rs_id);
				}
			
			} catch (Exception $e) {
				error_log(__FILE__.' '.__LINE__.' for variable: e  ==>'.print_r($e->getMessage(),true));
				//$rgis = new Model\Registration(array('_id'=>$rs_id),$app);			
				//$rgis->remove();
				throw new \Saw\Exceptions\SawException(new \Saw\Exceptions\PaymentException(),"The transaction failed.  Please check your card information and try again.");
			}		
			
		}
		
		//*/
		return new Response(json_encode(array(
			'paymentId'=>$paymentId,
			'registrationId'=>$rs_id,
			'label'=>'Successful Registration',
			'message'=>"Thank you, your Registration is complete.  You will receive a confirmation and receipt in the email address you provided.")), 200,array('Content-Type' => 'registration/json')
		);
	


	else:

		$doc['currentStatus'] = Model\Registration::$status['WAITLIST'];
		$doc['tempPayment'] = $doc['payment'];
		unset($doc['payment']);
		$rs = new Model\RegistrationSeminar($doc,$app);
		
		if(!empty($doc['email']) && $rs->findByEmail()){
	    	$response_arr = array('message'=>"Our records indicate you have already submitted a registration.  If you believe this message is in error please contact NCDD directly.",
	                              "invalidFields"=>array(array('name'=>'email','message'=>'Our records indicate you have already submitted a registration.  If you believe this message is in error please contact NCDD directly.')));
	        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
	    }
		$app['validateModel']($app, $rs);
		
		$rs_id = $rs->insert();

		return new Response(json_encode(array(
			'paymentId'=>'',
			'registrationId'=>$rs_id,
			'label'=>'Successful Registration',
			'message'=>"Thank you, your request to be added to the waitlist is complete.  You will be notified if a space becomes available.")), 200,array('Content-Type' => 'registration/json')
		);
	


	endif; // activate wait list end

})->after(function (Request $request, Response $response, Silex\Application $app) {
		
	if($_POST['activate_waitlist'] == false):
		//*
		if((int)$response->getStatusCode() == 200):
	    	$doc = $request->get('doc');

	    	// get the seminar information
	    	$seminar = new Model\Seminar(array('_id'=>$doc['seminarId']),$app);
	    	$seminar = $seminar->findById();
	    	$seminar['description'] = $app['prepare_content']($seminar['description']);

	    	// calculate the total and what is in the line item.
	    	$doc['registrationFee_orig'] = $doc['registrationFee'];
	    	$hardCopy = (array_key_exists('hardCopy',$doc)) ? $doc['hardCopy'] : '';
			$hardCopyFee = (array_key_exists('hardCopyFee',$doc)) ? $doc['hardCopyFee'] : '';
	    	if($hardCopy == 'NO'){
				$hardCopyFee = 0;
			}
			$depositQuestion = (array_key_exists('depositQuestion',$doc)) ? $doc['depositQuestion'] : '';
			if($depositQuestion == 'yes'){
				$doc['registrationFee'] = $doc['deposit'];
			}
			$doc['total'] = (int)$hardCopyFee+(int)$doc['registrationFee'];
			
			if(array_key_exists('registrationNumber', $doc) && Model\Scholarship::checkRegNum((int)$doc['registrationNumber'],$app)){
				$doc['total'] = 0;
				$doc['total_reason'] = "Scholarship Awarded";
			}

			// need the rsvp text
			$rsvp = (!empty($doc['rsvp'])) ? $doc['rsvp']:'';

			// need the payment type and details
			$paymentType = ($doc['currentPaymentType'] == Model\Registration::$paymentType['CREDIT']) ? 'credit' : 'check' ;
			$cardType = ($doc['currentPaymentType'] == Model\Registration::$paymentType['CREDIT']) ? $doc['payment']['cardType'] : '' ;
			$cardNumber = ($doc['currentPaymentType'] == Model\Registration::$paymentType['CREDIT']) ? $doc['payment']['number'] : '' ;

	    	// send admin the email notification
	    	$subject = 'Seminar Registration Submitted';
	    	$to = SAW_ADMIN_EMAIL;
	    	$view_vars = array('seminar'=>$seminar
	    						,'rsvp'=>$rsvp
	    						,'total'=>$doc['total']
	    						,'total_reason'=>(array_key_exists('total_reason', $doc)) ? $doc['total_reason']:'' 
	    						,'hardCopy'=>$hardCopy
	    						,'hardCopyFee'=>$hardCopyFee
	    						,'registrationFee'=>$doc['registrationFee']
	    						,'registrantName'=>$doc['name']
	    						,'paymentType'=>$paymentType
	    						,'cardType'=>$cardType
	    						,'cardNumber'=>$cardNumber
	    	);
	    	$body = $app['view']->render('email/registration-seminar-admin','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);

	    endif;
	    //*/
	endif; // activate wait list
});



/////////////////////////////
// GENERAL ADMIN FUNCTIONS //
/////////////////////////////

$app->get('/registration/{id}/view', function ($id, Request $request) use ($app) {
	
	$registration = new Model\Registration($doc=array('_id'=>$id), $app);
	$reg_arry = $registration->findById();
	
	$seminar = new Model\Seminar(array('_id'=>$reg_arry['seminarId']),$app);
	$seminar = $seminar->findById();

	/////////////////
	// scholarship //
	/////////////////
	if(array_key_exists('scholarshipId',$reg_arry) && !empty($reg_arry['scholarshipId'])){
		$scholarship = new Model\Scholarship(array('_id'=>$reg_arry['scholarshipId']),$app);
		$reg_arry['scholarship'] = $scholarship->findById();
	}
	///////////////
	// wait list //
	///////////////
	if($reg_arry['currentStatus'] == Model\Registration::$status['WAITLIST']):
    	$activate_waitlist = true;
    else:
    	$activate_waitlist = false;
    endif;



	$crumbs = array(array('name'=>'Registrations','href'=>'/registrations/seminar/'.$seminar['_id'])
					,array('name'=>$reg_arry['name'],'href'=>'/registration/'.$id.'/view')
					,array('name'=>$reg_arry['type'],'href'=>'/registration/'.$id.'/view')
					);
	$view_vars = array(
						 'active'=>'Seminar'
						,'page-plugin'=>'datatables'
						,'headline'=>'Registrations'
						,'description'=>"View all registration here."
						,'crumbs'=>$crumbs
						,'registration'=>$reg_arry
						,'seminar'=>$seminar
						,'activate_waitlist'=>$activate_waitlist
						);
	switch ($reg_arry['class']) {
		case 'RegistrationSeminar':
			return $app['view']->render('registration/seminar-view', 'default', $view_vars);		
			break;
		default:
			$msg = new \stdClass();
			$msg->message = 'This Registration cannot be found.';
			$msg->resolveMessage = 'Please go back and try again or contact the Administrator if this problem persists.';
			return $app['view']->render('errors/404','error', array('error'=>$msg));
			break;
	}
	
})->value('id','')
->before($mustbeADMIN);

$app->get('/registration/{id}/edit', function ($id, Request $request) use ($app) {
	
	$registration = new Model\Registration($doc=array('_id'=>$id), $app);
	$registration = $registration->findById();
	$seminar = new Model\Seminar(array('_id'=>$registration['seminarId']),$app);
	$seminar = $seminar->findById();
	/////////////////
	// scholarship //
	/////////////////
	if(array_key_exists('scholarshipId',$registration) && !empty($registration['scholarshipId'])){
		$scholarship = new Model\Scholarship(array('_id'=>$registration['scholarshipId']),$app);
		$registration['scholarship'] = $scholarship->findById();
	}

	$crumbs = array(array('name'=>'Registrations','href'=>'/registrations/seminar/'.$seminar['_id'])
					,array('name'=>$registration['name'],'href'=>'/registration/'.$id.'/view')
					,array('name'=>$registration['type'],'href'=>'/registration/'.$id.'/view')
					,array('name'=>'Edit','href'=>'/registration/'.$id.'/edit')
					);
	$view_vars = array(
						 'active'=>'Seminar'
						,'page-plugin'=>'datatables'
						,'headline'=>'Registrations'
						,'description'=>"Edit Registration."
						,'crumbs'=>$crumbs
						,'registration'=>$registration
						,'seminar'=>$seminar
						);
	switch ($registration['class']) {
		case 'RegistrationSeminar':
			return $app['view']->render('registration/seminar-edit', 'default', $view_vars);		
			break;
		
	}
	
})->value('id','')
->before($mustbeADMIN);

$app->post('/registration/edit', function (Request $request) use ($app) {

	// retrieve document from request
    $doc = $request->get('doc');

	switch ($doc['class']) {
		case 'RegistrationSeminar':
			$registration = new Model\RegistrationSeminar($doc, $app);
		    break;
	}
	
	// validate the model
	$app['validateModel']($app,$registration);
	$registration->saveEdit();	
    

	// add the registration fields
	$doc['scholarship']['barNumber'] = $doc['barNumber'];
	$doc['scholarship']['name'] = $doc['name'];
	$doc['scholarship']['phone'] = $doc['phone'];
	$doc['scholarship']['fax'] = $doc['fax'];
	$doc['scholarship']['email'] = $doc['email'];
	$doc['scholarship']['address1'] = $doc['address1'];
	$doc['scholarship']['address2'] = $doc['address2'];
	$doc['scholarship']['city'] = $doc['city'];
	$doc['scholarship']['state'] = $doc['state'];
	$doc['scholarship']['postalCode'] = $doc['postalCode'];
	$doc['scholarship']['country'] = $doc['country'];
	
	$registration = $registration->findById();
	if(array_key_exists('scholarshipId', $registration) && !empty($registration['scholarshipId'])){
	    $scholarship = new Model\Scholarship($doc['scholarship'], $app);
	    $app['validateModel']($app,$scholarship);
	    $scholarship->saveEdit();
	}

    $label = 'Registration Saved';
    $message = 'Registration Successfully Saved.';
    $response_status = 200;
    
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'registration/json'));

})->before($mustbeADMIN);

$app->post('/registration/markpaid', function (Request $request) use ($app) {

	// retrieve document from request
    $doc = $request->get('doc');
    $endTrial = $request->get('endTrial');
    $startTrial = $request->get('startTrial');
    
	switch ($doc['class']) {
		case 'RegistrationSeminar':
			$registration = new Model\RegistrationSeminar($doc, $app);
		    break;
	}
	if(!empty($endTrial)){
		$appArr = $registration->findOne($query=array('_id'=>new \MongoId($doc['_id'])),$fields=array('trial'=>true));
		$newEndDate = new Model\Date($app,$endTrial, $appArr['trial']['timeZone']);
		$newStartDate = new Model\Date($app,$startTrial, $appArr['trial']['timeZone']);
		
		$appArr['trial']['startDate'] = $newStartDate;
		$appArr['trial']['endDate'] = $newEndDate;
		$new_trial = new Model\Trial($appArr['trial'],$app);
		$app['validateModel']($app,$new_trial);

		$registration->trial = $new_trial->__toArray();
		$registration->trial['endDate'] = $newEndDate;
		$registration->trial['startDate'] = $newStartDate;
	}
	
	// validate the model
	$app['validateModel']($app,$registration);
	
	$registration_id = $registration->checkEmailExists();
	if(!empty($registration_id) && $registration_id != $registration->_id){
    	$label = 'Warning:';
    	$message = "The email address you're trying to update is already in use on another registration.  Please use a different email and try again.";
    	$response_status = 400;
    }else{
    	$member = $registration->saveEdit();	
    	$label = 'Registration Saved';
    	$message = 'Registration Successfully Saved.';
    	$response_status = 200;
    }
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'registration/json'));

})->before($mustbeADMIN);

$app->get('/registration/{id}/delete', function ($id, Request $request) use ($app) {
    $registration = new Model\Registration(array('_id'=>$id), $app);
    $registration->remove();
    return new Response(json_encode(array('message' => 'Successfully Deleted')), 200,array('Content-Type' => 'registration/json'));
})->before($mustbeADMIN);

$app->get('/registrations/seminar/{seminarId}/{offset}/{limit}', function ($seminarId, $offset, $limit, Request $request) use ($app) {
	$seminar = new Model\Seminar($doc=array('_id'=>$seminarId), $app);
	$seminar = $seminar->findById();
	$registration = new Model\RegistrationSeminar($doc=array(), $app);
	$submitted = $registration->fetchByStatusSeminar($seminarId,'SUBMITTED',$offset, $limit);
	$scholarship = $registration->fetchByStatusSeminar($seminarId,'SCHOLARSHIP',$offset, $limit);
	$scholarships_toapprove = array();
	$scholarships_approved = array();
	for ($i=0; $i < count($scholarship); $i++) { 
		if(is_array($scholarship)){
			if(array_key_exists('scholarshipId',$scholarship[$i]) && !empty($scholarship[$i]['scholarshipId'])){
				$s = new Model\Scholarship(array('_id'=>$scholarship[$i]['scholarshipId']),$app);
				$s = $s->findById();
				if($s['currentStatus'] == Model\Scholarship::$status['SUBMITTED']){
					$scholarships_toapprove[] = $scholarship[$i];
				}elseif($s['currentStatus'] == Model\Scholarship::$status['APPROVED']){
					$scholarships_approved[] = $scholarship[$i];
				}
			}else{
				$scholarships_approved[] = $scholarship[$i];
			}
		}
	}
	
	//$deposit = $registration->fetchByStatusSeminar($seminarId,'DEPOSIT',$offset, $limit);
	$depositbalance = $registration->fetchDepositStatus($seminarId,$offset, $limit);
	$paid = $registration->fetchByStatusSeminar($seminarId,'PAID',$offset, $limit);
	$waitlist = $registration->fetchByStatusSeminar($seminarId,'WAITLIST',$offset, $limit);
	$crumbs = array(array('name'=>'Seminars','href'=>'/seminar')
					,array('name'=>$seminar['headline'],'href'=>'/seminar/view/'.$seminar['_id'])
					,array('name'=>'Registrations','href'=>'/registrations/seminar/'.$seminar['_id']));
	$view_vars = array(
						 'active'=>'Seminar'
						,'page-plugin'=>'datatables'
						,'headline'=>'Registrations for - '.$seminar['headline']
						,'description'=>''
						,'crumbs'=>$crumbs
						,'submitted'=>$submitted
						//,'deposit'=>$deposit
						,'depositbalance'=>$depositbalance
						,'scholarship'=>$scholarship
						,'scholarships_toapprove'=>$scholarships_toapprove
						,'scholarships_approved'=>$scholarships_approved
						,'paid'=>$paid
						,'waitlist'=>$waitlist
						,'seminar'=>$seminar
						);
	return $app['view']->render('registration/seminar-index', 'default', $view_vars);
})
->value('offset','0')
->value('limit','100')
->before($mustbeADMIN);

$app->get('/registrations/offwaitlist/{registrationId}', function ($registrationId, Request $request) use ($app) {
    
    $registration = new Model\RegistrationSeminar(array('_id'=>$registrationId), $app);
    $seminar_id = $registration->moveWaitList('off');
 	
    return $app->redirect('/registrations/seminar/'.$seminar_id);
});
$app->get('/registrations/onwaitlist/{registrationId}', function ($registrationId, Request $request) use ($app) {
    
    $registration = new Model\RegistrationSeminar(array('_id'=>$registrationId), $app);
    $seminar_id = $registration->moveWaitList('on');
 	
    return $app->redirect('/registrations/seminar/'.$seminar_id);
 	
    return new Response(json_encode(array('message' => 'Moved successfully')), 200,array('Content-Type' => 'application/json'));
});


return $app;