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

$app['applicationEmails'] = $app->protect(function ($app,$applicationId,$context,$request) {

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
									,'middleName'=>$member->middleName
									,'lastName'=>$member->lastName
									,'paymentId'=>$application->paymentId
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
		$user = $app['session']->get('user');
		$user['suppress_emails'] = $request->get('suppress_emails');
		$app['session']->set('user',$user);

		if((is_array($user)) && array_key_exists('accessLevel', $user) && ($user['accessLevel'] == ADMIN  || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') ) ) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes'){
			switch ($apply_arr['class']) {
				case 'UpdateMember':
				case 'UpdateFoundingMember':
				case 'UpdateSustainingMember':
					return new Response(json_encode(array('message' => 'Approved successfully AND No emails sent to members.')), 200,array('Content-Type' => 'application/json'));
					break;
			}
		}else{
			$app['sendMail']($subject, $body, $to);	
		}
		
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
		// TODO no emails when ADMIN is approving -- temporary and should be removed after Hunter is done with the manual entry and payment of snail mailed renewals
		$user = $app['session']->get('user');
		$user['suppress_emails'] = $request->get('suppress_emails');
		$app['session']->set('user',$user);
		if((is_array($user)) && array_key_exists('accessLevel', $user) && ($user['accessLevel'] == ADMIN  || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes'){
			switch ($apply_arr['class']) {
				case 'UpdateMember':
					return new Response(json_encode(array('message' => 'Approved successfully AND No emails sent to members.')), 200,array('Content-Type' => 'application/json'));
					break;
			}
		}else{
			$app['sendMail']($subject, $body, $to);	
		}
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
$app->post('/application/promocode', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    if(!empty($doc['promocode']) && (strtoupper($doc['promocode']) == 'BONUS2015-' || strtoupper($doc['promocode']) == 'EAGLE2016-' || strtoupper($doc['promocode']) == 'NCDD2015-' || strtoupper($doc['promocode']) == 'NCDD2014-' || strtoupper($doc['promocode']) == 'TRIAL' || strtoupper($doc['promocode']) == 'DIVTRIAL' || strtoupper($doc['promocode']) == 'RFTRIAL' || strtoupper($doc['promocode']) == 'PDTRIAL' || strtoupper($doc['promocode']) == 'ALLENTRAPP')){
    	$valid = 'yes';
    	$message = 'Valid Promo Code.';
    	$type = (strtoupper($doc['promocode']) == 'BONUS2015-' || strtoupper($doc['promocode']) == 'EAGLE2016-' || strtoupper($doc['promocode']) == 'NCDD2015-' || strtoupper($doc['promocode']) == 'NCDD2014-') ? 'discount'.'-'.strtoupper($doc['promocode']): 'trial';
    }else{
    	$type = '';
    	$valid = 'no';
    	$message = 'Invalid Promo Code.';
    }
    if(!empty($doc['promocode'])){
    	if(strtoupper($doc['promocode']) == 'TRIAL' || strtoupper($doc['promocode']) == 'DIVTRIAL' || strtoupper($doc['promocode']) == 'RFTRIAL' || strtoupper($doc['promocode']) == 'PDTRIAL' || strtoupper($doc['promocode']) == 'ALLENTRAPP'){
    		$valid = 'yes';
	    	$message = 'Valid Promo Code.';
	    	$type = 'trial';
    	}else{
	    	$promo = new Model\Promotion(array(),$app);
	    	$res = $promo->isValid($doc['promocode']);
	    	if(!empty($res)){
	    		$valid = 'yes';
		    	$message = 'Valid Promo Code.';
		    	$type = strtoupper($doc['promocode']);
		    	$amount = $res['discountAmt'];
	    	}else{
	    		$type = '';
		    	$valid = 'no';
		    	$message = 'Invalid Promo Code.';
	    	}
	    }
    }else{
    	$type = '';
    	$valid = 'no';
    	$message = 'Invalid Promo Code.';
    }
    
    return new Response(json_encode(array('valid'=>$valid, 'type'=>$type,'message' => $message)), 200,array('Content-Type' => 'application/json'));
});
////////////////////////////////////////////////////
// check the membership restriction of promoocodes//
////////////////////////////////////////////////////
$app->post('/application/promocodeisvalidmemberhsip', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    
    $promo = new Model\Promotion(array(),$app);
	$res = $promo->isValid($doc['promocode']);
	if(!empty($res)){
		$mem = ($doc['publicDefender']=='yes') ? Model\Member::$membership['PUBLIC DEFENDER'] : Model\Member::$membership['GENERAL MEMBER'] ;
		
		if($promo->isValidMembership($doc['promocode'],$mem)){
			$valid = 'yes';
			$type = strtoupper($doc['promocode']);
	    	$message = 'Valid for General Members.';
		}else{
			$valid = 'no';
			$type='';
	    	$message = 'Unfortunately, this promotion is not valid for Public Defenders.';
		}
	}else{
		$valid = 'no';
		$type='';
    	$message = 'Invalid Promo Code.';
	}
    
    return new Response(json_encode(array('valid'=>$valid, 'type'=>$type, 'message' => $message)), 200,array('Content-Type' => 'application/json'));
});

$app->get('/application/new-member', function (Request $request) use ($app) {

	foreach(Model\ApplyNewMember::$dues as $type => $amount){
		$apply = new Model\Apply(array('membershipDues'=>$amount),$app);
		$dues[$type]['amount'] = $amount;
		$dues[$type]['prorated'] = $apply->proRate('today');
	}

	$promo = new Model\Promotion(array('isActive'=>'yes'),$app);
	$promos = $promo->findAllById('isActive');
	
	return $app['view']->render('application/new-member', 'blank',array('dues'=>$dues,'promos'=>$promos));
});
$app->get('/application/new-member-admin', function (Request $request) use ($app) {

	foreach(Model\ApplyNewMember::$dues as $type => $amount){
		$apply = new Model\Apply(array('membershipDues'=>$amount),$app);
		$dues[$type]['amount'] = $amount;
		$dues[$type]['prorated'] = $apply->proRate('today');
	}
	$crumbs = array(array('name'=>'Applications','href'=>'/applications')
		,array('name'=>'(admin) Add New Member','href'=>'/applications/new-member-admin')
	);
	$view_vars = array(
						 'active'=>'Applications/New'
						,'page-plugin'=>'datatables'
						,'headline'=>'Add a new member'
						,'description'=>"<a class='btn ' href='/applications'><i class=''></i> Cancel</a>"
						,'crumbs'=>$crumbs
						,'dues'=>$dues
	);
	return $app['view']->render('application/new-member-admin', 'default', $view_vars);
});




































$app->get('/application/new-expert-admin', function (Request $request) use ($app) {

	$crumbs = array(array('name'=>'Applications','href'=>'/applications')
		,array('name'=>'(admin) Add New Expert','href'=>'/applications/new-expert-admin')
	);
	$view_vars = array(
						 'active'=>'Applications/New'
						,'page-plugin'=>'datatables'
						,'headline'=>'Add a new expert'
						,'description'=>"<a class='btn ' href='/applications'><i class=''></i> Cancel</a>"
						,'crumbs'=>$crumbs
	);
	return $app['view']->render('application/new-expert-admin', 'default', $view_vars);
});
$app->post('/application/new-expert', function (Request $request) use ($app) {
	
	// retrieve document from request
    $doc = $request->get('doc');
    $doc['userAgent'] = $request->headers->get('User-Agent');

    $mem = new Model\Member($doc,$app);


	if(!empty($doc['email']) && $mem->findByEmail()){
    	error_log('BBBBBB: '.print_r('BBBBBB',true));
    	$response_arr = array('message'=>"Our records indicate you are already a member.  Please Log-in or contact NCDD directly.",
                              "invalidFields"=>array(array('name'=>'email','message'=>'Our records indicate you are already a member.  Please Log-in or contact NCDD directly.')));
        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
    }


    


    // prepare member record
		$password = substr(time(),-4);
		$mem_doc['password'] = $password;
		$mem_doc['firstName'] = $doc['firstName'];
		$mem_doc['middleName'] = $doc['middleName'];
		$mem_doc['lastName'] = $doc['lastName'];
		$mem_doc['email'] = $doc['email'];
		$mem_doc['primaryPhone'] = $doc['phone'];
		$mem_doc['primaryFax'] = $doc['fax'];
		$mem_doc['cellphone'] = $doc['cellphone'];
		$mem_doc['textAlertsOpt'] = $doc['textAlertsOpt'];
		$mem_doc['websites'] = array(array('websiteDesc'=>'','website'=>Model\Member::parseWebsite($doc['website'])));
		$mem_doc['currentMembership'] = Model\Member::$membership['EXPERT'];
	    $mem_doc['currentOrder'] = Model\Member::$order['EXPERT'];
	    $mem_doc['accessLevel'] = MEMBER;
	    
		// prepare location record
		$loc_doc['raw'] = $doc['formattedAddress'];
		$loc_doc['name'] = 'primary';
		$loc_doc['point'] = array($doc['lon'], $doc['lat']);
		$loc_doc['addressLine1'] = $doc['address1'];
		$loc_doc['addressLine2'] = $doc['address2'];
		$loc_doc['city'] = $doc['city'];
		$loc_doc['state'] = $doc['state'];
		$loc_doc['zip'] = $doc['postalCode'];
		$loc_doc['country'] = $doc['country'];
		$loc_doc['phone'] = $doc['phone'];
		$loc_doc['fax'] = $doc['fax'];
		$loc_doc['primary'] = 11;
		$location = new Model\Location($loc_doc, $app);

		$member = new Model\Member($mem_doc, $app, $location);
		$mem_id = $member->insert();

		$location->member = $member->__toArray(false);
		$location->ownerId = $mem_id;
		$location->insert();

		$member = new Model\Member(array('_id'=>$mem_id,'accessLevel'=>MEMBER,'changeAccessLevelTo'=>MEMBER,'listed'=>1),$app);
		$member->saveSafe();




    
	
	$label = 'Your application was received.  Thank you.';
	$message = 'Thank you for your interest in NCDD.  Your application has been submitted.  Please check your inbox for your receipt and log-in information.';
	$response_status = 200;
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));
})->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
			
	    endif;
});




























