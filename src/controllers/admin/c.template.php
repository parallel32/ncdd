<?php
/////////////////////////
// TEMPLATE MANAGEMENT //
/////////////////////////

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$template = $app['controllers_factory'];
$template->before($mustbeADMIN);

///////////
// INDEX //
///////////
/*
Upload: upload template zip, extract, insert into mongo, process html references (only relative references, http ones are ignored)
by ignoring http ones you can download change and reupload templates because downloaded ones will always have http references
so if you make a change to javascript or css you update the reference to relative

Download: extract from mongo (into directories), zip, download
*/
$template->get('/{domainId}', function ($domainId, Request $request) use ($app) {
	$domain = new Model\Domain($doc=array('_id'=>new MongoId($domainId)), $app);
	$domain = $domain->findById();
	$client = new Model\Client($clientDoc=array('_id'=>$domain['clientId']), $app);
	$client = $client->findById();
	$crumbs = array(array('name'=>'Clients','href'=>'/clients')
					,array('name'=>'Domains','href'=>'/domains/'.$domain['clientId'])
					,array('name'=>'Template','href'=>'/template/'.$domain['_id']));
	$view_vars = array(
						 'active'=>'Clients'
						,'page-plugin'=>'fileupload,chosen'
						,'headline'=>'Template for '.$domain['name']
						,'description'=>"Adding a new template"
						,'crumbs'=>$crumbs
						,'domain'=>$domain
						,'clientId'=>$domain['clientId']);
	return $app['view']->render('template/index', 'default', $view_vars);
})->value('domainId','');
///////////////////////////////
// RECEIVE THE UPLOADED FILE //
///////////////////////////////
$template->match('/upload/{domainId}', function ($domainId, Request $request) use ($app) {
	if(empty($domainId)){
		throw new \Saw\Model\Exceptions\DomainException("You must pass up a domainId.  Please try again.");
	}
	try {
		$doc = array('_id'=>$domainId);
		$template = new Model\Template(array(), $app);
		$template->setRequest($request);
		$domain = new Model\Domain($doc, $app);
		$domain->findById();
		$domain->saveTemplate($template);
		$response_arr = array('files'=>array(0=>array('name'=>$template->getUploadedFileName()
														,'size'=>$template->getUploadedFileSize()
														,'type'=>'zip'
														,'delete_type'=>"GET"
														,'delete_url'=>SAW_SERVER_PUBLIC_URL."/template/delete-uploaded-file/".$template->_id)));
		return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));	
	} catch (Saw\Model\Exceptions\DomainException $e) {
		$fileName = $_FILES['file']['name'];
		$response_arr = array('files'=>array(0=>array('name'=>$fileName
													,'size'=>0
													,'type'=>''
													,'error'=>$e->getMessage()
													)));	
		// 200 response is needed for the javascript fileupload library so that it can display the error message.
		//Otherwise if it's 500 it will display the message Internal Server Error by default
		return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));	
	} catch (Exception $e) {
		$fileName = $_FILES['file']['name'];
		$response_arr = array('files'=>array(0=>array('name'=>$fileName
													,'size'=>0
													,'type'=>''
													,'error'=>$e->getMessage()
													)));	
		// 200 response is needed for the javascript fileupload library so that it can display the error message.
		//Otherwise if it's 500 it will display Internal Server Error by default
		return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));	
	}
})->method('POST');
$template->match('/upload/{domainId}', function ($domainId, Request $request) use ($app) {
		$response_arr = array('files'=>array(0=>array('name'=>'','size'=>0,'type'=>'')));
		return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));	
})->method('HEAD|GET');
// HEAD is for the initial CORS request and POST is to receive the file
//...then HEAD stopped working but GET works as a response for the HEAD request
//...don't know why but I debugged it and silex was interpreting a HEAD request as GET in Symfony\Component\Routing\Matcher\UrlMather::match() function.

///////////////////////////////////////
// DELETE THE PHYSICAL UPLOADED FILE //
///////////////////////////////////////
$template->get('/delete-uploaded-file/{templateId}', function ($templateId, Request $request) use ($app) {
	$response_arr = array('message'=>"success on templateId:".$templateId);
	return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));
});

