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

////////////////////////////
// NEW MEMBER APPLICATION //
////////////////////////////
$app->get('/application/new-member', function (Request $request) use ($app) {
	return $app['view']->render('application/new-member', 'blank');
});
$app->post('/application/new-member', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $application = new Model\NewMemberApplication($doc, $app);
    // validate the model
    $app['validateModel']($app,$application);

    if($application->findByEmail()){
    	$label = 'Success, but...';
    	$message = 'Our records indicate you have already submitted an application.  Please Log-in if you are looking for another Application or contact NCDD directly.';
    	$response_status = 400;
    }else{
    	$application->insert();
    	$label = 'Your application was received.  Thank you.';
    	$message = 'Thank you for your interest in NCDD.  Your application has been submitted.  You will be notified by the College when it is approved or if there are any questions.';
    	$response_status = 200;
    }
    return new Response(json_encode(array('message' => $message,'label'=>$label)), $response_status,array('Content-Type' => 'application/json'));
})->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
	    	$doc = $request->get('doc');
	    	// send admin the email notification
	    	$subject = 'General Member Application Form Submitted';
	    	$to = SAW_ADMIN_EMAIL;
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    	);
	    	$body = $app['view']->render('email/new-member','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to, $app);
	    endif;
});

$app->get('/application/{id}/view', function ($id, Request $request) use ($app) {
	
	$application = new Model\Apply($doc=array('_id'=>$id), $app);
	$application = $application->findById();
	$crumbs = array(array('name'=>'Applications','href'=>'/application')
					,array('name'=>$application['firstName'].' '.$application['lastName'],'href'=>'/application/'.$id.'/view')
					,array('name'=>$application['type'],'href'=>'/application/'.$id.'/view')
					);
	$view_vars = array(
						 'active'=>'Application'
						,'page-plugin'=>'datatables'
						,'headline'=>'Applications'
						,'description'=>"View all application here."
						,'crumbs'=>$crumbs
						,'application'=>$application);
	return $app['view']->render('application/view', 'default', $view_vars);
})->value('id','')
->before($mustbeADMIN);

$app->post('/application/{id}/approve', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $application = new Model\Application($document, $app);
    // validate the model
    $app['validateModel']($app,$application,$groups=array('signup'));
    
    if($application->saveSafe()){
    	return new Response(json_encode(array('message' => 'Saved successfully')), 200,array('Content-Type' => 'application/json'));
    }else{
    	return $app->abort(500, 'Something went wrong and the application did not save.');
    }
})->before($mustbeADMIN);

$app->post('/application/{id}/delete', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $application = new Model\Application($document, $app);
    // validate the model
    $app['validateModel']($app,$application,$groups=array('signup'));
    
    if($application->saveSafe()){
    	return new Response(json_encode(array('message' => 'Saved successfully')), 200,array('Content-Type' => 'application/json'));
    }else{
    	return $app->abort(500, 'Something went wrong and the application did not save.');
    }
})->before($mustbeADMIN);

$app->get('/application/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$application = new Model\Apply($doc=array(), $app);
	$approved = $application->fetch($offset, $limit);
	$unapproved = $application->fetch($offset, $limit);

	$crumbs = array(array('name'=>'Applications','href'=>'/application'));
	$view_vars = array(
						 'active'=>'Applications'
						,'page-plugin'=>'datatables'
						,'headline'=>'Applications'
						,'description'=>"View all application here."
						,'crumbs'=>$crumbs
						,'approved'=>$approved
						,'unapproved'=>$unapproved);
	return $app['view']->render('users/application', 'default', $view_vars);
})
->value('offset','0')
->value('limit','100')
->before($mustbeADMIN);

return $app;