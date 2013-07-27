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

$forum = $app['controllers_factory'];
$forum->before($mustbeMEMBER);

$forum->get('/', function (Request $request) use ($app) {
	
	$crumbs = array(array('name'=>'DUI Forum','href'=>'/forum/'));
	$view_vars = array(
						 'active'=>'Forum'
						,'page-plugin'=>'datatables'
						,'headline'=>'DUI Forum'
						,'description'=>"Participate in all forums here."
						,'crumbs'=>$crumbs
						);
	return $app['view']->render('forum/index', 'default', $view_vars);
});
$forum->get('/post/{topic}', function ($topic, Request $request) use ($app) {
   
   
   $crumbs = array(array('name'=>'DUI Forum','href'=>'/forum/')
   					,array('name'=>'State Cannot Suspend DUI Driver for Conduct on Indian Land','href'=>'/forum/'));
	$view_vars = array(
						 'active'=>'Forum'
						,'page-plugin'=>'datatables'
						,'headline'=>$topic
						,'description'=>"Participate in this topic here."
						,'crumbs'=>$crumbs
						);
	return $app['view']->render('forum/post', 'default', $view_vars); 
	
});

$forum->get('/add-topic', function (Request $request) use ($app) {
   
   
   $crumbs = array(array('name'=>'DUI Forum','href'=>'/forum/')
   					,array('name'=>'Add Topic','href'=>'/forum/'));
	$view_vars = array(
						 'active'=>'Forum'
						,'page-plugin'=>'editor'
						,'headline'=>'Start a new topic.'
						,'description'=>"."
						,'crumbs'=>$crumbs
						);
	return $app['view']->render('forum/add-topic', 'default', $view_vars); 
	
});


$forum->get('/{thread}', function ($thread, Request $request) use ($app) {
   
   switch ($thread) {
   	case 'field-sobriety-testing':
   		$thread = "Field Sobriety Testing Forum";
   		break;
   	
   	case 'accident-investigation':
   		$thread = "Accident Investigation and Reconstruction";
   		break;
   	case 'blood-collection-and-storage':
   		$thread = "Blood Collection and Storage";
   		break;
   	case 'appeal-of-the-day':
   		$thread = "Appeal of the Day";
   		break;
   	
   }
   $crumbs = array(array('name'=>'DUI Forum','href'=>'/forum/')
   					,array('name'=>$thread,'href'=>'/forum/'));
	$view_vars = array(
						 'active'=>'Forum'
						,'page-plugin'=>'datatables'
						,'headline'=>$thread
						,'description'=>"Participate in this thread here."
						,'crumbs'=>$crumbs
						);
	return $app['view']->render('forum/thread', 'default', $view_vars); 
	
});


return $forum;