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


$app->get('/vfl', function (Request $request) use ($app) {
	
	$page = new Model\Page($doc=array('slug'=>'virtual-forensic-library'), $app);
	$result = $page->findById('slug');
	$result['body'] = $app['prepare_content']($result['body']);

	$crumbs = array(array('name'=>'Virtual Forensic Library','href'=>'/vfl')
					);
	$view_vars = array(
						 'active'=>'VFL'
						,'page-plugin'=>'datatables'
						,'headline'=>'Virtual Forensic Library'
						,'description'=>"Access the full forensic library here."
						,'content'=>$result['body']
						,'crumbs'=>$crumbs);

	return $app['view']->render('vfl/index', 'default', $view_vars);
})->before($mustbeMEMBER);
$app->get('/committee-report-videos', function (Request $request) use ($app) {
	
	$page = new Model\Page($doc=array('slug'=>'committee-report-videos'), $app);
	$result = $page->findById('slug');
	$result['body'] = $app['prepare_content']($result['body']);

	$crumbs = array(array('name'=>'Committee Report Videos','href'=>'/committee-report-videos')
					);
	$view_vars = array(
						 'active'=>'CRV'
						,'page-plugin'=>'datatables'
						,'headline'=>'Committee Report Videos'
						,'description'=>""
						,'content'=>$result['body']
						,'crumbs'=>$crumbs);

	return $app['view']->render('vfl/committee-report-videos', 'default', $view_vars);
})->before($mustbeMEMBER);
return $app;