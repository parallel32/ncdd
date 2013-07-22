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
	    	$app['sendMail']($subject, $body, $to);
	    endif;
});

$app->get('/application/{id}/view', function ($id, Request $request) use ($app) {
	
	$application = new Model\Apply($doc=array('_id'=>$id), $app);
	$application = $application->findById();
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
						,'application'=>$application);
	return $app['view']->render('application/view', 'default', $view_vars);
})->value('id','')
->before($mustbeADMIN);

$app->get('/application/{id}/approve/{type}', function ($id,$type, Request $request) use ($app) {
	switch ($type) {
		case 'NewMemberApplication':
			$application = new Model\NewMemberApplication(array('_id'=>$id), $app);
			break;
		case 'UpdateMember':
			$application = new Model\UpdateMember(array('_id'=>$id), $app);
			break;
		case 'UpdateFoundingMember':
			$application = new Model\UpdateFoundingMember(array('_id'=>$id), $app);
			break;
		case 'UpdateSustainingMember':
			$application = new Model\UpdateSustainingMember(array('_id'=>$id), $app);
			break;
		case 'NewSustainingMember':
			$application = new Model\NewSustainingMember(array('_id'=>$id), $app);
			break;		
	}
	$application->findById();
    $member = $application->approve();

    // email welcome message
	$subject = 'Welcome To NCDD';
	$to = $member->email;
	$view_vars = array('email'=>$member->email
						,'password'=>$member->password
	);
	$body = $app['view']->render('email/new-member-welcome','email', $view_vars);
	$app['sendMail']($subject, $body, $to);

    return new Response(json_encode(array('message' => 'Approved successfully')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);

$app->get('/application/{id}/pay', function ($id, Request $request) use ($app) {
	
	$application = new Model\Apply($doc=array('_id'=>$id), $app);
	$application = $application->findById();
	$crumbs = array(array('name'=>'Applications','href'=>'/applications')
					,array('name'=>$application['firstName'].' '.$application['lastName'],'href'=>'/application/'.$id.'/view')
					,array('name'=>$application['type'],'href'=>'/application/'.$id.'/view')
					,array('name'=>'Submit Payment','href'=>'/application/'.$id.'/pay')
					);
	$view_vars = array(
						 'active'=>'Application'
						,'page-plugin'=>'datatables'
						,'headline'=>'Membership Application Payment'
						,'description'=>"Pay membership Dues."
						,'crumbs'=>$crumbs
						,'application'=>$application);
	return $app['view']->render('application/pay', 'default', $view_vars);
})->value('id','')
->before($mustbeMEMBER);
$app->post('/application/{id}/pay', function ($id, Request $request) use ($app) {
    
    $doc = $request->get('doc');
    $application = new Model\NewMemberApplication($doc, $app);
    // validate the model
    $app['validateModel']($app,$application);

    return new Response(json_encode(array('message' => 'Successfully Paid')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeMEMBER);

$app->get('/application/{id}/delete', function ($id, Request $request) use ($app) {
    $application = new Model\Apply(array('_id'=>$id), $app);
    $application->remove();
    return new Response(json_encode(array('message' => 'Successfully Deleted')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);

$app->get('/applications/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$application = new Model\Apply($doc=array(), $app);
	$submitted = $application->fetchByStatus('SUBMITTED',$offset, $limit);
	$approved = $application->fetchByStatus('APPROVED',$offset, $limit);
	$paid = $application->fetchByDatePaid(90, $offset, $limit);
	$crumbs = array(array('name'=>'Applications','href'=>'/applications'));
	$view_vars = array(
						 'active'=>'Application'
						,'page-plugin'=>'datatables'
						,'headline'=>'Applications'
						,'description'=>"View all application here."
						,'crumbs'=>$crumbs
						,'submitted'=>$submitted
						,'approved'=>$approved
						,'paid'=>$paid);
	return $app['view']->render('application/index', 'default', $view_vars);
})
->value('offset','0')
->value('limit','100')
->before($mustbeADMIN);

return $app;
//echo"<pre>";print_r($submitted);echo "</pre>";