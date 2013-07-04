<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$page = $app['controllers_factory'];

$page->get('/home', function (Request $request) use ($app) {
	$page_contents_html = $app['view']->renderPageByRoute($request, '/',SAW_SITE_KEY);
    return new Response($page_contents_html,200,array('Content-Type' => 'text/html'));
});
$page->get('/{route}', function ($route, Request $request) use ($app) {
	$page_contents_html = $app['view']->renderPageByRoute($request, '/'.$route,SAW_SITE_KEY);
    return new Response($page_contents_html,200,array('Content-Type' => 'text/html'));
})->assert('route','.+');
$page->post('/{route}', function ($route, Request $request) use ($app) {
	$document['doc'] = $request->get('doc');
	$document['message'] = "success yo";
	$document['route'] = $route;
    return new Response(json_encode($document), 200,array('Content-Type' => 'application/json'));
})->assert('route','.+');

return $page;