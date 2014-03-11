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

$agenda = $app['controllers_factory'];
$agenda->before($mustbeMEMBER);
$common_view_vars = array(
	'active'=>'Seminar'
	,'headline'=>'Agenda'
);
// this screen has all agenda and time slots with add / edit / delete buttons
$agenda->get('/{seminarId}/manage', function ($seminarId, Request $request) use ($app, $common_view_vars) {
	$seminar = new Model\Seminar($doc=array("_id"=>$seminarId), $app);
	$seminar->findById();
	$agenda = new Model\Agenda($doc=array('seminarId'=>$seminarId), $app);
	$agendas = $agenda->findBySeminarId();

	$crumbs = array(array('name'=>"Seminars",'href'=>'/seminar/')
					,array('name'=>$seminar->headline,'href'=>'/seminar/view/'.$seminarId)
					,array('name'=>'Manage Agendas','href'=>'/agenda/'.$seminarId.'/manage'));
	$view_vars = array(
						'page-plugin'=>'timeline,editor'
						,'description'=>"View all Agendas here."
						,'crumbs'=>$crumbs
						,'agendas'=>$agendas
						,'seminar'=>$seminar
						/*,'add-link'=>'/agenda/'.$seminarId.'/add'*/);
	$view_vars = array_merge($common_view_vars, $view_vars);
	return $app['view']->render('seminar/agenda-manage', 'default', $view_vars);
})->value('seminarId','');
// this screen only allows you to view one agenda at a time and is read only
$agenda->get('/{seminarId}/{id}', function ($seminarId, $id, Request $request) use ($app, $common_view_vars) {
	$seminar = new Model\Seminar($doc=array("_id"=>$seminarId), $app);
	$seminar->findById();
	$agenda = new Model\Agenda($doc=array('_id'=>$id), $app);
	$agenda = $agenda->findById();
	foreach ($agenda['timeSlots'] as $key => $value) {
		$agenda['timeSlots'][$key]['description'] = $app['prepare_content']($agenda['timeSlots'][$key]['description']);
	}
	
	$crumbs = array(array('name'=>"Seminars",'href'=>'/seminar/')
					,array('name'=>$seminar->headline,'href'=>'/seminar/view/'.$seminarId)
					,array('name'=>$agenda['name'],'href'=>'/agenda/'.$seminarId.'/'.$id)
	);
	$view_vars = array(
						'page-plugin'=>'timeline'
						,'description'=>"View Agenda here."
						,'crumbs'=>$crumbs
						,'agenda'=>$agenda
						,'seminar'=>$seminar->__toArray()
						/*,'add-link'=>'/agenda/'.$seminarId.'/add'*/);
	$view_vars = array_merge($common_view_vars, $view_vars);
	return $app['view']->render('seminar/agenda-index', 'default', $view_vars);
})->value('seminarId','');

$agenda->post('/saveTimeSlot', function (Request $request) use ($app, $common_view_vars) {
	// retrieve document from request
    $doc = $request->get('doc');
    $doc['date'] = $doc['date'].' '.$doc['dateTime'];
    if(strpos($doc['_id'], '-') !== false): // means it's an edit 
    	$tmp = explode("-",$doc['_id']);
    	$_id = $tmp[0];
    	$_time = $tmp[1];
    	$agenda = new Model\Agenda(array('_id'=>$_id), $app);
    	$agenda->findById();
    	$doc['timeZone'] = $agenda->timeZone;
    	
    	$agendaTimeNew = new Model\AgendaTime($doc,$app);
	    $app['validateModel']($app,$agendaTimeNew);


    	$old['timeZone'] = $agenda->timeZone;
    	$old['date'] = new Model\Date($app,date('c',$_time),$agenda->timeZone);
    	$agendaTimeOld = new Model\AgendaTime($old,$app);
    	$agenda->removeTimeSlot($agendaTimeOld);
    	

	    $agenda->addTimeSlot($agendaTimeNew);
    else:
    	$agenda = new Model\Agenda(array('_id'=>$doc['_id']), $app);
	    $agenda_arr = $agenda->findById();
    	$doc['timeZone'] = $agenda->timeZone;

	    $agendaTime = new Model\AgendaTime($doc,$app);
	    $app['validateModel']($app,$agendaTime);
	    $agenda->addTimeSlot($agendaTime);
    endif;
    
    $message = 'Success.';
    return new Response(json_encode(array('message' => $message)), 200,array('Content-Type' => 'application/json'));
	
});
$agenda->post('/removeTimeSlot', function (Request $request) use ($app, $common_view_vars) {
	// retrieve document from request
    $doc = $request->get('doc');
    $doc['date'] = $doc['date'].' '.$doc['dateTime'];
    if(strpos($doc['_id'], '-') !== false): // means it's an edit 
    	$tmp = explode("-",$doc['_id']);
    	$_id = $tmp[0];
    	$_time = $tmp[1];
    	$agenda = new Model\Agenda(array('_id'=>$_id), $app);
    	$agenda->findById();
    	$doc['timeZone'] = $agenda->timeZone;

    	$old['timeZone'] = $agenda->timeZone;
    	$old['date'] = new Model\Date($app,date('c',$_time),$agenda->timeZone);
    	$agendaTimeOld = new Model\AgendaTime($old,$app);
    	$agenda->removeTimeSlot($agendaTimeOld);
    	
    endif;
    
    $message = 'Success.';
    return new Response(json_encode(array('message' => $message)), 200,array('Content-Type' => 'application/json'));
	
});

return $agenda;