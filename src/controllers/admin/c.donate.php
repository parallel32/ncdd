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


$app->get('/donate', function (Request $request) use ($app) {
	
	$member = Model\User::getUserBySession($app,'member');

	$location = new Model\Location($doc=array('member'=>array('_id'=>$member['_id'])), $app);
	$location = $location->getByMemberId();
	
	
	$crumbs = array(array('name'=>'Donatation','href'=>'/donate')
					);
	$view_vars = array(
						 'active'=>'Donation'
						,'page-plugin'=>'datatables'
						,'headline'=>'Donations'
						,'description'=>"View all donations here."
						,'crumbs'=>$crumbs
						,'member'=>$member
						,'location'=>$location
						);
	
	return $app['view']->render('donation/donate', 'blank', $view_vars);			
});


$app->post('/donate', function (Request $request) use ($app) {

	$paymentId = null;	
	$app_id = new \stdClass();	

    // retrieve document from request
	$doc = $request->get('doc');
	$doc['userAgent'] = $request->headers->get('User-Agent');

	$doc['currentStatus'] = Model\Donate::$status['SUBMITTED'];
	$doc['submittedDate'] = new Model\Date($app, 'now');

    // validate the model
    $donate = new Model\Donate($doc,$app);
	$app['validateModel']($app,$donate,$groups=array(''));



    if(array_key_exists('currentPaymentType',$doc) && $doc['currentPaymentType'] == Model\Donate::$paymentType['CHECK']){
    	
    }else{
    	$doc['payment']['ownerId'] = $app_id;
		$doc['payment']['ownerClass'] = 'Donate';

		$payment = new Model\Payment($doc['payment'],$app);
		
		$validate[] = array('model'=>$payment,'groups'=>array('cc'));
		$app['validateModel']($app,$validate);
		$paymentId = $payment->charge();
    }
    
    
   	
		


		// thank you receipt message
		$subject = 'NCDD Donation Received';
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


	return new Response(json_encode(array(
		'label'=>'Your donation was received.  Thank you!',
		'message'=>'Thank you for your generous donation to the NCDD.  An letter has been sent to your email address verifying your contribution.  Please let us know if you have any questions.')), 200,array('Content-Type' => 'registration/json')
	);


})->after(function (Request $request, Response $response, Silex\Application $app) {
		
});
$app->get('/donate/{id}/view', function ($id, Request $request) use ($app) {
	
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

///////////////
// MARK PAID //
///////////////
$app->get('/donate/{id}/pay', function ($id, Request $request) use ($app) {
	
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
})->value('id','');

$app->get('/donate/{id}/pay-other', function ($id, Request $request) use ($app) {
	
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
$app->post('/donate/payment', function (Request $request) use ($app) {
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

	$doc['currentPaymentType'] = Model\Payment::$paymentType['CHECK'];
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
});

// both credit card and pay by check XHR call this route to mark the application as paid.
// resetSession is passed in when the member is using the credit card payment screen and not used when the admin 
// is making a payment on behalf of the member using the same credit card screen
$app->get('/donate/{paymentId}/pay/{applicationId}/{resetSession}', function ($paymentId, $applicationId, $resetSession, Request $request) use ($app) {
    

    $apply = new Model\Apply($doc=array('_id'=>$applicationId), $app);
	$application = $apply->findById();

	switch ($application['class']) {
		case 'NewMemberApplication': // old deprecated
		case 'ApplyNewMember':
		case 'ApplyNewSustainingMember':
			$application = new Model\Apply(array('_id'=>$applicationId, 'paymentId'=>$paymentId), $app);
		    break;		
		case 'UpdateMember':

			// need to determine if a renewal was paid by CC or Chk and update the renewal document in the member record.
			$payment = new Model\Payment($doc=array('_id'=>$paymentId), $app);
			$payment = $payment->findById();
			$pay_by_check = ($payment['currentPaymentType'] == Model\Payment::$paymentType['CHECK']) ? 'yes':'no';
error_log(__FILE__.' '.__LINE__.' for variable: pay_by_check  ==>'.print_r($pay_by_check,true));
error_log(__FILE__.' '.__LINE__.' for variable: payment  ==>'.print_r($payment,true));
			$application = new Model\UpdateMember(array('_id'=>$applicationId, 'paymentId'=>$paymentId,'memberId'=>$application['memberId'],'payByCheck'=>$pay_by_check), $app);
			$application->saveSafe();

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


$app->get('/donations/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$donate = new Model\Donate($doc=array(), $app);
	$submitted = $donate->fetchByStatus('SUBMITTED',$offset, $limit,$filter=array());
	$paid = $donate->fetchByStatus('PAID',$offset, $limit,$filter=array());
	
	$crumbs = array(array('name'=>'Donations','href'=>'/donations'));
	$view_vars = array(
						 'active'=>'Donations'
						,'page-plugin'=>'datatables'
						,'headline'=>'Donations'
						,'description'=>"All donations listed here"
						,'crumbs'=>$crumbs
						,'submitted'=>$submitted
						,'paid'=>$paid
	);
	return $app['view']->render('donation/index', 'default', $view_vars);
})
->value('offset','0')
->value('limit','10000')
->before($mustbeADMIN);

return $app;