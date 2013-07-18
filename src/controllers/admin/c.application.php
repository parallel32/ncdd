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
    $document = $request->get('doc');
    $application = new Model\Application($document, $app);
    // validate the model
    $app['validateModel']($app,$application,$groups=array('signup'));

    if($application->findByEmail()){
    	$application->upsert();
    	$message = 'This application already exists and was updated. Click Add More to try again or Finished.';
    }else{
    	$application->insert();
    	$message = 'If you would like to add another click Add More or click Finished.';
    }
    return new Response(json_encode(array('message' => $message)), 200,array('Content-Type' => 'application/json'));
});





$app->get('/', function (Request $request) use ($app) {
	$application = new Model\Application($doc=array(), $app);
	$application = $application->find($query=array(),$fields=array('businessName', 'email', 'passwordOriginal'));

	$crumbs = array(array('name'=>'Applications','href'=>'/application'));
	$view_vars = array(
						 'active'=>'Applications'
						,'page-plugin'=>'datatables'
						,'headline'=>'Applications'
						,'description'=>"View all application here."
						,'crumbs'=>$crumbs
						,'application'=>$application);
	return $app['view']->render('users/application', 'default', $view_vars);
});

$app->get('/add', function (Request $request) use ($app) {
	$crumbs = array(array('name'=>'Applications','href'=>'/application')
					,array('name'=>'Add New','href'=>'/application/add'));
	$view_vars = array(
						 'active'=>'Applications'
						,'page-plugin'=>''
						,'headline'=>'Applications'
						,'description'=>"Add a new application"
						,'crumbs'=>$crumbs);
	return $app['view']->render('users/application-add', 'default', $view_vars);
});
$app->post('/add', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $application = new Model\Application($document, $app);
    // validate the model
    $app['validateModel']($app,$application,$groups=array('signup'));
    
    if($application->findByEmail()){
    	$application->upsert();
    	$message = 'This application already exists and was updated. Click Add More to try again or Finished.';
    }else{
    	$application->insert();
    	$message = 'If you would like to add another click Add More or click Finished.';
    }
    return new Response(json_encode(array('message' => $message)), 200,array('Content-Type' => 'application/json'));
	
});

$app->get('/edit/{id}', function ($id, Request $request) use ($app) {

	$application = new Model\Application($doc=array('_id'=>new MongoId($id)), $app);
	$doc = Model\Application::getAccountById($id, $app);

	$crumbs = array(array('name'=>'Applications','href'=>'/application')
					,array('name'=>'Edit','href'=>''));
	$view_vars = array(
						 'active'=>'Applications'
						,'page-plugin'=>''
						,'headline'=>'Applications'
						,'description'=>"Edit a application"
						,'crumbs'=>$crumbs
						,'application'=>$doc);
	return $app['view']->render('users/application-edit', 'default', $view_vars);
})->value('id','');
$app->post('/edit', function (Request $request) use ($app) {
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
});
return $app;