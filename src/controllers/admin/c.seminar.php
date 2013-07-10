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

$seminar = $app['controllers_factory'];
$seminar->before($mustbeMEMBER);
$common_view_vars = array(
	'active'=>'Seminar'
	,'headline'=>'Seminar'
	,'add-link'=>'/seminar/add'
);

$seminar->get('/', function (Request $request) use ($app, $common_view_vars) {
	$seminar = new Model\Seminar($doc=array(), $app);
	$seminar = $seminar->find($query=array(),$fields=array('businessName', 'email', 'passwordOriginal'));

	$crumbs = array(array('name'=>'Sessions & Seminars','href'=>'/seminar'));
	$view_vars = array(
						'page-plugin'=>'datatables'
						,'description'=>"View all Sessions & Seminars here."
						,'crumbs'=>$crumbs
						,'seminar'=>$seminar);
	$view_vars = array_merge($common_view_vars, $view_vars);
	return $app['view']->render('seminar/index', 'default', $view_vars);
});

$seminar->get('/add', function (Request $request) use ($app, $common_view_vars) {
	$crumbs = array(array('name'=>'Sessions & Seminars','href'=>'/seminar')
					,array('name'=>'Add New','href'=>'/seminar/add'));
	$view_vars = array(
						'page-plugin'=>'editor'
						,'description'=>"Add a new Seminar"
						,'crumbs'=>$crumbs);
	$view_vars = array_merge($common_view_vars, $view_vars);
	return $app['view']->render('seminar/add', 'default', $view_vars);
});
$seminar->post('/add', function (Request $request) use ($app, $common_view_vars) {
	// retrieve document from request
    $document = $request->get('doc');
    $seminar = new Model\Seminar($document, $app);
    // validate the model
    $app['validateModel']($app,$seminar);
    $seminar->insert();
    $message = 'If you would like to add another click Add More or click Finished.';
    return new Response(json_encode(array('message' => $message)), 200,array('Content-Type' => 'application/json'));
	
});

$seminar->get('/edit/{id}', function ($id, Request $request) use ($app, $common_view_vars) {

	$seminar = new Model\Seminar($doc=array('_id'=>new MongoId($id)), $app);
	$doc = Model\Seminar::getAccountById($id, $app);

	$crumbs = array(array('name'=>'Sessions & Seminars','href'=>'/seminar')
					,array('name'=>'Edit','href'=>''));
	$view_vars = array(
						'page-plugin'=>''
						,'description'=>"Edit a seminar"
						,'crumbs'=>$crumbs
						,'seminar'=>$doc);
	$view_vars = array_merge($common_view_vars, $view_vars);
	return $app['view']->render('users/seminar-edit', 'default', $view_vars);
})->value('id','');
$seminar->post('/edit', function (Request $request) use ($app, $common_view_vars) {
	// retrieve document from request
    $document = $request->get('doc');
    $seminar = new Model\Seminar($document, $app);
    // validate the model
    $app['validateModel']($app,$seminar,$groups=array('signup'));
    
    if($seminar->saveSafe()){
    	return new Response(json_encode(array('message' => 'Saved successfully')), 200,array('Content-Type' => 'application/json'));
    }else{
    	return $app->abort(500, 'Something went wrong and did not save.');
    }
});
////////////////////////
// REAL-TIME SLUGGIFY //
////////////////////////
$seminar->post('/slugify', function (Request $request) use ($app) {
	$str = $request->get('slug-str');
	$slug = Model\Seminar::slugify($str);
	return new Response(json_encode(array('message' => 'Successfully converted.', "slug"=>$slug)), 200,array('Content-Type' => 'application/json'));
});

return $seminar;