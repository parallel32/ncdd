<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$ufs = $app['controllers_factory'];

$ufs->get('/{file_path}', function ($file_path, Request $request) use ($app) {
	
	$regex = new \MongoRegex('/'.addcslashes($file_path,'/').'/i');
    $query = array('siteKey'=>SAW_SITE_KEY,'filename'=>$regex);
    $fields=array('filename','_id');
    $gridFSFile = $app['mongo']->gridfsfindOne('userland-images-and-files', $query, $fields, $slaveOkay=false);

    $file_contents = $app['mongo']->getFile($gridFSFile->file['_id'], 'domain');

	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));

})->assert('file_path','.+');

return $ufs;