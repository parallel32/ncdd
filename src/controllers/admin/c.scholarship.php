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

$app->get('/scholarships/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$scholarship = new Model\Scholarship($doc=array(), $app);
	$submitted = $scholarship->fetchByStatus('SUBMITTED',$offset, $limit);
	$approved = $scholarship->fetchByStatus('APPROVED',$offset, $limit);
	$crumbs = array(array('name'=>'Scholarships','href'=>'/scholarships'));
	$view_vars = array(
						 'active'=>'Scholarship'
						,'page-plugin'=>'datatables'
						,'headline'=>'Scholarships'
						,'description'=>"View all scholarship here."
						,'crumbs'=>$crumbs
						,'submitted'=>$submitted
						,'approved'=>$approved
						);
	return $app['view']->render('scholarship/index', 'default', $view_vars);
})
->value('offset','0')
->value('limit','10000')
->before($mustbeADMIN);

///////////
// APPLY //
///////////
$app->get('/scholarship/apply/{for}', function ($for, Request $request) use ($app) {
	return $app['view']->render('scholarship/apply', 'blank',array('for'=>$for));
})->value('for','');
$app->post('/scholarship/apply', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $scholarship = new Model\Scholarship($doc, $app);
    // validate the model
    $app['validateModel']($app,$scholarship);

    if($scholarship->findByEmail()){
    	$label = 'Success, but...';
    	$message = 'Our records indicate you have already submitted a scholarship.  Please contact NCDD directly if you are looking for another scholarship.';
    	$response_status = 400;
    }else{
    	$scholarship->insert();
    	$label = 'Your scholarship was received.  Thank you.';
    	$message = 'Thank you for your interest in NCDD.  Your scholarship has been submitted.  You will be notified by the College when it is approved or if there are any questions.';
    	$response_status = 200;
    }
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));
})->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
	    	$doc = $request->get('doc');
	    	// send admin the email notification
	    	$subject = 'Scholarship Application Form Submitted';
	    	$to = SAW_ADMIN_EMAIL;
	    	$view_vars = array('name'=>$doc['name']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    						,'for'=>$doc['for']
	    	);
	    	$body = $app['view']->render('email/new-scholarship','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);

	    	// send applicant the email notification
	    	$subject = 'Your NCDD Scholarship Application has been received.';
	    	$to = $doc['email'];
	    	$view_vars = array('name'=>$doc['name']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    						,'for'=>$doc['for']
	    	);
	    	$body = $app['view']->render('email/new-scholarship-submission','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);
	    endif;
});
$app->get('/scholarship/check/regnum/{regnum}', function ($regnum, Request $request) use ($app) {
	if(Model\Scholarship::checkRegNum((int)$regnum,$app)){
		return new Response(json_encode(array('message' => 'We have validated your registration number.  Please proceed with registration.','label'=>'Found')), 200,array('Content-Type' => 'application/json'));
	}else{
		return new Response(json_encode(array('errors' => 'The registration number you entered is invalid')), 404,array('Content-Type' => 'application/json'));
	}
})->value('regnum','');