/**

new member application submittal form - UPDATED

*/
$app->post('/application/new-member', function (Request $request) use ($app) {
	$user = $app['session']->get('user');
   	$is_admin = (is_array($user) && array_key_exists('accessLevel', $user) && $user['accessLevel'] == ADMIN) ? true : false;

	// retrieve document from request
    $doc = $request->get('doc');
    if(!array_key_exists('termsAcknowledgement', $doc)){
    	$doc['termsAcknowledgement'] = 'no';
    }
    if(!array_key_exists('twoSeminarsAcknowledgement', $doc)){
    	$doc['twoSeminarsAcknowledgement'] = 'no';
    }

    $doc['authorizationReleasePrintedName'] = $doc['executedPrintedName'];
  	$doc['authorizationReleasePrintedNameDate'] = $doc['executedPrintedNameDate'];

    // promocode sanity check
    if(!array_key_exists('promocode', $doc)){
    	$doc['promocode'] = '';
    }else{
    	$doc['promocode'] = strtoupper(trim($doc['promocode']));
    }
    $doc['userAgent'] = $request->headers->get('User-Agent');

	$application = new Model\ApplyNewMember($doc, $app);
	$mem = new Model\Member(array('email'=>$doc['email']),$app);

	if(!empty($doc['email']) && $application->findByEmail()){
		error_log('AAAAAAA: '.print_r('AAAAAAA',true));
    	$response_arr = array('message'=>"Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.",
                              "invalidFields"=>array(array('name'=>'email','message'=>'Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.')));
        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
    }
    if(!empty($doc['email']) && $mem->findByEmail()){
    	error_log('BBBBBB: '.print_r('BBBBBB',true));
    	$response_arr = array('message'=>"Our records indicate you are already a member.  Please Log-in or contact NCDD directly.",
                              "invalidFields"=>array(array('name'=>'email','message'=>'Our records indicate you are already a member.  Please Log-in or contact NCDD directly.')));
        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
    }

    // validate the application
    $app['validateModel']($app,$application);
    // validate the promo code
    $promo_res = array();
    if(!empty($doc['promocode'])){

    	$promo = new Model\Promotion(array('code'=>$doc['promocode']),$app);
    	// what the membership translates to and if you should validate
    	$mem = ($doc['publicDefender']=='yes') ? Model\Member::$membership['PUBLIC DEFENDER'] : Model\Member::$membership['GENERAL MEMBER'];

    	if($promo->isValidMembership($doc['promocode'],$mem)){
    		error_log(__FILE__.' '.__LINE__.' $mem: '.print_r($mem,true));
    		error_log(__FILE__.' '.__LINE__.' $doc[promocode]: '.print_r($doc['promocode'],true));
    		$promo_res = $promo->findById('code');    	
	    	$promo_res['currentMembership'] = $mem;
	    	$promo_res['optIn'] = (array_key_exists('optIn', $doc)) ? $doc['optIn'] : '';
	    	$promo_res['code'] = $doc['promocode'];
	    	
	    	$promo = new Model\Promotion($promo_res,$app);
	    	$app['validateModel']($app,$promo,array('onform'));
	    	$application->promotion = $promo_res;
	    }else{
	    	error_log(__FILE__.' '.__LINE__.' : '.print_r('NOT VALID PROMO',true));
	    }
    	// $response_arr = array('message'=>"Please check the authorization checkbox above and agree in order to use the promo code.",
	    //                           "invalidFields"=>array(array('name'=>'optIn','message'=>'Please check the opt-in checkbox above and agree in order to use the promo code.')
	    //                           								,array('name'=>'promocode','message'=>'')
	    //                           ));
	    //     return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
    	/*
    	if($doc['promocode'] == 'BONUS2015-'  ||$doc['promocode'] == 'TRIAL' || $doc['promocode'] == 'DIVTRIAL' || $doc['promocode'] == 'PDTRIAL' || $doc['promocode'] == 'RFTRIAL' || $doc['promocode'] == 'ALLENTRAPP'){
    		//skip validation because the acknlowlegdement doesn't need to be checked
    	}else{
	    	$response_arr = array('message'=>"Please check the authorization checkbox above and agree in order to use the promo code.",
	                              "invalidFields"=>array(array('name'=>'termsAcknowledgement','message'=>'Please check the authorization checkbox above and agree in order to use the promo code.')
	                              								,array('name'=>'promocode','message'=>'')
	                              ));
	        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
	    }
	    */
    }
    

    
    // re-calculate the amount in case the amount gets compromised on the way up to the server
	$dues = array();
	foreach(Model\ApplyNewMember::$dues as $type => $amount){
		$apply = new Model\Apply(array('membershipDues'=>$amount),$app);
		// calculate the discount amount
		if(is_array($promo_res) && !empty($promo_res) && array_key_exists('currentType', $promo_res)){
	    	if(\Saw\Model\Promotion::$type['MONEY'] == $promo_res['currentType']){
	    		if(!empty($promo_res['discountAmt']) && $promo_res['discountAmt'] > 0){
	    			$amount = $amount - $promo_res['discountAmt'];
	    		}
	    	}
	    	if(\Saw\Model\Promotion::$type['PERCENT'] == $promo_res['currentType']){
	    		if(!empty($promo_res['discountAmt']) && $promo_res['discountAmt'] > 0){
	    			$amount = $amount - ($amount * ($promo_res['discountAmt'])/100);
	    		}
	    	}
		}
		$dues[$type]['amount'] = $amount;
		$dues[$type]['prorated'] = $apply->proRate('today');
	}
	$yilp = $application->yearsInLawPractice;
	$now = date('Y',strtotime('today'));
	if($now - $yilp >= 6){
		$amt = ($doc['promocode'] == 'BONUS2015-' || $doc['promocode'] == 'EAGLE2016-') ? $dues[6]['amount']: $dues[6]['prorated']['a'];
	}elseif ($now - $yilp < 6){
		$amt = ($doc['promocode'] == 'BONUS2015-' || $doc['promocode'] == 'EAGLE2016-') ? $dues[1]['amount']: $dues[1]['prorated']['a'];
	}
	if($application->publicDefender == 'yes'/* && ($doc['promocode'] == 'BONUS2015-' || $doc['promocode'] == 'EAGLE2016-')*/){
		$amt = $dues['publicDefender']['prorated']['a'];
		/* EAGLE2016- promo doesn't apply to public defenders
		$amt = (empty($doc['promocode']) || $doc['promocode'] == 'EAGLE2016-') ? $dues['publicDefender']['amount']: $dues['publicDefender']['prorated']['a'];
		//*/
		// also erase the promo code so they don't get gouped in the promo code list
		//$doc['promocode'] = '';
		
		$amt = (empty($doc['promocode']) || $doc['promocode'] == 'BONUS2015-' || $doc['promocode'] == 'EAGLE2016-') ? $dues['publicDefender']['amount']: $dues['publicDefender']['prorated']['a'];
		// also erase the promo code so they don't get gouped in the promo code list
		//$doc['promocode'] = '';
error_log('pd $amt: '.print_r($amt,true));
	}

	if($doc['promocode'] == 'TRIAL' || $doc['promocode'] == 'DIVTRIAL' || $doc['promocode'] == 'PDTRIAL' || $doc['promocode'] == 'RFTRIAL' || $doc['promocode'] == 'ALLENTRAPP'){
		if($doc['promocode'] == 'ALLENTRAPP'){
			$trial_doc['startDate'] = 'now';
			$trial_doc['endDate'] = "December 31st, 2016";
		}else{
			$trial_doc['startDate'] = 'now';
			$trial_doc['endDate'] = "+1 year";	
		}
		
		$trial_doc['referredBy'] = $doc['referredBy'];
error_log('trial_doc:'.print_r($trial_doc,true));
		
		$trial = new Model\Trial($trial_doc,$app);

error_log('trial:'.print_r($trial,true));
		
		$applicationId = $application->insert();
		$_POST['applicationId'] = $applicationId->__toString();


		$application = new Model\Apply(array('_id'=>$applicationId,'referredBy'=>$doc['referredBy'],'trial'=>$trial->__toArray()), $app);
		$application->saveEdit();

		// approve as trial
		$response = $app['applicationEmails']($app,$applicationId,$context='new-member-trial',$request);
	}else{
		error_log('attempt to approve');
		// approve
		// sends email/new-member-welcome which now combines:
		// email/new-member-applicant-submission + 
		// email/new-member-welcome + 
		// email/new-member-welcome-complete + 
		// email/payment-thankyou
		if($is_admin){
			$application->currentStatus = Model\Apply::$status['APPROVED'];
			$applicationId = $application->insert();
			$_POST['applicationId'] = $applicationId->__toString();
		}
		

		if($is_admin == false):
		    // payment stuff BEGIN
		    $paymentId = new \stdClass();
			$validation_group = ($doc['payment']['currentPaymentType'] == Model\Payment::$paymentType['CREDIT']) ? 'cc' : 'check';		
			$doc['payment']['ownerId'] = new \MongoId(); // temporary to get past validation
			$doc['payment']['ownerClass'] = 'ApplyNewMember';
		endif;
		
		if($is_admin == false):
			$doc['amount'] = $amt;
			$doc['payment']['amount'] = $amt;
			$payment = new Model\Payment($doc['payment'],$app);

			// validate the payment
			$app['validateModel']($app, $payment,$groups=array($validation_group));
			
			// insert the application
			$applicationId = $application->insert();
			$_POST['applicationId'] = $applicationId->__toString();

			// redo the payment object to fill in all attributes just before charge.
			$doc['payment']['ownerId'] = $applicationId;
			$doc['payment']['ownerClass'] = 'ApplyNewMember';
			$doc['amount'] = $amt;
			$doc['payment']['amount'] = $amt;
			$payment = new Model\Payment($doc['payment'],$app);
			try {

				$application->paymentId = $payment->charge();	
				$payment_lite = $payment->__toArray();
				$payment_lite['number'] = $doc['payment']['number'].'.x';
				$payment_lite['cvc'] = $doc['payment']['cvc'].'.x';
				$promo_res['paymentLite'] = $payment_lite;
			} catch (Exception $e) {
				$app_remove = new Model\ApplyNewMember(array('_id'=>$applicationId), $app);
				$app_remove->remove();
				throw new \Saw\Exceptions\SawException(new \Saw\Exceptions\PaymentException(),$e->getMessage());
			}
			
			// payment stuff END

			// save the application
			//$app_id = $application->insert();			
			if(array_key_exists('payByCheck',$doc) && strpos($doc['payByCheck'], 'no') !== false){
				// save the card 
				$paymentlite->number = $paymentlite->number.'.x';
				$paymentlite->expYear = substr($paymentlite->expYear, -2);
				$memberobj = new Model\Member(array('_id'=>$memberId,'payment'=>$paymentlite),$app);
				$memberobj->saveSafe();
			}
		endif;


		
		// the member is created here via the approve() method called in the email sending logic
		$response = $app['applicationEmails']($app,$applicationId,$context='new-member-welcome',$request);

		// save the card by getting the memberId first

		$papply = new Model\ApplyNewMember(array('_id'=>$applicationId), $app);
		$papplication = $papply->findById();
		$paymentlite = new Model\PaymentLite($doc['payment'],$app);
		$paymentlite->renewalREUSE = ($doc['termsAcknowledgement'] == 'yes') ? 'yes' : 'no';

		$member = new Model\Member(array('_id'=>$papplication['memberId'],'payment'=>$paymentlite),$app);
		$member->saveSafe();

		// for generating the invoice block
			$member = $member->findById();		
			$location = new Model\Location(array('member'=>array('_id'=>$papplication['memberId'])), $app);
			$location = $location->getByMemberId();
			
			switch ($papplication['class']) {
				case 'NewMemberApplication': // old deprecated
				case 'ApplyNewMember':
				case 'ApplyNewSustainingMember':
					$pro_rate = $papply->proRate();
				    break;		
				case 'UpdateMember':
				case 'UpdateFoundingMember':
				case 'UpdateSustainingMember':
					$pro_rate = array('q'=>0,'a'=>0);
					break;
			}
		// end for generating the invoice block
		$invoice_block = $app['view']->element('invoice-block',array('application'=>$papplication,'member'=>$member,'location'=>$location,'pro_rated_membership_dues'=>$pro_rate));
		$ppayment = new Model\Payment(array(
			'_id'=>$application->paymentId
			,'memberId'=>$papplication['memberId']
			,'invoiceBlock'=>$invoice_block
		),$app);
		$ppayment->saveSafe();
		

		if($is_admin == false):
			// marking the application paid
			$application = new Model\Apply(array('_id'=>$applicationId, 'paymentId'=>$application->paymentId, 'promotion'=>$promo_res), $app);
			$application->markPaid(false);
		endif;

	}

	

	$label = 'Your application was received.  Thank you.';
	$message = 'Thank you for your interest in NCDD.  Your application has been submitted.  Please check your inbox for your receipt and log-in information.';
	$response_status = 200;
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));
})->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
			$user = $app['session']->get('user');
			$user['suppress_emails'] = $request->get('suppress_emails');
			$app['session']->set('user',$user);
			$suppress = (!empty($user) && (is_array($user)) && array_key_exists('accesslevel', $user) && ($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes') ? true: false;


	    	$doc = $request->get('doc');
	    	// send admin the email notification
	    	$subject = 'General Member Application Form Submitted';
	    	$to = SAW_ADMIN_EMAIL;
	    	// cc state delegate and regional delegate if exists.
	    	$delegate = new Model\Delegate(array(),$app);
	    	$state = strtolower($doc['state']);
	    	$country = ($doc['country'] == 'US') ? 'usa':'canada';
	    	$res = $delegate->fetchByState($state,$country);
	    	if(!empty($res) && is_array($res)):
	    		if(array_key_exists('regionalDelegateEmail', $res) && !empty($res['regionalDelegateEmail'])){
	    			$to.=', '.$res['regionalDelegateEmail'];
	    		}
	    		foreach ($res['members'] as $member) {
	    			$to.=', '.$member['email'];
	    		}
	    	endif;
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'middleName'=>$doc['middleName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    						,'phone'=>$doc['phone']
	    	);
	    	$body = $app['view']->render('email/new-member','email', $view_vars);
	    	if(!$suppress){$app['sendMail']($subject, $body, $to);}

	    	// send applicant the email notification
	    	// deprecated - all emails are handeled in the controller body except the for the admin email above
	    	/*
	    	$subject = 'Your Application for NCDD Membership has been Received';
	    	$to = $doc['email'];
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'middleName'=>$doc['middleName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    						,'applicationId'=>$_POST['applicationId']
	    	);
	    	$body = $app['view']->render('email/new-member-applicant-submission','email', $view_vars);
	    	if(!$suppress){$app['sendMail']($subject, $body, $to);}
	    	//*/
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
    if(!array_key_exists('termsAcknowledgement', $doc)){
    	$doc['termsAcknowledgement'] = 'no';
    }
    if(!array_key_exists('twoSeminarsAcknowledgement', $doc)){
    	$doc['twoSeminarsAcknowledgement'] = 'no';
    }
    $doc['userAgent'] = $request->headers->get('User-Agent');
    $application = new Model\ApplyNewSustainingMember($doc, $app);

    if($application->findByEmail()){
    	$response_arr = array('message'=>"Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.",
                              "invalidFields"=>array(array('name'=>'email','message'=>'Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.')));
        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
    }else{
        // validate the model
	    $app['validateModel']($app,$application);

    	$applicationId = $application->insert();
    	$_POST['applicationId'] = $applicationId->__toString();
    	$label = 'Your application was received.  Thank you.';
    	$message = 'Thank you for your interest in NCDD.  Your application has been submitted.  You will be notified by the College when it is approved or if there are any questions.';
    	$response_status = 200;
    }
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));
})->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
	    	$user = $app['session']->get('user');
			$user['suppress_emails'] = $request->get('suppress_emails');
			$app['session']->set('user',$user);
			$suppress = (!empty($user) && (is_array($user)) && array_key_exists('accesslevel', $user) && ($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') ) ) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes') ? true: false;
			
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
	    	if(!$suppress){$app['sendMail']($subject, $body, $to);}

	    	// send applicant the email notification
	    	$subject = 'Your Application for NCDD Membership has been Received';
	    	$to = $doc['email'];
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'middleName'=>$doc['middleName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    						,'applicationId'=>$_POST['applicationId']
	    	);
	    	$body = $app['view']->render('email/new-sustaining-member-applicant-submission','email', $view_vars);
	    	if(!$suppress){$app['sendMail']($subject, $body, $to);}
	    endif;
});

///////////////////////////////
// UPDATE MEMBER APPLICATION //
///////////////////////////////
/**
RENEWAL 
*/
$app->get('/application/update-member/{memberId}', function ($memberId, Request $request) use ($app) {

	//get the user logged in
	if(empty($memberId)){
		$user = $app['session']->get('user');
		$memberId = $user['user_id'];
	}
	

	$location = new Model\Location($doc=array('member'=>array('_id'=>$memberId)), $app);
	$loc = $location->getPrimary($memberId);
	if(empty($loc)){
		$location = $location->getByMemberId();	
	}else{
		$location = $loc;
	}
	

	$member = new Model\Member($doc=array('_id'=>$memberId), $app);
	$member = $member->findById();
	

	$locobj = new Model\Location(array('ownerId'=>$memberId),$app);
	$locations = $locobj->getByOwner();
	$member['locations'] = $locations;

	// prepare the card payment fields
	if(is_array($member) && array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('number', $member['payment'])){
		$member['payment']['cvc'] = str_replace('.x', '', $member['payment']['cvc']);
		$member['payment']['number'] = str_replace('.x', '', $member['payment']['number']);
		$member['payment']['number'] = (!empty($member['payment']['number'])) ? '...'.substr($member['payment']['number'], -4) :'';
		$payment = $member['payment'];
	}else{
		$payment = array();
	}
	
	/////////////
	// AUTO-PAY//
	/////////////
	// attempt to find the auto-pay created applicationId
	// in order to bypass the payment stuff.
	$is_autopay = false;
	if(is_array($member) && array_key_exists('applicationId', $member['renewal']) && !empty($member['renewal']['applicationId']) && $member['renewal']['currentStatus'] == Model\Renewal::$status['AUTOPAY']){
		$is_autopay = true;
	}

	$crumbs = array(array('name'=>'Dashboard','href'=>'/')
					,array('name'=>'Membership Renewal','href'=>'/application/update-member')
					);
	$view_vars = array(
						 'active'=>'Dashboard'
						,'page-plugin'=>'datatables,editor'
						,'headline'=>'Membership Renewal Form'
						,'description'=>"Fill in and submit this application to begin your membership renewal process."
						,'crumbs'=>$crumbs
						,'member'=>$member
						,'location'=>$location
						,'payment'=>$payment
						,'is_autopay'=>$is_autopay
						);
		
	return $app['view']->render('application/update-member', 'default', $view_vars);
})->value('memberId','');

$app->post('/application/renewal/promocode/validate', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    if(!empty($doc['renewalpromocode']) && (strtoupper($doc['renewalpromocode']) == 'RENEW2016')){
    	$user = $app['session']->get('user');
		$memberId = $user['user_id'];
		$is_eligible = true;
		$valid = 'yes';
    	$message = 'Valid Promo Code.';
    	// is member eligible? - meaning is it their first time subscribing to auto-renew?
    	// if part of the EAGLE2016- promo then not eligible
    	$application = new Model\Apply(array(),$app);
		$eagle2016promocode = $application->fetchByStatus('PAID',$offset=0, $limit=10000,$filter=array('promocode'=>'EAGLE2016-'));
		foreach ($eagle2016promocode as $record) {
			if((string)$record['memberId'] == $memberId){
				$is_eligible = false;
				$valid = 'no';
				$message = 'Sorry, you cannot use this promo because you already received the EAGLE2016 promo';
			}
		}
    	// if have termsAcknowledge checked in last cycle's renewal form then not eligible
		$apply = new Model\Apply(array(),$app);
		$query = array('termsAcknowledgement'=>'yes'
						,'paidDate.date'=>array('$lte'=>new \MongoDate(strtotime('now'))
												,'$gte'=>new \MongoDate(strtotime('-395 day')))
		);
		$renewals = $apply->find($query,$fields=array('memberId'=>1,'termsAcknowledgement'=>1),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=10000);

		foreach ($renewals as $record) {
			if($record['memberId'] == $memberId){
				error_log('found it: '.print_r('found it',true));
			}
			if($record['termsAcknowledgement'] == 'yes' && $record['memberId'] == $memberId){
				$is_eligible = false;
				$valid = 'no';
				$message = 'Sorry, you cannot use this promo because you already received a discount last time for signing up for auot-pay and we thank you for that!';
			}
		}

    	// if a public defender then not eligible
		$member = new Model\Member(array('_id'=>$memberId),$app);
		$member = $member->findById();
		if($member['currentMembership'] == Model\Member::$membership['PUBLIC DEFENDER']){
			$is_eligible = false;
			$valid = 'no';
			$message = 'Sorry, you cannot us this promo because you are a pulbic defender';
		}
    	
    	$type = (strtoupper($doc['renewalpromocode']) == 'RENEW2016') ? 'discount'.'-'.strtoupper($doc['renewalpromocode']): '';
    }else{
    	$type = '';
    	$valid = 'no';
    	$message = 'Invalid Promo Code.';
    }
    
    return new Response(json_encode(array('valid'=>$valid, 'type'=>$type,'message' => $message)), 200,array('Content-Type' => 'application/json'));
});
/*

RENEWAL SUBMISSIONS HERE

*/
$app->post('/application/update-member/{memberId}', function ($memberId, Request $request) use ($app) {

	//get the user logged in
	if(empty($memberId)){
		$user = $app['session']->get('user');
		$memberId = $user['user_id'];
	}

	$member = new Model\Member(array('_id'=>$memberId),$app);
	$member = $member->findById();

	$location = new Model\Location($doc=array('member'=>array('_id'=>$memberId)), $app);
	$location = $location->getByMemberId();
	if(empty($location)){
		$location['city'] = '';
		$location['state'] = '';
	}


    // retrieve document from request
	$doc = $request->get('doc');
	$doc['userAgent'] = $request->headers->get('User-Agent');
	$doc_orig = $doc;

	// check if the promocode is valid otherwise clear it
	if(array_key_exists('renewalpromocode', $doc)){
		if($doc['renewalpromocode'] == strtoupper('RENEW2016')){
			// do nothing
		}else{
			// clear it
			$doc['renewalpromocode'] = '';
		}
	}

	/////////////
	// AUTO-PAY//
	/////////////
	// attempt to find the auto-pay created applicationId
	// in order to bypass the payment stuff.
	$is_autopay = false;
	if(array_key_exists('applicationId', $member['renewal']) && !empty($member['renewal']['applicationId']) && $member['renewal']['currentStatus'] == Model\Renewal::$status['AUTOPAY']){
		$is_autopay = true;
	}


	// if(array_key_exists('termsAcknowledgement', $doc) && $doc['termsAcknowledgement'] == 'yes'){
 //    	$doc['payByCheck'] = 'no-store';
 //    }

	// add name, email and area to the application for identification
	$doc['memberId'] = new \MongoId($memberId);
	$doc['firstName'] = (empty($doc['firstName'])) ? $member['firstName'] : $doc['firstName'];
	$doc['middleName'] = (empty($doc['middleName'])) ? (array_key_exists('middleName',$member)) ? $member['middleName']: '' : $doc['middleName'];
	$doc['lastName'] = (empty($doc['lastName'])) ? $member['lastName'] : $doc['lastName'];
	$doc['email'] = (empty($doc['email'])) ? $member['email'] : $doc['email'];
	$doc['city'] = (empty($doc['city'])) ? $location['city'] : $doc['city'];
	$doc['state'] = (empty($doc['state'])) ? $location['state'] : $doc['state'];
	// everything is automatically approved now
	$doc['currentStatus'] = Model\Apply::$status['APPROVED'];
	$doc['approvedDate'] = new Model\Date($app, 'now');
	$doc['submittedDate'] = new Model\Date($app, 'now');
	if($is_autopay){
		$doc['membershipDues'] = '-'; // just to get past the validation
	}

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


	if(!$is_autopay):

	    if((array_key_exists('payByCheck',$doc) && strpos($doc['payByCheck'], 'no') !== false) || (!empty($doc['paymentlite']['number']))){

	    	if(is_array($member) && !empty($member['renewal']) && is_array($member['renewal']) && !empty($member['renewal']['paymentId'])){
				$response_arr = array('message'=>"Our records indicate your applicaton is already paid.  On behalf of the NCDD, thank you for your continued membership!",
		                              "invalidFields"=>array(array('name'=>'email','message'=>'Our records indicate your applicaton is already paid.  On behalf of the NCDD, thank you for your continued membership!')));
		        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
			}
	    	// this no-store has been deprecated
	    	if($doc['payByCheck'] == 'no-store'){
	    		$doc['paymentlite']['renewalREUSE'] = 'yes';
	    	}
	    	// prepare to save the credit card information only if it's not an already saved card

	    	if(strpos($doc['paymentlite']['number'], '...') !== false){
	    		// no need to re-validate since it's already saved
	    		$tmpmem = new Model\Member(array('_id'=>$memberId),$app);
				$tmpmem = $tmpmem->findById();
	    		$paymentlite = new Model\PaymentLite($tmpmem['payment'], $app);
	    	}else{
	    		$paymentlite = new Model\PaymentLite($doc['paymentlite'], $app);
		    	$validate[] = array('model'=>$paymentlite,'groups'=>array('cc'));
		    	$app['validateModel']($app,$validate);	
	    	}
		    

	    	// save the card and retain membership credit if exists - (only if not on file)
			$tmpmem = new Model\Member(array('_id'=>$memberId),$app);
			$tmpmem = $tmpmem->findById();
			
			
			$tmprenewalcredit = (is_array($tmpmem['payment']) && array_key_exists('renewalCredit', $tmpmem['payment'])) ? $tmpmem['payment']['renewalCredit']: '';
			if(!empty($tmprenewalcredit))
				$paymentlite->renewalCredit = $tmprenewalcredit;
			$paymentlite->number = $paymentlite->number.'.x';
			$paymentlite->expYear = substr($paymentlite->expYear, -2);
			if(array_key_exists('termsAcknowledgement', $doc) && !empty($doc['termsAcknowledgement']) && $doc['termsAcknowledgement'] == 'yes'){
				$paymentlite->renewalREUSE = 'yes';
			}

			$memberobj = new Model\Member(array('_id'=>$memberId,'payment'=>$paymentlite),$app);
			$memberobj->saveSafe();
	    }
	    
	    
	    // save the application
		$app_id = $application->insert();	

	endif; 	
	
	if ($doc['contributionCheck'] == 'yes') {
		
		$doc['payment']['ownerId'] = $app_id;
		$doc['payment']['ownerClass'] = 'UpdateMember';

		$payment = new Model\Payment($doc['payment'],$app);
		
		$validate[] = array('model'=>$payment,'groups'=>array('cc'));
		$app['validateModel']($app,$validate);
		$paymentId = $payment->charge();

		// thank you receipt message
		$subject = 'NCDD Contribution Payment Received';
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


	}
	
	
	$member['renewal']['currentStatus'] = ($is_autopay) ? Model\Renewal::$status['PAID']: Model\Renewal::$status['APPROVED'];;
	$member['renewal']['submittedDate'] = new Model\Date($app, 'now'); 
	$member['renewal']['approvedDate'] = new Model\Date($app, 'now');
	$member['renewal']['contributionPaymentId'] = $paymentId; 
	if(!$is_autopay):
		$member['renewal']['applicationId'] = $app_id; 
		$member['renewal']['payByCheck'] = (array_key_exists('payByCheck', $doc)) ? $doc['payByCheck']: '';
	endif;

	$renewal = new Model\Renewal($member['renewal'],$app);
	$renewal->setRenewalByMember($member['_id']);
	
	// update member's profile
	$membersaveprofile = array();
	if(!empty($doc_orig['firstName'])){
		$membersaveprofile['firstName'] = $doc_orig['firstName'];
	}
	if(!empty($doc_orig['lastName'])){
		$membersaveprofile['lastName'] = $doc_orig['lastName'];
	}
	if(!empty($doc_orig['middleName'])){
		$membersaveprofile['middleName'] = $doc_orig['middleName'];
	}
	if(!empty($doc_orig['email'])){
		$membersaveprofile['email'] = $doc_orig['email'];
	}
	if(!empty($doc_orig['listServEmail'])){
		$membersaveprofile['listServEmail'] = $doc_orig['listServEmail'];
	}
	if(!empty($membersaveprofile)){
		$membersaveprofile['_id'] = $memberId;
		$member = new Model\Member($membersaveprofile,$app);
		$member->saveSafe();
	}

	return new Response(json_encode(array(
		'label'=>'Your application was received.  Thank you.',
		'message'=>'Thank you for your interest in NCDD.  Your application has been submitted.  You will be notified by the College if there are any questions or concerns that need to be addressed.')), 200,array('Content-Type' => 'registration/json')
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
$app->get('/application/{id}/print', function ($id, Request $request) use ($app) {
	
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
			return $app['view']->render('application/print-new-member', 'blank', $view_vars);		
			break;
		default:
			$msg = new \stdClass();
			$msg->message = 'This Application cannot be found.';
			$msg->resolveMessage = 'Please go back and try again or contact the Administrator if this problem persists.';
			return $app['view']->render('errors/404','error', array('error'=>$msg));
			break;
	}
	
})->value('id','');

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
    if(!array_key_exists('termsAcknowledgement', $doc)){
    	$doc['termsAcknowledgement'] = 'no';
    }
    if(!array_key_exists('twoSeminarsAcknowledgement', $doc)){
    	$doc['twoSeminarsAcknowledgement'] = 'no';
    }
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
		
		$appArr['trial']['referredBy'] = $doc['referredBy'];
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
		    	// now need to update the payment type on the original member record
		    	if(array_key_exists('payByCheck', $doc)){
		    		$apply = new Model\Apply(array('_id'=>$doc['_id']),$app);
		    		$apply = $apply->findById();
		    		$mem = new Model\Member(array('_id'=>$apply['memberId']),$app);
		    		$mem->updateByCriteria(array('$set'=>array('renewal.payByCheck'=>$doc['payByCheck'])), array('_id'=>$apply['memberId']));
		    	}
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
			// now need to update the payment type on the original member record
	    	if(array_key_exists('payByCheck', $doc)){
	    		$apply = new Model\Apply(array('_id'=>$doc['_id']),$app);
	    		$apply = $apply->findById();
	    		$mem = new Model\Member(array('_id'=>$apply['memberId']),$app);
	    		$mem->updateByCriteria(array('$set'=>array('renewal.payByCheck'=>$doc['payByCheck'])), array('_id'=>$apply['memberId']));
	    	}
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

	return $app['applicationEmails']($app,$id,$context='new-member-trial',$request);
})->before($mustbeADMIN);

