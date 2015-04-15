<?php
////////////////////////
// FOURMS CONTROLLERS //
////////////////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$card = $app['controllers_factory'];
$card->before($mustbeMEMBER);

////////////
//  HOME  //
////////////
// edit a card on file
$card->get('/{userId}', function ($userId, Request $request) use ($app) {
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	$accessLevel = $user['accessLevel'];

	if(empty($userId)){
		$userId = $user['user_id'];
	}

	$member = new Model\Member(array('_id'=>$userId),$app);
	$member = $member->findById();

	$crumbs = array(array('name'=>'Card','href'=>'/card')
					,array('name'=>'Manage your credit card on file','href'=>'/card')
	);
	$view_vars = array(
						 'active'=>'Card'
						,'page-plugin'=>''
						,'headline'=>($accessLevel == ADMIN) ? 'Edit card for <font style="color:red">'.$member['displayName'].'</font>': 'Edit your card' 
						,'description'=>"Edit your card here"
						,'crumbs'=>$crumbs
						);
	$view_vars['userId'] = $userId;
	if(is_array($member) && array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('number', $member['payment'])){
		$member['payment']['cvc'] = str_replace('.x', '', $member['payment']['cvc']);
		$member['payment']['number'] = str_replace('.x', '', $member['payment']['number']);
		if($accessLevel < ADMIN){
			$member['payment']['number'] = (!empty($member['payment']['number'])) ? '...'.substr($member['payment']['number'], -4) :'';	
		}		
		$view_vars['payment'] = $member['payment'];
	}else{
		$view_vars['payment'] = array();
	}

	return $app['view']->render('card/edit', 'default', $view_vars);
})->value('userId','');

// add / save card 
$card->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
	if(empty($document['userId'])){
		$userId = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$app);
	}else{
		$userId = $document['userId'];
	}
	$orig_member = new Model\Member(array('_id'=>$userId),$app);
	$orig_member = $orig_member->findById();

	$payment = new Model\PaymentLite($document, $app);
	
	if(strpos($document['number'], '...') === false && strlen($document['number']) > 13){
		$app['validateModel']($app,$payment,array('cc'));
		$payment->number = $payment->number.'.x';
	}else{
		$member = new Model\Member(array('_id'=>$userId),$app);
		$member = $member->findById();
		if(array_key_exists('payment', $member) && array_key_exists('number', $member['payment']))
			$payment->number = $member['payment']['number'];
	}	

	$payment->expYear = substr($payment->expYear, -2);
	$payment = $payment->__toArray();
	// unset any values that are empty for overwrite safety
	foreach ($payment as $key => $value) {
		if(empty($value)){
			unset($payment[$key]);
		}
	}
	$payment = array_merge($orig_member['payment'],$payment);
	$payment['declineCount'] = 0;
	$member = new Model\Member(array('_id'=>$userId,'payment'=>$payment),$app);
	$member->saveSafe();
	
    return new Response(json_encode(array('userId'=>$userId, 'message' => 'Card details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
});

return $card;