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

////////////
//  HOME  //
////////////
$app->get('/stateseminar', function (Request $request) use ($app) {
	
	$stateseminar = new Model\StateSeminar(array('currentType'=>Model\StateSeminar::$type['STATE']),$app);
	$stateseminars = $stateseminar->fetchByType();
	$sponsoredseminars = $stateseminar->fetchSponsored();
	
	
	$crumbs = array(array('name'=>'State Seminars','href'=>'/stateseminar'));
	$view_vars = array(
						 'active'=>'Seminar/State'
						,'page-plugin'=>'datatables'
						,'headline'=>'State Approved Seminars'
						,'description'=>"Here you can define the tags to be available for blog posts and stateseminars available for products in the NCDD Store."
						,'crumbs'=>$crumbs
						,'stateseminars'=>$stateseminars
						,'sponsoredseminars'=>$sponsoredseminars
						);
	return $app['view']->render('stateseminar/index', 'default', $view_vars);
})->before($mustbeMEMBER);


// add / edit a stateseminar
$app->get('/stateseminar/edit/{stateseminarId}', function ($stateseminarId, Request $request) use ($app) {
	
	$crumbs = array(array('name'=>'State Seminar','href'=>'/stateseminar')
					,array('name'=>'Manage State Seminars','href'=>'/stateseminar/index')
	);
	$view_vars = array(
						 'active'=>'Seminar/State'
						,'page-plugin'=>''
						,'headline'=>(empty($stateseminarId)) ? 'Add a new stateseminar' : 'Edit your stateseminar' 
						,'description'=>(empty($stateseminarId)) ? "Add a new stateseminar here" : "Edit your stateseminar here"
						,'crumbs'=>$crumbs
						);
	
	if(!empty($stateseminarId)){	
		$stateseminar = new Model\StateSeminar(array('_id'=>$stateseminarId),$app);
		$stateseminar = $stateseminar->findById();

		$view_vars['crumbs'][] = array('name'=>$stateseminar['name'],'href'=>'/stateseminar/edit/'.$stateseminarId);
		$view_vars['crumbs'][] = array('name'=>'edit','href'=>'/stateseminar/edit/'.$stateseminarId);

		$view_vars['stateseminar'] = $stateseminar;
		$view_vars['add'] = 'no';
		$view_vars['image'] = (!empty($stateseminar['image'])) ? $app['getImageURL']($stateseminar['image'],'large') : '/placeholder';
	}else{
		$view_vars['crumbs'][] = array('name'=>'add','href'=>'/stateseminar/edit');
		$view_vars['add'] = 'yes';
		$view_vars['image'] = '/placeholder';
	}

	
	return $app['view']->render('stateseminar/edit', 'default', $view_vars);
})
->value('stateseminarId','')
->before($mustbeADMIN);

// add / save stateseminar 
$app->post('/stateseminar/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    
	$stateseminar = new Model\StateSeminar($document, $app);
    // validate the model
   	$app['validateModel']($app,$stateseminar);
    $stateseminar->saveEdit();
    
    return new Response(json_encode(array('stateseminarId'=>$stateseminar->_id->__toString(), 'message' => 'StateSeminar details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);


// remove a stateseminar completely
$app->get('/stateseminar/{stateseminarId}/remove', function ($stateseminarId, Request $request) use ($app) {
	
	$stateseminar = new Model\StateSeminar(array('_id'=>$stateseminarId), $app);
    $stateseminar->findById();
	$stateseminar->delete();
	return new Response(json_encode(array('message' => 'StateSeminar details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
	
})->before($mustbeADMIN);
///////////////////
// PHOTO EDITING //
///////////////////
$app->get('/stateseminar/edit/{stateseminarId}/edit-photo', function ($stateseminarId, Request $request) use ($app) {

	$stateseminar = new Model\StateSeminar($doc=array('_id'=>new MongoId($stateseminarId)), $app);
	$stateseminar = $stateseminar->findById();
	
	$crumbs = array(array('name'=>'State Seminars','href'=>'/stateseminar')
					,array('name'=>'Manage State Seminars','href'=>'/stateseminar/index')
					,array('name'=>$stateseminar['name'],'href'=>'/stateseminar/edit/'.$stateseminarId)
					,array('name'=>'edit','href'=>'/stateseminar/edit/'.$stateseminarId)
					,array('name'=>'photo','href'=>'/stateseminar/edit/'.$stateseminarId.'/edit-photo')
	);

	$view_vars = array(
						 'active'=>'Seminar/State'
						,'page-plugin'=>'fileupload'
						,'headline'=>'State Seminar'
						,'description'=>"Edit state seminar photo"
						,'crumbs'=>$crumbs
						,'stateseminar'=>$stateseminar
						,'image'=>(!empty($stateseminar['image'])) ? $app['getImageURL']($stateseminar['image'],'large') : '/placeholder'
						,'imageDelete'=>(!empty($stateseminar['image'])) ? '/image/delete/'.$stateseminar['image']['context'].'/'.$stateseminar['image']['belongsTo'] : '');
	return $app['view']->render('stateseminar/edit-photo', 'default', $view_vars);
})
->value('stateseminarId','')->before($mustbeADMIN);

$app->get('/stateseminar/edit/{stateseminarId}/edit-photo-crop', function ($stateseminarId, Request $request) use ($app) {

	$stateseminar = new Model\StateSeminar($doc=array('_id'=>new MongoId($stateseminarId)), $app);
	$stateseminar = $stateseminar->findById();
	
	$crumbs = array(array('name'=>'State Seminars','href'=>'/stateseminar')
					,array('name'=>'Manage State Seminars','href'=>'/stateseminar/index')
					,array('name'=>$stateseminar['name'],'href'=>'/stateseminar/edit/'.$stateseminarId)
					,array('name'=>'edit','href'=>'/stateseminar/edit/'.$stateseminarId)
					,array('name'=>'photo','href'=>'/stateseminar/edit/'.$stateseminarId.'/edit-photo')
					,array('name'=>'crop','href'=>'/stateseminar/edit/'.$stateseminarId.'/edit-photo-crop')
	);
	
	$view_vars = array(
						 'active'=>'Seminar/State'
						,'page-plugin'=>'crop'
						,'headline'=>'State Seminar'
						,'description'=>"Crop state seminar photo"
						,'crumbs'=>$crumbs
						,'stateseminar'=>$stateseminar
						,'image'=>(!empty($stateseminar['image'])) ? $app['getImageURL']($stateseminar['image'],'large') : '/placeholder'
						);
	return $app['view']->render('stateseminar/edit-photo-crop', 'default', $view_vars);
})
->value('stateseminarId','')->before($mustbeADMIN);

// slugify
$app->post('/stateseminar/slugify', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $slug = Model\StateSeminar::slugify($doc['name']);
    
    return new Response(json_encode(array('slug'=>$slug, 'message' => 'successful operation.')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);



return $app;