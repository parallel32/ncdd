<?php
/**
 * Namespace Aliases
 */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Saw\Model;

/**
 * Include Controllers
 * order is important:
 * c.system.php must always be first.
 */
$app = require __DIR__.'/controllers/c.system.php';
$app = require __DIR__.'/controllers/c.payment.php';
$app = require __DIR__.'/controllers/../../src/Saw/Component/Connect/Controllers/c.twitter.php';
$app = require __DIR__.'/controllers/../../src/Saw/Component/Connect/Controllers/c.facebook.php';

return $app;
