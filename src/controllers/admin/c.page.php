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

$page = $app['controllers_factory'];
$page->before($mustbeADMIN);

$page->get('/', function (Request $request) use ($app) {
	// retrieve from query string
    $query = $request->get('query');

	$crumbs = array(array('name'=>'Page','href'=>'/page/'));
	$view_vars = array(
						 'active'=>'Pages'
						,'page-plugin'=>'datatables'
						,'headline'=>'Pages'
						,'description'=>"All pages here."
						,'crumbs'=>$crumbs
						);
	return $app['view']->render('page/index', 'default', $view_vars);
});
$page->get('/dynamic', function (Request $request) use ($app) {
	// retrieve document from request
    $page = new Model\Page(array(), $app);
    $results = $page->fetchDynamic();
    //error_log('results:'.print_r($results,true));
    if(!empty($results)){
    	$message = count($results).' pages found.';
    }else{
    	$message = 'No pages matched that name.';
    }
    return new Response(json_encode(array('results'=>$results,'message' => $message)), 200,array('Content-Type' => 'application/json'));
	
});
$page->get('/managed', function (Request $request) use ($app) {
	// retrieve document from request
    $page = new Model\Page(array(), $app);
    $results = $page->fetchManaged();
    if(!empty($results)){
    	$message = count($results).' pages found.';
    }else{
    	$message = 'No pages matched that name.';
    }
    return new Response(json_encode(array('results'=>$results,'message' => $message)), 200,array('Content-Type' => 'application/json'));
	
});

$page->get('/order/{id}/{order}', function ($id, $order, Request $request) use ($app) {
    $order = (empty($order)) ? '*' : $order ;
	$page = new Model\Page(array('_id'=>$id,'orderNum'=>$order), $app);
	$page->updateOrderNum();
    return new Response(json_encode(array('message' => 'order updated successfully.')), 200,array('Content-Type' => 'application/json'));
})->value('order','*');


$page->get('/{slug}/delete', function ($slug, Request $request) use ($app) {
	// retrieve document from request
    $page = new Model\Page(array('slug'=>$slug), $app);
    // validate the model
    $page->delete();
    
    return new Response(json_encode(array('message' => 'Page has been deleeted successfully.')), 200,array('Content-Type' => 'application/json'));
});

$page->get('/{slug}/{type}/edit/{headline}', function ($slug, $type, $headline, Request $request) use ($app) {
	$add = ($headline == 'place-holder' && $slug == 'place-holder') ? 'yes': 'no';
	$headline = ($headline == 'place-holder') ? '' : $headline ;
	$slug = ($slug == 'place-holder') ? '' : $slug;

	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$page = $page->findById('slug');

	
	$crumbs = array(array('name'=>'Pages','href'=>'/page/')
					,array('name'=>(!empty($page) && array_key_exists('headline',$page)) ? $page['headline'] : $headline ,'href'=>'/page/'.$slug.'/'.$type.'/edit')
					,array('name'=>'Edit','href'=>'/page/'.$slug.'/'.$type.'/edit')
					);
	$view_vars = array(
						 'active'=>'Pages'
						,'page-plugin'=>'editor'
						,'headline'=>'Pages'
						,'description'=>"Edit a page"
						,'crumbs'=>$crumbs
						,'page'=>$page
						,'slug'=>$slug
						,'currentType'=>Model\Page::$type[$type]
						,'type'=>Model\Page::$type
						,'headline'=>$headline
						,'statusReversed'=>Model\Page::$statusReversed
						,'status'=>Model\Page::$status
						,'add'=>$add
						);

	// prepare the virtual forensic library modal
	$app['prepare_vfl']($view_vars);

	return $app['view']->render('page/edit', 'default', $view_vars);
})->value('slug','')->value('headline','');
$page->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $page = new Model\Page($document, $app);
    // validate the model
    $app['validateModel']($app,$page);
    $page->saveEdit();
    
    return new Response(json_encode(array('message' => 'Page details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
});


return $page;