////////////////////////
// UPDATE APPLICATION //
////////////////////////
$app->get('/scholarship/update/{memberId}', function ($memberId, Request $request) use ($app) {

	//get the user logged in
	if(empty($memberId)){
		$user = $app['session']->get('user');
		$memberId = $user['user_id'];
	}
	
	$location = new Model\Location($doc=array('member'=>array('_id'=>$memberId)), $app);
	$location = $location->getByMemberId();
	$member = $location['member'];

	$crumbs = array(array('name'=>'Dashboard','href'=>'/')
					,array('name'=>'Membership Renewal','href'=>'/scholarship/update')
					);
	$view_vars = array(
						 'active'=>'Scholarship'
						,'page-plugin'=>'datatables'
						,'headline'=>'Membership Renewal Form'
						,'description'=>"Fill in and submit this scholarship to begin your membership renewal process."
						,'crumbs'=>$crumbs
						,'member'=>$member
						,'location'=>$location);
		
	return $app['view']->render('scholarship/update', 'default', $view_vars);
})->value('memberId','');
$app->post('/scholarship/update/{memberId}', function ($memberId, Request $request) use ($app) {

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
	// add name, email and area to the scholarship for identification
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
			$scholarship = new Model\UpdateMember($doc, $app);
			break;
		case Model\Member::$membership['FOUNDING MEMBER']:
			$scholarship = new Model\UpdateFoundingMember($doc, $app);
			break;
		case Model\Member::$membership['SUSTAINING MEMBER']:
			$scholarship = new Model\UpdateSustainingMember($doc, $app);
			break;
		
	}
    
    // validate the model
    $app['validateModel']($app,$scholarship,$groups=array('update_member'));
	$app_id = $scholarship->insert();		

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
		
		// TODO no emails when ADMIN is approving -- temporary and should be removed after Hunter is done with the manual entry and payment of snail mailed renewals
		$user = $app['session']->get('user');
		$user['suppress_emails'] = $request->get('suppress_emails');
		$app['session']->set('user',$user);
		if($user['accessLevel'] == ADMIN && $user['suppress_emails'] == 'yes'){
			// do nothing
		}else{
			$app['sendMail']($subject, $body, $to);
		}		

		// update the newly created payment record
		$payment = new Model\Payment(array('_id'=>$paymentId,'ownerId'=>$app_id),$app);
		$payment->saveSafe();
	}
	
	$member['renewal']['currentStatus'] = Model\Renewal::$status['SUBMITTED'];
	$member['renewal']['submittedDate'] = new Model\Date($app, 'now'); 
	$member['renewal']['scholarshipId'] = $app_id; 
	$member['renewal']['contributionPaymentId'] = $paymentId; 

	$renewal = new Model\Renewal($member['renewal'],$app);
	$renewal->setRenewalByMember($member['_id']);
	
	return new Response(json_encode(array(
		'label'=>'Your scholarship was received.  Thank you.',
		'message'=>'Thank you for your interest in NCDD.  Your scholarship has been submitted.  You will be notified by the College when it is approved or if there are any questions.')), 200,array('Content-Type' => 'registration/json')
	);

})->value('memberId','')
->after(function (Request $request, Response $response, Silex\Application $app) {
		
});

///////////////////////
// GENERAL FUNCTIONS //
///////////////////////
$app->get('/scholarship/{id}/view-public', function ($id, Request $request) use ($app) {
	
	$scholarship = new Model\Scholarship($doc=array('_id'=>$id), $app);
	$scholarship = $scholarship->findById();

	if(empty($scholarship)){
		$msg = new \stdClass();
		$msg->message = 'This Scholarship cannot be found.';
		$msg->resolveMessage = 'Please go back and try again or contact the Administrator if this problem persists.';
		return $app['view']->render('errors/404','error', array('error'=>$msg));
	}
	$crumbs = array(array('name'=>'Scholarships','href'=>'/scholarships')
					,array('name'=>$scholarship['for'].' - '.$scholarship['name'],'href'=>'/scholarship/'.$id.'/view')
					,array('name'=>'View','href'=>'/scholarship/'.$id.'/view')
					);
	$view_vars = array(
						 'active'=>'Scholarship'
						,'page-plugin'=>'datatables'
						,'headline'=>'Private Scholarship View'
						,'description'=>"View all scholarships here."
						,'crumbs'=>$crumbs
						,'scholarship'=>$scholarship
						);
	return $app['view']->render('scholarship/view-public', 'blank', $view_vars);
	
})->value('id','');

