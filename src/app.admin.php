<?php
$app = require __DIR__.'/app.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

// c.authentication-functions.php must be first because security definitions are here
$app = require __DIR__.'/controllers/admin/c.authentication-functions.php';
$app = require __DIR__.'/controllers/admin/c.authentication.php';
$app = require __DIR__.'/controllers/admin/c.dashboards.php';

$app->mount('/ufs', 		include __DIR__.'/controllers/admin/c.ufs.php');//user uploaded files file system
$app->mount('/utilities', 	include __DIR__.'/controllers/admin/c.utilities.php');
$app->mount('/member', 		include __DIR__.'/controllers/admin/c.member.php');
$app->mount('/seminar', 	include __DIR__.'/controllers/admin/c.seminar.php');
$app->mount('/agenda', 		include __DIR__.'/controllers/admin/c.agenda.php');

/**
 * Before Filter
 */
$app->before(function (Request $request) use ($app) {
	// needs to be here to truly activate the session object because it's lazy-loaded.
	$app['session']->get('_sf2_attributes');
});
/**
 * After Filter
 */
$app->after(function (Request $request, Response $response) {
	// this is needed for the site editor to issue posts to the admin website
    //$response->headers->set('Access-Control-Allow-Origin', '*');
});
return $app;