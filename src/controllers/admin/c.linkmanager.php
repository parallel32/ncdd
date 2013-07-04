<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$app['issueSubRequest'] = $app->protect(function (Request $request, $uri) use ($app) {
	try {
		$uri = $uri ?: '/page/home';
		$subRequest = Request::create($uri
	    								,$request->getMethod()
	    								,array('doc'=>$request->get('doc')) ?: array()
	    								,$request->cookies->all()
	    								,$request->files->all()
	    								,$request->server->all());
		if ($request->getSession()) {
		    $subRequest->setSession($request->getSession());
		}
		$response = $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST, false);	
		return $response;
	} catch (Exception $e) {
		$sawException = new Saw\Exceptions\SawException($e);
		return $app['errorExceptionHandler']($e, $sawException->getHttpStatusCode());
	}
	
});
$app['linkManager'] = $app->protect(function (GetResponseEvent $event) use ($app) {

	
	// if the host is not the cms admin website then proceed to validate links
	// this basically turns off all re-routing of paths for the admin system
	// also ignore the link processing of all routes that start with the following black list
	$request = $event->getRequest();
	$_route = $request->getPathInfo();
	$_route_params = $request->attributes->get('_route_params') ?: array();

	$blacklisted = false;
	$black_list = array('/tfs','/ufs','favicon.ico');
	foreach($black_list as $prefix){
		if(strpos($_route, $prefix) !== false){
			$blacklisted = true;
		}
	}
	//error_log('blacklisted:'.($blacklisted)?'yes':'no');
	// initial conditions must be met in order to begin processing a link
	if(!$blacklisted 
		&& $request instanceof Request 
		&& $request->getHost() != SAW_ADMIN_WEBSITE 
		&& $request->getHost() != SAW_SERVER_PUBLIC_NAME):


		switch ($event->getRequestType()) {
	    	case HttpKernelInterface::MASTER_REQUEST:
	    		//error_log('MASTER_REQUEST');
	    		break;
	    	case HttpKernelInterface::SUB_REQUEST:
		    	//error_log('SUB_REQUEST');
	    		break;		    	
	    }
		
	    
	    /*
	    error_log('host:'.$request->getHost());
		error_log('_route:'.print_r($_route,true));
		error_log('_route_params:'.print_r($_route_params,true));
	    error_log('site-key:'.SAW_SITE_KEY);
		error_log('index-route:'.SAW_INDEX_ROUTE);
		//*/	
	    if(true):
	    	//*  LOGIC FOR VALIDATING LINKS
		    // query mongo for the link
		    $doc = array('route'=>$_route,'siteKey'=>SAW_SITE_KEY);
		    $link = new Model\Link($doc,$app);
		    $result = $link->findBySitekeyRoute(false,'');// find also checks if it's a module by querying the route against the registered modules
		    //error_log('link result:'.print_r($result,true));
		    
		    if(array_key_exists('statusCode',$result) && $result['statusCode'] > 201):
		    	$headers=array('Content-Type' => 'text/html');
		    	if(!empty($result['redirect'])){
		    		$headers = array_merge($headers,array('Location'=>$result['redirect']));
		    	}
		    	$_route = '/'.$result['statusCode'];
		    	$page_contents = $app['view']->renderPageTypeByRoute($_route
		    														,SAW_SITE_KEY
		    														,$view_vars=array('message'=>$result['message'],'redirect'=>$result['redirect']));
		    	$response = new Response($page_contents,200,$headers);
		    	$event->setResponse($response);
		    	return;
		    endif;

		    // check if the link is a module(of the available modules), if so let pass thru otherwise send it to the index route
		    if(!$result['isModule'] && HttpKernelInterface::MASTER_REQUEST === $event->getRequestType() && strpos($_route, '/sawcms') === false):
	    		// check for 404
		    	unset($result['isModule']);
		    	if(empty($result) && $_route != '/'){
		    		//error_log('..........in 404');
		    		// render the 404 page type
			    	$page_contents = $app['view']->renderPageTypeByRoute('/404',SAW_SITE_KEY,array('route'=>$_route));
			    	$response = new Response($page_contents,200,array('Content-Type' => 'text/html'));
			    	$event->setResponse($response);
			    	return;
		    	}

	    		// _route contains a starting slash(/)
	    		$new_route = ($_route=='/') ? SAW_INDEX_ROUTE : '/page'.$_route;
				//error_log('new_route:'.$new_route);
		        $response = $app['issueSubRequest']($request, $new_route);
				$event->setResponse($response);
				return;
			endif;
		
	    endif;// true | false

   	else:
   		//error_log('else statement');
   		//error_log('_route:'.$_route);
	endif;
	
});

$app['dispatcher']->addListener(KernelEvents::EXCEPTION, function (GetResponseForExceptionEvent $event) use ($app) {
	// if i send exceptions through the link manager again they will throw an error that they were not caught
	// also they will not get caught in the global error handler.  I think this is not necessary anymore
	// because now the error handler checks if it's not the admin site and if so renders the error page via 
	// the new renderPageTypeByRoute() method in the view wrapper...
	//error_log('via exception listener===================================================');
	$app['linkManager']($event);
}, Silex\Application::EARLY_EVENT+1);

$app['dispatcher']->addListener(KernelEvents::REQUEST, function (GetResponseEvent $event) use ($app) {
	//error_log('via request listener:::::::::::::::::::::::::::::::::::::::::::::::::::::::');
    $app['linkManager']($event);
});

return $app;