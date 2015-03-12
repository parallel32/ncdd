<?php
///////////////////////
// MEMBER MANAGEMENT //
///////////////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$member = $app['controllers_factory'];
$member->before($mustbeMEMBER);

$member->get('/streamcsv/{members}', function ($members, Request $request) use ($app) {
	
	$member = new Model\Member(array(),$app);
	error_log(__FILE__.' '.__LINE__.' for variable: membership  ==>'.print_r(Model\Member::$membership['GENERAL MEMBER'],true));
	switch ($members) {
		case 'gm':
			$res = $member->fetchForCSV(Model\Member::$membership['GENERAL MEMBER']);
			break;
		case 'sm':
			$res = $member->fetchForCSV(Model\Member::$membership['SUSTAINING MEMBER']);
			break;
		case 'fm':
			$res = $member->fetchForCSV(Model\Member::$membership['FOUNDING MEMBER']);
			break;
		case 'pd':
			$res = $member->fetchForCSV(Model\Member::$membership['PUBLIC DEFENDER']);
			break;		
		case 'r-u':
			$res = $member->fetchRenewalForCSV('UNSUBMITTED',array(Model\Member::$membership['GENERAL MEMBER'],Model\Member::$membership['PUBLIC DEFENDER']));
			break;		
	}
	
	$csv = '';	
	if(is_array($res) && !empty($res)):	
    foreach ($res as $key => $value) {
		unset($value['_id']);
    	unset($value['id']);
    	if(array_key_exists('member', $value)){
    		$value2 = $value['member'];
	    	unset($value['member']);
	    	$new_value = array_merge($value,$value2);	
    	}else{
    		$new_value = $value;
    	}
    	
    	$line = implode(',', $new_value);
    	$csv.= $line.PHP_EOL;
	}
	endif;

    return new Response($csv, 200, array('Content-Type' => 'text/csv'));
    //return $app['view']->render('member/search', 'blank', $view_vars);

})->value('members','');

$member->get('/search', function (Request $request) use ($app) {
	// retrieve from query string
    $query = $request->get('query');

	$crumbs = array(array('name'=>'Member Search','href'=>'/member/search'));
	$view_vars = array(
						 'active'=>'Members/search'
						,'page-plugin'=>'datatables'
						,'headline'=>'Members Search'
						,'description'=>"Search for all members here."
						,'crumbs'=>$crumbs
						,'query'=>$query
						);
	return $app['view']->render('member/search', 'default', $view_vars);
});
$member->post('/search', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $member = new Model\Member(array(), $app);
    $results = $member->search($doc['search']);
    if(!empty($results)){
    	$message = count($results).' members found.';
    }else{
    	$message = 'No members matched that name.';
    }
    
    $state = (Model\Member::isState($doc['search'])) ? 'yes' : 'no';
    return new Response(json_encode(array('state'=>$state,'results'=>$results,'message' => $message)), 200,array('Content-Type' => 'application/json'));
	
});

$member->get('/add', function (Request $request) use ($app) {
	$crumbs = array(array('name'=>'Members','href'=>'/member/search')
					,array('name'=>'Add New','href'=>'/member/add'));
	$view_vars = array(
						 'active'=>'Members'
						,'page-plugin'=>''
						,'headline'=>'Members'
						,'description'=>"Add a new member"
						,'crumbs'=>$crumbs);
	return $app['view']->render('users/member-add', 'default', $view_vars);
});
$member->post('/add', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $member = new Model\Member($document, $app);
    // validate the model
    $app['validateModel']($app,$member,$groups=array('signup'));
    
    if($member->findByEmail()){
    	$member->upsert();
    	$message = 'This member already exists and was updated. Click Add More to try again or Finished.';
    }else{
    	$member->insert();
    	$message = 'If you would like to add another click Add More or click Finished.';
    }
    return new Response(json_encode(array('message' => $message)), 200,array('Content-Type' => 'application/json'));
	
});

// change the member order number
$member->get('/order/{id}/{order}/{state}', function ($id, $order, $state, Request $request) use ($app) {
    $order = (empty($order)) ? '*' : $order ;
	if(!empty($state) && $state == 'yes'){
		$member = new Model\Member(array('_id'=>$id,'orderNumState'=>$order), $app);
		$member->updateOrderNumState();
	}else{
		$member = new Model\Member(array('_id'=>$id,'orderNum'=>$order), $app);
		$member->updateOrderNum();
	}
	return new Response(json_encode(array('message' => 'order updated successfully.')), 200,array('Content-Type' => 'application/json'));
})->value('order','*')->value('state','');

