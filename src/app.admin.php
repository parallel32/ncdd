<?php
$app = require __DIR__.'/app.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

// c.authentication-functions.php must be first because security definitions are here
$app = require __DIR__.'/controllers/admin/c.authentication-functions.php';
$app = require __DIR__.'/controllers/admin/c.authentication.php';
$app = require __DIR__.'/controllers/admin/c.dashboards.php';
$app = require __DIR__.'/controllers/admin/c.images.php';
$app = require __DIR__.'/controllers/admin/c.custom-permissions.php';

// mounted controllers have one level of access defined
$app->mount('/utilities', 		include __DIR__.'/controllers/admin/c.utilities.php');
$app->mount('/member', 			include __DIR__.'/controllers/admin/c.member.php');
$app->mount('/seminar', 		include __DIR__.'/controllers/admin/c.seminar.php');
$app->mount('/agenda', 			include __DIR__.'/controllers/admin/c.agenda.php');
$app->mount('/page', 			include __DIR__.'/controllers/admin/c.page.php');
$app->mount('/forum', 			include __DIR__.'/controllers/admin/c.forum.php');
$app->mount('/product',			include __DIR__.'/controllers/admin/c.product.php');
$app->mount('/category',		include __DIR__.'/controllers/admin/c.category.php');
$app->mount('/drive',			include __DIR__.'/controllers/admin/c.drive.php');
$app->mount('/emailsent',		include __DIR__.'/controllers/admin/c.emailsent.php');

// unmounted controllers usually have several levels of access defined in the routes. 
// i.e. some admin, some public, some member only.
$app = require __DIR__.'/controllers/admin/c.application.php';
$app = require __DIR__.'/controllers/admin/c.scholarship.php';
$app = require __DIR__.'/controllers/admin/c.payment-manage.php';
$app = require __DIR__.'/controllers/admin/c.vfl.php';
$app = require __DIR__.'/controllers/admin/c.blog.php';
$app = require __DIR__.'/controllers/admin/c.comment.php';
$app = require __DIR__.'/controllers/admin/c.register.php';
$app = require __DIR__.'/controllers/admin/c.topic.php';
$app = require __DIR__.'/controllers/admin/c.stateseminar.php';
$app = require __DIR__.'/controllers/admin/c.reference.php';

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