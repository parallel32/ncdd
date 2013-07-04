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

$links = $app['controllers_factory'];
$links->before($mustbeADMIN);
///////////
// INDEX //
///////////
$links->get('/{domainId}', function ($domainId, Request $request) use ($app) {
	if(empty($domainId) || strlen($domainId) < 24)
		throw new \Saw\Model\Exceptions\DomainException("You must pass a domainId.");
	$link = new Model\Link($doc=array('domainId'=>$domainId), $app);
	$links = $link->find($query=array('domainId'=>$domainId),$fields=array('_id','statusCode','route','pageType','name'),true,array('_id'=>-1));
	
	$domain = new Model\Domain($doc=array('_id'=>$domainId), $app);
	$domain->findById();
	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Domains','href'=>'/domains/'.$domain->clientId)
					,array('name'=>'Links','href'=>'/links/'.$domainId));
	

	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>'datatables'
						,'headline'=>'Links'
						,'description'=>"Viewing all available links for domain: <strong>".$domain->name."</strong>."
						,'crumbs'=>$crumbs
						,'links'=>$links
						,'domainId'=>$domainId
						);
	return $app['view']->render('links/index', 'default', $view_vars);
})->value('domainId','');
$links->get('/pages/{domainId}', function ($domainId, Request $request) use ($app) {
	if(empty($domainId) || strlen($domainId) < 24)
		throw new \Saw\Model\Exceptions\DomainException("You must pass a domainId.");
	$link = new Model\Link($doc=array('domainId'=>$domainId), $app);
	$links = $link->getPages();
	$domain = new Model\Domain($doc=array('_id'=>$domainId), $app);
	$domain->findById();
	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Domains','href'=>'/domains/'.$domain->clientId)
					,array('name'=>'Links','href'=>'/links/'.$domainId)
					,array('name'=>'Pages','href'=>'/links/pages/'.$domainId)
					);
	

	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>'datatables'
						,'headline'=>'Pages'
						,'description'=>"Viewing all available Pages for domain: <strong>".$domain->name."</strong>."
						,'crumbs'=>$crumbs
						,'links'=>$links
						,'domainId'=>$domainId
						);
	return $app['view']->render('links/index', 'default', $view_vars);
})->value('domainId','');
/////////
// ADD //
/////////
$links->get('/{domainId}/add', function ($domainId, Request $request) use ($app) {
	if(empty($domainId))
		throw new \Saw\Model\Exceptions\DomainException("You must pass a domainId.");
	$domain = new Model\Domain($doc=array('_id'=>$domainId), $app);
	$domain->findById();
	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Domains','href'=>'/domains/'.$domain->clientId)
					,array('name'=>'Links','href'=>'/links/'.$domainId)
					,array('name'=>'Add','href'=>'/links/'.$domainId.'/add'));
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>'datatables'
						,'headline'=>'Links'
						,'description'=>"Add a new link for: <strong>".$domain->name."</strong>"
						,'crumbs'=>$crumbs
						,'domainId'=>$domainId
						,'siteKey'=>$domain->siteKey
						,'pageTypes'=>$domain->pageTypes
						);
	return $app['view']->render('links/add', 'default', $view_vars);
})->value('domainId','');

$links->post('/add', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $link = new Model\Link($document, $app);
    // validate the model
    $app['validateModel']($app,$link,$groups=array('add'));	        
    $link->insert();
    return new Response(json_encode(array('message' => 'Successfully Added.')), 200,array('Content-Type' => 'application/json'));
});

$links->get('/{domainId}/addbatch', function ($domainId, Request $request) use ($app) {
	if(empty($domainId))
		throw new \Saw\Model\Exceptions\DomainException("You must pass a domainId.");
	$domain = new Model\Domain($doc=array('_id'=>$domainId), $app);
	$domain->findById();
	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Domains','href'=>'/domains/'.$domain->clientId)
					,array('name'=>'Links','href'=>'/links/'.$domainId)
					,array('name'=>'Add Batch','href'=>'/links/'.$domainId.'/add'));
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>'datatables'
						,'headline'=>'Links'
						,'description'=>"Add new links for: <strong>".$domain->name."</strong>"
						,'crumbs'=>$crumbs
						,'domainId'=>$domainId
						,'siteKey'=>$domain->siteKey
						,'pageTypes'=>$domain->pageTypes
						);
	return $app['view']->render('links/addbatch', 'default', $view_vars);
})->value('domainId','');