/////////////
// APPROVE //
/////////////
$app->get('/application/{id}/approve/{type}', function ($id,$type, Request $request) use ($app) {
	//error_log('type:'.$type);
	$user = $app['session']->get('user');
	$user['suppress_emails'] = $request->get('suppress_emails');
	$app['session']->set('user',$user);
	return $app['applicationEmails']($app,$id,$context='new-member-welcome',$request);
})->before($mustbeADMIN);

///////////////
// MARK PAID //
///////////////
$app->get('/application/{id}/pay', function ($id, Request $request) use ($app) {
	
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
})->value('id','')
->before($mustbeMEMBER);

$app->get('/application/{id}/pay-other', function ($id, Request $request) use ($app) {
	
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
$app->post('/application/payment', function (Request $request) use ($app) {
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
	$paid = $application->fetchByStatus('PAID', $offset=0,$limit=$limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
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
	$approved = $application->fetchByStatus('APPROVED',$offset, $limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
	$trial = $application->fetchByStatus('TRIAL',$offset, $limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
	$paid = $application->fetchByDatePaidRange('Jan 1','now', $offset, $limit,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));

	$ncddtrialpromocode = $application->fetchByStatus('TRIAL',$offset, $limit,$filter=array('promocode'=>array('$in'=>array('TRIAL','DIVTRIAL','PDTRIAL','RFTRIAL','ALLENTRAPP'))));
	$allentrapptrialpromocode = $application->fetchByStatus('TRIAL',$offset, $limit,$filter=array('promocode'=>array('$in'=>array('ALLENTRAPP'))));
	$eagle2016promocode = $application->fetchByStatus('PAID',$offset, $limit,$filter=array('promocode'=>'EAGLE2016'));
	
	if(!empty($eagle2016promocode)):
	for ($i=0; $i < count($eagle2016promocode); $i++) { 
		switch ($eagle2016promocode[$i]['class']) {
	    	case 'ApplyNewMember':
	    		$reference = new Model\ReferenceMember(array('applicationId'=>$eagle2016promocode[$i]['_id']), $app);
	    		break;
	    	case 'ApplyNewSustainingMember':
	    		$reference = new Model\ReferenceSustainingMember(array('applicationId'=>$eagle2016promocode[$i]['_id']), $app);
	    		break;
	    	
	    }
	    $eagle2016promocode[$i]['new_references'] = array('total'=>$reference->getTotalSubmissions(),'max'=>$reference->getMaxSubmissions());
	}
	endif;

	// PROMOTIONS
	$promotion = new Model\Promotion(array('currentStatus'=>Model\Promotion::$status['NEWMEMBER']),$app);
	$promotions = $promotion->fetchByStatus();
	// count how many sign ups per promotion there have been.
	$promos = array();
	if(!empty($promotions) && is_array($promotions)):
		foreach ($promotions as $promo) {
			$obj = new Model\Apply(array(),$app);
			$new_applications = $obj->find(array('promotion.code'=>$promo['code']),$fields=array(),$slaveOkay=true,$sort=array('_id'=>-1),$offset=0,$limit=10000);

			for ($i=0; $i < count($new_applications); $i++) { 
				
				$member = new Model\Member(array('_id'=>$new_applications[$i]['memberId']),$app);
				$member = $member->findById();
				if(!empty($member) && is_array($member))
					$new_applications[$i]['member'] = $member;

				switch ($new_applications[$i]['class']) {
			    	case 'ApplyNewMember':
			    		$reference = new Model\ReferenceMember(array('applicationId'=>$new_applications[$i]['_id']), $app);
			    		break;
			    	case 'ApplyNewSustainingMember':
			    		$reference = new Model\ReferenceSustainingMember(array('applicationId'=>$new_applications[$i]['_id']), $app);
			    		break;
			    	
			    }
			    $new_applications[$i]['new_references'] = array('total'=>$reference->getTotalSubmissions(),'max'=>$reference->getMaxSubmissions());

			}

			$promos[$promo['code']] = $new_applications;
		}
	endif;

	$crumbs = array(array('name'=>'Applications','href'=>'/applications'));
	$view_vars = array(
						 'active'=>'Applications/New'
						,'page-plugin'=>'datatables'
						,'headline'=>'Applications'
						,'description'=>"<a class='btn green ' href='/application/new-member-admin'><i class='icon-plus'></i> New Member</a>&nbsp;<a class='btn green ' href='/application/new-expert-admin'><i class='icon-plus'></i> New Expert</a>"
						,'crumbs'=>$crumbs
						,'approved'=>$approved
						,'trial'=>$trial
						,'paid'=>$paid
						,'eagle2016promocode'=>$eagle2016promocode
						,'ncddtrialpromocode'=>$ncddtrialpromocode
						,'allentrapptrialpromocode'=>$allentrapptrialpromocode
						,'promos'=>$promos
	);
	return $app['view']->render('application/index', 'default', $view_vars);
})
->value('offset','0')
->value('limit','10000')
->before($mustbeADMIN);
//////////////////////////////////////////////////////////
// RENEWALS - MEMBERS WITH A CREDIT FOR MEMBERSHIP FEES //
//////////////////////////////////////////////////////////
$app->get('/renewalscredits/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$member = new Model\Member($doc=array(), $app);
	$renewals = $member->fetchByRenewalCredit($offset, $limit);
	
	$crumbs = array(array('name'=>'Renewals','href'=>'/renewals')
					,array('name'=>'Renewals - Credits','href'=>'/renewalscredits'));
	$view_vars = array(
						 'active'=>'Applications/RenewalCredits'
						,'page-plugin'=>'datatables'
						,'headline'=>'Renewals with credits'
						,'description'=>"View all renewals whose contact information has been updated."
						,'crumbs'=>$crumbs
						,'renewals'=>$renewals
						);
	return $app['view']->render('application/index-renewalscredits', 'default', $view_vars);
})
->value('offset','0')
->value('limit','20000')
->before($mustbeADMIN);
////////////////////////////////////////////
// RENEWALS - CONTACT INFORMATION UPDATES //
////////////////////////////////////////////
$app->get('/renewalscontacts/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$member = new Model\Member($doc=array(), $app);
	$renewals = array(
		'submitted'=>$member->fetchByRenewalStatus('SUBMITTED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit)
		,'approved'=>$member->fetchByRenewalStatus('APPROVED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit)
		,'paid'=>$member->fetchByRenewalStatus('PAID',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']), $offset, $limit)
	);
	
	$renewalsc = array();
	
	$r = array();
	$r_email = array();
	$r_bar = array();
	$r_listserv = array();
	$r_firmname = array();
	$r_address = array();
	$r_phone = array();

	$cnt = 0;
	for ($i=0; $i < count($renewals['submitted']); $i++) { 
		$renewalsc[$cnt]['applicationId'] = $renewals['submitted'][$i]['renewal']['applicationId'];
		$renewalsc[$cnt]['_id'] = $renewals['submitted'][$i]['_id'];
		$cnt++;
	}
	for ($i=0; $i < count($renewals['approved']); $i++) { 
		$renewalsc[$cnt]['applicationId'] = $renewals['approved'][$i]['renewal']['applicationId'];
		$renewalsc[$cnt]['_id'] = $renewals['approved'][$i]['_id'];
		$cnt++;
	}
	for ($i=0; $i < count($renewals['paid']); $i++) { 
		$renewalsc[$cnt]['applicationId'] = $renewals['paid'][$i]['renewal']['applicationId'];
		$renewalsc[$cnt]['_id'] = $renewals['paid'][$i]['_id'];
		$cnt++;
	}
	// retrieve applications whose contact info has been updated
	$r = array();
	for ($i=0; $i < count($renewalsc); $i++) { 
		
		$apply = new Model\Apply($doc=array('_id'=>$renewalsc[$i]['applicationId']), $app);
		$a = $apply->findById();
		
		if(!empty($a)){

			$member = new Model\Member($doc=array('_id'=>$renewalsc[$i]['_id']), $app);
			$member = $member->findById();
			$location = new Model\Location($doc=array('member'=>array('_id'=>$renewalsc[$i]['_id'])), $app);
			$location = $location->getByMemberId();

			
			/* field map...

			$member['displayName'] == $a['firstName'].' '.$a['middleName'].' '.$a['lastName']
			$member['email'] == $a['email']
			$member['barNumber'] == $a['barNumber']
			$a['addToListServ']
			$member['listServEmail'] == $a['listServEmail']
			

			$location['name'] == $a['firmName']
			$location['addressLine1'] == $a['address1']
			$location['addressLine2'] == $a['address2']
			$location['city'] == $a['city']
			$location['state'] == $a['state']
			$location['zip'] == $a['postalCode']
			$location['country'] == $a['country']
			$location['phone'] == $a['phone']
			$location['fax'] == $a['fax']
			
			*/
			if($member['email'] == 'johnson@emisonlaw.com'){
				//echo '<pre>';print_r($a);echo '</pre>';
				//echo '<pre>';print_r($member);echo '</pre>';
			}
			// remove applications from the list which are false positives meaning the update is pointless because it's an update of the same values
			// what remains should be the applications that truly have updated contact information
			$popfalse = 0;
			$popfalse_email = 0;
			$popfalse_bar = 0;
			$popfalse_listserv = 0;
			$popfalse_firmname = 0;
			$popfalse_address = 0;
			$popfalse_phone = 0;
			$popfalse_fax = 0;
			if(!empty($a['firstName']) || !empty($a['middleName']) || !empty($a['lastName'])){ 
				
				$tmp = explode(' ', $member['displayName']);
				if(count($tmp) > 2){
					if($member['displayName'] != $a['firstName'].' '.$a['middleName'].' '.$a['lastName']){
						$popfalse++;
					}
				}elseif(count($tmp) <= 2){
					if($member['displayName'] != $a['firstName'].' '.$a['lastName']){
						$popfalse++;
					}
				}

				
			}
			if(!empty($a['email']) 
				&& strtolower(trim($member['email'])) != strtolower(trim($a['email']))){
				$popfalse++;
				$popfalse_email++;
			}
			if(!empty($a['barNumber']) 
				&& strtolower(trim($member['barNumber'])) != strtolower(trim($a['barNumber']))){
				$popfalse++;
				$popfalse_bar++;
			}
			if((!empty($a['listServEmail']) 
				&& strtolower(trim($member['listServEmail'])) != strtolower(trim($a['listServEmail'])))
				|| ($a['addToListServ'] == 'yes') && !empty($a['listServEmail']) && strtolower(trim($member['listServEmail'])) == strtolower(trim($a['listServEmail']))){
				$popfalse++;
				$popfalse_listserv++;
			}
			if(!empty($a['firmName']) 
				&& strtolower(trim($location['name'])) != strtolower(trim($a['firmName']))){
				$popfalse++;
				$popfalse_firmname++;
			}

			if(!empty($a['address1']) 
				&& strtolower(trim($location['addressLine1'])) != strtolower(trim($a['address1']))){
				$popfalse++;
				$popfalse_address++;
			}
			if(!empty($a['address2']) 
				&& strtolower(trim($location['addressLine2'])) != strtolower(trim($a['address2']))){
				$popfalse++;
				$popfalse_address++;
			}
			if(!empty($a['city']) 
				&& strtolower(trim($location['city'])) != strtolower(trim($a['city']))){
				$popfalse++;
				$popfalse_address++;
			}
			if(!empty($a['state']) 
				&& strtolower(trim($location['state'])) != strtolower(trim($a['state']))){
				$popfalse++;
				$popfalse_address++;
			}
			if(!empty($a['postalcode']) 
				&& strtolower(trim($location['zip'])) != strtolower(trim($a['postalCode']))){
				$popfalse++;
				$popfalse_address++;
			}
			if(!empty($a['country']) 
				&& strtolower(trim($location['country'])) != strtolower(trim($a['country']))){
				$popfalse++;
				$popfalse_address++;
			}

			if(!empty($a['phone']) 
				&& strtolower(trim($location['phone'])) != strtolower(trim($a['phone']))){
				$popfalse++;
				$popfalse_phone++;
			}
			if(!empty($a['fax']) 
				&& strtolower(trim($location['fax'])) != strtolower(trim($a['fax']))){
				$popfalse++;
				$popfalse_fax++;
			}

			if($popfalse > 0){
				$r[] = $member;
			}
			if($popfalse_email > 0){
				$r_email[] = $member;
			}
			if($popfalse_bar > 0){
				$r_bar[] = $member;
			}
			if($popfalse_listserv > 0){
				$r_listserv[] = $member;
			}
			if($popfalse_firmname > 0){
				$r_firmname[] = $member;
			}
			if($popfalse_address > 0){
				$r_address[] = $member;
			}
			if($popfalse_phone > 0){
				$r_phone[] = $member;
			}

		}
	}
	
	
	$crumbs = array(array('name'=>'Renewals','href'=>'/renewals')
					,array('name'=>'Renewals - C','href'=>'/renewalscontacts'));
	$view_vars = array(
						 'active'=>'Applications/RenewalContacts'
						,'page-plugin'=>'datatables'
						,'headline'=>'Renewals - Contact Info Updates'
						,'description'=>"View all renewals whose contact information has been updated."
						,'crumbs'=>$crumbs
						,'renewals'=>$r
						,'renewals_email'=>$r_email
						,'renewals_bar'=>$r_bar
						,'renewals_listserv'=>$r_listserv
						,'renewals_firmname'=>$r_firmname
						,'renewals_address'=>$r_address
						,'renewals_phone'=>$r_phone
						);
	return $app['view']->render('application/index-renewalscontacts', 'default', $view_vars);
})
->value('offset','0')
->value('limit','20000')
->before($mustbeADMIN);

/**
AUTO-RENEW STARTS HERE
*/
///////////////////////
// AUTO-RENEW - SEED //
///////////////////////
$app->get('/renewalsautoseed', function (Request $request) use ($app) {

	ini_set('memory_limit','1024M');

	//*
	// safety can't re-seed if records already there.
	$ar = new Model\AutoRenew(array(),$app);
	$ar_res = $ar->find();
	if(!empty($ar_res)){
		return new Response('You have to purge AutoRenew in order to re-seed', 200,array('Content-Type' => 'text/html'));
	}
	//*/




	// GROUP BY PROMOTION then based on the payment.renewalREUSE in the member record.

	// INCLUDE
	// New members with NCDD2015  (recieved $50 discount if they sign up for auto-renew)
	// New members with NCDD2014  (recieved $50 discount if they sign up for auto-renew)
	

	// EXCLUDE 
	// New members with EAGLE2016- (2016 prepaid - and should be on auto-renew)
	// New Members with BONUS2015 (2016 prepaid - nothing about auto-renew)
	// Renewals    with RENEW2016 (happening now) (checked auto-renew [they had to to use the promo]. they received an eagle trophy.  exluded NCDD2015 and Public Defenders)

	// extreme filter - if card on file and haven't paid and not in exclude group then auto-renew

	// sanity check - only pass renewals that don't already have a payment record (in case folks forgot about the promos and did it on their own)
	// so, in that case I need to show them as paid here.

	// finally, create a new status with a dashboard message after the payment has been made.
	// let's not forget to send the email along with the payment receipt.

	// DETAILS - calculate if card on file has already expired and show it or show when it does expire.
	// 		   - sort the records based on credit card expiration date
	//		   - group declined cards and show the error and link to pop-up to update card
	//		   - make a separate script to run the cards on a schedule and print the schedule on the screen based on how many cards can run before the script timesout.

	// TABLE COLUMNS
	// before pay and after pay - promo | card badge linked to popup or no card badge (grey) | card exp date | card number | date promo used  | new member or renewal | member name | payment link to popup
	// declined - 				  promo | card badge linked to popup or no card badge (grey) | card exp date | card number | date promo used  | new member or renewal | member name | gateway error

	// the mongo query for everyone on autorenew and has a card on file.
	// db.member.find({status:2,'payment.renewalREUSE':'yes',currentMembership:10,listed:1,'payment.number':{$ne:null}}).count();

	$cnt = 0;
    $final_arr = array();

    $memberObj = new Model\Member($doc=array(), $app);    
    $members = $memberObj->find(array('payment.renewalREUSE'=>'yes','status'=>USER_STATUS_ACTIVE,'currentMembership'=>Model\Member::$membership['GENERAL MEMBER']),$fields=array(),true,$sort=array('payment.expYear'=>-1,'payment.expMonth'=>-1),0,10000);
    foreach ($members as $member){
        if($member['payment']['renewalREUSE'] == 'yes'){
            if(array_key_exists('number', $member['payment']) && !empty($member['payment']['number'])){
                $res_arr = array();
                $res_arr['_id'] = (string)$member['_id'];
                $res_arr['expMonth'] = $member['payment']['expMonth'];
                $res_arr['expYear'] = $member['payment']['expYear'];
                
                $date1 = strtotime($res_arr['expYear']."-".$res_arr['expMonth']."-01");
                $date2 = strtotime("2016-01-01");
                $res_arr['expired'] = ($date2 > $date1) ? 'yes' : 'no';

                $res_arr['name'] = $member['displayName'];
                $res_arr['email'] = $member['email'];
                $res_arr['payment'] = $member['payment'];

                if($res_arr['expired'] == 'yes'){
                	$final_arr['expired'][(string)$member['_id']] = $res_arr;
                }else{
                	$final_arr['valid'][(string)$member['_id']] = $res_arr;
                }
                
                $cnt++;    
            }
            
        }

    }
echo "<pre>start ";echo ' expired:'.count($final_arr['expired']).' valid:'.count($final_arr['valid']);echo "</pre>";
    // extract promos
	// EAGLE2016-
	// RENEW2016
	// BONUS2015
    $promo_arr = array();
    $application = new Model\Apply($doc=array(),$app);
    $res = $application->find(array('promocode'=>array('$in'=>array('EAGLE2016','BONUS2015'))),$fields=array(),true,$sort=array(),0,10000);
echo "<pre> eagle bonus: ";print_r(count($res));echo "</pre>";
    if(is_array($res)  && !empty($res)){
    	foreach($res as $item){
    		$promo_arr[(string)$item['memberId']] = 'something';
    	}
    }
    $res = $application->find(array('renewalpromocode'=>'RENEW2016'),$fields=array(),true,$sort=array(),0,10000);
echo "<pre> renew: ";print_r(count($res));echo "</pre>";    
    if(is_array($res)  && !empty($res)){
    	foreach($res as $item){
    		$promo_arr[(string)$item['memberId']] = 'something';
    	}
    }

    $final_arr['expired'] = array_diff_key($final_arr['expired'], $promo_arr);
    $final_arr['valid'] = array_diff_key($final_arr['valid'], $promo_arr);

echo "<pre>after promos ";echo ' expired:'.count($final_arr['expired']).' valid:'.count($final_arr['valid']);echo "</pre>";
	
	// sanity check - make sure last years promos are included
	
	$last_year_promo_arr = array();
    $application = new Model\Apply($doc=array(),$app);
    $res = $application->find(array('promocode'=>array('$in'=>array('NCDD2015','NCDD2014'))),$fields=array(),true,$sort=array(),0,10000);
echo "<pre> ncdd 2014 & 15: ";print_r(count($res));echo "</pre>";
	$past_promo_arr = array();
    if(is_array($res)  && !empty($res)){
    	foreach($res as $item){
    		if(!empty($item['memberId'])){
    			$memberObj = new Model\Member($doc=array('_id'=>$item['memberId']), $app);    
			    $member = $memberObj->findById();
			    if(!empty($member)){
				    
				        if($member['payment']['renewalREUSE'] == 'yes'){
				            if(array_key_exists('number', $member['payment']) && !empty($member['payment']['number'])){
				                $res_arr = array();
				                $res_arr['_id'] = (string)$member['_id'];
				                $res_arr['expMonth'] = $member['payment']['expMonth'];
				                $res_arr['expYear'] = $member['payment']['expYear'];
				                
				                $date1 = strtotime($res_arr['expYear']."-".$res_arr['expMonth']."-01");
				                $date2 = strtotime("2016-01-01");
				                $res_arr['expired'] = ($date2 > $date1) ? 'yes' : 'no';

				                $res_arr['name'] = $member['displayName'];
				                $res_arr['email'] = $member['email'];
				                $res_arr['payment'] = $member['payment'];

				                if($res_arr['expired'] == 'yes'){
				                	$past_promo_arr['expired'][(string)$member['_id']] = $res_arr;
				                }else{
				                	$past_promo_arr['valid'][(string)$member['_id']] = $res_arr;
				                }
				                
				                $cnt++;    
				            }
				            
				        }

				    
				}
    		}
    		
    	}
    }
echo "<pre> past promo arr expired: ";print_r(count($past_promo_arr['expired']));echo "</pre>";
echo "<pre> past promo arr valid: ";print_r(count($past_promo_arr['valid']));echo "</pre>";
	
	$past_promo_arr['expired'] = array_diff_key($past_promo_arr['expired'], $final_arr['expired']);
    $past_promo_arr['valid'] = array_diff_key($past_promo_arr['valid'], $final_arr['valid']);

echo "<pre>after past promos ";echo ' expired:'.count($final_arr['expired']).' valid:'.count($final_arr['valid']);echo "</pre>";
	
	// add folks who should be in the list...
	$final_arr['expired'] = array_merge($final_arr['expired'],$past_promo_arr['expired']);
	$final_arr['valid'] = array_merge($final_arr['valid'],$past_promo_arr['valid']);

echo "<pre>with sanity check including last years promos that got left out ";echo ' expired:'.count($final_arr['expired']).' valid:'.count($final_arr['valid']);echo "</pre>";
	
	







	// extract those who have already paid
	$memberObj = new Model\Member($doc=array(), $app);    
    $members = $memberObj->find(array('payment.renewalREUSE'=>'yes','status'=>USER_STATUS_ACTIVE,'currentMembership'=>Model\Member::$membership['GENERAL MEMBER']),$fields=array(),true,$sort=array('payment.expYear'=>-1,'payment.expMonth'=>-1),0,10000);
    $paid_arr = array();
    foreach ($members as $member){
        if(is_array($member['renewal']) && array_key_exists('paymentId', $member['renewal']) && !empty($member['renewal']['paymentId'])){
                    
            $paid_arr[(string)$member['_id']] = 'something';
            
        }

    }
    echo "<pre>paid_arr";print_r(count($paid_arr));echo "</pre>";
    $final_arr['expired'] = array_diff_key($final_arr['expired'], $paid_arr);
    $final_arr['valid'] = array_diff_key($final_arr['valid'], $paid_arr);
echo "<pre>after paid ";echo ' expired:'.count($final_arr['expired']).' valid:'.count($final_arr['valid']);echo "</pre>";
	

echo "<pre>final total ";print_r(count($final_arr['expired'])+count($final_arr['valid']));echo "</pre>";
	

	// now we have the final good array.
	
	




















	// now we run the audit array through the same exclusions
	$running_total = 0;
    $member_res = array();

    // NEW MEMBERS
    echo "<pre>";print_r('NEW MEMBERS');echo "</pre>";
    $apply  = new Model\Apply(array(),$app);
    
    $start  = 'Nov 5, 2014';
    $end    = 'Dec 4, 2014';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);

    echo "<pre>A total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);

    
    $start  = 'Dec 4, 2014';
    $end    = 'Dec 17, 2014';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>B total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);

    $start  = 'Dec 17, 2014';
    $end    = 'Dec 18, 2014';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>C total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);

    $start  = 'Dec 18, 2014';
    $end    = 'Jan 2, 2015';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>D total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);

    $start  = 'Jan 2, 2015';
    $end    = 'Feb 19, 2015';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>E total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);

    $start  = 'Feb 19, 2015';
    $end    = 'May 4, 2015';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>F total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);

    $start  = 'May 4, 2015';
    $end    = 'Oct 1, 2015';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>G total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);

    $start  = 'Oct 1, 2015';
    $end    = 'Nov 23, 2015';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>H total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);

    $start  = 'Nov 23, 2015';
    $end    = 'Nov 25, 2015';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>I total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);

    $start  = 'Nov 25, 2015';
    $end    = 'Nov 30, 2015';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>J total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);

    $start  = 'Nov 30, 2015';
    $end    = 'Jan 12, 2016';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>K total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);

    echo "<pre>running total:";print_r($running_total);echo "</pre>";


    $start  = 'Nov 5, 2014';
    $end    = 'Jan 12, 2016';
    $query  = array('class'=>'ApplyNewMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>inclusive total:";print_r(count($result));echo "</pre>";
    

    $running_total = 0;
    // Renewals
    echo "<pre>";print_r('RENEWALS:');echo "</pre>";
    $start  = 'Dec 4, 2014';
    $end    = 'Dec 9, 2014';
    $query  = array('class'=>'UpdateMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>A total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);
    
    $start  = 'Dec 9, 2014';
    $end    = 'Dec 10, 2014';
    $query  = array('class'=>'UpdateMember','termsAcknowledgement'=>'yes','payByCheck'=>'no-store','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>B total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);
    
    $start  = 'Dec 10, 2014';
    $end    = 'Dec 12, 2014';
    $query  = array('class'=>'UpdateMember','termsAcknowledgement'=>'yes','payByCheck'=>'no-store','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>C total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);
    
    
    $start  = 'Dec 12, 2014';
    $end    = 'Jan 2, 2015';
    $query  = array('class'=>'UpdateMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>D total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);
    
    
    $start  = 'Jan 2, 2015';
    $end    = 'Feb 27, 2015';
    $query  = array('class'=>'UpdateMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>E total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);
    
    $start  = 'Feb 27, 2015';
    $end    = 'May 4, 2015';
    $query  = array('class'=>'UpdateMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>F total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);
    
    $start  = 'May 4, 2015';
    $end    = 'Dec 5, 2015';
    $query  = array('class'=>'UpdateMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>G total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);
    
    $start  = 'Dec 5, 2015';
    $end    = 'Jan 4, 2016';
    $query  = array('class'=>'UpdateMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>H total:";print_r(count($result));echo "</pre>";
    $running_total+= count($result);
    
    echo "<pre>running total:";print_r($running_total);echo "</pre>";
    
    $start  = 'Dec 4, 2014';
    $end    = 'Jan 4, 2016';
    $query  = array('class'=>'UpdateMember','termsAcknowledgement'=>'yes','submittedDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
                                                ,'$lt'=>new \MongoDate(strtotime($end)))
        );
    $result = $apply->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
    for ($i=0; $i < count($result); $i++) { 
        $tmp[(string)$result[$i]['_id']] = $result[$i];
    }
    $member_res = array_merge($member_res,$tmp);
    
    echo "<pre>inclusive total:";print_r(count($result));echo "</pre>";
    
    echo "<pre>";print_r(count($member_res));echo "</pre>";

    foreach ($member_res as $member) {
    	$memObj = new Model\Member(array('_id'=>$member['memberId']),$app);
    	$members[] = $memObj->findById();
    }








	$cnt = 0;
    $final_arr_audit = array();

    foreach ($members as $member){
        if($member['payment']['renewalREUSE'] == 'yes'){
            if(array_key_exists('number', $member['payment']) && !empty($member['payment']['number'])){
                $res_arr = array();
                $res_arr['_id'] = (string)$member['_id'];
                $res_arr['expMonth'] = $member['payment']['expMonth'];
                $res_arr['expYear'] = $member['payment']['expYear'];
                
                $date1 = strtotime($res_arr['expYear']."-".$res_arr['expMonth']."-01");
                $date2 = strtotime("2016-01-01");
                $res_arr['expired'] = ($date2 > $date1) ? 'yes' : 'no';

                $res_arr['name'] = $member['displayName'];
                $res_arr['email'] = $member['email'];
                $res_arr['payment'] = $member['payment'];

                if($res_arr['expired'] == 'yes'){
                	$final_arr_audit['expired'][(string)$member['_id']] = $res_arr;
                }else{
                	$final_arr_audit['valid'][(string)$member['_id']] = $res_arr;
                }
                
                $cnt++;    
            }
            
        }

    }
echo "<pre>start ";echo ' expired:'.count($final_arr_audit['expired']).' valid:'.count($final_arr_audit['valid']);echo "</pre>";
    
	// extract promos
	// EAGLE2016-
	// RENEW2016
	// BONUS2015
    $promo_arr = array();
    $application = new Model\Apply($doc=array(),$app);
    $res = $application->find(array('promocode'=>array('$in'=>array('EAGLE2016','BONUS2015'))),$fields=array(),true,$sort=array(),0,10000);
echo "<pre> eagle bonus: ";print_r(count($res));echo "</pre>";
    if(is_array($res)  && !empty($res)){
    	foreach($res as $item){
    		$promo_arr[(string)$item['memberId']] = 'something';
    	}
    }
    $res = $application->find(array('renewalpromocode'=>'RENEW2016'),$fields=array(),true,$sort=array(),0,10000);
echo "<pre> renew: ";print_r(count($res));echo "</pre>";    
    if(is_array($res)  && !empty($res)){
    	foreach($res as $item){
    		$promo_arr[(string)$item['memberId']] = 'something';
    	}
    }

    $final_arr_audit['expired'] = array_diff_key($final_arr_audit['expired'], $promo_arr);
    $final_arr_audit['valid'] = array_diff_key($final_arr_audit['valid'], $promo_arr);

echo "<pre>after promos ";echo ' expired:'.count($final_arr_audit['expired']).' valid:'.count($final_arr_audit['valid']);echo "</pre>";
	
	// sanity check - make sure last years promos are included
	
	$last_year_promo_arr = array();
    $application = new Model\Apply($doc=array(),$app);
    $res = $application->find(array('promocode'=>array('$in'=>array('NCDD2015','NCDD2014'))),$fields=array(),true,$sort=array(),0,10000);
echo "<pre> ncdd 2014 & 15: ";print_r(count($res));echo "</pre>";
	$past_promo_arr = array();
    if(is_array($res)  && !empty($res)){
    	foreach($res as $item){
    		if(!empty($item['memberId'])){
    			$memberObj = new Model\Member($doc=array('_id'=>$item['memberId']), $app);    
			    $member = $memberObj->findById();
			    if(!empty($member)){
				    
				        if($member['payment']['renewalREUSE'] == 'yes'){
				            if(array_key_exists('number', $member['payment']) && !empty($member['payment']['number'])){
				                $res_arr = array();
				                $res_arr['_id'] = (string)$member['_id'];
				                $res_arr['expMonth'] = $member['payment']['expMonth'];
				                $res_arr['expYear'] = $member['payment']['expYear'];
				                
				                $date1 = strtotime($res_arr['expYear']."-".$res_arr['expMonth']."-01");
				                $date2 = strtotime("2016-01-01");
				                $res_arr['expired'] = ($date2 > $date1) ? 'yes' : 'no';

				                $res_arr['name'] = $member['displayName'];
				                $res_arr['email'] = $member['email'];
				                $res_arr['payment'] = $member['payment'];

				                if($res_arr['expired'] == 'yes'){
				                	$past_promo_arr['expired'][(string)$member['_id']] = $res_arr;
				                }else{
				                	$past_promo_arr['valid'][(string)$member['_id']] = $res_arr;
				                }
				                
				                $cnt++;    
				            }
				            
				        }

				    
				}
    		}
    		
    	}
    }
echo "<pre> past promo arr expired: ";print_r(count($past_promo_arr['expired']));echo "</pre>";
echo "<pre> past promo arr valid: ";print_r(count($past_promo_arr['valid']));echo "</pre>";
	
	$past_promo_arr['expired'] = array_diff_key($past_promo_arr['expired'], $final_arr_audit['expired']);
    $past_promo_arr['valid'] = array_diff_key($past_promo_arr['valid'], $final_arr_audit['valid']);

echo "<pre>after past promos ";echo ' expired:'.count($final_arr_audit['expired']).' valid:'.count($final_arr_audit['valid']);echo "</pre>";
	
	// add folks who should be in the list...
	$final_arr_audit['expired'] = array_merge($final_arr_audit['expired'],$past_promo_arr['expired']);
	$final_arr_audit['valid'] = array_merge($final_arr_audit['valid'],$past_promo_arr['valid']);

echo "<pre>with sanity check including last years promos that got left out ";echo ' expired:'.count($final_arr_audit['expired']).' valid:'.count($final_arr_audit['valid']);echo "</pre>";
	

	// extract those who have already paid
    $paid_arr = array();
    foreach ($members as $member){
        if(is_array($member['renewal']) && array_key_exists('paymentId', $member['renewal']) && !empty($member['renewal']['paymentId'])){
                    
            $paid_arr[(string)$member['_id']] = 'something';
            
        }

    }

    // need to first save the members who have paid and are in the final_arr_audit list so I can update their payment.renewalREUSE later
    $paid_arr_r = array();
    foreach ($final_arr_audit['expired'] as $key => $value) {
    	if(array_key_exists($key, $paid_arr)){
    		$paid_arr_r[$key] = 'yes';
    	}
    }
    foreach ($final_arr_audit['valid'] as $key => $value) {
    	if(array_key_exists($key, $paid_arr)){
    		$paid_arr_r[$key] = 'yes';
    	}
    }
    echo "<pre>paid_arr:";print_r(count($paid_arr));echo "</pre>";
    $final_arr_audit['expired'] = array_diff_key($final_arr_audit['expired'], $paid_arr);
    $final_arr_audit['valid'] = array_diff_key($final_arr_audit['valid'], $paid_arr);
echo "<pre>after paid ";echo ' expired:'.count($final_arr_audit['expired']).' valid:'.count($final_arr_audit['valid']);echo "</pre>";



echo "<pre>final total ";print_r(count($final_arr_audit['expired'])+count($final_arr_audit['valid']));echo "</pre>";









































	
	// the end resulting arrays will then be diffed.  i will diff the coded array from the audit array and vice versa.  
	// which ever result is greater will be the super set that will be added to the autorenew collection.


	$final_arr;
	$final_arr_audit;

	echo "<pre>final_arr count";print_r(count($final_arr['valid'])+count($final_arr['expired']));echo "</pre>";
	echo "<pre>final_arr_audit count";print_r(count($final_arr_audit['valid'])+count($final_arr_audit['expired']));echo "</pre>";

	// super set $final_arr
	$res_coded['expired'] = array_diff_key($final_arr['expired'], $final_arr_audit['expired']);
	$res_coded['valid'] = array_diff_key($final_arr['valid'], $final_arr_audit['valid']);
	
	echo "<pre>res_coded expired";print_r($res_coded['expired']);echo "</pre>";
	echo "<pre>res_coded valid";print_r($res_coded['valid']);echo "</pre>";

	// super set $final_arr_audit
	$res_audit['expired'] = array_diff_key($final_arr_audit['expired'], $final_arr['expired']);
	$res_audit['valid'] = array_diff_key($final_arr_audit['valid'], $final_arr['valid']);

	echo "<pre>res_audit expired";print_r($res_audit['expired']);echo "</pre>";
	echo "<pre>res_audit valid";print_r($res_audit['valid']);echo "</pre>";

	echo "<pre>res_audit expired count";print_r(count($res_audit['expired']));echo "</pre>";
	echo "<pre>res_audit valid count";print_r(count($res_audit['valid']));echo "</pre>";

	










































//* //
	$m = 1;
	foreach ($final_arr_audit as $key => $value) {
		foreach ($value as $record) {
			
			// need to reset each member's payment.renewalREUSE to 'yes' for each one of these members regardless of what it was.
			$member = new Model\Member(array('_id'=>$record['_id']),$app);
			$_update = $member->updateByCriteria(array('$set'=>array('payment.renewalREUSE'=>'yes')), array('_id'=>$member->_id));

			$ar_arr['record'] = $record;
		    $ar_arr['expired'] = ($key == 'expired') ? 'yes' : 'no';
		    $ar_arr['valid'] = ($key == 'valid') ? 'yes' : 'no';
		    
		    $ar = new Model\AutoRenew($ar_arr,$app);
		    $ar->insert();
		    $m++;
		}
	}

	// now need to reset all the paid people's payment.renewalREUSE because they were removed from the $final_arr_audit array.
	// $paid_arr looks like this >> $paid_arr[(string)$member['_id']] = 'something';
	$k = 1;
	foreach ($paid_arr_r as $key => $value) {
		// need to reset each member's payment.renewalREUSE to 'yes' for each one of these members regardless of what it was.
		$member = new Model\Member(array('_id'=>$key),$app);
		$_update = $member->updateByCriteria(array('$set'=>array('payment.renewalREUSE'=>'yes')), array('_id'=>$member->_id));		
		$k++;
	}

	echo "<pre>Auto renew total:";print_r($m);echo "</pre>";
	echo "<pre>Paid renewals total:";print_r($k);echo "</pre>";
//*/
	return new Response('', 200,array('Content-Type' => 'text/html'));
})
->before($mustbeADMIN);


$app->get('/renewalsautoseedsanitycheckagainstpayments', function ($offset, $limit, Request $request) use ($app) {

	$ar = new Model\AutoRenew(array(),$app);
	$res_autorenew = $ar->find(array(),$fields=array(),$slaveOkay=true,$sort=array(),0,100000);
	
	$pay  = new Model\Payment(array(),$app);
    
    
    $i=0;
    $res=0;
	if(!empty($res_autorenew) && is_array($res_autorenew)){
		for ($x=0; $x < count($res_autorenew); $x++) { 
			$value = $res_autorenew[$x];
			$memberId = new \MongoId($value['record']['_id']);

			$start  = 'Dec 1, 2015';
		    $end    = 'Feb 10, 2016';
		    $query  = array('memberId'=>$memberId,'ownerClass'=>'UpdateMember','paidDate.date'=>array(
		    	'$gte'=>new \MongoDate(strtotime($start))
		        ,'$lt'=>new \MongoDate(strtotime($end)))
		    );
		    $pay_res = $pay->find($query,$fields=array(),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=100000);
		    if(!empty($pay_res)){
		    	echo "<table cellspacing='5'>";
			    $res = 0;
			    foreach ($pay_res as $thepayment) {

	                $memObj = new Model\Member(array('_id'=>$thepayment['memberId']),$app);
	                $memObj->findById();
	                echo "<tr>";
	                echo "<td>".$memObj->displayName.'</td><td> pfb </td><td>'.$thepayment['name'].'</td><td>'.$thepayment['_id'].'</td>';
	                echo "</tr>";
	                $res++;
		        	$del_ar = new Model\AutoRenew(array('_id'=>$value['_id']),$app);
		        	$del_ar->delete();
			    }
			    echo "</table>";
		    }

		}
	}
	return new Response('total autorenew:'.count($res_autorenew).' total dups:'.$res,200,array('Content-Type' => 'text/html'));
})
->value('offset','0')
->value('limit','20000')
->before($mustbeADMIN);


///////////////////////
// AUTO-RENEW - VIEW //
///////////////////////
$app->get('/renewalsauto/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {

	$ar = new Model\AutoRenew(array(),$app);
	$ar_res = $ar->find(array(),$fields=array(),$slaveOkay=true,$sort=array(),$offset,$limit);
	$valid = $ar->find(array('valid'=>'yes'),$fields=array(),$slaveOkay=true,$sort=array('record.payment.expYear'=>1,'record.payment.expMonth'=>1),$offset,$limit);
	$expired = $ar->find(array('expired'=>'yes'),$fields=array(),$slaveOkay=true,$sort=array('record.payment.expYear'=>1,'record.payment.expMonth'=>1),$offset,$limit);
	$declined = $ar->find(array('declined'=>'yes'),$fields=array(),$slaveOkay=true,$sort=array('record.payment.expYear'=>1,'record.payment.expMonth'=>1),$offset,$limit);
	//$paid = $ar->find(array('paid'=>'yes'),$fields=array(),$slaveOkay=true,$sort=array('paymentId'=>1),$offset,$limit);
	$member = new Model\Member($doc=array(), $app);
	$paid = $member->fetchByRenewalStatus('AUTOPAY',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']), $offset, $limit);
	$grand_total = 0;
	$grand_total += (is_array($valid)) ? count($valid) : 0;
	$grand_total += (is_array($expired)) ? count($expired) : 0;
	$grand_total += (is_array($declined)) ? count($declined) : 0;
	$grand_total += (is_array($paid)) ? count($paid) : 0;

	$crumbs = array(array('name'=>'Renewals','href'=>'/renewals')
					,array('name'=>'Renewals - Auto Renew','href'=>'/renewalsauto'));
	$view_vars = array(
						 'active'=>'Applications/RenewalAuto'
						,'page-plugin'=>'datatables'
						,'headline'=>'Members marked for auto-renew'
						,'description'=>""
						,'crumbs'=>$crumbs
						,'ar_res'=>$ar_res
						,'valid'=>$valid
						,'expired'=>$expired
						,'declined'=>$declined
						,'paid'=>$paid
						,'grand_total'=>$grand_total
						);

	return $app['view']->render('application/index-renewalsauto', 'default', $view_vars);
})
->value('offset','0')
->value('limit','20000')
->before($mustbeADMIN);

/////////////////////////
// AUTO-RENEW - CHARGE //
/////////////////////////
$app->get('/renewalsautocharge', function (Request $request) use ($app) {
	

// DERIVE MEMBERSHIP DUES

		$ar = new Model\AutoRenew(array(),$app);
		$valid = $ar->find(array('valid'=>'yes'),$fields=array(),$slaveOkay=true,$sort=array('record.payment.expYear'=>1,'record.payment.expMonth'=>1),0,100000);
		$expired = $ar->find(array('expired'=>'yes'),$fields=array(),$slaveOkay=true,$sort=array('record.payment.expYear'=>1,'record.payment.expMonth'=>1),0,100000);
		
		$i=0;
		$valid_found = 0;
		$valid_found2 = 0;
		if(!empty($valid) && is_array($valid)):
			for ($x=0; $x < count($valid); $x++) { 
				$value = $valid[$x];

				// derive membership dues:
				// new app = yearsInLawPractice
				// renewal = membershipDues - 6+ = $225, <6 $175, pd $50
				
				$um = new Model\Apply(array(),$app);
				$um_res = $um->find(array('class'=>'UpdateMember','memberId'=>new \MongoId($value['record']['_id'])),array('membershipDues'=>1));
				if(!empty($um_res)){
					$valid_found++;
					$membershipDues = $um_res[0]['membershipDues'];
					$valid[$x]['membershipDues'] = $membershipDues;
				}else{

					// look in new member apps
					$nm = new Model\Apply(array(),$app);
					$nm_res = $nm->find(array('class'=>'ApplyNewMember','memberId'=>new \MongoId($value['record']['_id'])),array('yearsInLawPractice'=>1));
					if(!empty($nm_res)){
						$valid_found2++;
						if(((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) > 1000){
							$membershipDues = ( (int)$nm_res[0]['yearsInLawPractice'] >= 6) ? 225 : 175;
						}else{
							$membershipDues = ( ((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) >= 6) ? 225 : 175;
						}
						$valid[$x]['membershipDues'] = $membershipDues;
						//error_log('A: '.print_r($membershipDues,true));
					}else{
						echo "<pre>";print_r($value['record']['_id']);echo "</pre>";
					}
				}
				// sanity check for public defenders
				$pd = new Model\Member(array('_id'=>$value['record']['_id']),$app);
				$pd = $pd->findById();
				if($pd['currentMembership'] == Model\Member::$membership['PUBLIC DEFENDER']){
					$valid[$x]['membershipDues'] = 50;
				}
				$i++;
			}	
		endif; 
		echo "valid: ".$i." found:".$valid_found." found2:".$valid_found2."<br><br>";
		$i=0;
		$expired_found = 0;
		$expired_found2 = 0;
		if(!empty($expired) && is_array($expired)):
			for ($x=0; $x < count($expired); $x++) { 
				$value = $expired[$x];
				// update the expYear in an attempt to charge the card
				$expired[$x]['record']['payment']['expYear'] = 2017;
				
				// derive membership dues:
				// new app = yearsInLawPractice
				// renewal = membershipDues - 6+ = $225, <6 $175, pd $50
				
				$um = new Model\Apply(array(),$app);
				$um_res = $um->find(array('class'=>'UpdateMember','memberId'=>new \MongoId($value['record']['_id'])),array('membershipDues'=>1));
				if(!empty($um_res)){
					$expired_found++;
					$membershipDues = $um_res[0]['membershipDues'];
					$expired[$x]['membershipDues'] = $membershipDues;
				}else{

					// look in new member apps
					$nm = new Model\Apply(array(),$app);
					$nm_res = $nm->find(array('class'=>'ApplyNewMember','memberId'=>new \MongoId($value['record']['_id'])),array('yearsInLawPractice'=>1));
					if(!empty($nm_res)){
						$expired_found2++;
						if(((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) > 1000){
							$membershipDues = ( (int)$nm_res[0]['yearsInLawPractice'] >= 6) ? 225 : 175;
						}else{
							$membershipDues = ( ((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) >= 6) ? 225 : 175;
						}
						$expired[$x]['membershipDues'] = $membershipDues;
						//error_log('B: '.print_r($membershipDues,true));
					}else{
						//echo "<pre>";print_r($value['record']['_id']);echo "</pre>";
					}
				}
				// sanity check for public defenders
				$pd = new Model\Member(array('_id'=>$value['record']['_id']),$app);
				$pd = $pd->findById();
				if($pd['currentMembership'] == Model\Member::$membership['PUBLIC DEFENDER']){
					$expired[$x]['membershipDues'] = 50;
				}
				$i++;
			}
		endif; 
		echo "expired: ".$i." found:".$expired_found." found2:".$expired_found2."<br><br>";
		
		echo "<pre>count(valid):";print_r((!empty($valid) && is_array($valid)) ? count($valid) : 0);echo "</pre>";
		echo "<pre>count(expired):";print_r(count($expired));echo "</pre>";
		
// MEMBERSHIP DUES HAVE BEEN DERIVED
// COMBINE THE ARRAYS since the expYear on the expired cards has been updated 
		$finalArr = (is_array($expired) && is_array($valid)) ? array_merge($valid,$expired) : $valid;
		$run = (count($finalArr) >= 10) ? 10: count($finalArr);
		for ($x=0; $x < $run; $x++) { 
			$value = $finalArr[$x];
echo "<pre>";print_r($value);echo "</pre>";
			$memberId = $value['record']['_id'];
			$member = new Model\Member(array('_id'=>$memberId),$app);
			$member = $member->findById();
			$location = new Model\Location(array('member'=>$member),$app);
			$location = $location->getByMemberId();



// PREPARE APPLICATION				
			$doc['memberId'] = new \MongoId($memberId);
			$doc['email'] = $member['email'];
			$doc['firstName'] = $member['firstName'];
			$doc['lastName'] = $member['lastName'];
			$doc['currentStatus'] = Model\Apply::$status['DRAFT'];
			$doc['approvedDate'] = new \stdClass();
			$doc['submittedDate'] = new \stdClass();
			$doc['paidDate'] = new \stdClass();
			$doc['paymentId'] = new \stdClass();
			$doc['membershipDues'] = $value['membershipDues'];

			$application = new Model\UpdateMember($doc, $app);
			$app_id = $application->insert();	
			
// MAKE THE PAYMENT



			/////////////////////////////////
			// prepare their correct total //
			/////////////////////////////////
			$pro_rate = array('q'=>0,'a'=>0);
			$discount = 0;
			 // CREDIT DISCOUNT FOR MEMBERS WHO HOLD A CREDIT WITH US
			$discount2 = 0;
			if(array_key_exists('payment',$member) 
			      && !empty($member['payment'])
			      && is_array($member['payment'])
			      && array_key_exists('renewalCredit',$member['payment'])
			      && !empty($member['payment']['renewalCredit'])
			      && $member['payment']['renewalCredit'] > 0
			): 
			   $discount2  = $member['payment']['renewalCredit'];
			endif;
		                       
		    $amount = $value['membershipDues'];

		    $new_renewal_credit = null;
		    $amount = $amount-$discount-$discount2;
		    if($amount < 0 && !empty($discount2)){
		    	$new_renewal_credit = abs($amount);
		    }else if($amount > 0 && !empty($discount2)){
		    	$new_renewal_credit = '-';
		    }
		    $amount = ($amount <= 0) ? 0:$amount;
		    
		    ////////////////////////////////////////////////////////////////////////////////
			// activate a manual charge and create receipt - only if the declineCount = 0 //
			// if it's more than zero then the card must be updated 					  //
			////////////////////////////////////////////////////////////////////////////////

			$doc['memberId'] = $memberId;
			$doc['ownerId'] = $app_id;
			$doc['ownerClass'] = 'UpdateMember';
			$doc['description'] = 'INV-'.time();
			$doc['title'] = 'UPDATE MEMBER APPLICATION';
			$doc['firstName'] = $member['firstName'];
			$doc['lastName'] = $member['lastName'];
			$doc['email'] = '';
			$doc['phone'] = '';
			$doc['addressLine1'] = $value['record']['payment']['addressLine1'];
			$doc['addressLine2'] = $value['record']['payment']['addressLine2'];
			$doc['city'] = $value['record']['payment']['city'];
			$doc['stateProvinceRegion'] = $value['record']['payment']['stateProvinceRegion'];
			$doc['zipPostalCode'] = $value['record']['payment']['zipPostalCode'];
			$doc['country'] = $value['record']['payment']['country'];
			$doc['amount'] = $amount;
			$doc['expMonth'] = $value['record']['payment']['expMonth'];
			$doc['expYear'] = $value['record']['payment']['expYear'];
			$doc['number'] = str_replace('.x', '', $value['record']['payment']['number']);
			//$doc['number'] = $member['payment']['number'];
			$doc['cvc'] = str_replace('.x', '', $value['record']['payment']['cvc']);
			$doc['name'] = $value['record']['payment']['name'];
			// prepare the invoice
			$application = new Model\Apply(array('_id'=>$app_id),$app);
			$application = $application->findById($id='_id', $fields=array(), $slaveOkay=false);

		   	$doc['invoiceBlock'] = $app['view']->element('invoice-block',array('application'=>$application,'member'=>$member,'location'=>$location,'pro_rated_membership_dues'=>$pro_rate));
			$payment = new Model\Payment($doc,$app);

			try {
				$app['validateModel']($app, $payment,$groups=array('cc'));	
			} catch (Exception $e) {
				error_log(__FILE__.' '.__LINE__.' for variable: payment  ==>'.print_r($payment,true));
				throw new \Saw\Exceptions\SawException(new \Saw\Exceptions\PaymentException(),$e->getMessage());
			}
			
			try {


				error_log(': '.print_r('AAA',true));
				$paymentId = $payment->charge();	
// update auto-renew record				
				$ar_doc['_id'] = $value['_id'];
				$ar_doc['paid'] = 'yes';
				$ar_doc['expired'] = 'no';
				$ar_doc['valid'] = 'no';
				$ar_doc['declined'] = 'no';
				$ar_doc['declinedMessage'] = '-';
				$ar_doc['paymentId'] = $paymentId;
				$ar = new Model\AutoRenew($ar_doc,$app);
				$ar->saveSafe();
// update application with paymentid and paid date
				$appl = new Model\Apply(array('_id'=>$app_id, 'paymentId'=>$paymentId,'paidDate'=>new Model\Date($app, 'now')), $app);
				$appl->saveSafe();
// update member's renewal credit 
				$tpaymnt = $member['payment'];
		    	$tpaymnt['declineCount'] = 0;
		    	if(!is_null($new_renewal_credit))
		    		$tpaymnt['renewalCredit'] = $new_renewal_credit;
		    	$tmem = new Model\Member(array('_id'=>$application['memberId'],'payment'=>$tpaymnt),$app);
		    	$tmem->saveSafe();

// PREPARE THE RENEWAL ARRAY IN THE MEMBER RECORD
				$mem['renewal']['applicationId'] = $app_id; 
				$mem['renewal']['currentStatus'] = Model\Renewal::$status['AUTOPAY'];
				$mem['renewal']['submittedDate'] = new \stdClass();
				$mem['renewal']['approvedDate'] = new \stdClass();
				$mem['renewal']['paidDate'] = new Model\Date($app, 'now');
				$mem['renewal']['paymentId'] = $paymentId;
				$mem['renewal']['payByCheck'] = 'no';

				$renewal = new Model\Renewal($mem['renewal'],$app);
				$renewal->setRenewalByMember($memberId);


// PREPARE TO SEND THE EMAIL
				$subject = 'NCDD Membership Dues Payment Received';
				$to = $member['email'];
				$view_vars = array('firstName'=>$member['firstName']
									,'middleName'=>(array_key_exists('middleName', $member)) ? $member['middleName'] : ''
									,'lastName'=>$member['lastName']
									,'membershipDues'=>$value['membershipDues']
				);
				$body = $app['view']->render('email/auto-pay-payment-thankyou','email', $view_vars);
				
				$app['sendMail']($subject, $body, $to);
				
			} catch (Exception $e) {
				error_log(': '.print_r('BBB',true));
				$ar_doc['_id'] = $value['_id'];
				$ar_doc['paid'] = 'no';
				$ar_doc['expired'] = 'no';
				$ar_doc['valid'] = 'no';
				$ar_doc['paymentId'] = new \stdClass();
				$ar_doc['declined'] = 'yes';
				$ar_doc['declinedMessage'] = $e->getMessage();
				$ar = new Model\AutoRenew($ar_doc,$app);
				$ar->saveSafe();

			}


		error_log('x '.$x.' of '.count($x));
		} // end for


	
	return new Response('', 200,array('Content-Type' => 'text/html'));
});



/////////////////////////
// credit card screens // 
/////////////////////////
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

























/////////////////////////////////////////////////
// AUTO-RENEW SEND DECLINED CC FOLLOW UP EMAIL //
///////////////////////////////////////////////// 
$app->get('/renewals-send-decline-followup-email', function (Request $request) use ($app) {
return false;
	$ar = new Model\AutoRenew(array('declined'=>'yes'),$app);
	$ar_res = $ar->findAllById('declined', $fields=array(), $sort=array(), $slaveOkay=true,$offset=0,$limit=2000);
	$i=0;
	foreach ($ar_res as $autorenew) {

		$member = new Model\Member(array('_id'=>$autorenew['record']['_id']),$app);
		$member = $member->findById();


		$subject = 'NCDD Membership Auto Renewal';
		$to = $member['email'];
		$view_vars = array('firstName'=>$member['firstName']
							,'middleName'=>(array_key_exists('middleName', $member)) ? $member['middleName'] : ''
							,'lastName'=>$member['lastName']
							,'securelink'=>'https://'.SAW_ADMIN_WEBSITE.'/renewals-autopay/'.$autorenew['_id']
		);
		$body = $app['view']->render('email/auto-pay-cc-decline-follow-up','email', $view_vars);
		if(!empty($to)){
			error_log('$to: '.print_r($to,true));
		}else{
			error_log('securlink: '.print_r($view_vars['securelink'],true));
		}
		echo "<pre>";print_r($to);echo "</pre>";
		echo "<pre>";print_r($body);echo "</pre>";
		$app['sendMail']($subject, $body, $to);
		error_log('$i: '.print_r($i,true));
		$i++;
	}

	return new Response('', 200,array('Content-Type' => 'text/html'));
})->before($mustbeADMIN);


// renewal auto-pay follow up to update thier card and pay
// screen
$app->get('/renewals-autopay/{autoRenewId}', function ($autoRenewId, Request $request) use ($app) {

	$ar = new Model\AutoRenew(array('_id'=>$autoRenewId),$app);
	$ar_res = $ar->findById();

	if(is_array($ar_res) && !empty($ar_res) && $ar_res['paid'] == 'yes' && !empty($ar_res['paymentId'])){
		$view_vars = array(
						'headline'=>'Membership Renewal Payment Verification'
						,'description'=>"Update your payment information to renew your membership."
						,'ar_res'=>$ar_res
						);
		return $app['view']->render('application/renewal-cc-decline-follow-up-already-paid', 'blank', $view_vars);
	}

	$member = new Model\Member(array('_id'=>$ar_res['record']['_id']),$app);
	$member = $member->findById();



	// derive membership dues:
	// new app = yearsInLawPractice
	// renewal = membershipDues - 6+ = $225, <6 $175, pd $50
	$um = new Model\Apply(array(),$app);
	$um_res = $um->find(array('class'=>'UpdateMember','memberId'=>$member['_id']),array('membershipDues'=>1));
	if(!empty($um_res)){
		$membershipDues = $um_res[0]['membershipDues'];
	}else{

		// look in new member apps
		$nm = new Model\Apply(array(),$app);
		$nm_res = $nm->find(array('class'=>'ApplyNewMember','memberId'=>$member['_id']),array('yearsInLawPractice'=>1));
		if(!empty($nm_res)){
			$expired_found2++;
			if(((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) > 1000){
				$membershipDues = ( (int)$nm_res[0]['yearsInLawPractice'] >= 6) ? 225 : 175;
			}else{
				$membershipDues = ( ((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) >= 6) ? 225 : 175;
			}
		}
	}
	// sanity check for public defenders
	$pd = new Model\Member(array('_id'=>$member['_id']),$app);
	$pd = $pd->findById();
	if($pd['currentMembership'] == Model\Member::$membership['PUBLIC DEFENDER']){
		$membershipDues = 50;
	}


	$view_vars = array(
						'headline'=>'Membership Renewal Payment Verification'
						,'description'=>"Update your payment information to renew your membership."
						,'ar_res'=>$ar_res
						,'membershipDues'=>$membershipDues
						);
	if(is_array($ar_res) && array_key_exists('payment',$ar_res['record']) && is_array($ar_res['record']['payment']) && !empty($ar_res['record']['payment']) && array_key_exists('number', $ar_res['record']['payment'])){
		$ar_res['record']['payment']['cvc'] = str_replace('.x', '', $ar_res['record']['payment']['cvc']);
		$ar_res['record']['payment']['number'] = str_replace('.x', '', $ar_res['record']['payment']['number']);
		$ar_res['record']['payment']['number'] = (!empty($ar_res['record']['payment']['number'])) ? '...'.substr($ar_res['record']['payment']['number'], -4) :'';	
		$view_vars['payment'] = $ar_res['record']['payment'];
	}else{
		$view_vars['payment'] = array();
	}

	$view_vars['post-url'] = '/renewals-autopay';

	return $app['view']->render('application/renewal-cc-decline-follow-up', 'blank', $view_vars);
    
});

// post 
$app->post('/renewals-autopay', function (Request $request) use ($app) {
	// retrieve document from request
    $orig_doc = $request->get('doc');
    $ar = new Model\AutoRenew(array('_id'=>$orig_doc['_id']),$app);
    $ar_res = $ar->findById();
    $member = new Model\Member(array('_id'=>$ar_res['record']['_id']),$app);
    $member = $member->findById();

    // derive membership dues:
	// new app = yearsInLawPractice
	// renewal = membershipDues - 6+ = $225, <6 $175, pd $50
	$um = new Model\Apply(array(),$app);
	$um_res = $um->find(array('class'=>'UpdateMember','memberId'=>$member['_id']),array('membershipDues'=>1));
	if(!empty($um_res)){
		$membershipDues = $um_res[0]['membershipDues'];
	}else{

		// look in new member apps
		$nm = new Model\Apply(array(),$app);
		$nm_res = $nm->find(array('class'=>'ApplyNewMember','memberId'=>$member['_id']),array('yearsInLawPractice'=>1));
		if(!empty($nm_res)){
			$expired_found2++;
			if(((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) > 1000){
				$membershipDues = ( (int)$nm_res[0]['yearsInLawPractice'] >= 6) ? 225 : 175;
			}else{
				$membershipDues = ( ((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) >= 6) ? 225 : 175;
			}
		}
	}
	// sanity check for public defenders
	$pd = new Model\Member(array('_id'=>$member['_id']),$app);
	$pd = $pd->findById();
	if($pd['currentMembership'] == Model\Member::$membership['PUBLIC DEFENDER']){
		$membershipDues = 50;
	}


	// pay
	

	$location = new Model\Location(array('member'=>$member),$app);
	$location = $location->getByMemberId();



// PREPARE APPLICATION				
	$doc['memberId'] = $member['_id'];
	$doc['email'] = $member['email'];
	$doc['firstName'] = $member['firstName'];
	$doc['lastName'] = $member['lastName'];
	$doc['currentStatus'] = Model\Apply::$status['DRAFT'];
	$doc['approvedDate'] = new \stdClass();
	$doc['submittedDate'] = new \stdClass();
	$doc['paidDate'] = new \stdClass();
	$doc['paymentId'] = new \stdClass();
	$doc['membershipDues'] = $membershipDues;

	if(!empty($member['renewal']['applicationId'])){
		$app_id = $member['renewal']['applicationId'];
	}else{
		$application = new Model\UpdateMember($doc, $app);
		$app_id = $application->insert();		
	}
	
	
// MAKE THE PAYMENT



	/////////////////////////////////
	// prepare their correct total //
	/////////////////////////////////
	$pro_rate = array('q'=>0,'a'=>0);
	$discount = 0;
	 // CREDIT DISCOUNT FOR MEMBERS WHO HOLD A CREDIT WITH US
	$discount2 = 0;
	if(array_key_exists('payment',$member) 
	      && !empty($member['payment'])
	      && is_array($member['payment'])
	      && array_key_exists('renewalCredit',$member['payment'])
	      && !empty($member['payment']['renewalCredit'])
	      && $member['payment']['renewalCredit'] > 0
	): 
	   $discount2  = $member['payment']['renewalCredit'];
	endif;
                       
    $amount = $membershipDues;

    $new_renewal_credit = null;
    $amount = $amount-$discount-$discount2;
    if($amount < 0 && !empty($discount2)){
    	$new_renewal_credit = abs($amount);
    }else if($amount > 0 && !empty($discount2)){
    	$new_renewal_credit = '-';
    }
    $amount = ($amount <= 0) ? 0:$amount;
    
    ////////////////////////////////////////////////////////////////////////////////
	// activate a manual charge and create receipt - only if the declineCount = 0 //
	// if it's more than zero then the card must be updated 					  //
	////////////////////////////////////////////////////////////////////////////////

	$doc['memberId'] = $member['_id'];
	$doc['ownerId'] = $app_id;
	$doc['ownerClass'] = 'UpdateMember';
	$doc['description'] = 'INV-'.time();
	$doc['title'] = 'UPDATE MEMBER APPLICATION';
	$doc['firstName'] = $member['firstName'];
	$doc['lastName'] = $member['lastName'];
	$doc['email'] = '';
	$doc['phone'] = '';
	$doc['addressLine1'] = $orig_doc['addressLine1'];
	$doc['addressLine2'] = $orig_doc['addressLine2'];
	$doc['city'] = $orig_doc['city'];
	$doc['stateProvinceRegion'] = $orig_doc['stateProvinceRegion'];
	$doc['zipPostalCode'] = $orig_doc['zipPostalCode'];
	$doc['country'] = $orig_doc['country'];
	$doc['amount'] = $amount;
	$doc['expMonth'] = $orig_doc['expMonth'];
	$doc['expYear'] = $orig_doc['expYear'];
	$doc['number'] = str_replace('.x', '', (strpos($orig_doc['number'], '...') !== false) ? $ar_res['record']['payment']['number'] : $orig_doc['number']);
	error_log('xxxxxx------xxxxxxx-----xxxxxx------number: '.print_r($doc['number'],true));
	//$doc['number'] = $member['payment']['number'];
	$doc['cvc'] = str_replace('.x', '', $orig_doc['cvc']);
	$doc['name'] = $ar_res['record']['payment']['name'];
	// prepare the invoice
	$application = new Model\Apply(array('_id'=>$app_id),$app);
	$application = $application->findById($id='_id', $fields=array(), $slaveOkay=false);

   	$doc['invoiceBlock'] = $app['view']->element('invoice-block',array('application'=>$application,'member'=>$member,'location'=>$location,'pro_rated_membership_dues'=>$pro_rate));
	$payment = new Model\Payment($doc,$app);

	try {
		$app['validateModel']($app, $payment,$groups=array('cc'));	
	} catch (Exception $e) {
		error_log(__FILE__.' '.__LINE__.' for variable: payment  ==>'.print_r($payment,true));
		throw new \Saw\Exceptions\SawException(new \Saw\Exceptions\PaymentException(),$e->getMessage());
	}
	
	try {
		$paymentId = $payment->charge();	
	} catch (Exception $e) {
		error_log('hererererererererere: '.print_r('hererererererererere',true));
		$ar_doc['_id'] = $ar_res['_id'];
		$ar_doc['paid'] = 'no';
		$ar_doc['expired'] = 'no';
		$ar_doc['valid'] = 'no';
		$ar_doc['paymentId'] = new \stdClass();
		$ar_doc['declined'] = 'yes';
		$ar_doc['declinedMessage'] = $e->getMessage();
		$ar = new Model\AutoRenew($ar_doc,$app);
		$ar->saveSafe();

		return new Response(json_encode(array('message' => $ar_doc['declinedMessage'])), 400,array('Content-Type' => 'application/json'));

	}
	try {

// update auto-renew record				
		$ar_res['paid'] = 'yes';
		$ar_res['expired'] = 'no';
		$ar_res['valid'] = 'no';
		$ar_res['declined'] = 'no';
		$ar_res['declinedMessage'] = '-';
		$ar_res['expMonth'] = $orig_doc['expMonth'];
		$ar_res['expYear'] = $orig_doc['expYear'];
		$ar_res['paymentId'] = $paymentId;
		$ar_res['payment']['addressLine1'] = $orig_doc['addressLine1'];
		$ar_res['payment']['addressLine2'] = $orig_doc['addressLine2'];
		$ar_res['payment']['city'] = $orig_doc['city'];
		$ar_res['payment']['stateProvinceRegion'] = $orig_doc['stateProvinceRegion'];
		$ar_res['payment']['zipPostalCode'] = $orig_doc['zipPostalCode'];
		$ar_res['payment']['country'] = $orig_doc['country'];
		$ar_res['payment']['expMonth'] = $orig_doc['expMonth'];
		$ar_res['payment']['expYear'] = $orig_doc['expYear'];
		$ar_res['payment']['number'] = (strpos($orig_doc['number'], '...') !== false) ? $ar_res['record']['payment']['number'] : $orig_doc['number'].'.x';
		$ar_res['payment']['cvc'] = $orig_doc['cvc'];
		$ar_res['payment']['name'] = $orig_doc['name'];

		$ar = new Model\AutoRenew($ar_res,$app);
		$ar->saveSafe();
// update application with paymentid and paid date
		$appl = new Model\Apply(array('_id'=>$app_id, 'paymentId'=>$paymentId,'paidDate'=>new Model\Date($app, 'now')), $app);
		$appl->saveSafe();
// update member's renewal credit 
		$plite = new Model\PaymentLite($ar_res['payment'],$app);
		$tpaymnt = $plite->__toArray();
    	$tpaymnt['renewalREUSE'] = 'yes';
    	$tpaymnt['declineCount'] = 0;

    	if(!is_null($new_renewal_credit))
    		$tpaymnt['renewalCredit'] = $new_renewal_credit;
    	$tmem = new Model\Member(array('_id'=>$application['memberId'],'payment'=>$tpaymnt),$app);
    	$tmem->saveSafe();

// PREPARE THE RENEWAL ARRAY IN THE MEMBER RECORD
		$mem['renewal']['applicationId'] = $app_id; 
		$mem['renewal']['currentStatus'] = Model\Renewal::$status['AUTOPAY'];
		$mem['renewal']['submittedDate'] = new \stdClass();
		$mem['renewal']['approvedDate'] = new \stdClass();
		$mem['renewal']['paidDate'] = new Model\Date($app, 'now');
		$mem['renewal']['paymentId'] = $paymentId;
		$mem['renewal']['payByCheck'] = 'no';

		$renewal = new Model\Renewal($mem['renewal'],$app);
		$renewal->setRenewalByMember($member['_id']);

// PREPARE SERVER RESPONSE MESSAGE
		$message = 'Thank you for renewing your NCDD membership.  An email confirmation has been sent to your address on file.';

// PREPARE TO SEND THE EMAIL
		$subject = 'NCDD Membership Dues Payment Received';
		$to = $member['email'];
		$view_vars = array('firstName'=>$member['firstName']
							,'middleName'=>(array_key_exists('middleName', $member)) ? $member['middleName'] : ''
							,'lastName'=>$member['lastName']
							,'membershipDues'=>$membershipDues
		);
		$body = $app['view']->render('email/auto-pay-payment-thankyou','email', $view_vars);
		
		$app['sendMail']($subject, $body, $to);

		
	} catch (Exception $e) {
		error_log('exception cauhgt after successful credit card charge: '.print_r($e->getMessage(),true));	
	}	

	return new Response(json_encode(array('message' => $message)), 200,array('Content-Type' => 'application/json'));
});





































////////////////////////////////////////////////////////////////////////////////////////////////////
///  STANDARD RENEWAL FOLLOW UP SCREEN, POST CONTROLLER, EMAIL ROUTE THAT SENDS THE PRIVATE LINKS //  NOT AUTO PAY FOLLOW UP 
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get('/renewal-send-declined-follow-up-email', function (Request $request) use ($app) {

	$member = new Model\Member(array(),$app);
	$members = $member->fetchByRenewalStatus('APPROVED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset=0, $limit=1000);
	$i=0;
	echo "<pre>";print_r(count($members));echo "</pre>";
	foreach ($members as $member) {
		if($member['renewal']['payByCheck'] != 'yes'){
			$subject = 'NCDD Membership Renewal Card Decline';
			$to = $member['email'];
			$view_vars = array('displayName'=>$member['displayName']
								,'securelink'=>'https://'.SAW_ADMIN_WEBSITE.'/renewal-cc-declined/'.$member['_id']
			);
			$body = $app['view']->render('email/renewal-cc-decline-follow-up','email', $view_vars);
			if(!empty($to)){
				error_log('$to: '.print_r($to,true));
			}else{
				error_log('securlink: '.print_r($view_vars['securelink'],true));
			}
	echo "<pre>";print_r($body);echo "</pre>";
			$app['sendMail']($subject, $body, $to);
			error_log('$i: '.print_r($i,true));
			echo "<pre>";print_r($i);echo "</pre>";
			$i++;
		}
	}

	return new Response('', 200,array('Content-Type' => 'text/html'));
})->before($mustbeADMIN);

// screen
$app->get('/renewal-cc-declined/{renewId}', function ($renewId, Request $request) use ($app) {
	$expired_found2 = 0;
	$member = new Model\Member(array('_id'=>$renewId),$app);
	$member = $member->findById();

	if(is_array($member) && !empty($member['renewal']) && is_array($member['renewal']) && !empty($member['renewal']['paymentId'])){
		$view_vars = array(
						'headline'=>'Renewal Membership already paid'
						,'description'=>"You're already paid up for this year.  Thank you."
						,'member'=>$member
						);
		return $app['view']->render('application/renewal-follow-up-already-paid', 'blank', $view_vars);
	}

	


	// derive membership dues:
	// new app = yearsInLawPractice
	// renewal = membershipDues - 6+ = $225, <6 $175, pd $50
	$membershipDues = 225;
	$um = new Model\Apply(array(),$app);
	$um_res = $um->find(array('class'=>'UpdateMember','memberId'=>$member['_id']),array('membershipDues'=>1));
	if(!empty($um_res)){
		$membershipDues = $um_res[0]['membershipDues'];
	}else{

		// look in new member apps
		$nm = new Model\Apply(array(),$app);
		$nm_res = $nm->find(array('class'=>'ApplyNewMember','memberId'=>$member['_id']),array('yearsInLawPractice'=>1));
		if(!empty($nm_res)){
			$expired_found2++;
			if(((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) > 1000){
				$membershipDues = ( (int)$nm_res[0]['yearsInLawPractice'] >= 6) ? 225 : 175;
			}else{
				$membershipDues = ( ((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) >= 6) ? 225 : 175;
			}
		}
	}
	// sanity check for public defenders
	$pd = new Model\Member(array('_id'=>$member['_id']),$app);
	$pd = $pd->findById();
	if($pd['currentMembership'] == Model\Member::$membership['PUBLIC DEFENDER']){
		$membershipDues = 50;
	}


	$view_vars = array(
						'headline'=>'Membership Renewal'
						,'description'=>"Renewa your membership now."
						,'member'=>$member
						,'membershipDues'=>$membershipDues
						);
	if(is_array($member) && array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('number', $member['payment'])){
		$member['payment']['cvc'] = str_replace('.x', '', $member['payment']['cvc']);
		$member['payment']['number'] = str_replace('.x', '', $member['payment']['number']);
		$member['payment']['number'] = (!empty($member['payment']['number'])) ? '...'.substr($member['payment']['number'], -4) :'';	
		$view_vars['payment'] = $member['payment'];
	}else{
		$view_vars['payment'] = array();
	}
	$view_vars['post-url'] = '/renewal-follow-up-pay';
	$view_vars['ar_res']['_id'] = $renewId;

	return $app['view']->render('application/renewal-cc-decline-follow-up', 'blank', $view_vars);
    
});
////////////////////////////////////////////////////////////////////////////////////////////////////
///  STANDARD RENEWAL FOLLOW UP SCREEN, POST CONTROLLER, EMAIL ROUTE THAT SENDS THE PRIVATE LINKS //  NOT AUTO PAY FOLLOW UP 
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get('/renewal-send-unsubmitted-followup-email', function (Request $request) use ($app) {

	$member = new Model\Member(array(),$app);
	$members = $member->fetchByRenewalStatus('UNSUBMITTED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset=0, $limit=1000);
	$i=0;
	echo "<pre>";print_r(count($members));echo "</pre>";
	foreach ($members as $member) {

		$subject = 'NCDD Membership Renewal Reminder';
		$to = $member['email'];
		$view_vars = array('displayName'=>$member['displayName']
							,'securelink'=>'https://'.SAW_ADMIN_WEBSITE.'/renewal-follow-up/'.$member['_id']
		);
		$body = $app['view']->render('email/renewal-reminder','email', $view_vars);
		if(!empty($to)){
			error_log('$to: '.print_r($to,true));
		}else{
			error_log('securlink: '.print_r($view_vars['securelink'],true));
		}
echo "<pre>";print_r($body);echo "</pre>";
		$app['sendMail']($subject, $body, $to);
		error_log('$i: '.print_r($i,true));
		echo "<pre>";print_r($i);echo "</pre>";
		$i++;
	}

	return new Response('', 200,array('Content-Type' => 'text/html'));
})->before($mustbeADMIN);

// screen
$app->get('/renewal-follow-up/{renewId}', function ($renewId, Request $request) use ($app) {
	$expired_found2 = 0;
	$member = new Model\Member(array('_id'=>$renewId),$app);
	$member = $member->findById();

	if(is_array($member) && !empty($member['renewal']) && is_array($member['renewal']) && !empty($member['renewal']['paymentId'])){
		$view_vars = array(
						'headline'=>'Renewal Membership already paid'
						,'description'=>"You're already paid up for this year.  Thank you."
						,'member'=>$member
						);
		return $app['view']->render('application/renewal-follow-up-already-paid', 'blank', $view_vars);
	}

	


	// derive membership dues:
	// new app = yearsInLawPractice
	// renewal = membershipDues - 6+ = $225, <6 $175, pd $50
	$membershipDues = 225;
	$um = new Model\Apply(array(),$app);
	$um_res = $um->find(array('class'=>'UpdateMember','memberId'=>$member['_id']),array('membershipDues'=>1));
	if(!empty($um_res)){
		$membershipDues = $um_res[0]['membershipDues'];
	}else{

		// look in new member apps
		$nm = new Model\Apply(array(),$app);
		$nm_res = $nm->find(array('class'=>'ApplyNewMember','memberId'=>$member['_id']),array('yearsInLawPractice'=>1));
		if(!empty($nm_res)){
			$expired_found2++;
			if(((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) > 1000){
				$membershipDues = ( (int)$nm_res[0]['yearsInLawPractice'] >= 6) ? 225 : 175;
			}else{
				$membershipDues = ( ((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) >= 6) ? 225 : 175;
			}
		}
	}
	// sanity check for public defenders
	$pd = new Model\Member(array('_id'=>$member['_id']),$app);
	$pd = $pd->findById();
	if($pd['currentMembership'] == Model\Member::$membership['PUBLIC DEFENDER']){
		$membershipDues = 50;
	}


	$view_vars = array(
						'headline'=>'Membership Renewal'
						,'description'=>"Renewa your membership now."
						,'member'=>$member
						,'membershipDues'=>$membershipDues
						);
	if(is_array($member) && array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('number', $member['payment'])){
		$member['payment']['cvc'] = str_replace('.x', '', $member['payment']['cvc']);
		$member['payment']['number'] = str_replace('.x', '', $member['payment']['number']);
		$member['payment']['number'] = (!empty($member['payment']['number'])) ? '...'.substr($member['payment']['number'], -4) :'';	
		$view_vars['payment'] = $member['payment'];
	}else{
		$view_vars['payment'] = array();
	}

	return $app['view']->render('application/renewal-follow-up-pay', 'blank', $view_vars);
    
});

// post 
$app->post('/renewal-follow-up-pay', function (Request $request) use ($app) {
	$expired_found2 = 0;
	// retrieve document from request
    $orig_doc = $request->get('doc');
    $member = new Model\Member(array('_id'=>$orig_doc['_id']),$app);
    $member = $member->findById();

    // derive membership dues:
	// new app = yearsInLawPractice
	// renewal = membershipDues - 6+ = $225, <6 $175, pd $50
	$membershipDues = 225;
	$um = new Model\Apply(array(),$app);
	$um_res = $um->find(array('class'=>'UpdateMember','memberId'=>$member['_id']),array('membershipDues'=>1));
	error_log('$um_res: '.print_r($um_res,true));
	if(!empty($um_res)){
		$membershipDues = $um_res[0]['membershipDues'];
	}else{

		// look in new member apps
		$nm = new Model\Apply(array(),$app);
		$nm_res = $nm->find(array('class'=>'ApplyNewMember','memberId'=>$member['_id']),array('yearsInLawPractice'=>1));
		error_log('$nm_res: '.print_r($nm_res,true));
		if(!empty($nm_res)){
			$expired_found2++;
			if(((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) > 1000){
				$membershipDues = ( (int)$nm_res[0]['yearsInLawPractice'] >= 6) ? 225 : 175;
			}else{
				$membershipDues = ( ((int)date('Y') - (int)$nm_res[0]['yearsInLawPractice']) >= 6) ? 225 : 175;
			}
		}
	}
	// sanity check for public defenders
	$pd = new Model\Member(array('_id'=>$member['_id']),$app);
	$pd = $pd->findById();
	if($pd['currentMembership'] == Model\Member::$membership['PUBLIC DEFENDER']){
		$membershipDues = 50;
	}


	// pay
	

	$location = new Model\Location(array('member'=>$member),$app);
	$location = $location->getByMemberId();



// PREPARE APPLICATION				
	if(!empty($member['renewal']['applicationId'])){
		$app_id = $member['renewal']['applicationId'];
	}else{
		
		$orig_doc['memberId'] = $member['_id'];
		$orig_doc['email'] = $member['email'];
		$orig_doc['firstName'] = $member['firstName'];
		$orig_doc['lastName'] = $member['lastName'];
		$orig_doc['currentStatus'] = Model\Apply::$status['DRAFT'];
		$orig_doc['approvedDate'] = new \stdClass();
		$orig_doc['submittedDate'] = new \stdClass();
		$orig_doc['paidDate'] = new \stdClass();
		$orig_doc['paymentId'] = new \stdClass();
		$orig_doc['membershipDues'] = $membershipDues;
		$orig_doc['addToListServ'] = 'yes';
		$orig_doc['payByCheck'] = 'no';

		$application = new Model\UpdateMember($orig_doc, $app);
		// validate the model
    	$app['validateModel']($app,$application,$groups=array('update_member'));
		$app_id = $application->insert();		
	}
	
    
	
// MAKE THE PAYMENT

	/////////////////////////////////
	// prepare their correct total //
	/////////////////////////////////
	$pro_rate = array('q'=>0,'a'=>0);
	$discount = 0;
	 // CREDIT DISCOUNT FOR MEMBERS WHO HOLD A CREDIT WITH US
	$discount2 = 0;
	if(array_key_exists('payment',$member) 
	      && !empty($member['payment'])
	      && is_array($member['payment'])
	      && array_key_exists('renewalCredit',$member['payment'])
	      && !empty($member['payment']['renewalCredit'])
	      && $member['payment']['renewalCredit'] > 0
	): 
	   $discount2  = $member['payment']['renewalCredit'];
	endif;
                       
    $amount = $membershipDues;

    $new_renewal_credit = null;
    $amount = $amount-$discount-$discount2;
    if($amount < 0 && !empty($discount2)){
    	$new_renewal_credit = abs($amount);
    }else if($amount > 0 && !empty($discount2)){
    	$new_renewal_credit = '-';
    }
    $amount = ($amount <= 0) ? 0:$amount;
    
    ////////////////////////////////////////////////////////////////////////////////
	// activate a manual charge and create receipt - only if the declineCount = 0 //
	// if it's more than zero then the card must be updated 					  //
	////////////////////////////////////////////////////////////////////////////////

	$doc['memberId'] = $member['_id'];
	$doc['ownerId'] = $app_id;
	$doc['ownerClass'] = 'UpdateMember';
	$doc['description'] = 'INV-'.time();
	$doc['title'] = 'UPDATE MEMBER APPLICATION';
	$doc['firstName'] = $member['firstName'];
	$doc['lastName'] = $member['lastName'];
	$doc['email'] = '';
	$doc['phone'] = '';
	$doc['addressLine1'] = $orig_doc['addressLine1'];
	$doc['addressLine2'] = $orig_doc['addressLine2'];
	$doc['city'] = $orig_doc['city'];
	$doc['stateProvinceRegion'] = $orig_doc['stateProvinceRegion'];
	$doc['zipPostalCode'] = $orig_doc['zipPostalCode'];
	$doc['country'] = $orig_doc['country'];
	$doc['amount'] = $amount;
	$doc['expMonth'] = $orig_doc['expMonth'];
	$doc['expYear'] = $orig_doc['expYear'];
	$doc['number'] = str_replace('.x', '', (strpos($orig_doc['number'], '...') !== false) ? $member['payment']['number'] : $orig_doc['number']);
	error_log('yyyyyyyyyy------yyyyyyyyyy-----yyyyyyyyyy------number: '.print_r($doc['number'],true));
	//$doc['number'] = $member['payment']['number'];
	$doc['cvc'] = str_replace('.x', '', $orig_doc['cvc']);
	$doc['name'] = $orig_doc['name'];
	// prepare the invoice
	$application = new Model\Apply(array('_id'=>$app_id),$app);
	$application = $application->findById($id='_id', $fields=array(), $slaveOkay=false);

   	$doc['invoiceBlock'] = $app['view']->element('invoice-block',array('application'=>$application,'member'=>$member,'location'=>$location,'pro_rated_membership_dues'=>$pro_rate));
	$payment = new Model\Payment($doc,$app);

	try {
		$app['validateModel']($app, $payment,$groups=array('cc'));	
	} catch (Exception $e) {
		error_log(__FILE__.' '.__LINE__.' for variable: payment  ==>'.print_r($payment,true));
		throw new \Saw\Exceptions\SawException(new \Saw\Exceptions\PaymentException(),$e->getMessage());
	}
	
	try {
		$paymentId = $payment->charge();	
	} catch (Exception $e) {
		error_log('here.....yyyyyyyyyy: '.print_r('here.......yyyyyyyyyy',true));
		
		return new Response(json_encode(array('message' => $e->getMessage())), 400,array('Content-Type' => 'application/json'));

	}
	try {

// update application with paymentid and paid date
		$appl = new Model\Apply(array('_id'=>$app_id,'currentStatus'=>Model\Apply::$status['PAID'],'paymentId'=>$paymentId,'paidDate'=>new Model\Date($app, 'now')), $app);
		$appl->saveSafe();
// update member's renewal credit 
		$plite = new Model\PaymentLite($orig_doc,$app);
		$tpaymnt = $plite->__toArray();
    	$tpaymnt['declineCount'] = 0;

    	if(!is_null($new_renewal_credit))
    		$tpaymnt['renewalCredit'] = $new_renewal_credit;
error_log(__FILE__.' '.__LINE__.' $tpaymnt: '.print_r($tpaymnt,true));
    	$tmem = new Model\Member(array('_id'=>$application['memberId'],'payment'=>$tpaymnt),$app);
    	$tmem->saveSafe();

// PREPARE THE RENEWAL ARRAY IN THE MEMBER RECORD
		$mem['renewal']['applicationId'] = $app_id; 
		$mem['renewal']['currentStatus'] = Model\Renewal::$status['PAID'];
		$mem['renewal']['submittedDate'] = new \stdClass();
		$mem['renewal']['approvedDate'] = new \stdClass();
		$mem['renewal']['paidDate'] = new Model\Date($app, 'now');
		$mem['renewal']['paymentId'] = $paymentId;
		$mem['renewal']['payByCheck'] = 'no';

		$renewal = new Model\Renewal($mem['renewal'],$app);
		$renewal->setRenewalByMember($member['_id']);

// PREPARE SERVER RESPONSE MESSAGE
		$message = 'Thank you for renewing your NCDD membership.  An email confirmation has been sent to your address on file: '.$member['email'];

// PREPARE TO SEND THE EMAIL
		$subject = 'NCDD Membership Dues Payment Received';
		$to = $member['email'];
		$view_vars = array('firstName'=>$member['firstName']
							,'middleName'=>(array_key_exists('middleName', $member)) ? $member['middleName'] : ''
							,'lastName'=>$member['lastName']
							,'membershipDues'=>$membershipDues
		);
		$body = $app['view']->render('email/renewal-paid-thank-you','email', $view_vars);
		
		$app['sendMail']($subject, $body, $to);

		
	} catch (Exception $e) {
		error_log('exception cauhgt after successful credit card charge: '.print_r($e->getMessage(),true));	
	}	

	return new Response(json_encode(array('message' => $message)), 200,array('Content-Type' => 'application/json'));
});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  END -------    STANDARD RENEWAL FOLLOW UP SCREEN, POST CONTROLLER, EMAIL ROUTE THAT SENDS THE PRIVATE LINKS //  NOT AUTO PAY FOLLOW UP 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


































//////////////
// RENEWALS //
//////////////
$app->get('/renewals/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$member = new Model\Member($doc=array(), $app);
	$apply = new Model\Apply(array(),$app);
	$renewals = array(
		'unsubmitted'=>$member->fetchByRenewalStatus('UNSUBMITTED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit)
		,'submitted'=>$member->fetchByRenewalStatus('SUBMITTED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit)
		,'approved'=>$member->fetchByRenewalStatus('APPROVED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit)
		,'paid'=>$member->fetchByRenewalStatus('PAID',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']), $offset, $limit)
		,'unpaidbycheck'=>$member->fetchByPaymentStatus('unpaid-PAYBYCHECK',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']), $offset, $limit)
	);
	$updates_founding = array(
		'unsubmitted'=>$member->fetchByRenewalStatus('UNSUBMITTED',array(Model\Member::$membership['FOUNDING MEMBER']),$offset, $limit)
		,'submitted'=>$member->fetchByRenewalStatus('SUBMITTED',array(Model\Member::$membership['FOUNDING MEMBER']),$offset, $limit)
		,'approved'=>$member->fetchByRenewalStatus('APPROVED',array(Model\Member::$membership['FOUNDING MEMBER']),$offset, $limit)
	);
	$updates_sustaining = array(
		'unsubmitted'=>$member->fetchByRenewalStatus('UNSUBMITTED',array(Model\Member::$membership['SUSTAINING MEMBER']),$offset, $limit)
		,'submitted'=>$member->fetchByRenewalStatus('SUBMITTED',array(Model\Member::$membership['SUSTAINING MEMBER']),$offset, $limit)
		,'approved'=>$member->fetchByRenewalStatus('APPROVED',array(Model\Member::$membership['SUSTAINING MEMBER']),$offset, $limit)
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
						,'updates_founding'=>$updates_founding
						,'updates_sustaining'=>$updates_sustaining
						);
	return $app['view']->render('application/index-renewals', 'default', $view_vars);
})
->value('offset','0')
->value('limit','20000')
->before($mustbeADMIN);


$app->get('/applications/activate/renewals/{activate}', function ($activate, Request $request) use ($app) {
	$member = new Model\Member($doc=array(), $app);
	
	if($activate == 'yes'){
		// prepare to remove trial members from the lists by updating them after the renewals run
		$application = new Model\Apply($doc=array(), $app);
		$trial = $application->fetchByStatus('TRIAL',0, 10000,$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
		

		// find all the active members who aren't already active and create the renewal attribute
		$renewal = new Model\Renewal(array(),$app);
		$renewal->prepareInsert();
		$renewal = $renewal->__toArray();

		// get the count of the updates to occur  /// $type 10 means a null type value
		// actuall query db.member.find({$or:[{renewal:{$exists:false}},{renewal:{$exists:true,$type:10}},{renewal:{}}],status:2,currentMembership:10,listed:1}).count();
		$common_query = array('$or'=>array(array('renewal'=>array('$exists'=>false)),array('renewal'=>array('$exists'=>true,'$type'=>10)),array('renewal'=>new \stdClass())));		
		//$common_query = array();

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

		$tr_count = 0;
		if(!empty($trial) && is_array($trial)){
			foreach ($trial as $record):
				$trial_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), array('_id'=>$record['memberId']));
				$tr_count++;
			endforeach;
		}

		// one-time - prepare the folks who've already paid dues through promotions
		/*
			case 'paid-CC':
    			$query = array('status'=>USER_STATUS_ACTIVE
						,'renewal.currentStatus'=>Renewal::$status['PAID']
						,'payment.renewalREUSE'=>array('$ne'=>'yes')
						,'payment.number'=>array('$exists'=>true)
						,'$where'=>'this.payment.number.length > 3'
						,'currentMembership'=>array('$in'=>$membership)
						);
    			break;
    		case 'paid-CCRECUR':
    			$query = array('status'=>USER_STATUS_ACTIVE
						,'renewal.currentStatus'=>Renewal::$status['PAID']
						,'payment.renewalREUSE'=>'yes'
						,'payment.number'=>array('$exists'=>true)
						,'$where'=>'this.payment.number.length > 3'
						,'currentMembership'=>array('$in'=>$membership)
						);
    			break;    		
		*/
		$application = new Model\Apply($doc=array(), $app);
		$bonus2015promocode = $application->fetchByStatus('PAID',0, 10000,$filter=array('promocode'=>'BONUS2015'));
		$promo_count = 0;
		if(!empty($trial) && is_array($trial)){
			foreach ($bonus2015promocode as $record):
				$doc['currentStatus'] = Model\Renewal::$status['PAID'];
				$doc['applicationId'] = new \MongoId($record['_id']);
				$doc['submittedDate'] = $record['submittedDate'];
				$doc['approvedDate']  = $record['approvedDate'];
				$doc['paidDate'] 	  = $record['paidDate'];
				$doc['paymentId'] 	  = $record['paymentId'];

				$renewal = new Model\Renewal($doc,$app);
				$renewal->prepareInsert();
				$renewal = $renewal->__toArray();

				$bonus2015promocode_update = $member->updateByCriteria(array('$set'=>array('renewal'=>$renewal)), array('_id'=>$record['memberId']));

				$promo_count++;
			endforeach;
		}
		$eagle2016promocode = $application->fetchByStatus('PAID',0, 10000,$filter=array('promocode'=>'EAGLE2016'));
		if(!empty($trial) && is_array($trial)){
			foreach ($eagle2016promocode as $record):
				$doc['currentStatus'] = Model\Renewal::$status['PAID'];
				$doc['applicationId'] = new \MongoId($record['_id']);
				$doc['submittedDate'] = $record['submittedDate'];
				$doc['approvedDate']  = $record['approvedDate'];
				$doc['paidDate'] 	  = $record['paidDate'];
				$doc['paymentId'] 	  = $record['paymentId'];

				$renewal = new Model\Renewal($doc,$app);
				$renewal->prepareInsert();
				$renewal = $renewal->__toArray();

				$eagle2016promocode_update = $member->updateByCriteria(array('$set'=>array('renewal'=>$renewal)), array('_id'=>$record['memberId']));

				$promo_count++;
			endforeach;
		}
		



		$label = 'Renewal Activation Successful.';
    	$message = $gm_count.' General Members were activated<br><br>'.$sm_count.' Sustaining Members were activated<br><br>'.$fm_count.' Founding Members were activated<br><br>'.$pd_count.' Public Defenders were activated<br><br>'.$tr_count.' Trial Members were ignored<br><br>'.$promo_count.' Promo Members were marked PAID<br><br>Note: only active members\' renewals were activated.  Non-active members who are activated during the renewal process will have to be manually activated.';
    	
	}elseif($activate == 'clear'){
		// clear all active members' renewal attribute
		$gm_query = array('currentMembership'=>Model\Member::$membership['GENERAL MEMBER']);
		$sm_query = array('currentMembership'=>Model\Member::$membership['SUSTAINING MEMBER']);
		$fm_query = array('currentMembership'=>Model\Member::$membership['FOUNDING MEMBER']);
		$pd_query = array('currentMembership'=>Model\Member::$membership['PUBLIC DEFENDER']);
		
		$gm_count = $member->count($gm_query);
		$sm_count = $member->count($sm_query);
		$fm_count = $member->count($fm_query);
		$pd_count = $member->count($pd_query);
		
		$gm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $gm_query);
		$sm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $sm_query);
		$fm_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $fm_query);
		$pd_update = $member->updateByCriteria(array('$set'=>array('renewal'=>null)), $pd_query);

		$label = 'Renewal Clear Successful.';
    	$message = $gm_count.' General Members were cleared<br><br>'.$sm_count.' Sustaining Members were cleared<br><br>'.$fm_count.' Founding Members were cleared<br><br>'.$pd_count.' Public Defenders were cleared<br><br>Note: both active and non active members\' renewals were cleared.  Non-active members who are activated during the renewal process will have to be manually cleared.';
    	
	}

    return new Response(json_encode(array('message' => $message,'label'=>$label)),200,array('Content-Type' => 'application/json'));

})->value('acitvate','')
->before($mustbeADMIN);








/**
AUTOPAY
*/
//////////////////////////////////////
// auto-payment system for renewals //
//////////////////////////////////////
// this is called via xhr from the index-renewals.php view every 8 seconds 
// and processes 3 records each time
$app->get('/application/autopay', function (Request $request) use ($app) {
	$limit = 3;
	////////////////////////////////////////////////////////////////////////
	// get all the applications that must be paid and prepare the objects //
	////////////////////////////////////////////////////////////////////////
	$member = new Model\Member($doc=array(), $app);	
	$query = array('status'=>USER_STATUS_ACTIVE,
					'renewal.currentStatus'=>Model\Renewal::$status['APPROVED'],
					'renewal.payByCheck'=>array('$in'=>array('no','no-store','')),
					'currentMembership'=>array('$in'=>array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER'])));
	$approved_count = $member->count($query);

	$offset = $app['session']->get('autopay-offset');
	$offset = (empty($offset)) ? 0 : $offset;
	
	$approved = $member->fetchByRenewalStatusPaymentType('APPROVED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']),$offset, $limit);
	$approvedc = count($approved);
	$new_offset = ($offset+$limit > $approved_count) ? 0: $offset+$limit;
	$app['session']->set('autopay-offset',$new_offset);
	$apps_paid = array();
	if(!empty($approved)):
	foreach($approved as $record):
		$apply = new Model\Apply($doc=array('_id'=>$record['renewal']['applicationId']), $app);
		$application = $apply->findById();
		
		$location = new Model\Location($doc=array('member'=>array('_id'=>$application['memberId'])), $app);
		$location = $location->getByMemberId();

		$member = new Model\Member($doc=array('_id'=>$application['memberId']), $app);
		$member = $member->findById();
		

		if(!empty($member)
			&& is_array($member)
			&& array_key_exists('payment',$member)
		    && !empty($member['payment'])
		    && is_array($member['payment'])
		    && array_key_exists('number',$member['payment'])
		    && !empty($member['payment']['number'])
		    && strlen($member['payment']['number']) > 10):

			/////////////////////////////////
			// prepare their correct total //
			/////////////////////////////////
			$pro_rate = array('q'=>0,'a'=>0);
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

			// EARLY BIRD DISCOUNT FOR 2014 -- is not over..
			$discount = 0;
			/*
			if($application['type'] == 'UPDATE MEMBER APPLICATION'
			    //&& strtotime($application['approvedDate']['iso']) < strtotime('December 31, 2014')
			    && array_key_exists('payment', $member) && array_key_exists('renewalREUSE', $member['payment']) && $member['payment']['renewalREUSE'] == 'yes'
			    && $application['membershipDues'] > 50
			): 
				$discount = 50;
			endif;
			//*/
			 // CREDIT DISCOUNT FOR MEMBERS WHO HOLD A CREDIT WITH US
			$discount2 = 0;
			if(array_key_exists('payment',$member) 
			      && !empty($member['payment'])
			      && is_array($member['payment'])
			      && array_key_exists('renewalCredit',$member['payment'])
			      && !empty($member['payment']['renewalCredit'])
			      && $member['payment']['renewalCredit'] > 0
			): 
			   $discount2  = $member['payment']['renewalCredit'];
			endif;
		                       
		    if($pro_rate['q'] > 1): 
		    	$amount = $pro_rate['a'];
		    else: 
		       $amount = $application['membershipDues'];
		    endif;
		    
		    $new_renewal_credit = null;
		    $amount = $amount-$discount-$discount2;
		    if($amount < 0 && !empty($discount2)){
		    	$new_renewal_credit = abs($amount);
		    }else if($amount > 0 && !empty($discount2)){
		    	$new_renewal_credit = '-';
		    }
		    $amount = ($amount <= 0) ? 0:$amount;
		    
		    ////////////////////////////////////////////////////////////////////////////////
			// activate a manual charge and create receipt - only if the declineCount = 0 //
			// if it's more than zero then the card must be updated 					  //
			////////////////////////////////////////////////////////////////////////////////

		    if(array_key_exists('payment', $member) && array_key_exists('declineCount', $member['payment']) && ($member['payment']['declineCount'] == 0 || empty($member['payment']['declineCount']))){
				$doc['memberId'] = $application['memberId'];
				$doc['ownerId'] = $application['_id'];
				$doc['ownerClass'] = $application['class'];
				$doc['description'] = 'INV-'.time();
				$doc['title'] = $application['type'];
				$doc['firstName'] = $application['firstName'];
				$doc['lastName'] = $application['lastName'];
				$doc['email'] = $application['email'];
				$doc['phone'] = (!empty($application['phone'])) ? $application['phone']: $location['phone'];
				$doc['addressLine1'] = (!empty($application['address1'])) ? $application['address1']: $member['payment']['addressLine1'];
				$doc['addressLine2'] = (!empty($application['address2'])) ? $application['address2']: (array_key_exists('addressLine2', $member['payment'])) ? $member['payment']['addressLine2'] : '';
				$doc['city'] = (!empty($application['city'])) ? $application['city']: $member['payment']['city'];
				$doc['stateProvinceRegion'] = (!empty($application['state'])) ? $application['state']: $member['payment']['stateProvinceRegion'];
				$doc['zipPostalCode'] = (!empty($application['postalCode'])) ? $application['postalCode']: $member['payment']['zipPostalCode'];
				$doc['country'] = (!empty($application['country'])) ? $application['country']: $member['payment']['country'];
				$doc['amount'] = $amount;
				$doc['expMonth'] = $member['payment']['expMonth'];
				$doc['expYear'] = $member['payment']['expYear'];
				$doc['number'] = str_replace('.x', '', $member['payment']['number']);
				//$doc['number'] = $member['payment']['number'];
				$doc['cvc'] = str_replace('.x', '', $member['payment']['cvc']);
				$doc['name'] = $member['payment']['name'];
				// prepare the invoice
			   	$doc['invoiceBlock'] = $app['view']->element('invoice-block',array('application'=>$application,'member'=>$member,'location'=>$location,'pro_rated_membership_dues'=>$pro_rate));
				$payment = new Model\Payment($doc,$app);
				if($amount <= 0){
					$app['validateModel']($app, $payment,$groups=array('manual'));
					$paymentId = $payment->manualCharge();
					$tpaymnt = $member['payment'];
			    	$tpaymnt['declineCount'] = 0;
			    	if(!is_null($new_renewal_credit))
			    		$tpaymnt['renewalCredit'] = $new_renewal_credit;
			    	$tmem = new Model\Member(array('_id'=>$application['memberId'],'payment'=>$tpaymnt),$app);
			    	$tmem->saveSafe();
				}else{
					try {
						$app['validateModel']($app, $payment,$groups=array('cc'));	
					} catch (Exception $e) {
						error_log(__FILE__.' '.__LINE__.' for variable: payment  ==>'.print_r($payment,true));
						throw new \Saw\Exceptions\SawException(new \Saw\Exceptions\PaymentException(),$e->getMessage());
					}
					
					try {
						$paymentId = $payment->charge();	
						$tpaymnt = $member['payment'];
				    	$tpaymnt['declineCount'] = 0;
				    	if(!is_null($new_renewal_credit))
				    		$tpaymnt['renewalCredit'] = $new_renewal_credit;
				    	$tmem = new Model\Member(array('_id'=>$application['memberId'],'payment'=>$tpaymnt),$app);
				    	$tmem->saveSafe();
					} catch (Exception $e) {
						$tpaymnt = $member['payment'];
				    	$tpaymnt['declineCount'] = (array_key_exists('declineCount', $tpaymnt)) ? $tpaymnt['declineCount']+1: 1;
				    	$tmem = new Model\Member(array('_id'=>$application['memberId'],'payment'=>$tpaymnt),$app);
				    	$tmem->saveSafe();
						return new Response(json_encode(array('message'=>"appId:".$application['_id']." failed due to invalid card")), 400,array('Content-Type' => 'application/json'));
					}
					
				}

				///////////////////////////////
				// mark the application paid //
				///////////////////////////////
				switch ($application['class']) {
					case 'NewMemberApplication': // old deprecated
					case 'ApplyNewMember':
					case 'ApplyNewSustainingMember':
						$appl = new Model\Apply(array('_id'=>$application['_id'], 'paymentId'=>$paymentId), $app);
					    break;		
					case 'UpdateMember':
						$appl = new Model\UpdateMember(array('_id'=>$application['_id'], 'paymentId'=>$paymentId,'memberId'=>$application['memberId']), $app);
						break;
					case 'UpdateFoundingMember':
						$appl = new Model\UpdateFoundingMember(array('_id'=>$application['_id'], 'paymentId'=>$paymentId,'memberId'=>$application['memberId']), $app);
						break;
					case 'UpdateSustainingMember':
						$appl = new Model\UpdateSustainingMember(array('_id'=>$application['_id'], 'paymentId'=>$paymentId,'memberId'=>$application['memberId']), $app);
						break;
				}
			   	$appl->markPaid(false);


				// return the application id to the xhr
				$apps_paid[] = $application['_id'];
			}// endif delineCount == 0
		endif;
	endforeach;
	endif;

	return new Response(json_encode(array('apps_paid'=>$apps_paid,'new_offset'=>$new_offset,'message'=>"success")), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);



return $app;