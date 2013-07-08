<?php
////////////////
// DASHBOARDS //
////////////////

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$app->get('/', function (Request $request) use ($app) {
	$user = Model\User::getUserAccessLevelBySession($app);
	$crumbs = array(array('name'=>'Dashboard','href'=>'/'));
	$view_vars = array(
						 'active'=>'Dashboard'
						,'page-plugin'=>'dashboard'
						,'headline'=>'Dashboard'
						,'description'=>"Welcome.  Here you'll find aggregated data from your account."
						,'crumbs'=>$crumbs);
	switch ($user['accessLevel']) {
		case ADMIN:
			array_push($view_vars['crumbs'],array('name'=>'Admin','href'=>'/'));
			return $app['view']->render('dashboards/admin', 'default', $view_vars);
			break;
		case EDITOR:
			array_push($view_vars['crumbs'],array('name'=>'Client','href'=>'/'));
			return $app['view']->render('dashboards/client', 'default', $view_vars);
			break;
		case MEMBER:
			array_push($view_vars['crumbs'],array('name'=>'Editor','href'=>'/'));
			return $app['view']->render('dashboards/editor', 'default', $view_vars);
			break;
	}
})->before($mustbeADMIN);

return $app;