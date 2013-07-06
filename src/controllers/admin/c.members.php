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

$members = $app['controllers_factory'];
$members->before($mustbeADMIN);

$members->get('/', function (Request $request) use ($app) {
	$member = new Model\Member($doc=array(), $app);
	$members = $member->find($query=array(),$fields=array('businessName', 'email', 'passwordOriginal'));

	$crumbs = array(array('name'=>'Members','href'=>'/members'));
	$view_vars = array(
						 'active'=>'Members'
						,'page-plugin'=>'datatables'
						,'headline'=>'Members'
						,'description'=>"View all members here."
						,'crumbs'=>$crumbs
						,'members'=>$members);
	return $app['view']->render('users/members', 'default', $view_vars);
});

$members->get('/add', function (Request $request) use ($app) {
	$crumbs = array(array('name'=>'Members','href'=>'/members')
					,array('name'=>'Add New','href'=>'/members/add'));
	$view_vars = array(
						 'active'=>'Members'
						,'page-plugin'=>''
						,'headline'=>'Members'
						,'description'=>"Add a new member"
						,'crumbs'=>$crumbs);
	return $app['view']->render('users/members-add', 'default', $view_vars);
});
$members->post('/add', function (Request $request) use ($app) {
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

$members->get('/edit/{userId}', function ($userId, Request $request) use ($app) {

	$member = new Model\Member($doc=array('_id'=>new MongoId($userId)), $app);
	$doc = Model\Member::getAccountById($userId, $app);

	$crumbs = array(array('name'=>'Members','href'=>'/members')
					,array('name'=>'Edit','href'=>''));
	$view_vars = array(
						 'active'=>'Members'
						,'page-plugin'=>''
						,'headline'=>'Members'
						,'description'=>"Edit a member"
						,'crumbs'=>$crumbs
						,'member'=>$doc);
	return $app['view']->render('users/members-edit', 'default', $view_vars);
})->value('userId','');
$members->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $member = new Model\Member($document, $app);
    // validate the model
    $app['validateModel']($app,$member,$groups=array('signup'));
    
    if($member->saveSafe()){
    	return new Response(json_encode(array('message' => 'Saved successfully')), 200,array('Content-Type' => 'application/json'));
    }else{
    	return $app->abort(500, 'Something went wrong and the member did not save.');
    }
});
return $members;