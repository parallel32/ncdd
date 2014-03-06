<?php
////////////////////////
// FOURMS CONTROLLERS //
////////////////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$drive = $app['controllers_factory'];
$drive->before($mustbeMEMBER);

/////////////
//  IMAGE  //
/////////////
$drive->get('/image', function (Request $request) use ($app) {
	
	
	//$drive = new Model\Category(array('currentType'=>Model\Category::$type['STORE']),$app);
	//$categories = $drive->fetchByType();
	
	
	$crumbs = array(array('name'=>'Drive','href'=>'/drive')
					,array('name'=>'Image','href'=>'/drive/image')
	);
	$view_vars = array(
						 'active'=>'Drive'
						,'page-plugin'=>''
						,'headline'=>'Manage Images'
						,'description'=>"Add or remove photos from here for embedding into your content"
						,'crumbs'=>$crumbs
						);
	return $app['view']->render('drive/image', 'blank', $view_vars);
});


return $drive;