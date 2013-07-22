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

$common_view_vars = array(
	'active'=>'Dashboard'
	,'headline'=>'Dashboard'
	,'add-link'=>''
);

$app->get('/', function (Request $request) use ($app, $common_view_vars) {
	$user = Model\User::getUserAccessLevelBySession($app);
	$crumbs = array(array('name'=>'Dashboard','href'=>'/'));
	$view_vars = array(
						 'page-plugin'=>'dashboard,datatables'
						,'description'=>"Welcome.  Here you'll find aggregated data from your account."
						,'crumbs'=>$crumbs);
	$view_vars = array_merge($common_view_vars, $view_vars);
	switch ($user['accessLevel']) {
		case ADMIN:
			$apply = new Model\Apply(array(),$app);
			$applications = $apply->fetchByStatus('SUBMITTED');
			$view_vars['applications']=$applications;
			array_push($view_vars['crumbs'],array('name'=>'Admin','href'=>'/'));
			return $app['view']->render('dashboards/admin', 'default', $view_vars);
			break;
		case EDITOR:
			array_push($view_vars['crumbs'],array('name'=>'Client','href'=>'/'));
			return $app['view']->render('dashboards/editor', 'default', $view_vars);
			break;
		case MEMBER:
			$apply = new Model\Apply(array(),$app);
			$applications = $apply->fetchByMember('APPROVED');
			$view_vars['applications']=$applications;
			array_push($view_vars['crumbs'],array('name'=>'Editor','href'=>'/'));
			return $app['view']->render('dashboards/member', 'default', $view_vars);
			break;
	}
})->before($mustbeMEMBER);

return $app;