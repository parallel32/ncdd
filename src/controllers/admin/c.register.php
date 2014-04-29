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
	$subject = 'NCDD Seminar Confirmation';
	$to = $registration['email'];
	$view_vars = array('seminar'=>$seminar
						,'registration'=>$registration
	);
	$body = $app['view']->render('email/registration-seminar-customer-confirmation','email', $view_vars);
	$body = str_replace("#total#", '$'.$registration['total'], $body);

	if($registration['currentStatus'] == Model\Registration::$status['DEPOSIT'] || $registration['currentStatus'] == Model\Registration::$status['DEPOSITBALANCE']){
		$body = str_replace("#balance_due#", '$'.((int)$registration['registrationFeeOriginal'] - (int)$registration['deposit']), $body);
		$body = str_replace("#balance_due_date#", $registration['depositDueDate'], $body);
		$body = str_replace("#payment_link#", 'https://'.SAW_ADMIN_WEBSITE.'/registration/seminar/deposit/'.$registrationId, $body);
	}
	
	$app['sendMail']($subject, $body, $to);

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
	$payment = new Model\Payment($doc,$app);
	$app['validateModel']($app, $payment,$groups=array('manual'));
	$paymentId = $payment->manualCharge();

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
    
    $registration = new Model\Registration(array('_id'=>$registrationId, 'paymentId'=>$paymentId), $app);
    //$app['seminarConfirmationEmail']($app,$registrationId);
    $registration->markPaid();
    
    $payment = new Model\Payment(array('_id'=>$paymentId),$app);
	$payment->findById();

	// thank you receipt message
	$subject = 'NCDD Payment Received';
	$to = $payment->email;
	$view_vars = array('payment'=>$payment->__toArray()
						,'paymentId'=>$paymentId
						,'email'=>$payment->email
	);
	$body = $app['view']->render('email/payment-thankyou','email', $view_vars);
		
	$app['sendMail']($subject, $body, $to);

    return new Response(json_encode(array('message' => 'Paid successfully')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeMEMBER);


//////////////////////////////
// NEW SEMINAR REGISTRATION //
//////////////////////////////
$app->get('/registration/seminar/{seminarId}/{slug}', function ($seminarId, $slug, Request $request) use ($app) {

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

	$seminar = new Model\Seminar(array('_id'=>$seminarId),$app);
	$seminar = $seminar->findById();
	$view_vars = array('seminar'=>$seminar,
						'member'=>$member,
						'location'=>$location,
						'layout_title'=>'Registration for '.$seminar['headline']
	);
	return $app['view']->render('registration/seminar', 'blank',$view_vars);
});
$app->post('/registration/seminar', function (Request $request) use ($app) {
	// retrieve document from request
	$doc = $request->get('doc'); 
	$registrationFee = $doc['registrationFee'];
	$hardCopy = (array_key_exists('hardCopy',$doc)) ? $doc['hardCopy'] : '';
	$hardCopyFee = (array_key_exists('hardCopyFee',$doc)) ? $doc['hardCopyFee'] : '';
	if($hardCopy == 'NO'){
		$hardCopyFee = 0;
	}
	$depositQuestion = (array_key_exists('depositQuestion',$doc)) ? $doc['depositQuestion'] : '';
	if($depositQuestion == 'yes'){
		$registrationFee = $doc['deposit'];
		$doc['currentStatus'] = Model\Registration::$status['DEPOSIT'];
	}

	$doc['total'] = (int)$hardCopyFee+(int)$registrationFee;
	
	//*
	$paymentId = new \stdClass();	
	$rs = new Model\RegistrationSeminar($doc,$app);
	$app['validateModel']($app, $rs);
	$rs_id = $rs->insert();
		
	if ($doc['currentPaymentType'] == Model\Registration::$paymentType['CREDIT']) {
		
		$doc['payment']['ownerId'] = $rs_id;
		$doc['payment']['ownerClass'] = 'RegistrationSeminar';

		$payment = new Model\Payment($doc['payment'],$app);
		$app['validateModel']($app, $payment,$groups=array('cc'));
		$app['seminarConfirmationEmail']($app,$rs_id);
		$paymentId = $payment->charge();
		
	}
	//*/
	return new Response(json_encode(array(
		'paymentId'=>$paymentId,
		'registrationId'=>$rs_id,
		'label'=>'Successful Registration',
		'message'=>"Thank you, your Registration is complete.  You will receive an confirmation and receipt in the email address you provided.")), 200,array('Content-Type' => 'registration/json')
	);

})->after(function (Request $request, Response $response, Silex\Application $app) {
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
			
			// need the rsvp text
			$rsvp = $doc['rsvp'];

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

	    	// send applicant the email notification (this is not the confirmation, which also includes the deposit)
    		$subject = 'NCDD Seminar Registration Information';
	    	$to = $doc['email'];
	    	$view_vars = array('seminar'=>$seminar
	    						,'rsvp'=>$rsvp
	    						,'total'=>$doc['total']
	    						,'hardCopy'=>$hardCopy
	    						,'hardCopyFee'=>$hardCopyFee
	    						,'registrationFee'=>$doc['registrationFee']
	    						,'registrantName'=>$doc['name']
	    						,'paymentType'=>$paymentType
	    						,'cardType'=>$cardType
	    						,'cardNumber'=>$cardNumber
	    	);
	    	$body = $app['view']->render('email/registration-seminar-customer','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);

	    endif;
	    //*/
});



/////////////////////////////
// GENERAL ADMIN FUNCTIONS //
/////////////////////////////

$app->get('/registration/{id}/view', function ($id, Request $request) use ($app) {
	
	$registration = new Model\Registration($doc=array('_id'=>$id), $app);
	$registration = $registration->findById();
	
	$seminar = new Model\Seminar(array('_id'=>$registration['seminarId']),$app);
	$seminar = $seminar->findById();

	$crumbs = array(array('name'=>'Registrations','href'=>'/registrations/seminar/'.$seminar['_id'])
					,array('name'=>$registration['name'],'href'=>'/registration/'.$id.'/view')
					,array('name'=>$registration['type'],'href'=>'/registration/'.$id.'/view')
					);
	$view_vars = array(
						 'active'=>'Seminar'
						,'page-plugin'=>'datatables'
						,'headline'=>'Registrations'
						,'description'=>"View all registration here."
						,'crumbs'=>$crumbs
						,'registration'=>$registration
						,'seminar'=>$seminar
						);
	switch ($registration['class']) {
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
	$submitted = $registration->fetchByStatus($seminarId,'SUBMITTED',$offset, $limit);
	$scholarship = $registration->fetchByStatus($seminarId,'SCHOLARSHIP',$offset, $limit);
	$scholarshipapprove = $registration->fetchByStatus($seminarId,'SCHOLARSHIPAPPROVE',$offset, $limit);
	$deposit = $registration->fetchByStatus($seminarId,'DEPOSIT',$offset, $limit);
	$depositbalance = $registration->fetchByStatus($seminarId,'DEPOSITBALANCE',$offset, $limit);
	$paid = $registration->fetchByStatus($seminarId,'PAID',$offset, $limit);
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
						,'deposit'=>$deposit
						,'depositbalance'=>$depositbalance
						,'scholarship'=>$scholarship
						,'scholarshipapprove'=>$scholarshipapprove
						,'paid'=>$paid);
	return $app['view']->render('registration/seminar-index', 'default', $view_vars);
})
->value('offset','0')
->value('limit','100')
->before($mustbeADMIN);

return $app;