$links->post('/addbatch', function (Request $request) use ($app) {
	// retrieve document from request
	$validation_errors = array();
	$other_errors = array();
	$document = $request->get('doc');
    $lines = explode(PHP_EOL,$document['batch']);
    for ($i=0; $i < count($lines); $i++) { 
    	//*
    	$csv_arr = explode(',',trim($lines[$i]));
    	$doc['pageType'] 	= trim($csv_arr[0]);
	    $doc['route'] 		= trim($csv_arr[1]);
	    $doc['name'] 		= trim($csv_arr[2]);
	    $doc['statusCode'] 	= trim($csv_arr[3]);
	    $doc['redirect'] 	= trim($csv_arr[4]);
	    $doc['message'] 	= trim($csv_arr[5]);
	    $doc['siteKey'] 	= $document['siteKey'];
	    $doc['domainId'] 	= $document['domainId'];
    	
	    try {
	    	$link = new Model\Link($doc, $app);
	    	// validate the model
		    $app['validateModel']($app,$link,$groups=array('addbatch'));	
		    $link->insert();
	    } catch (\Saw\Model\Exceptions\DomainException $e) {
	    	$invalid_arr = $e->getInvalidFields();
	    	$inv_str = '';
	    	foreach($invalid_arr as $arr){
	    		$inv_str.= implode(',',$arr);
	    	}
	    	array_push($validation_errors, $lines[$i].' >> ERRORS >> '.$inv_str);
	    } catch (\Exception $e) {
	    	array_push($other_errors, $lines[$i]);
	    }
	    
    }// end for
    
    if(!empty($validation_errors)){
    	return new Response(json_encode(array('errors'=>$validation_errors,'message' => 'The following records did not validate.')), 400,array('Content-Type' => 'application/json'));
    }
    if(!empty($other_errors)){
    	return new Response(json_encode(array('errors'=>$other_errors,'message' => 'The following records did not not insert because of an internal server error.')), 500,array('Content-Type' => 'application/json'));
    }
    return new Response(json_encode(array('message' => 'Successfully added.')), 200,array('Content-Type' => 'application/json'));
    
});
//////////
// EDIT //
//////////
$links->get('/edit/{linkId}', function ($linkId, Request $request) use ($app) {
	if(empty($linkId) || strlen($linkId) < 24)
		throw new \Saw\Model\Exceptions\DomainException("You must pass a linkId.");

	$link = new Model\Link($doc=array('_id'=>new MongoId($linkId)), $app);
	$doc = $link->findById();
	
	$domain = new Model\Domain(array('_id'=>$link->domainId), $app);
	$domain->findById();
	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Domains','href'=>'/domains/'.$domain->clientId)
					,array('name'=>'Links','href'=>'/links/'.$link->domainId)
					,array('name'=>'Edit','href'=>'/links/edit/'.$doc['_id']));
	
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>'datatables'
						,'headline'=>' links'
						,'description'=>"Edit link for: <strong>".$domain->name."</strong>"
						,'crumbs'=>$crumbs
						,'pageTypes'=>$domain->pageTypes
						,'link'=>$doc
						);
	return $app['view']->render('links/edit', 'default', $view_vars);
})->value('linkId','');

$links->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $link = new Model\Link($document, $app);
    // validate the model
    $validate_group = (array_key_exists('oldRoute',$document)) ? 'editroute' : 'edit';
    $app['validateModel']($app,$link,$groups=array($validate_group));	 

    $link->edit();
    return new Response(json_encode(array('message' => 'Successfully Saved.')), 200,array('Content-Type' => 'application/json'));
});

$links->get('/{domainId}/editroute/', function ($domainId, Request $request) use ($app) {
	if(empty($domainId) || strlen($domainId) < 24)
		throw new \Saw\Model\Exceptions\DomainException("You must pass a domainId.");

	$domain = new Model\Domain(array('_id'=>$domainId), $app);
	$domain->findById();
	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Domains','href'=>'/domains/'.$domain->clientId)
					,array('name'=>'Links','href'=>'/links/'.$domainId)
					,array('name'=>'Edit by Route','href'=>'/links/'.$domainId.'/editroute'));
	
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>'datatables'
						,'headline'=>' links'
						,'description'=>"Edit link for: <strong>".$domain->name."</strong>"
						,'crumbs'=>$crumbs
						,'pageTypes'=>$domain->pageTypes
						,'siteKey'=>$domain->siteKey
						,'domainId'=>$domainId
						);
	return $app['view']->render('links/editroute', 'default', $view_vars);
})->value('domainId','');

////////////
// DELETE //
////////////
$links->get('/delete/{linkId}', function ($linkId, Request $request) use ($app) {
	if(empty($linkId) || strlen($linkId) < 24)
		throw new \Saw\Model\Exceptions\DomainException("You must pass a linkId.");
	$doc = array('_id'=>$linkId);
	$link = new Model\Link($doc, $app);
	$link->delete();
	return new Response(json_encode(array('message' => 'Successfully Deleted.', "id"=>$link->_id)), 200,array('Content-Type' => 'application/json'));
})->value('linkId','');
////////////////////////
// REAL-TIME SLUGGIFY //
////////////////////////
$links->post('/slugify', function (Request $request) use ($app) {
	$str = $request->get('slug-str');
	$slug = Model\Link::slugify($str);
	return new Response(json_encode(array('message' => 'Successfully converted.', "slug"=>$slug)), 200,array('Content-Type' => 'application/json'));
});

return $links;