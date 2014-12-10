<?php
///////////////////////////////////
// PAYMENT MANAGEMENT SCREENS /////
///////////////////////////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$app->post('/payment/charge', function (Request $request) use ($app) {
	// retrieve document from request
	$doc = $request->get('doc');
	// check if the payment is coming up from within another <form> and coming up as a nested document
	if(array_key_exists('payment',$doc) && is_array($doc['payment'])){
		$doc = $doc['payment'];
	}

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
	

	//error_log('/payment/charge:doc:'.print_r($doc,true));
	$payment = new Model\Payment($doc,$app);
	$app['validateModel']($app, $payment,$groups=array('cc'));
	$paymentId = $payment->charge();

    // thank you receipt message
	$subject = 'NCDD Payment Received';
	$to = $payment->email;
	$view_vars = array('payment'=>$payment->__toArray()
						,'paymentId'=>$paymentId
						,'email'=>$payment->email
	);
	$body = $app['view']->render('email/payment-thankyou','email', $view_vars);
	

	// TODO no emails when ADMIN is approving -- temporary and should be removed after Hunter is done with the manual entry and payment of snail mailed renewals
	$user = $app['session']->get('user');
	$user['suppress_emails'] = $request->get('suppress_emails');
	$app['session']->set('user',$user);
	if( ($user['accessLevel'] == ADMIN  || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && $user['suppress_emails'] == 'yes'){
		// do nothing
	}else{
		$app['sendMail']($subject, $body, $to);
	}	
	
	return new Response(json_encode(array('paymentId'=>$paymentId,'message'=>"success")), 200,array('Content-Type' => 'application/json'));
		
});

$app->post('/payment/refund', function (Request $request) use ($app) {
	// retrieve document from request
	$doc = $request->get('doc');
	// instantiate payment and do the refund

	return new Response(json_encode(array('message'=>"success")), 200,array('Content-Type' => 'application/json'));
		
});

return $app;