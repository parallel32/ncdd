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
    return new Response(json_encode(array('results'=>$results,'message' => $message)), 200,array('Content-Type' => 'application/json'));
	
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
$member->get('/order/{id}/{order}', function ($id, $order, Request $request) use ($app) {
    $order = (empty($order)) ? '*' : $order ;
	$member = new Model\Member(array('_id'=>$id,'orderNum'=>$order), $app);
	$member->updateOrderNum();
    return new Response(json_encode(array('message' => 'order updated successfully.')), 200,array('Content-Type' => 'application/json'));
})->value('order','*');

$member->get('/{userId}/edit', function ($userId, Request $request) use ($app) {

	$member = new Model\Member($doc=array('_id'=>new MongoId($userId)), $app);
	$member = $member->findById();
	$member['membershipBadge'] = (!empty($member['currentMembership'])) ? Model\Member::$membershipBadge[$member['currentMembership']] : '';
	$member['boardCertifiedBadge'] = Model\Member::$boardCertifiedBadge;
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


$member->post('/{id}/location/add', function ($id, Request $request) use ($app) {
	
	// get the member to embed
	$member = new Model\Member(array('_id'=>$id), $app);
    $member->findById();
    
    // retrieve document from request
    $doc = $request->get('doc');
    $doc['point'] = array($doc['lon'],$doc['lat']);
    $doc['ownerId'] = $id;
    
    $location = new Model\Location($doc,$app, $member);
    $app['validateModel']($app,$location);

    $insert_id = $location->insert();
    
    return new Response(json_encode(array('id'=>$insert_id, 'message' => 'added successfully.')), 200,array('Content-Type' => 'application/json'));
});
$member->get('/location/{id}/delete', function ($id, Request $request) use ($app) {
    $location = new Model\Location(array('_id'=>$id), $app);
    $location->remove();
    return new Response(json_encode(array('message' => 'removed successfully.')), 200,array('Content-Type' => 'application/json'));
});

$member->post('/{id}/website/add', function ($id, Request $request) use ($app) {
	
	$doc = $request->get('doc');
	// get the member to embed
	$member = new Model\Member(array('_id'=>$id), $app);
	$member->addWebsite($doc);
	$member->getWebsites();
	$member->saveEdit();    
    return new Response(json_encode(array('name'=>$doc['website'], 'id'=>$id, 'message' => 'added successfully.')), 200,array('Content-Type' => 'application/json'));
});
$member->get('/{id}/website/{website}/delete', function ($id, $website, Request $request) use ($app) {
    
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
	// get the member to embed
	$member = new Model\Member(array('_id'=>$id), $app);
	$member->addPracticeArea($doc);
	$member->getPracticeAreas();
	$member->saveEdit();    
    return new Response(json_encode(array('name'=>$doc['pa'], 'id'=>$id, 'message' => 'added successfully.')), 200,array('Content-Type' => 'application/json'));
});
$member->get('/{id}/pa/{pa}/delete', function ($id, $pa, Request $request) use ($app) {
    
	$member = new Model\Member(array('_id'=>$id), $app);
	$member->removePracticeArea($pa);
	$member->getPracticeAreas();
	$member->saveEdit();
    return new Response(json_encode(array('message' => 'removed successfully.')), 200,array('Content-Type' => 'application/json'));
});


return $member;