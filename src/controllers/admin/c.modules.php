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

$modules = $app['controllers_factory'];
$modules->before($mustbeADMIN);

/////////////////////
// AVAILABLE INDEX //
/////////////////////
$modules->get('/available', function (Request $request) use ($app) {
	$module = new Model\ModuleAvailable($doc=array(), $app);
	$modules = $module->find($query=array(),$fields=array('name','indexRoute'));
	$crumbs = array(array('name'=>'Available Modules','href'=>'/modules/available'));
	$view_vars = array(
						 'active'=>'Modules'
						,'page-plugin'=>'datatables'
						,'headline'=>'Available Modules'
						,'description'=>"Viewing all available modules for domains."
						,'crumbs'=>$crumbs
						,'modules'=>$modules
						);
	return $app['view']->render('modules/available', 'default', $view_vars);
});
///////////////////
// AVAILABLE ADD //
///////////////////
$modules->get('/available/add', function (Request $request) use ($app) {
	$crumbs = array(array('name'=>'Available Modules','href'=>'/modules/available')
					,array('name'=>'Add','href'=>'/modules/available/add'));
	$view_vars = array(
						 'active'=>'Modules'
						,'page-plugin'=>'datatables'
						,'headline'=>'Available Modules'
						,'description'=>"Add a new module"
						,'crumbs'=>$crumbs
						);
	return $app['view']->render('modules/available-add', 'default', $view_vars);
});
$modules->post('/available/add', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $moduleAvailable = new Model\ModuleAvailable($document, $app);
    // validate the model
    $app['validateModel']($app,$moduleAvailable);	        
    $moduleAvailable->insert();
    return new Response(json_encode(array('message' => 'Successfully Added.')), 200,array('Content-Type' => 'application/json'));
});
////////////////////
// AVAILABLE EDIT //
////////////////////
$modules->get('/available/edit/{moduleId}', function ($moduleId, Request $request) use ($app) {
	$module = new Model\ModuleAvailable($doc=array('_id'=>new MongoId($moduleId)), $app);
	$doc = $module->findById();
	
	$crumbs = array(array('name'=>'Available Modules','href'=>'/modules/available')
					,array('name'=>'Edit','href'=>'/modules/available/edit/'.$doc['_id']));
	$view_vars = array(
						 'active'=>'Modules'
						,'page-plugin'=>'datatables'
						,'headline'=>'Available Modules'
						,'description'=>"Edit ".$doc['name']." module"
						,'crumbs'=>$crumbs
						,'module'=>$doc
						);
	return $app['view']->render('modules/available-edit', 'default', $view_vars);
})->value('moduleId','');
$modules->post('/available/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $moduleAvailable = new Model\ModuleAvailable($document, $app);
    // validate the model
    $app['validateModel']($app,$moduleAvailable);	        
    $moduleAvailable->edit();
    return new Response(json_encode(array('message' => 'Successfully Saved.')), 200,array('Content-Type' => 'application/json'));
});
//////////////////////
// AVAILABLE DELETE //
//////////////////////
$modules->get('/available/delete/{moduleId}', function ($moduleId, Request $request) use ($app) {
	if(!empty($moduleId)){
		$doc = array('_id'=>$moduleId);
    	$module = new Model\ModuleAvailable($doc, $app);
    	$module->delete();
    	return new Response(json_encode(array('message' => 'Successfully Deleted.', "id"=>$module->_id)), 200,array('Content-Type' => 'application/json'));
    }else{
    	return $app->abort(400, 'A module id must be passed up.');
    }
})->value('moduleId','');

return $modules;