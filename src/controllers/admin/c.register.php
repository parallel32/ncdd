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
	$registration = $registration->findById();
	$seminar = new Model\Seminar(array('_id'=>$registration['seminarId']),$app);
	$seminar = $seminar->findById();
	
    // email welcome message
	$subject = 'NCDD Seminar Confirmation';
	$to = $registration['email'];
	$view_vars = array('seminar'=>$seminar
						,'registration'=>$registration
	);
	$body = $app['view']->render('email/registration-seminar-customer-confirmation','email', $view_vars);

	
	$app['sendMail']($subject, $body, $to);

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

// this is posted to by the registrations/pay-other.php view
// mark the registration paid and create a payment record, which is the receipt
$app->post('/registration/payment', function (Request $request) use ($app) {
	// retrieve document from request
	$doc = $request->get('doc');
	$payment = new Model\Payment($doc,$app);
	$app['validateModel']($app, $payment,$groups=array('manual'));
	$paymentId = $payment->manualCharge();
	
	return new Response(json_encode(array('paymentId'=>$paymentId,'message'=>"success")), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);

// both credit card and pay by check XHR call this route to mark the registration as paid.
// resetSession is passed in when the member is using the credit card payment screen and not used when the admin 
// is making a payment on behalf of the member using the same credit card screen
$app->get('/registration/{paymentId}/pay/{registrationId}', function ($paymentId, $registrationId, Request $request) use ($app) {
    
    $registration = new Model\Registration(array('_id'=>$registrationId, 'paymentId'=>$paymentId), $app);
    $registration->markPaid();
    $app['seminarConfirmationEmail']($app,$registrationId);
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
	if($doc['hardCopy'] == 'NO'){
		$doc['hardCopyFee'] = 0;
	}
	$doc['total'] = (int)$doc['hardCopyFee']+(int)$doc['registrationFee'];

	$paymentId = new \stdClass();	
	$rs = new Model\RegistrationSeminar($doc,$app);
	$app['validateModel']($app, $rs);
	$rs_id = $rs->insert();
			
	if ($doc['currentPaymentType'] == Model\Registration::$paymentType['CREDIT']) {
		
		$doc['payment']['ownerId'] = $rs_id;
		$doc['payment']['ownerClass'] = 'RegistrationSeminar';

		$payment = new Model\Payment($doc['payment'],$app);
		$app['validateModel']($app, $payment,$groups=array('cc'));
		$paymentId = $payment->charge();

		$app['seminarConfirmationEmail']($app,$rs_id);
	}
	
	return new Response(json_encode(array(
		'paymentId'=>$paymentId,
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

	    	// calculate the total and what is in the line item.
	    	if($doc['hardCopy'] == 'NO'){
				$doc['hardCopyFee'] = 0;
			}
			$doc['total'] = (int)$doc['hardCopyFee']+(int)$doc['registrationFee'];
			
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
	    						,'hardCopy'=>$doc['hardCopy']
	    						,'hardCopyFee'=>$doc['hardCopyFee']
	    						,'registrationFee'=>$doc['registrationFee']
	    						,'registrantName'=>$doc['name']
	    						,'paymentType'=>$paymentType
	    						,'cardType'=>$cardType
	    						,'cardNumber'=>$cardNumber
	    	);
	    	$body = $app['view']->render('email/registration-seminar-admin','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);

	    	// send applicant the email notification
	    	$subject = 'NCDD Seminar Registration Receipt';
	    	$to = $doc['email'];
	    	$view_vars = array('seminar'=>$seminar
	    						,'rsvp'=>$rsvp
	    						,'total'=>$doc['total']
	    						,'hardCopy'=>$doc['hardCopy']
	    						,'hardCopyFee'=>$doc['hardCopyFee']
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
						,'paid'=>$paid);
	return $app['view']->render('registration/seminar-index', 'default', $view_vars);
})
->value('offset','0')
->value('limit','100')
->before($mustbeADMIN);

return $app;