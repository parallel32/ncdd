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



$app['applicationEmails'] = $app->protect(function ($app,$applicationId,$context) {

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
									,'lastName'=>$member->lastName
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
		
		$app['sendMail']($subject, $body, $to);
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
		
		$app['sendMail']($subject, $body, $to);
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
$app->get('/application/new-member', function (Request $request) use ($app) {
	return $app['view']->render('application/new-member', 'blank');
});
$app->post('/application/new-member', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $application = new Model\ApplyNewMember($doc, $app);
    // validate the model
    $app['validateModel']($app,$application);

    if($application->findByEmail()){
    	$label = 'Success, but...';
    	$message = 'Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.';
    	$response_status = 400;
    }else{
    	$application->insert();
    	$label = 'Your application was received.  Thank you.';
    	$message = 'Thank you for your interest in NCDD.  Your application has been submitted.  You will be notified by the College when it is approved or if there are any questions.';
    	$response_status = 200;
    }
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));
})->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
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
	    	$app['sendMail']($subject, $body, $to);

	    	// send applicant the email notification
	    	$subject = 'Your Application for NCDD Membership has been Received';
	    	$to = $doc['email'];
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'middleName'=>$doc['middleName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    	);
	    	$body = $app['view']->render('email/new-member-applicant-submission','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);
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
    $application = new Model\ApplyNewSustainingMember($doc, $app);
    // validate the model
    $app['validateModel']($app,$application);

    if($application->findByEmail()){
    	$label = 'Your submission is correct, but...';
    	$message = 'Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.';
    	$response_status = 400;
    }else{
    	$application->insert();
    	$label = 'Your application was received.  Thank you.';
    	$message = 'Thank you for your interest in NCDD.  Your application has been submitted.  You will be notified by the College when it is approved or if there are any questions.';
    	$response_status = 200;
    }
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));
})->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
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
	    	$app['sendMail']($subject, $body, $to);

	    	// send applicant the email notification
	    	$subject = 'Your Application for NCDD Membership has been Received';
	    	$to = $doc['email'];
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'middleName'=>$doc['middleName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    	);
	    	$body = $app['view']->render('email/new-sustaining-member-applicant-submission','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);
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
	$member = $location['member'];

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
						,'location'=>$location);
		
	return $app['view']->render('application/update-member', 'default', $view_vars);
})->value('memberId','');
$app->post('/application/update-member/{memberId}', function ($memberId, Request $request) use ($app) {

	//get the user logged in
	if(empty($memberId)){
		$user = $app['session']->get('user');
		$memberId = $user['user_id'];
	}
	
	$location = new Model\Location($doc=array('member'=>array('_id'=>$memberId)), $app);
	$location = $location->getByMemberId();
	$member = $location['member'];


    // retrieve document from request
	$doc = $request->get('doc');
	// add name, email and area to the application for identification
	$doc['memberId'] = new \MongoId($memberId);

	$doc['firstName'] = (empty($doc['firstName'])) ? $member['firstName'] : $doc['firstName'];
	$doc['middleName'] = (empty($doc['middleName'])) ? (array_key_exists('middleName',$member)) ? $member['middleName']: '' : $doc['middleName'];
	$doc['lastName'] = (empty($doc['lastName'])) ? $member['lastName'] : $doc['lastName'];
	$doc['email'] = (empty($doc['email'])) ? $member['email'] : $doc['email'];
	$doc['city'] = (empty($doc['city'])) ? $location['city'] : $doc['city'];
	$doc['state'] = (empty($doc['state'])) ? $location['state'] : $doc['state'];

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
	$app_id = $application->insert();		

	if ($doc['contributionCheck'] == 'yes') {
		
		$doc['payment']['ownerId'] = $app_id;
		$doc['payment']['ownerClass'] = 'UpdateMember';

		$payment = new Model\Payment($doc['payment'],$app);
		$app['validateModel']($app, $payment,$groups=array('cc'));
		$paymentId = $payment->charge();

		// thank you receipt message
		$subject = 'NCDD Payment Received';
		$to = $payment->email;

		$view_vars = array('payment'=>$payment->__toArray()
							,'paymentId'=>$paymentId
							,'email'=>$member['email']
		);
		$body = $app['view']->render('email/payment-thankyou','email', $view_vars);
			
		$app['sendMail']($subject, $body, $to);

		// update the newly created payment record
		$payment = new Model\Payment(array('_id'=>$paymentId,'ownerId'=>$app_id),$app);
		$payment->saveSafe();


	}
	
	
	
	$member['renewal']['currentStatus'] = Model\Renewal::$status['SUBMITTED'];
	$member['renewal']['submittedDate'] = new Model\Date($app, 'now'); 
	$member['renewal']['applicationId'] = $app_id; 
	$member['renewal']['contributionPaymentId'] = $paymentId; 

	$renewal = new Model\Renewal($member['renewal'],$app);
	$renewal->setRenewalByMember($member['_id']);
	

	

	return new Response(json_encode(array(
		'label'=>'Your application was received.  Thank you.',
		'message'=>'Thank you for your interest in NCDD.  Your application has been submitted.  You will be notified by the College when it is approved or if there are any questions.')), 200,array('Content-Type' => 'registration/json')
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

	return $app['applicationEmails']($app,$id,$context='new-member-trial');
})->before($mustbeADMIN);

/////////////
// APPROVE //
/////////////
$app->get('/application/{id}/approve/{type}', function ($id,$type, Request $request) use ($app) {
	//error_log('type:'.$type);
	return $app['applicationEmails']($app,$id,$context='new-member-welcome');
})->before($mustbeADMIN);

///////////////
// MARK PAID //
///////////////
$app->get('/application/{id}/pay', function ($id, Request $request) use ($app) {
	
	$apply = new Model\Apply($doc=array('_id'=>$id), $app);
	$application = $apply->findById();
	
	$location = new Model\Location($doc=array('member'=>array('_id'=>$application['memberId'])), $app);
	$location = $location->getByMemberId();
	$member = $location['member'];

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
	$member = $location['member'];

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
		
	$app['sendMail']($subject, $body, $to);
	
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

    return $app['applicationEmails']($app,$applicationId,$context='new-member-complete');
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
	$paid = $application->fetchByStatus('PAID', $offset=0,$limit=100,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
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
	$submitted = $application->fetchByStatus('SUBMITTED',$offset, $limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
	$approved = $application->fetchByStatus('APPROVED',$offset, $limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
	$trial = $application->fetchByStatus('TRIAL',$offset, $limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
	$paid = $application->fetchByDatePaid(90, $offset, $limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
	$crumbs = array(array('name'=>'Applications','href'=>'/applications'));
	$view_vars = array(
						 'active'=>'Applications/New'
						,'page-plugin'=>'datatables'
						,'headline'=>'Applications'
						,'description'=>"View all application here."
						,'crumbs'=>$crumbs
						,'submitted'=>$submitted
						,'approved'=>$approved
						,'trial'=>$trial
						,'paid'=>$paid);
	return $app['view']->render('application/index', 'default', $view_vars);
})
->value('offset','0')
->value('limit','100')
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
	);
	$updates = array(
		'unsubmitted'=>$member->fetchByRenewalStatus('UNSUBMITTED',array(Model\Member::$membership['FOUNDING MEMBER'],Model\Member::$membership['SUSTAINING MEMBER']),$offset, $limit)
		,'submitted'=>$member->fetchByRenewalStatus('SUBMITTED',array(Model\Member::$membership['FOUNDING MEMBER'],Model\Member::$membership['SUSTAINING MEMBER']),$offset, $limit)
		,'approved'=>$member->fetchByRenewalStatus('APPROVED',array(Model\Member::$membership['FOUNDING MEMBER'],Model\Member::$membership['SUSTAINING MEMBER']),$offset, $limit)
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
						,'updates'=>$updates);
	return $app['view']->render('application/index-renewals', 'default', $view_vars);
})
->value('offset','0')
->value('limit','2000')
->before($mustbeADMIN);


$app->get('/applications/activate/renewals/{activate}', function ($activate, Request $request) use ($app) {
	$member = new Model\Member($doc=array(), $app);
	
	if($activate == 'yes'){
		// find all the active members who aren't already active and create the renewal attribute
		$renewal = new Model\Renewal(array(),$app);
		$renewal->prepareInsert();
		$renewal = $renewal->__toArray();

		// get the count of the updates to occur  /// $type 10 means a null type value
		// actuall query db.member.find({$or:[{renewal:{$exists:false}},{renewal:{$exists:true,$type:10}},{renewal:{}}],status:2,currentMembership:10}).count();
		$common_query = array('$or'=>array(array('renewal'=>array('$exists'=>false)),array('renewal'=>array('$exists'=>true,'$type'=>10)),array('renewal'=>new \stdClass())));		
		
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


		$label = 'Renewal Activation Successful.';
    	$message = $gm_count.' General Members were activated<br><br>'.$sm_count.' Sustaining Members were activated<br><br>'.$fm_count.' Founding Members were activated<br><br>'.$pd_count.' Public Defenders were activated<br><br>Note: only active members were updated.  Non-active members who are activated during the renewal process will have to be manually activated.';
    	
	}elseif($activate == 'clear'){
		// clear all active members' renewal attribute
		$gm_query = array('currentMembership'=>Model\Member::$membership['GENERAL MEMBER'],'status'=>USER_STATUS_ACTIVE);
		$sm_query = array('currentMembership'=>Model\Member::$membership['SUSTAINING MEMBER'],'status'=>USER_STATUS_ACTIVE);
		$fm_query = array('currentMembership'=>Model\Member::$membership['FOUNDING MEMBER'],'status'=>USER_STATUS_ACTIVE);
		$pd_query = array('currentMembership'=>Model\Member::$membership['PUBLIC DEFENDER'],'status'=>USER_STATUS_ACTIVE);
		
		$gm_count = $member->count($gm_query);
		$sm_count = $member->count($sm_query);
		$fm_count = $member->count($fm_query);
		$pd_count = $member->count($pd_query);
		
		$gm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $gm_query);
		$sm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $sm_query);
		$fm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $fm_query);
		$pd_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $pd_query);

		$label = 'Renewal Clear Successful.';
    	$message = $gm_count.' General Members were cleared<br><br>'.$sm_count.' Sustaining Members were cleared<br><br>'.$fm_count.' Founding Members were cleared<br><br>'.$pd_count.' Public Defenders were cleared<br><br>Note: only active members were updated.  Non-active members who are activated during the renewal process will have to be manually cleared.';
    	
	}

    return new Response(json_encode(array('message' => $message,'label'=>$label)),200,array('Content-Type' => 'application/json'));

})->value('acitvate','')
->before($mustbeADMIN);



return $app;
//echo"<pre>";print_r($submitted);echo "</pre>";