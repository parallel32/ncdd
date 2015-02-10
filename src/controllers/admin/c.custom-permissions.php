<?php
///////////////////////////////////
// PAYMENT MANAGEMENT SCREENS /////
///////////////////////////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;


$app->post('/utilities/member/delete', function (Request $request) use ($app) {
    // retrieve document from request
    $document = $request->get('doc');
    $member = new Model\Member($document, $app);
    // validate the model
    $member->removeMember();
    
    return new Response(json_encode(array('message' => 'This Member has been deleted successfully.')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);

$app->get('/page/dynamic/private', function (Request $request) use ($app) {
    // retrieve document from request
    $page = new Model\Page(array(), $app);
    $results = $page->fetchByStatus('PRIVATE');
    //error_log('results:'.print_r($results,true));
    if(!empty($results)){
        $message = count($results).' pages found.';
    }else{
        $message = 'No pages matched that name.';
    }
    return new Response(json_encode(array('results'=>$results,'message' => $message)), 200,array('Content-Type' => 'application/json'));
    
})->before($mustbeMEMBER);

// view all pages
$app->get('/page/all', function (Request $request) use ($app) {
	
	$page = new Model\Page(array(), $app);
	$pages = $page->fetchByStatus('PRIVATE');
	$view_vars['pages']=$pages;
	
	$crumbs = array(array('name'=>'Pages','href'=>'/page/all')
					);
	$view_vars = array(
						 'active'=>'Pages'
						,'page-plugin'=>''
						,'headline'=>'Pages'
						,'description'=>"View a page"
						,'crumbs'=>$crumbs
						,'pages'=>$pages
						
						);
	return $app['view']->render('page/view-all', 'default', $view_vars);
})->before($mustbeMEMBER);
// view a page
$app->get('/page/view/{slug}', function ($slug, Request $request) use ($app) {
	
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$page = $page->findById('slug');

	
	$crumbs = array(array('name'=>'Pages','href'=>'/page/all')
					,array('name'=>$page['headline'],'href'=>'/page/view/'.$slug)
					,array('name'=>'View','href'=>'/page/view/'.$slug)
					);
	$view_vars = array(
						 'active'=>'Pages'
						,'page-plugin'=>''
						,'headline'=>'Pages'
						,'description'=>"View a page"
						,'crumbs'=>$crumbs
						,'page'=>$page
						
						);
	return $app['view']->render('page/view', 'default', $view_vars);
})->before($mustbeMEMBER)->value('slug','');


$app->post('/location/{id}/edit', function ($id, Request $request) use ($app) {
	
    // retrieve document from request
    $doc = $request->get('doc');
    if(!empty($doc['lon']) && !empty($doc['lat'])){
    	$doc['point'] = array($doc['lon'],$doc['lat']);	
    }
    $doc['_id'] = $id;
    
    $location = new Model\Location($doc,$app);
    $app['validateModel']($app,$location);

    // need to get a name to attach the change record
    $loc_res = $location->findOne(array('_id'=>$location->_id));
    //record the change
    $res = Model\Change::check($location,$loc_res['member']['displayName'],$app);

    $location->saveSafe();
    
    return new Response(json_encode(array('message' => 'saved successfully.')), 200,array('Content-Type' => 'application/json'));
});

return $app;