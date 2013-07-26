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
	
	$crumbs = array(array('name'=>'Virtual Forensic Library','href'=>'/vfl')
					);
	$view_vars = array(
						 'active'=>'VFL'
						,'page-plugin'=>'datatables'
						,'headline'=>'Virtual Forensic Library'
						,'description'=>"Access the full forensic library here."
						,'crumbs'=>$crumbs);

	return $app['view']->render('vfl/index', 'default', $view_vars);
})->before($mustbeMEMBER);
return $app;