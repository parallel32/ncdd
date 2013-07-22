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

$app->get('/badge/member/{id}', function ($id, Request $request) use ($app) {
	// return the badge

	// retrieve document from request
	$doc = $request->get('doc');
	$payment = new Model\Payment($doc,$app);
	$app['validateModel']($app, $payment);
	$paymentId = $payment->charge();
	
	return new Response(json_encode(array('paymentId'=>$paymentId,'message'=>"success")), 200,array('Content-Type' => 'payment/json'));
		
});
$app->get('/badge/boardcertified/{id}', function ($id, Request $request) use ($app) {
	// return the badge

	// retrieve document from request
	$doc = $request->get('doc');
	$payment = new Model\Payment($doc,$app);
	$app['validateModel']($app, $payment);
	$paymentId = $payment->charge();
	
	return new Response(json_encode(array('paymentId'=>$paymentId,'message'=>"success")), 200,array('Content-Type' => 'payment/json'));
		
});

return $app;