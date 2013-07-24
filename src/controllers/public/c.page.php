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

$app->get('/', function (Request $request) use ($app) {
	$view_vars['slogan_block'] = 'home';
	return $app['view']->render('page/home', 'content',$view_vars);
});
$app->get('/deans-message', function (Request $request) use ($app) {
	$view_vars['slogan_block'] = 'deansmessage';
	return $app['view']->render('page/deans-message', 'content', $view_vars);
});
$app->get('/blog', function (Request $request) use ($app) {
	return $app['view']->render('page/blog-roll', 'content');
});
$app->get('/dui-laws-in-your-state', function (Request $request) use ($app) {
	return $app['view']->render('page/dui-laws-in-your-state', 'content');
});


return $app;