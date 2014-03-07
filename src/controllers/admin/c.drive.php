<?php
////////////////////////
// FOURMS CONTROLLERS //
////////////////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$drive = $app['controllers_factory'];
$drive->before($mustbeMEMBER);

/////////////
//  IMAGE  //
/////////////
$drive->get('/image/{belongsTo}', function ($belongsTo, Request $request) use ($app) {
	
	$belongsTo = (!empty($belongsTo)) ? (is_object($belongsTo)) ? $belongsTo : new \MongoId($belongsTo) : '';

	$drive = new Model\Drive(array('belongsTo'=>$belongsTo),$app);
	$images = $drive->fetchOrderBy($query=array('belongsTo'=>$belongsTo));
	$crumbs = array(array('name'=>'Drive','href'=>'/drive')
					,array('name'=>'Image','href'=>'/drive/image/'.(string)$belongsTo)
	);
	$view_vars = array(
						 'active'=>'Drive'
						,'page-plugin'=>''
						,'headline'=>'Manage Images'
						,'description'=>"Add or remove photos from here for embedding into your content"
						,'crumbs'=>$crumbs
						,'images'=>$images
						,'belongsTo'=>(string)$belongsTo
						);
	return $app['view']->render('drive/image', 'blank', $view_vars);
})->value('belongsTo','');

$drive->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    
    $drive = new Model\Drive($document, $app);
    $drive->saveEdit();
    
    return new Response(json_encode(array('driveId'=>$drive->_id->__toString(), 'message' => 'Drive details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
});


///////////////////
// PHOTO EDITING //
///////////////////
$drive->get('/edit/{driveId}/edit-photo', function ($driveId, Request $request) use ($app) {

	$drive = new Model\Drive($doc=array('_id'=>new MongoId($driveId)), $app);
	$drive = $drive->findById();

	$view_vars = array(
						 'active'=>'Drive'
						,'page-plugin'=>'fileupload'
						,'headline'=>'Drive'
						,'description'=>"Edit drive photo"
						,'drive'=>$drive
						,'image'=>(!empty($drive['image'])) ? $app['getImageURL']($drive['image'],'large') : '/placeholder');
	return $app['view']->render('drive/edit-photo', 'blank', $view_vars);
})
->value('driveId','');

$drive->get('/edit/{driveId}/edit-photo-crop', function ($driveId, Request $request) use ($app) {

	$drive = new Model\Drive($doc=array('_id'=>new MongoId($driveId)), $app);
	$drive = $drive->findById();
	
	$crumbs = array(array('name'=>'Manage the Drive','href'=>'/drive/image')
					,array('name'=>'photo','href'=>'/drive/edit/'.$driveId.'/edit-photo')
					,array('name'=>'crop','href'=>'/drive/edit/'.$driveId.'/edit-photo-crop')
	);
	
	$view_vars = array(
						 'active'=>'Drive'
						,'page-plugin'=>'crop'
						,'headline'=>'Drive'
						,'description'=>"Crop drive photo"
						,'crumbs'=>$crumbs
						,'drive'=>$drive
						,'image'=>(!empty($drive['image'])) ? $app['getImageURL']($drive['image'],'large') : '/placeholder'
						);
	return $app['view']->render('drive/edit-photo-crop', 'blank', $view_vars);
})
->value('driveId','');


return $drive;