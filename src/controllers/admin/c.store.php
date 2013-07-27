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

$store = $app['controllers_factory'];
$store->before($mustbeMEMBER);

$store->get('/', function (Request $request) use ($app) {
	
	$crumbs = array(array('name'=>'NCDD Store','href'=>'/store/'));
	$view_vars = array(
						 'active'=>'Store'
						,'page-plugin'=>'datatables'
						,'headline'=>'NCDD Store'
						,'description'=>"Participate in all stores here."
						,'crumbs'=>$crumbs
						);
	return $app['view']->render('store/index', 'default', $view_vars);
});

return $store;