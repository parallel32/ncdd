<?php
///////////////////////
// DOMAIN MANAGEMENT //
///////////////////////

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$domains = $app['controllers_factory'];
$domains->before($mustbeADMIN);

///////////
// INDEX //
///////////
$domains->get('/{clientId}', function ($clientId, Request $request) use ($app) {
	$domain = new Model\Domain($doc=array(), $app);
	$domains = $domain->find($query=array('clientId'=>$clientId),$fields=array('name'=>true,'serverAliasSaw'=>true,'siteKey'=>true,'indexRoute'=>true,'enabled'=>true,'modules'=>true,'pageTypes'=>true,'pageCount'=>true,'linkCount'=>true));
	$client = new Model\Client($doc=array('_id'=>$clientId), $app);
	$clientDoc = $client->findById();

	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Domains','href'=>'/domains/'.$clientId));
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>'datatables'
						,'headline'=>'Domains for '.$clientDoc['businessName']
						,'description'=>"Viewing all domains."
						,'crumbs'=>$crumbs
						,'domains'=>$domains
						,'clientId'=>$clientId);
	return $app['view']->render('domains/index', 'default', $view_vars);
})->value('clientId','');
/////////
// ADD //
/////////
$domains->get('/{clientId}/add', function ($clientId, Request $request) use ($app) {
	$client = new Model\Client($doc=array('_id'=>$clientId), $app);
	$clientDoc = $client->findById();

	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Domains','href'=>'/domains/'.$clientId)
					,array('name'=>'Add New','href'=>'/domains/'.$clientId.'/add'));
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>''
						,'headline'=>'Domain for '.$clientDoc['businessName']
						,'description'=>"Adding a New Domain"
						,'crumbs'=>$crumbs
						,'clientId'=>$clientId);
	return $app['view']->render('domains/add', 'default', $view_vars);
})->value('clientId','');
$domains->post('/add', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $domain = new Model\Domain($document, $app);
    // validate the model
    $app['validateModel']($app,$domain);	        
    $domain->insert();
    return new Response(json_encode(array('message' => 'Domain Successfully Added.')), 200,array('Content-Type' => 'application/json'));
});
//////////
// EDIT //
//////////
$domains->get('/edit/{domainId}', function ($domainId, Request $request) use ($app) {
	$domain = new Model\Domain($doc=array('_id'=>new MongoId($domainId)), $app);
	$doc = $domain->findById();
	$client = new Model\Client($clientDoc=array('_id'=>$doc['clientId']), $app);
	$clientDoc = $client->findById();
	
	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Domains','href'=>'/domains/'.$doc['clientId'])
					,array('name'=>'Edit','href'=>'/domains/edit/'.$doc['_id']));
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>''
						,'headline'=>'Domain for '.$clientDoc['businessName']
						,'description'=>"Editing a Domain"
						,'crumbs'=>$crumbs
						,'domain'=>$doc
						,'clientId'=>$doc['clientId']);
	return $app['view']->render('domains/edit', 'default', $view_vars);
})->value('domainId','');
$domains->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $domain = new Model\Domain($document, $app);
    // validate the model
    $app['validateModel']($app,$domain);
    $domain->edit();
    return new Response(json_encode(array('message' => 'Domain Successfully Edited.')), 200,array('Content-Type' => 'application/json'));
});
////////////
// ENABLE //
////////////
$domains->get('/enable/{domainName}', function ($domainName, Request $request) use ($app) {
	if(!empty($domainName)){
		$doc = array('name'=>$domainName);
    	$domain = new Model\Domain($doc, $app);
    	$domain->enable();
    	return new Response(json_encode(array('message' => $domainName.' has been enabled.', "id"=>$domain->_id)), 200,array('Content-Type' => 'application/json'));
    }else{
    	return $app->abort(400, 'A domain name must be passed up.');
    }
})->value('domainName','');
/////////////
// DISABLE //
/////////////
$domains->get('/disable/{domainName}', function ($domainName, Request $request) use ($app) {
	if(!empty($domainName)){
		$doc = array('name'=>$domainName);
    	$domain = new Model\Domain($doc, $app);
    	$domain->disable();
    	return new Response(json_encode(array('message' => $domainName.' has been disabled.', "id"=>$domain->_id)), 200,array('Content-Type' => 'application/json'));
    }else{
    	return $app->abort(400, 'A domain name must be passed up.');
    }
})->value('domainName','');
////////////
// DELETE //
////////////
$domains->get('/delete/{domainName}', function ($domainName, Request $request) use ($app) {
	if(!empty($domainName)){
		$doc = array('name'=>$domainName);
    	$domain = new Model\Domain($doc, $app);
    	// TODO deleting a domain is dangerous and can lead to many orphaned records: pages, links, images, domain.files domain.chunks
    	// need to put in more thought about how to delete domains.
    	//$domain->delete();
    	return new Response(json_encode(array('message' => $domainName.' has been deleted...NO THE DELETE METHOD HAS BEEN COMMENTED OUT C.DOMAINS.PHP LINE 133', "id"=>$domain->_id)), 200,array('Content-Type' => 'application/json'));
    }else{
    	return $app->abort(400, 'A domain name must be passed up.');
    }
})->value('domainName','');
/////////////
// MODULES //
/////////////
$domains->get('/modules/{domainId}', function ($domainId, Request $request) use ($app) {
	$domain = new Model\Domain($doc=array('_id'=>new MongoId($domainId)), $app);
	$domain = $domain->findById();
	$client = new Model\Client($clientDoc=array('_id'=>$domain['clientId']), $app);
	$clientDoc = $client->findById();
	$module = new Model\ModuleAvailable($mdoc=array(),$app);
	$modules = $module->find(array(), array());
	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Domains','href'=>'/domains/'.$domain['clientId'])
					,array('name'=>'Modules','href'=>'/domains/modules/'.$domain['_id']));
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>'checkboxes'
						,'headline'=>'Domain for '.$clientDoc['businessName']
						,'description'=>"Editing Modules"
						,'crumbs'=>$crumbs
						,'domain'=>$domain
						,'clientId'=>$domain['clientId']
						,'modules'=>$modules);
	return $app['view']->render('domains/modules', 'default', $view_vars);
})->value('domainId','');
$domains->get('/modules/add/{domainId}/{moduleId}', function ($domainId, $moduleId, Request $request) use ($app) {
	if(empty($domainId) || empty($moduleId)){
		throw new \Saw\Model\Exceptions\DomainException("You must pass up a domainId and a moduleId.  Please try again.");
	}
	$domain = new Model\Domain(array('_id'=>$domainId), $app);
	$module = new Model\ModuleAvailable(array('_id'=>$moduleId),$app);
    $module->findById();
    $domain->addModule($module);
    return new Response(json_encode(array('message' => 'Module successfully added.')), 200,array('Content-Type' => 'application/json'));
})->value('domainId','')
->value('moduleId','');
$domains->get('/modules/remove/{domainId}/{moduleId}', function ($domainId, $moduleId, Request $request) use ($app) {
	if(empty($domainId) || empty($moduleId)){
		throw new \Saw\Model\Exceptions\DomainException("You must pass up a domainId and a moduleId.  Please try again.");
	}
	$domain = new Model\Domain(array('_id'=>$domainId), $app);
	$module = new Model\ModuleAvailable(array('_id'=>$moduleId),$app);
	$module->findById();
    $domain->removeModule($module);
    return new Response(json_encode(array('message' => 'Module successfully removed.')), 200,array('Content-Type' => 'application/json'));
})->value('domainId','')
->value('moduleId','');
return $domains;