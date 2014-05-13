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

$emailsent = $app['controllers_factory'];
$emailsent->before($mustbeADMIN);

$emailsent->get('/', function (Request $request) use ($app) {
	
	$emailsent = new Model\EmailSent(array(),$app);
	$emails = $emailsent->find($query=array(),$fields=array('_id'=>1,'to'=>1,'subject'=>1,'sentDate'=>1,'timeZone'=>1),$slaveOkay=true,$sort=array('_id'=>-1),$offset=0,$limit=100);
	$emailcnt = $emailsent->find($query=array(),$fields=array('to'=>1,'subject'=>1,'sentDate'=>1,'timeZone'=>1),$slaveOkay=true,$sort=array(),$offset=0,$limit=10000000000);
	$emailcnt = (is_array($emailcnt)) ? count($emailcnt) : 0;
	
	$emailq = new Model\EmailQ(array(),$app);
	$emailsq = $emailq->find($query=array(),$fields=array('_id'=>1,'to'=>1,'subject'=>1,'sentDate'=>1,'timeZone'=>1),$slaveOkay=true,$sort=array('_id'=>-1),$offset=0,$limit=100);
	$emailqcnt = (is_array($emailsq)) ? count($emailsq): 0;
	
	$crumbs = array(array('name'=>'EmailSent','href'=>'/emailsent'));
	$view_vars = array(
						 'active'=>'EmailSent'
						,'page-plugin'=>'datatables'
						,'headline'=>'EmailSent'
						,'description'=>"All emails sent by the system are recorded here."
						,'crumbs'=>$crumbs
						,'emails'=>$emails
						,'emailcnt'=>$emailcnt
						,'emailsq'=>$emailsq
						,'emailqcnt'=>$emailqcnt
						);
	return $app['view']->render('emailsent/index', 'default', $view_vars);
});

$emailsent->post('/search', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $emailsent = new Model\EmailSent(array(), $app);
    $results = (!empty($doc['search'])) ? $emailsent->search($doc['search']) : array();
    if(!empty($results)){
    	$message = count($results).' emails found.';
    }else{
    	$message = '<h2>No emails matched your keywords.</h2>';
    }
    return new Response(json_encode(array('results'=>$results,'message' => $message)), 200,array('Content-Type' => 'application/json'));
});
// view an email in html format
$emailsent->get('/{id}/view', function ($id, Request $request) use ($app) {
	
	$es = new Model\EmailSent(array('_id'=>$id),$app);
	$es = $es->findById();
	$view_vars = array(
						 'body'=>$es['body']
						);
	return $app['view']->render('emailsent/view', 'blank',$view_vars);
});


// resend an email
$emailsent->get('/resend/{emailsentId}', function ($emailsentId, Request $request) use ($app) {
	
	return new Response(json_encode(array('message' => 'The email has been resent successfully.')), 200,array('Content-Type' => 'application/json'));
})
->value('emailsentId','');

// remove a emailsent completely
$emailsent->get('/{emailsentId}/remove', function ($emailsentId, Request $request) use ($app) {
	
	$emailsent = new Model\EmailSent(array('_id'=>$emailsentId), $app);
    $emailsent->findById();
	$emailsent->delete();
	return new Response(json_encode(array('message' => 'EmailSent details have removed successfully.')), 200,array('Content-Type' => 'application/json'));
	
});
return $emailsent;