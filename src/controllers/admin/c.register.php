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



$app['registrationEmails'] = $app->protect(function ($app,$registrationId,$context) {

	$apply = new Model\Apply(array('_id'=>$registrationId), $app);
	$apply_arr = $apply->findById();

	if($context == 'seminar'){
		switch ($apply_arr['class']) {
			case 'RegistrationSeminar':
				$registration = new Model\RegistrationSeminar(array('_id'=>$registrationId), $app);
				$registration->findById();
			    $member = $registration->approve();
			    // email welcome message
				$subject = 'Welcome To NCDD';
				$to = $member->email;
				$view_vars = array('email'=>$member->email
									,'password'=>$member->password
									,'firstName'=>$member->firstName
									,'lastName'=>$member->lastName
				);
				$body = $app['view']->render('email/new-member-welcome','email', $view_vars);
				break;
			
		}
		
		$app['sendMail']($subject, $body, $to);
	    return new Response(json_encode(array('message' => 'Approved successfully')), 200,array('Content-Type' => 'registration/json'));
	}
});

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
    $registration = new Model\RegistrationSeminar($doc, $app);
    // validate the model
    $app['validateModel']($app,$registration);

    if($registration->findByEmail()){
    	$label = 'Success, but...';
    	$message = 'Our records indicate you have already submitted an registration.  Please Log-in if you are looking for another Registration or contact NCDD directly.';
    	$response_status = 400;
    }else{
    	$registration->insert();
    	$label = 'Your seminar registration was received.  Thank you.';
    	$message = 'Thank you for your interest in NCDD.  Your registration has been submitted.  You will be notified by the College when it is approved or if there are any questions.';
    	$response_status = 200;
    }
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'registration/json'));
})->after(function (Request $request, Response $response, Silex\Registration $app) {
		if((int)$response->getStatusCode() == 200):
	    	$doc = $request->get('doc');
	    	// send admin the email notification
	    	$subject = 'Seminar Registration Submitted';
	    	$to = SAW_ADMIN_EMAIL;
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'middleName'=>$doc['middleName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    	);
	    	$body = $app['view']->render('email/registration-seminar-admin','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);

	    	// send applicant the email notification
	    	$subject = 'Your Registration for an NCDD Seminar has been Received';
	    	$to = $doc['email'];
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'middleName'=>$doc['middleName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    	);
	    	$body = $app['view']->render('email/registration-seminar-customer','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);
	    endif;
});


///////////////////////
// PAYMENT FUNCTIONS //
///////////////////////
// the credit card charging view has it's routes stored in the Payment.js.php file
$app->post('/registration/seminar/payment', function (Request $request) use ($app) {
	// retrieve document from request
	$doc = $request->get('doc');



	$payment = new Model\Payment($doc['payment'],$app);
	$app['validateModel']($app, $payment,$groups=array('manual'));
	$paymentId = $payment->manualCharge();
	
	return new Response(json_encode(array('paymentId'=>$paymentId,'message'=>"success")), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);


///////////////////////
// GENERAL FUNCTIONS //
///////////////////////

$app->get('/registration/{id}/view', function ($id, Request $request) use ($app) {
	
	$registration = new Model\Registration($doc=array('_id'=>$id), $app);
	$registration = $registration->findById();
	$crumbs = array(array('name'=>'Registrations','href'=>'/registrations')
					,array('name'=>$registration['firstName'].' '.$registration['lastName'],'href'=>'/registration/'.$id.'/view')
					,array('name'=>$registration['type'],'href'=>'/registration/'.$id.'/view')
					);
	$view_vars = array(
						 'active'=>'Registration'
						,'page-plugin'=>'datatables'
						,'headline'=>'Registrations'
						,'description'=>"View all registration here."
						,'crumbs'=>$crumbs
						,'registration'=>$registration);
	switch ($registration['class']) {
		case 'RegistrationSeminar':
			return $app['view']->render('registration/view-seminar', 'default', $view_vars);		
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
	
	$registration = new Model\Apply($doc=array('_id'=>$id), $app);
	$registration = $registration->findById();

	$crumbs = array(array('name'=>'Registrations','href'=>'/registrations')
					,array('name'=>$registration['firstName'].' '.$registration['lastName'],'href'=>'/registration/'.$id.'/view')
					,array('name'=>$registration['type'],'href'=>'/registration/'.$id.'/view')
					,array('name'=>'Edit','href'=>'/registration/'.$id.'/edit')
					);
	$view_vars = array(
						 'active'=>'Registration'
						,'page-plugin'=>'datatables'
						,'headline'=>'Registrations'
						,'description'=>"Edit Registration."
						,'crumbs'=>$crumbs
						,'registration'=>$registration);
	switch ($registration['class']) {
		case 'RegistrationSeminar':
			return $app['view']->render('registration/edit-seminar', 'default', $view_vars);		
			break;
		
	}
	
})->value('id','')
->before($mustbeADMIN);

$app->post('/registration/edit', function (Request $request) use ($app) {

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

$app->get('/registrations/seminar/{seminarId}/{offset}/{limit}', function ($seminarId, $offset, $limit, Request $request) use ($app) {
	$registration = new Model\Registration($doc=array(), $app);
	$submitted = $registration->fetchByStatus('SUBMITTED',$offset, $limit);
	$paid = $registration->fetchByDatePaid(90, $offset, $limit);
	$crumbs = array(array('name'=>'Registrations','href'=>'/registrations'));
	$view_vars = array(
						 'active'=>'Registrations/New'
						,'page-plugin'=>'datatables'
						,'headline'=>'Registrations'
						,'description'=>"View all registration here."
						,'crumbs'=>$crumbs
						,'submitted'=>$submitted
						,'approved'=>$approved
						,'trial'=>$trial
						,'paid'=>$paid);
	return $app['view']->render('registration/index', 'default', $view_vars);
})
->value('offset','0')
->value('limit','100')
->before($mustbeADMIN);

return $app;