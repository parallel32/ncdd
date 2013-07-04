<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$tfs = $app['controllers_factory'];

$tfs->get('/{file_path}', function ($file_path, Request $request) use ($app) {
	$file_contents = '';
	$regex = new \MongoRegex('/'.addcslashes($file_path,'/').'/i');
    $query = array('siteKey'=>SAW_SITE_KEY,'filename'=>$regex);
    $fields=array('filename','_id');
    $gridFSFile = $app['mongo']->gridfsfindOne('domain', $query, $fields, $slaveOkay=false);
    if(is_object($gridFSFile)){
	    $file_contents = (is_object($gridFSFile)) ? $app['mongo']->getFile($gridFSFile->file['_id'], 'domain') : '';
	}
	return new Response($file_contents, 200, array('Content-Type' => $app['system_extension_mime_type']($file_path)));

})->assert('file_path','.+');


// Returns the system MIME type mapping of extensions to MIME types, as defined in /etc/mime.types.
$app['system_extension_mime_types'] = $app->protect(function () {
	
    $out = array();
    $file = fopen('/etc/mime.types', 'r');
    while(($line = fgets($file)) !== false) {
        $line = trim(preg_replace('/#.*/', '', $line));
        if(!$line)
            continue;
        $parts = preg_split('/\s+/', $line);
        if(count($parts) == 1)
            continue;
        $type = array_shift($parts);
        foreach($parts as $part)
            $out[$part] = $type;
    }
    fclose($file);
    return $out;
});

// Returns the system MIME type (as defined in /etc/mime.types) for the filename specified.
$app['system_extension_mime_type'] = $app->protect(function ($file) use($app) {
    # $file - the filename to examine
    static $types;
    if(!isset($types))
        $types = $app['system_extension_mime_types']();
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if(!$ext)
        $ext = $file;
    $ext = strtolower($ext);
    return isset($types[$ext]) ? $types[$ext] : null;
});


return $tfs;