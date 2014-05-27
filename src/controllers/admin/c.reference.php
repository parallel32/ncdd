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

////////////////////
// REFERENCE FORM //
////////////////////
// {id} is the owner id for which this reference is for. in most cases this is the applicationId
$app->get('/reference/{id}/view', function ($id, Request $request) use ($app) {

	$reference = new Model\Reference(array('_id'=>$id),$app);
    $reference = $reference->findById();
	
	$application = new Model\Apply(array('_id'=>$reference['applicationId']),$app);
    $application = $application->findById();

    switch ($reference['class']) {
    	case 'ReferenceMember':
    		$view = 'reference/view-new-member';
    		break;
    	case 'ReferenceSustainingMember':
    		$view = 'reference/view-new-sustaining-member';
    		break;
    	
    }
    $crumbs = array(array('name'=>'Applications','href'=>'/applications')
					,array('name'=>$application['firstName'].' '.$application['lastName'],'href'=>'/application/'.$id.'/view')
					,array('name'=>$application['type'],'href'=>'/application/'.$id.'/view')
					,array('name'=>'Reference','href'=>'/reference/'.$id.'/view')
					);
	$view_vars = array(
						 'active'=>'Application'
						,'page-plugin'=>'datatables'
						,'headline'=>'Reference'
						,'description'=>""
						,'crumbs'=>$crumbs
						,'reference'=>$reference
    					,'application'=>$application
						);
	
    
	return $app['view']->render($view, 'default', $view_vars);
})->before($mustbeADMIN);
// {id} is the owner id for which this reference is for. in most cases this is the applicationId
$app->get('/reference/{id}/view-public', function ($id, Request $request) use ($app) {

	$reference = new Model\Reference(array('_id'=>$id),$app);
    $reference = $reference->findById();
	
	$application = new Model\Apply(array('_id'=>$reference['applicationId']),$app);
    $application = $application->findById();

    switch ($reference['class']) {
    	case 'ReferenceMember':
    		$view = 'reference/view-new-member-public';
    		break;
    	case 'ReferenceSustainingMember':
    		$view = 'reference/view-new-sustaining-member-public';
    		break;
    	
    }
    $crumbs = array(array('name'=>'Applications','href'=>'/applications')
				,array('name'=>$application['firstName'].' '.$application['lastName'],'href'=>'/application/'.$id.'/view')
				,array('name'=>$application['type'],'href'=>'/application/'.$id.'/view')
				,array('name'=>'Reference','href'=>'/reference/'.$id.'/view-public')
				);
    $view_vars = array(
						 'active'=>'Application'
						,'page-plugin'=>'datatables'
						,'headline'=>'Private Reference View'
						,'description'=>""
						,'crumbs'=>$crumbs
						,'reference'=>$reference
    					,'application'=>$application
						);
	
	return $app['view']->render($view, 'blank', $view_vars);
});

// {id} is the owner id for which this reference is for. in most cases this is the applicationId
// in our case the owner id is an application (new member or sustaining member)
// {for} is the name of the applicant simply to give the url a friendly appearance
$app->get('/reference/{id}/{for}', function ($id, $for, Request $request) use ($app) {

	$application = new Model\Apply(array('_id'=>$id),$app);
    $application = $application->findById();
    switch ($application['class']) {
    	case 'ApplyNewMember':
    		$reference = new Model\ReferenceMember(array('applicationId'=>$id), $app);
    		$view = 'reference/new-member';
    		break;
    	case 'ApplyNewSustainingMember':
    		$reference = new Model\ReferenceSustainingMember(array('applicationId'=>$id), $app);
    		$view = 'reference/new-sustaining-member';
    		break;
    	
    }
    $view_vars = array(
    	'max-submissions-reached'=>$reference->checkMaxSubmissions()
    	,'application'=>$application);

	return $app['view']->render($view, 'blank', $view_vars);
});
$app->post('/reference/{id}', function ($id, Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');

    $application = new Model\Apply(array('_id'=>$doc['applicationId']),$app);
    $application = $application->findById();
    $doc['application'] = $application;
    switch ($application['class']) {
    	case 'ApplyNewMember':
    		$reference = new Model\ReferenceMember($doc, $app);
    		break;
    	case 'ApplyNewSustainingMember':
    		$reference = new Model\ReferenceSustainingMember($doc, $app);
    		break;
    	
    }
    // validate the model
    $app['validateModel']($app,$reference);
    $reference->insert();

    return new Response(json_encode(array('message' => 'On behalf of the NCDD executive committee, thank you for taking the time to submit the reference form.'
    									  ,'label'=>'We have received the reference form.')), 200,array('Content-Type' => 'application/json'));

})->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
	    	$doc = $request->get('doc');
	    	$application = new Model\Apply(array('_id'=>$doc['applicationId']),$app);
		    $application = $application->findById();
		    switch ($application['class']) {
		    	case 'ApplyNewMember':
		    		$reference = new Model\ReferenceMember($doc, $app);
		    		break;
		    	case 'ApplyNewSustainingMember':
		    		$reference = new Model\ReferenceSustainingMember($doc, $app);
		    		break;
		    	
		    }
		    // send email notification to the admin only when the max submissions have been reached
	    	if($reference->checkMaxSubmissions()){
	    		$subject = 'All References Submitted';
		    	$to = SAW_ADMIN_EMAIL;
		    	$view_vars = array('applicationId'=>$doc['applicationId']);
		    	$body = $app['view']->render('email/new-member-reference-max-submissions','email', $view_vars);
		    	$app['sendMail']($subject, $body, $to);
	    	}
	    	
	    endif;
});
return $app;