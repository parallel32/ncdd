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
	$seminars = $seminar->find($query=array(),$fields=array(),true,$sort=array('startDate.date'=>1));
	if(!empty($seminars)):
		for ($i=0; $i < count($seminars); $i++) {
			$agenda = new Model\Agenda(array('seminarId'=>$seminars[$i]['_id']),$app);
			$agendas = $agenda->findBySeminarId();
			$seminars[$i]['agendas'] = $agendas;
		}
	endif;
	$crumbs = array(array('name'=>'Sessions & Seminars','href'=>'/seminar'));
	$view_vars = array(
						'page-plugin'=>'datatables'
						,'description'=>"View all Sessions & Seminars here."
						,'crumbs'=>$crumbs
						,'seminars'=>$seminars);
	$view_vars = array_merge($common_view_vars, $view_vars);
	return $app['view']->render('seminar/index', 'default', $view_vars);
});
$seminar->get('/view/{id}', function ($id, Request $request) use ($app, $common_view_vars) {
	$seminar = new Model\Seminar($doc=array('_id'=>$id), $app);
	$seminar = $seminar->findById();
	
	$agenda = new Model\Agenda(array('seminarId'=>$id),$app);
	$agendas = $agenda->findBySeminarId();
	$seminar['agendas'] = $agendas;
	
	$crumbs = array(array('name'=>'Seminars','href'=>'/seminar/')
					,array('name'=>$seminar['headline'],'href'=>'/seminar/view/'.$id)
					);
	$view_vars = array(
						'page-plugin'=>'datatables'
						,'description'=>"View all Sessions & Seminars here."
						,'crumbs'=>$crumbs
						,'seminar'=>$seminar);
	$view_vars = array_merge($common_view_vars, $view_vars);
	return $app['view']->render('seminar/view', 'default', $view_vars);
})->value('id','');

$seminar->get('/add', function (Request $request) use ($app, $common_view_vars) {
	$crumbs = array(array('name'=>'Seminars','href'=>'/seminar/')
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
    $_id = $seminar->insert();
    $message = 'The Seminar has been added.  Continue to create the agneda or click Finished.';
    return new Response(json_encode(array('id'=>$_id,'message' => $message)), 200,array('Content-Type' => 'application/json'));
	
});

$seminar->get('/edit/{id}', function ($id, Request $request) use ($app, $common_view_vars) {

	$seminar = new Model\Seminar($doc=array('_id'=>new MongoId($id)), $app);
	$seminar = $seminar->findById();

	$crumbs = array(array('name'=>'Seminars','href'=>'/seminar/')
					,array('name'=>$seminar['headline'],'href'=>'/seminar/view/'.$seminar['_id'])
					,array('name'=>'Edit','href'=>''));
	$view_vars = array(
						'page-plugin'=>'fileupload,editor'
						,'description'=>"Edit a Seminar"
						,'crumbs'=>$crumbs
						,'seminar'=>$seminar);
	$view_vars = array_merge($common_view_vars, $view_vars);
	return $app['view']->render('seminar/edit', 'default', $view_vars);
})->value('id','');
$seminar->post('/edit', function (Request $request) use ($app, $common_view_vars) {
	// retrieve document from request
    $document = $request->get('doc');
    $seminar = new Model\Seminar($document, $app);
    // validate the model
    $app['validateModel']($app,$seminar);
    
    $seminar->edit();
    return new Response(json_encode(array('message' => 'Saved successfully')), 200,array('Content-Type' => 'application/json'));
});

$seminar->get('/delete/{id}', function ($id, Request $request) use ($app, $common_view_vars) {
	$seminar = new Model\Seminar(array('_id'=>$id), $app);
    $seminar->delete();
    return new Response(json_encode(array('message' => 'Removed successfully')), 200,array('Content-Type' => 'application/json'));
    
})->value('id','');

////////////////////////
// REAL-TIME SLUGGIFY //
////////////////////////
$seminar->post('/slugify', function (Request $request) use ($app) {
	$str = $request->get('slug-str');
	$slug = Model\Seminar::slugify($str);
	return new Response(json_encode(array('message' => 'Successfully converted.', "slug"=>$slug)), 200,array('Content-Type' => 'application/json'));
});
return $seminar;