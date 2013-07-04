<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$app->get('/contact', function (Request $request) use ($app) {
	$page_contents_html = $app['view']->renderPageTypeByRoute('/portfolio',SAW_SITE_KEY);
    return new Response($page_contents_html,200,array('Content-Type' => 'text/html'));
});
$app->post('/contact', function (Request $request) use ($app) {
	$document['doc'] = $request->get('doc');
	$document['message'] = "success yo";
	return new Response(json_encode($document), 200,array('Content-Type' => 'application/json'));
});

return $app;