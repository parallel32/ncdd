<?php
///////////////////////
// DOMAIN MANAGEMENT //
///////////////////////

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$sawcms = $app['controllers_factory'];
$sawcms->before($mustbeEDITOR);

// section edit from the inline editor
$sawcms->post('/sedit', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $document = array('_id'=>$doc['pageid'],'sections'=>array('label'=>$doc['section'], 'value'=>$doc['content']));
    $link = new Model\Link($document, $app);
    // validate the model
    $app['validateModel']($app,$link,$groups=array('sedit'));	 

    $link->sectionEdit();
    return new Response(json_encode(array('message' => 'Successfully Saved.')), 200,array('Content-Type' => 'application/json'));
});
return $sawcms;