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


$app->get('/comment/private/{belongsTo}', function ($belongsTo, Request $request) use ($app) {
	
	$comment = new Model\Comment(array('belongsTo'=>$belongsTo),$app);
	$comments = $comment->fetchByBelongsTo();

	return new Response(json_encode(array('comments'=>$comments,'count'=>count($comments),'message' => 'success')), 200,array('Content-Type' => 'application/json'));

})->before($mustbeMEMBER)->value('belongsTo','');

$app->post('/comment/private/post', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $comment = new Model\Comment($doc,$app);
    $app['validateModel']($app,$comment);
    $comment->insert();

    return new Response(json_encode(array('message' => 'successful operation.')), 200,array('Content-Type' => 'application/json'));

})->before($mustbeMEMBER)->value('belongsTo','');

$app->post('/comment/private/post/reply/{replyTo}', function ($replyTo, Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $comment = new Model\Comment(array(),$app);
    $comment->replyTo($replyTo,$doc);
    
    return new Response(json_encode(array('message' => 'successful operation.')), 200,array('Content-Type' => 'application/json'));

})->before($mustbeMEMBER)->value('replyTo','');

return $app;