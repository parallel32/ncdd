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

$blog = $app['controllers_factory'];
$blog->before($mustbeMEMBER);

$blog->get('/', function (Request $request) use ($app) {
	
	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog/'));
	$view_vars = array(
						 'active'=>'Blog'
						,'page-plugin'=>'datatables'
						,'headline'=>'DUI Blog'
						,'description'=>"Participate in all blogs here."
						,'crumbs'=>$crumbs
						);
	return $app['view']->render('blog/index', 'default', $view_vars);
});

return $blog;