<?php
$app = require __DIR__.'/app.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

// unmounted controllers usually have several levels of access defined in the routes. 
// i.e. some admin, some public, some member only.
$app = require __DIR__.'/controllers/public/c.member.php';
$app = require __DIR__.'/controllers/public/c.page.php';

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
    $response->headers->set('Access-Control-Allow-Origin', '*');
});
return $app;