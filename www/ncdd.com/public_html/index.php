<?php
require_once __DIR__.'/../../../vendor/autoload.php';
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
ErrorHandler::register();
$app = require __DIR__.'/../../../src/bootstrap.public.php';
$app->run();