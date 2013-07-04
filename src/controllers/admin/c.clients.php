<?php
///////////////////////
// CLIENT MANAGEMENT //
///////////////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$clients = $app['controllers_factory'];
$clients->before($mustbeADMIN);

$clients->get('/', function (Request $request) use ($app) {
	$client = new Model\Client($doc=array(), $app);
	$clients = $client->find($query=array(),$fields=array('businessName', 'email', 'passwordOriginal'));

	$crumbs = array(array('name'=>'Clients','href'=>'/clients'));
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>'datatables'
						,'headline'=>'Clients'
						,'description'=>"View all clients here."
						,'crumbs'=>$crumbs
						,'clients'=>$clients);
	return $app['view']->render('users/clients', 'default', $view_vars);
});

$clients->get('/add', function (Request $request) use ($app) {
	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Add New','href'=>'/clients/add'));
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>''
						,'headline'=>'Clients'
						,'description'=>"Add a new client"
						,'crumbs'=>$crumbs);
	return $app['view']->render('users/clients-add', 'default', $view_vars);
});
$clients->post('/add', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $client = new Model\Client($document, $app);
    // validate the model
    $app['validateModel']($app,$client,$groups=array('signup'));
    
    if($client->findByEmail()){
    	$client->upsert();
    	$message = 'This client already exists and was updated. Click Add More to try again or Finished.';
    }else{
    	$client->insert();
    	$message = 'If you would like to add another click Add More or click Finished.';
    }
    return new Response(json_encode(array('message' => $message)), 200,array('Content-Type' => 'application/json'));
	
});

$clients->get('/edit/{userId}', function ($userId, Request $request) use ($app) {

	$client = new Model\Client($doc=array('_id'=>new MongoId($userId)), $app);
	$doc = Model\Client::getAccountById($userId, $app);

	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Edit','href'=>''));
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>''
						,'headline'=>'Clients'
						,'description'=>"Edit a client"
						,'crumbs'=>$crumbs
						,'client'=>$doc);
	return $app['view']->render('users/clients-edit', 'default', $view_vars);
})->value('userId','');
$clients->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $client = new Model\Client($document, $app);
    // validate the model
    $app['validateModel']($app,$client,$groups=array('signup'));
    
    if($client->saveSafe()){
    	return new Response(json_encode(array('message' => 'Saved successfully')), 200,array('Content-Type' => 'application/json'));
    }else{
    	return $app->abort(500, 'Something went wrong and the client did not save.');
    }
});
return $clients;