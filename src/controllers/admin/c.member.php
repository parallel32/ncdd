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

$member->get('/', function (Request $request) use ($app) {
	$member = new Model\Member($doc=array(), $app);
	$member = $member->find($query=array(),$fields=array('businessName', 'email', 'passwordOriginal'));

	$crumbs = array(array('name'=>'Members','href'=>'/member'));
	$view_vars = array(
						 'active'=>'Members'
						,'page-plugin'=>'datatables'
						,'headline'=>'Members'
						,'description'=>"View all member here."
						,'crumbs'=>$crumbs
						,'member'=>$member);
	return $app['view']->render('users/member', 'default', $view_vars);
});

$member->get('/add', function (Request $request) use ($app) {
	$crumbs = array(array('name'=>'Members','href'=>'/member')
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

$member->get('/{userId}/edit', function ($userId, Request $request) use ($app) {

	$member = new Model\Member($doc=array('_id'=>new MongoId($userId)), $app);
	$member = $member->findById();
	$member['membershipBadge'] = Model\Member::$membershipBadge[$member['currentMembership']];
	$member['boardCertifiedBadge'] = Model\Member::$boardCertifiedBadge;
	$member['facultyBadge'] = Model\Member::$facultyBadge[$member['currentFacultyPosition']];
	$crumbs = array(array('name'=>'Members','href'=>'/member')
					,array('name'=>$member['firstName'].' '.$member['lastName'],'href'=>'/member/'.$userId.'/edit')
					,array('name'=>'Edit','href'=>'/member/'.$userId.'/edit')
					);
	$view_vars = array(
						 'active'=>'Members/edit'
						,'page-plugin'=>'datatables'
						,'headline'=>'Members'
						,'description'=>"Edit a member"
						,'crumbs'=>$crumbs
						,'member'=>$member);
	return $app['view']->render('member/edit', 'default', $view_vars);
})->value('userId','');
$member->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $member = new Model\Member($document, $app);
    // validate the model
    $app['validateModel']($app,$member);
    $member->saveSafe();
    
    return new Response(json_encode(array('message' => 'Member details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
});
return $member;