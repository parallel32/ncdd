<?php
$app = require __DIR__.'/app.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

// c.authentication-functions.php must be first because security definitions are here
$app = require __DIR__.'/controllers/admin/c.authentication-functions.php';
$app = require __DIR__.'/controllers/admin/c.authentication.php';
$app = require __DIR__.'/controllers/admin/c.dashboards.php';
$app = require __DIR__.'/controllers/admin/c.linkmanager.php';

$app->mount('/cfs', 		include __DIR__.'/controllers/admin/c.cfs.php');//code file system
$app->mount('/tfs', 		include __DIR__.'/controllers/admin/c.tfs.php');//template file system
$app->mount('/ufs', 		include __DIR__.'/controllers/admin/c.ufs.php');//user uploaded files file system
$app->mount('/page', 		include __DIR__.'/controllers/admin/c.page.php');
$app->mount('/modules', 	include __DIR__.'/controllers/admin/c.modules.php');
$app->mount('/domains', 	include __DIR__.'/controllers/admin/c.domains.php');
$app->mount('/clients', 	include __DIR__.'/controllers/admin/c.clients.php');
$app->mount('/links', 		include __DIR__.'/controllers/admin/c.links.php');
$app->mount('/template', 	include __DIR__.'/controllers/admin/c.template.php');
$app->mount('/utilities', 	include __DIR__.'/controllers/admin/c.utilities.php');
//the route prefix for all the inline website editor routes.. this is here so that they can be filtered out of the link manager link processing
$app->mount('/sawcms', 		include __DIR__.'/controllers/admin/c.sawcms.php');

/**
* Site Modules
* They cannot be mounted with a prefix because /blog becomes /blog/, which issues 2 requests to the server 
* because the reqeust for /blog is a 301 redirect to /blog/
*/
$app = require __DIR__.'/controllers/admin/c.blog.php';
$app = require __DIR__.'/controllers/admin/c.contact.php';

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