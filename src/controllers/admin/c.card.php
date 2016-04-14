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


///////////////////////
//  AUTO-RENEW HOME  //
///////////////////////

// edit a card on file
$card->get('/promotion/{status}/{id}', function ($status, $id, Request $request) use ($app) {
	$member['payment'] = array();
	switch ($status) {

		case Model\Promotion::$status['NEWMEMBER']:
			$application = new Model\Apply(array('_id'=>$id),$app);
			$application = $application->findById();
			$member['payment'] = $application['promotion']['paymentLite'] ;
			break;
		case Model\Promotion::$status['RENEWAL']:
			
			break;
		case Model\Promotion::$status['STORE']:
			
			break;
		case Model\Promotion::$status['SEMINAR']:
			
			break;
		
		
	}
	
	$crumbs = array(array('name'=>'Card','href'=>'/card')
					,array('name'=>'Manage credit card on file','href'=>'/card')
	);
	$view_vars = array(
						 'active'=>'Card'
						,'page-plugin'=>''
						,'headline'=>'Edit card' 
						,'description'=>"Edit card here"
						,'crumbs'=>$crumbs
						,'status'=>$status
						,'id'=>$id
						);
	
	if(is_array($member) && array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('number', $member['payment'])){
		$member['payment']['cvc'] = str_replace('.x', '', $member['payment']['cvc']);
		$member['payment']['number'] = str_replace('.x', '', $member['payment']['number']);
		$view_vars['payment'] = $member['payment'];
	}else{
		$view_vars['payment'] = array();
	}

	return $app['view']->render('card/promotion-edit', 'default', $view_vars);
})->value('userId','');

// add / save card 
$card->post('/promotion/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    
    $paymentLite = new Model\PaymentLite($document, $app);
	
	$app['validateModel']($app,$paymentLite,array('cc'));
	$paymentLite->number = $paymentLite->number.'.x';
	$paymentLite->expYear = substr($paymentLite->expYear, -2);
	$paymentLite = $paymentLite->__toArray();
	// unset any values that are empty for overwrite safety
	// unless it's the renewalCredit
	foreach ($paymentLite as $key => $value) {
		if(empty($value) && $key != 'renewalCredit'){
			unset($paymentLite[$key]);
		}
	}
	$paymentLite['declineCount'] = 0;
	
	/////////////////////////////////
	// now save the paymentLite document inside the promotion document inside the parent record
	/////////////////////////////////
	switch ($document['status']) {

		case Model\Promotion::$status['NEWMEMBER']:
			$appobj = new Model\Apply(array('_id'=>$document['id']),$app);
			$application = $appobj->findById();
			$application['promotion']['paymentLite'] = array_merge($application['promotion']['paymentLite'], $paymentLite);
			$appobj = new Model\Apply($application,$app);
			$appobj->saveSafe();
			break;
		case Model\Promotion::$status['RENEWAL']:
			
			break;
		case Model\Promotion::$status['STORE']:
			
			break;
		case Model\Promotion::$status['SEMINAR']:
			
			break;
		
		
	}

    return new Response(json_encode(array('message' => 'Card details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
});



///////////////////////
//  AUTO-RENEW HOME  //
///////////////////////

// edit a card on file
$card->get('/auto-renew/{userId}', function ($userId, Request $request) use ($app) {
	
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

	return $app['view']->render('card/auto-renew-edit', 'default', $view_vars);
})->value('userId','');

// add / save card 
$card->post('/auto-renew/edit', function (Request $request) use ($app) {
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
	// unless it's the renewalCredit
	foreach ($payment as $key => $value) {
		if(empty($value) && $key != 'renewalCredit'){
			unset($payment[$key]);
		}
	}
	$payment = array_merge($orig_member['payment'],$payment);
	$payment['declineCount'] = 0;
	$member = new Model\Member(array('_id'=>$userId,'payment'=>$payment),$app);
	$member->saveSafe();

	/////////////////////////////////
	// now save the auto-renew record
	/////////////////////////////////
	$member = $member->__toArray();

	$res_arr['_id'] = (string)$orig_member['_id'];
    $res_arr['expMonth'] = $orig_member['payment']['expMonth'];
    $res_arr['expYear'] = $orig_member['payment']['expYear'];
    
    $date1 = strtotime($res_arr['expYear']."-".$res_arr['expMonth']."-01");
    $date2 = strtotime("2016-01-01");
    $res_arr['expired'] = ($date2 > $date1) ? 'yes' : 'no';

	$ar = new Model\AutoRenew(array(), $app);
	$ar_res = $ar->findOne(array('record._id'=>(string)$orig_member['_id']));
	if(!empty($ar_res) && is_array($ar_res) && empty($ar_res['paymentId'])){
		$ar_res['record']['expMonth'] = $res_arr['expMonth'];
		$ar_res['record']['expYear']  = $res_arr['expYear'];
		$ar_res['record']['expired']  = $res_arr['expired'];
		$ar_res['record']['payment']  = $payment;
		$ar_res['expired'] 			  = 'no';
		$ar_res['valid'] 			  = 'yes';
		$ar_res['declined'] 		  = 'no';
		$ar_res['declinedMessage'] 	  = '-';

	}
	$ar = new Model\AutoRenew($ar_res, $app);
	$ar->saveSafe();
	
    return new Response(json_encode(array('userId'=>$userId, 'message' => 'Card details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
});




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
	// unless it's the renewalCredit
	foreach ($payment as $key => $value) {
		if(empty($value) && $key != 'renewalCredit'){
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