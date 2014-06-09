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


$app->get('/payment/{id}/view', function ($id, Request $request) use ($app) {
	
	$payment = new Model\Payment(array('_id'=>$id), $app);
	$payment = $payment->findById();

	$crumbs = array(array('name'=>'Payments','href'=>'/payment')
					,array('name'=>$payment['title'],'href'=>'/payment/'.$id.'/view')
					,array('name'=>$payment['name'],'href'=>'/payment/'.$id.'/view')
					);
	$view_vars = array(
						 'active'=>'Payment'
						,'page-plugin'=>'datatables'
						,'headline'=>'Payments'
						,'description'=>"View all payment here."
						,'crumbs'=>$crumbs
						,'payment'=>$payment);
	return $app['view']->render('payment/view', 'default', $view_vars);
})->value('id','')
->before($mustbeMEMBER);


$app->get('/payment/{offset}/{limit}', function ($offset, $limit, Request $request) use ($app) {
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	if($user['accessLevel'] == MEMBER){
		$payment = new Model\Payment($doc=array('memberId'=>$user['user_id']), $app);
	}elseif($user['accessLevel'] == UNPAIDMEMBER){
		$payment = new Model\Payment($doc=array('memberId'=>$user['user_id']), $app);
	}else{
		$payment = new Model\Payment($doc=array(), $app);
	}
	$payments = $payment->fetchAll();
	$crumbs = array(array('name'=>'Payments','href'=>'/payment'));
	$view_vars = array(
						 'active'=>'Payment'
						,'page-plugin'=>'datatables'
						,'headline'=>'Payments'
						,'description'=>"View all payments here."
						,'crumbs'=>$crumbs
						,'payments'=>$payments);
	return $app['view']->render('payment/index', 'default', $view_vars);
})
->value('offset','0')
->value('limit','10000')
->before($mustbeMEMBER);


return $app;