$app->get('/scholarship/{id}/view', function ($id, Request $request) use ($app) {
	
	$scholarship = new Model\Scholarship($doc=array('_id'=>$id), $app);
	$scholarship = $scholarship->findById();

	if(empty($scholarship)){
		$msg = new \stdClass();
		$msg->message = 'This Scholarship cannot be found.';
		$msg->resolveMessage = 'Please go back and try again or contact the Administrator if this problem persists.';
		return $app['view']->render('errors/404','error', array('error'=>$msg));
	}
	$crumbs = array(array('name'=>'Scholarships','href'=>'/scholarships')
					,array('name'=>$scholarship['for'].' - '.$scholarship['name'],'href'=>'/scholarship/'.$id.'/view')
					,array('name'=>'View','href'=>'/scholarship/'.$id.'/view')
					);
	$view_vars = array(
						 'active'=>'Scholarship'
						,'page-plugin'=>'datatables'
						,'headline'=>'Scholarships'
						,'description'=>"View all scholarships here."
						,'crumbs'=>$crumbs
						,'scholarship'=>$scholarship
						);
	return $app['view']->render('scholarship/view', 'default', $view_vars);
		
})->value('id','')
->before($mustbeADMIN);

$app->get('/scholarship/{id}/edit', function ($id, Request $request) use ($app) {
	
	$scholarship = new Model\Scholarship($doc=array('_id'=>$id), $app);
	$scholarship = $scholarship->findById();

	if(empty($scholarship)){
		$msg = new \stdClass();
		$msg->message = 'This Scholarship cannot be found.';
		$msg->resolveMessage = 'Please go back and try again or contact the Administrator if this problem persists.';
		return $app['view']->render('errors/404','error', array('error'=>$msg));
	}
	$crumbs = array(array('name'=>'Scholarships','href'=>'/scholarships')
					,array('name'=>$scholarship['for'].' - '.$scholarship['name'],'href'=>'/scholarship/'.$id.'/view')
					,array('name'=>'Edit','href'=>'/scholarship/'.$id.'/edit')
					);
	$view_vars = array(
						 'active'=>'Scholarship'
						,'page-plugin'=>'datatables'
						,'headline'=>'Scholarships'
						,'description'=>"View all scholarships here."
						,'crumbs'=>$crumbs
						,'scholarship'=>$scholarship
						);
	return $app['view']->render('scholarship/edit', 'default', $view_vars);
	
})->value('id','')
->before($mustbeADMIN);

$app->post('/scholarship/edit', function (Request $request) use ($app) {

	// retrieve document from request
    $doc = $request->get('doc');
	$scholarship = new Model\Scholarship($doc, $app);    

	$app['validateModel']($app,$scholarship);

	$scholarship_id = $scholarship->checkEmailExists();
	if(!empty($scholarship_id) && $scholarship_id != $scholarship->_id){
    	$label = 'Warning:';
    	$message = "The email address you're trying to update is already in use on another scholarship.  Please use a different email and try again.";
    	$response_status = 400;
    }else{
    	$member = $scholarship->saveEdit();	
    	$label = 'Scholarship Saved';
    	$message = 'Scholarship Successfully Saved.';
    	$response_status = 200;
    }

    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));

})->before($mustbeADMIN);

/////////////
// APPROVE //
/////////////
$app->get('/scholarship/{id}/approve', function ($id,Request $request) use ($app) {
	
	$scholarship = new Model\Scholarship(array('_id'=>$id), $app);
	$scholarship->approve();
	$scholarship->findById();
    // email welcome message
	$subject = 'Your NCDD Scholarship Has Been Approved';
	$to = $scholarship->email;
	$view_vars = array('name'=>$scholarship->name
						,'for'=>$scholarship->for
						,'registrationNumber'=>$scholarship->registrationNumber
	);
	$body = $app['view']->render('email/new-scholarship-approved','email', $view_vars);

	$user = $app['session']->get('user');
	$user['suppress_emails'] = $request->get('suppress_emails');
	$app['session']->set('user',$user);
	if($user['accessLevel'] == ADMIN && $user['suppress_emails'] == 'yes'){
		// do nothing
	}else{
		$app['sendMail']($subject, $body, $to);
	}
	return new Response(json_encode(array('message' => 'Approved successfully')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);
////////////
// DELETE //
////////////
$app->get('/scholarship/{id}/delete', function ($id, Request $request) use ($app) {
    $scholarship = new Model\Scholarship(array('_id'=>$id), $app);
    $scholarship = $scholarship->findById();
    
    $scholarship->remove();
    return new Response(json_encode(array('message' => 'Successfully Deleted')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);

return $app;