$member->get('/{userId}/edit', function ($userId, Request $request) use ($app) {

	$member = new Model\Member($doc=array('_id'=>new MongoId($userId)), $app);
	$member = $member->findById();
	$member['membershipBadge'] = (!empty($member['currentMembership'])) ? Model\Member::$membershipBadge[$member['currentMembership']] : '';
	$member['boardCertifiedBadge'] = Model\Member::$boardCertifiedBadge;
	$member['boardCertifiedBadgeSr'] = Model\Member::$boardCertifiedBadgeSr;
	$member['facultyBadge'] = (!empty($member['currentFacultyPosition'])) ? Model\Member::$facultyBadge[$member['currentFacultyPosition']]: '';;
	$member ['membershipReversed'] = Model\Member::$membershipReversed;
	$member ['facultyPositionReversed'] = Model\Member::$facultyPositionReversed;
	$member ['orderReversed'] = Model\Member::$orderReversed;


	$location = new Model\Location(array('ownerId'=>$userId),$app);
	$locations = $location->getByOwner();
	$member['locations'] = $locations;
	$crumbs = array(array('name'=>'Members','href'=>'/member/search')
					,array('name'=>$member['firstName'].' '.$member['lastName'],'href'=>'/member/'.$userId.'/edit')
					,array('name'=>'Edit','href'=>'/member/'.$userId.'/edit')
					);
	$view_vars = array(
						 'active'=>'Members/edit'
						,'page-plugin'=>'datatables,editor'
						,'headline'=>'Members'
						,'description'=>"Edit a member"
						,'crumbs'=>$crumbs
						,'member'=>$member
						,'image'=>(!empty($member['image'])) ? $app['getImageURL']($member['image'],'small') : '/noprofileimage'
						);
	return $app['view']->render('member/edit', 'default', $view_vars);
})->value('userId','');
$member->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $member = new Model\Member($document, $app);
    // validate the model
    $app['validateModel']($app,$member);
    //record the change
    $res = Model\Change::check($member, $member->displayName,$app);


    $member->saveEdit();
    
    return new Response(json_encode(array('message' => 'Member details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
});

$member->get('/{userId}/edit-photo', function ($userId, Request $request) use ($app) {

	$member = new Model\Member($doc=array('_id'=>new MongoId($userId)), $app);
	$member = $member->findById();
	
	$crumbs = array(array('name'=>'Members','href'=>'/member/search')
					,array('name'=>$member['firstName'].' '.$member['lastName'],'href'=>'/member/'.$userId.'/edit')
					,array('name'=>'Edit','href'=>'/member/'.$userId.'/edit')
					,array('name'=>'Photo','href'=>'/member/'.$userId.'/edit-photo')
					);
	$view_vars = array(
						 'active'=>'Members/edit'
						,'page-plugin'=>'fileupload'
						,'headline'=>'Members'
						,'description'=>"Edit member photo"
						,'crumbs'=>$crumbs
						,'member'=>$member
						,'image'=>(!empty($member['image'])) ? $app['getImageURL']($member['image'],'small') : '/noprofileimage'
						,'imageDelete'=>(!empty($member['image'])) ? '/image/delete/'.$member['image']['context'].'/'.$member['image']['belongsTo'] : '');
	return $app['view']->render('member/edit-photo', 'default', $view_vars);
})->value('userId','');
$member->get('/{userId}/edit-photo-crop', function ($userId, Request $request) use ($app) {

	$member = new Model\Member($doc=array('_id'=>new MongoId($userId)), $app);
	$member = $member->findById();
	
	$crumbs = array(array('name'=>'Members','href'=>'/member/search')
					,array('name'=>$member['firstName'].' '.$member['lastName'],'href'=>'/member/'.$userId.'/edit')
					,array('name'=>'Edit','href'=>'/member/'.$userId.'/edit')
					,array('name'=>'Photo','href'=>'/member/'.$userId.'/edit-photo')
					,array('name'=>'Crop','href'=>'/member/'.$userId.'/edit-photo-crop')
					);
	$view_vars = array(
						 'active'=>'Members/edit'
						,'page-plugin'=>'crop'
						,'headline'=>'Members'
						,'description'=>"Crop member photo"
						,'crumbs'=>$crumbs
						,'member'=>$member
						,'image'=>(!empty($member['image'])) ? $app['getImageURL']($member['image'],'small') : '/noprofileimage'
						);
	return $app['view']->render('member/edit-photo-crop', 'default', $view_vars);
})->value('userId','');

















$member->post('/{id}/practicestate/add', function ($id, Request $request) use ($app) {
	
    // retrieve document from request
    $doc = $request->get('doc');
    if(empty($doc['lon']) && empty($doc['lat'])){
    	$response_arr = array('message'=>"You must Geocode the state in order to save it.",
                              "invalidFields"=>array(array('name'=>'geocode','message'=>'')));
        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
    }
    $doc['point'] = array($doc['lon'],$doc['lat']);
    $doc['ownerId'] = $id;
    
    // get the member to embed
	$member = new Model\Member(array('_id'=>$id), $app);
	$doc['member'] = $member->findById();

    $location = new Model\Location($doc,$app);
    $app['validateModel']($app,$location,$groups=array('ps'));

    $insert_id = $location->insert();

    // get the member to embed
    unset($doc['member']);
    $doc['_id'] = $insert_id;
	$ps = $member->addPracticeState($doc);
	$member->getPracticeStates();
	$member->saveEdit();    
    
    return new Response(json_encode(array('id'=>$insert_id, 'message' => 'added successfully.')), 200,array('Content-Type' => 'application/json'));
});
$member->post('/{id}/practicestate/delete', function ($id, Request $request) use ($app) {

	$state = $request->get('state');
	if(!empty($state)){
		$location = new Model\Location(array('_id'=>$id), $app);
	    $loc = $location->findById();
	    $location->remove();
	    
		$member = new Model\Member(array('_id'=>$loc['member']['_id']), $app);
		$member->removePracticeState($state);
		$member->getPracticeStates();
		$member->saveEdit();
	}
    return new Response(json_encode(array('message' => 'removed successfully.')), 200,array('Content-Type' => 'application/json'));
});













$member->post('/{id}/location/add', function ($id, Request $request) use ($app) {
	
    // retrieve document from request
    $doc = $request->get('doc');
    
    if(empty($doc['lon']) && empty($doc['lat'])){
    	$response_arr = array('message'=>"You must Geocode your address in order to save it.",
                              "invalidFields"=>array(array('name'=>'geocode','message'=>'')));
        return new Response(json_encode($response_arr), 403,array('Content-Type' => 'application/json'));
    }

    $doc['point'] = array($doc['lon'],$doc['lat']);
    $doc['ownerId'] = $id;
    
    // get the member to embed
	$member = new Model\Member(array('_id'=>$id), $app);
	$doc['member'] = $member->findById();

    $location = new Model\Location($doc,$app);
    $app['validateModel']($app,$location);

    $insert_id = $location->insert();
    
    return new Response(json_encode(array('id'=>$insert_id, 'message' => 'added successfully.')), 200,array('Content-Type' => 'application/json'));
});
$member->get('/location/{id}/delete', function ($id, Request $request) use ($app) {
    $location = new Model\Location(array('_id'=>$id), $app);
    $loc = $location->findById();
    $location->remove();
    // now set the owner's other oldest location as the primary
    $location = new Model\Location(array('ownerId'=>$loc['member']['_id']),$app);
    $location->setFirstAsPrimary();
    return new Response(json_encode(array('message' => 'removed successfully.')), 200,array('Content-Type' => 'application/json'));
});
$member->get('/location/{id}/primary', function ($id, Request $request) use ($app) {
    $location = new Model\Location(array('_id'=>$id), $app);
    $location->setPrimary();
    return new Response(json_encode(array('message' => 'removed successfully.')), 200,array('Content-Type' => 'application/json'));
});

$member->post('/{id}/website/add', function ($id, Request $request) use ($app) {
	
	$doc = $request->get('doc');
	// get the member to embed
	$member = new Model\Member(array('_id'=>$id), $app);
	$website = $member->addWebsite($doc);
	$member->getWebsites();
	$member->saveEdit();    
    return new Response(json_encode(array('name'=>$website, 'id'=>$id, 'message' => 'added successfully.')), 200,array('Content-Type' => 'application/json'));
});
$member->post('/{id}/website/delete', function ($id, Request $request) use ($app) {
    $website = $request->get('website');
	$member = new Model\Member(array('_id'=>$id), $app);
	$member->removeWebsite($website);
	$member->getWebsites();
	$member->saveEdit();
    return new Response(json_encode(array('message' => 'removed successfully.')), 200,array('Content-Type' => 'application/json'));
});

$member->post('/{id}/language/add', function ($id, Request $request) use ($app) {
	
	$doc = $request->get('doc');
	// get the member to embed
	$member = new Model\Member(array('_id'=>$id), $app);
	$member->addLanguage($doc);
	$member->getLanguages();
	$member->saveEdit();    
    return new Response(json_encode(array('name'=>$doc['language'], 'id'=>$id, 'message' => 'added successfully.')), 200,array('Content-Type' => 'application/json'));
});
$member->get('/{id}/language/{language}/delete', function ($id, $language, Request $request) use ($app) {
    
	$member = new Model\Member(array('_id'=>$id), $app);
	$member->removeLanguage($language);
	$member->getLanguages();
	$member->saveEdit();
    return new Response(json_encode(array('message' => 'removed successfully.')), 200,array('Content-Type' => 'application/json'));
});

$member->post('/{id}/pa/add', function ($id, Request $request) use ($app) {
	
	$doc = $request->get('doc');
	$doc['percent'] = str_replace('%','',$doc['percent']);
	// get the member to embed
	$member = new Model\Member(array('_id'=>$id), $app);
	$member->addPracticeArea($doc);
	$member->getPracticeAreas();
	$member->saveEdit();    
    return new Response(json_encode(array('pa'=>$doc, 'id'=>$id, 'message' => 'added successfully.')), 200,array('Content-Type' => 'application/json'));
});
$member->post('/{id}/pa/delete', function ($id, Request $request) use ($app) {
    $pa = $request->get('pa');
	$member = new Model\Member(array('_id'=>$id), $app);
	$member->removePracticeArea($pa);
	$member->getPracticeAreas();
	$member->saveEdit();
    return new Response(json_encode(array('message' => 'removed successfully.')), 200,array('Content-Type' => 'application/json'));
});


return $member;