///////////////////////////////////////////////////////////////////////////
// NO JAVASCRIPT ENABLED NOTICE -- used by fileupload javascript library //
///////////////////////////////////////////////////////////////////////////
$template->get('/upload/nojavascript', function (Request $request) use ($app) {
	return $app['view']->render('template/nojavascript', 'default', $view_vars);
});

///////////////////////////////////
// EXTRACT THE UPLOADED ZIP FILE //
///////////////////////////////////
$template->get('/extract/{domainId}', function ($domainId, Request $request) use ($app) {
	if(empty($domainId)){
		throw new \Saw\Model\Exceptions\DomainException("You must pass up a domainId.  Please try again.");
	}
	$doc = array('_id'=>$domainId);
	$domain = new Model\Domain($doc, $app);
	$doc = $domain->getTemplate();
	return new Response(json_encode(array('elements'=>$doc, 'message' => 'Dialog data loaded.')), 200,array('Content-Type' => 'application/json'));
})->value('domainId','');
$template->post('/extract/{domainId}', function ($domainId, Request $request) use ($app) {
	if(empty($domainId)){
		throw new \Saw\Model\Exceptions\DomainException("You must pass up a domainId.  Please try again.");
	}
	$doc = array('_id'=>$domainId);
	$domain = new Model\Domain($doc, $app);
	$doc['template'] = $domain->getTemplate();
	$template = new Model\Template($doc['template'], $app);
	if($template->extract()){
		return new Response(json_encode(array('message'=>'Template Extracted Successfully')), 200,array('Content-Type' => 'application/json'));
	}else{
		return new Response(json_encode(array('message'=>'Extraction Failed.')), 500,array('Content-Type' => 'application/json'));
	}	
})->value('domainId','');

//////////////////////////////////
// INSERT EXTRACTED FILES TO DB //
//////////////////////////////////
$template->get('/insertdb/{domainId}', function ($domainId, Request $request) use ($app) {
	if(empty($domainId)){
		throw new \Saw\Model\Exceptions\DomainException("You must pass up a domainId.  Please try again.");
	}
	$doc = array('_id'=>$domainId);
	$domain = new Model\Domain($doc, $app);
	$doc['template'] = $domain->getTemplate();
	// save the references to the files that were extracted.
	$template = new Model\Template($doc['template'], $app);
	$template->saveExtractedTemplateFiles();
	$doc['template'] = $template->__toArray();
	$domain = new Model\Domain($doc, $app);
	$domain->saveSafe();
	
	return new Response(json_encode(array('elements'=>$doc['template']['files'],'message'=>'Files that were extracted..')), 200,array('Content-Type' => 'application/json'));
	
})->value('domainId','');
$template->post('/insertdb/{domainId}', function ($domainId, Request $request) use ($app) {
	if(empty($domainId)){
		throw new \Saw\Model\Exceptions\DomainException("You must pass up a domainId.  Please try again.");
	}
	$doc = array('_id'=>$domainId);
	$domain = new Model\Domain($doc, $app);
	$doc = $domain->findById();
	$template = new Model\Template($doc['template'], $app);
	$template->insertDB($doc);
	
	return new Response(json_encode(array('message'=>'Extraced Files inserted into DB successfully')), 200,array('Content-Type' => 'application/json'));
})->value('domainId','');

////////////////////////
// PROCESS HTML FILES //
////////////////////////
$template->get('/processhtml/{domainId}', function ($domainId, Request $request) use ($app) {
	if(empty($domainId)){
		throw new \Saw\Model\Exceptions\DomainException("You must pass up a domainId.  Please try again.");
	}
	$doc = array('_id'=>$domainId);
	$domain = new Model\Domain($doc, $app);
	$doc = $domain->findById();
	$files = $domain->getFilesToProcess();
	return new Response(json_encode(array('elements'=>$files,'message'=>'HTML and CSS files ready to processed for references:')), 200,array('Content-Type' => 'application/json'));
	
})->value('domainId','');
$template->post('/processhtml/{domainId}', function ($domainId, Request $request) use ($app) {
	if(empty($domainId)){
		throw new \Saw\Model\Exceptions\DomainException("You must pass up a domainId.  Please try again.");
	}
	$doc = array('_id'=>$domainId);
	$domain = new Model\Domain($doc, $app);
	$doc = $domain->findById();
	$domain->processFiles();
	return new Response(json_encode(array('message'=>'Processed Files Successfully')), 200,array('Content-Type' => 'application/json'));
})->value('domainId','');




return $template;