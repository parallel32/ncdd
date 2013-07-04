<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$cfs = $app['controllers_factory'];

$cfs->get('/{siteKey}/{file_path}', function ($siteKey, $file_path, Request $request) use ($app) {
    $file_contents = '';
	$regex = new \MongoRegex('/'.addcslashes($file_path,'/').'/i');
    $query = array('siteKey'=>$siteKey,'filename'=>$regex);
    $fields=array('filename','_id');
    $gridFSFile = $app['mongo']->gridfsfindOne('domain', $query, $fields, $slaveOkay=false);
    if(is_object($gridFSFile)){
	    $file_contents = (is_object($gridFSFile)) ? $app['mongo']->getFile($gridFSFile->file['_id'], 'domain') : '';
	}
    return new Response($file_contents, 200, array('Content-Type' => 'text/html'));

})->assert('file_path','.+');

return $cfs;