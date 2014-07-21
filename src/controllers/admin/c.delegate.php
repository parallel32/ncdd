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

$app->get('/delegate', function (Request $request) use ($app) {
	
	$countries = Model\Delegate::getStates();
	$delegate = new Model\Delegate(array(),$app);
	$areas = array();
	foreach ($countries as $country => $states) {
		foreach ($states as $name=>$abbr) {
			$members = '<table>';
			$sd = $delegate->fetchByState(strtolower($abbr),$country);

			$arr['currentStatus'] = $sd['currentStatus'];
			$arr['name'] = $name;
			$arr['abbr'] = $abbr;
			if(!empty($sd) && array_key_exists('members', $sd) && !empty($sd['members'])){
				foreach ($sd['members'] as $member) {
					$members.= '<tr><td>'.$member['displayName'].'</td></tr>';
				}
			}else{
				$members.= '<tr><td></td></tr>';
			}

			$members.='</table>';
			$arr['members'] = $members;// add their names
			$arr['add'] = (!empty($sd) && array_key_exists('_id', $sd) && !empty($sd['_id'])) ? 'no':'yes'; // will determine if an add or an edit link is made
			$arr['_id'] = (!empty($sd) && array_key_exists('_id', $sd)) ? $sd['_id']:''; // will determine if an add or an edit link is made
			$arr['lastEditDate'] = (!empty($sd) && array_key_exists('lastEditDate', $sd)) ? $sd['lastEditDate']['fullDateTime']: '';

			$areas[$country][$name] = $arr;
		}
	}
	//echo "<pre>";print_r($areas);echo "</pre>";
	$crumbs = array(array('name'=>'Delegate','href'=>'/delegate'));
	$view_vars = array( 'active'=>'Delegate'
						,'page-plugin'=>'datatables'
						,'headline'=>'Delegate'
						,'description'=>"Manage all delegates here."
						,'crumbs'=>$crumbs
						,'areas'=>$areas
						);
	return $app['view']->render('delegate/index', 'default', $view_vars);
})->before($mustbeADMIN);

$app->get('/delegate/edit/{id}', function ($id, Request $request) use ($app) {

	$delegate = new Model\Delegate(array('_id'=>$id),$app);
	$delegate = $delegate->findById();

	$member = new Model\Member(array(),$app);
	$state_delegates = $member->search('State Delegates',true);

	//echo "<pre>";print_r($areas);echo "</pre>";
	$crumbs = array(array('name'=>'Delegate','href'=>'/delegate'));
	$view_vars = array( 'active'=>'Delegate'
						,'page-plugin'=>'datatables'
						,'headline'=>'Delegate'
						,'description'=>"Manage delegate page here."
						,'crumbs'=>$crumbs
						,'delegate'=>$delegate
						,'state_delegates'=>$state_delegates
						,'add'=>'no'
						);
	$view_vars['image'] = (!empty($delegate['image'])) ? $app['getImageURL']($delegate['image'],'large') : '/placeholder';
	$view_vars['image2'] = (!empty($delegate['image2'])) ? $app['getImageURL']($delegate['image2'],'large') : '/placeholder';
	$view_vars['image3'] = (!empty($delegate['image3'])) ? $app['getImageURL']($delegate['image3'],'large') : '/placeholder';
	return $app['view']->render('delegate/edit', 'default', $view_vars);
})->before($mustbeMEMBER);

$app->get('/delegate/add/{country}/{stateabbr}', function ($country,$stateabbr,Request $request) use ($app) {

	$member = new Model\Member(array(),$app);
	$state_delegates = $member->search('State Delegates',true);

	$delegate = new Model\Delegate(array(),$app);
	$the_states = $delegate->getStates();
	$delegate = $delegate->fetchByState($stateabbr,$country,true);
	$state = array_search(strtoupper($stateabbr), $the_states[$country]);
	
	if(empty($delegate)){
		$delegate = new Model\Delegate(array('country'=>$country,'abbr'=>$stateabbr,'state'=>$state,'add'=>'yes'),$app);
		$_id = $delegate->saveEdit();
		$delegate = $delegate->findById();
	}
	$crumbs = array(array('name'=>'Delegate','href'=>'/delegate'));
	$view_vars = array( 'active'=>'Delegate'
						,'page-plugin'=>'datatables'
						,'headline'=>'Delegate'
						,'description'=>"Manage all delegates here."
						,'crumbs'=>$crumbs
						,'delegate'=>$delegate
						,'state_delegates'=>$state_delegates
						,'add'=>'no'
						);
	$view_vars['image'] = (!empty($delegate['image'])) ? $app['getImageURL']($delegate['image'],'large') : '/placeholder';
	$view_vars['image2'] = (!empty($delegate['image2'])) ? $app['getImageURL']($delegate['image2'],'large') : '/placeholder';
	$view_vars['image3'] = (!empty($delegate['image3'])) ? $app['getImageURL']($delegate['image3'],'large') : '/placeholder';
	return $app['view']->render('delegate/edit', 'default', $view_vars);

})->before($mustbeADMIN);

$app->post('/delegate/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
	    
    $delegate = new Model\Delegate($document,$app);
    $delegate->saveEdit();
    return new Response(json_encode(array('delegateId'=>$document['_id'], 'message' => 'Delegate details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeMEMBER);


// edit the photo
$app->get('/delegate/edit/{delegateId}/edit-photo/{parentAttr}', function ($delegateId, $parentAttr, Request $request) use ($app) {

	$delegate = new Model\Delegate($doc=array('_id'=>new MongoId($delegateId)), $app);
	$delegate = $delegate->findById();
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	$second_crumb = ($user['accessLevel'] == ADMIN) ? array('name'=>'Manage all Delegates here.','href'=>'/delegate'): array('name'=>'','href'=>'/delegate/edit/'.$delegateId);
	
	$crumbs = array(array('name'=>'Delegate','href'=>'/delegate')
					,$second_crumb
					,array('name'=>$delegate['state'],'href'=>'/delegate/edit/'.$delegateId)
					,array('name'=>'edit','href'=>'/delegate/edit/'.$delegateId)
					,array('name'=>'photo','href'=>'/delegate/edit/'.$delegateId.'/edit-photo')
	);

	$view_vars = array(
						 'active'=>'Delegate/My'
						,'page-plugin'=>'fileupload'
						,'headline'=>'Delegate'
						,'description'=>"Edit delegate photo"
						,'crumbs'=>$crumbs
						,'delegate'=>$delegate
						,'parentAttr'=>$parentAttr
						,'image'=>(!empty($delegate[$parentAttr])) ? $app['getImageURL']($delegate[$parentAttr],'large') : '/placeholder'
						,'imageDelete'=>(!empty($delegate[$parentAttr])) ? '/image/delete/'.$delegate[$parentAttr]['context'].'/'.$delegate[$parentAttr]['belongsTo'].'/'.$parentAttr : '');
	return $app['view']->render('delegate/edit-photo', 'default', $view_vars);
})
->before($mustbeMEMBER)
->value('delegateId','');

$app->get('/delegate/edit/{delegateId}/edit-photo-crop/{parentAttr}', function ($delegateId,$parentAttr, Request $request) use ($app) {

	$delegate = new Model\Delegate($doc=array('_id'=>new MongoId($delegateId)), $app);
	$delegate = $delegate->findById();
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	$second_crumb = ($user['accessLevel'] == ADMIN) ? array('name'=>'Manage all Delegates here.','href'=>'/delegate'): array('name'=>'','href'=>'/delegate/edit/'.$delegateId);	
	
	$crumbs = array(array('name'=>'dDelegate','href'=>'/delegate')
					,$second_crumb
					,array('name'=>$delegate['state'],'href'=>'/delegate/edit/'.$delegateId)
					,array('name'=>'edit','href'=>'/delegate/edit/'.$delegateId)
					,array('name'=>'photo','href'=>'/delegate/edit/'.$delegateId.'/edit-photo/'.$parentAttr)
					,array('name'=>'crop','href'=>'/delegate/edit/'.$delegateId.'/edit-photo-crop/'.$parentAttr)
	);
	
	$view_vars = array(
						 'active'=>'Delegate/My'
						,'page-plugin'=>'crop'
						,'headline'=>'Delegate'
						,'description'=>"Crop delegate photo"
						,'crumbs'=>$crumbs
						,'delegate'=>$delegate
						,'parentAttr'=>$parentAttr
						,'image'=>(!empty($delegate[$parentAttr])) ? $app['getImageURL']($delegate[$parentAttr],'large') : '/placeholder'
						);
	return $app['view']->render('delegate/edit-photo-crop', 'default', $view_vars);
})
->before($mustbeMEMBER)
->value('delegateId','');






////////////
// member //
////////////
$app->get('/delegate/{id}/member/add/{memberId}', function ($id, $memberId, Request $request) use ($app) {
	//*	
	// get the member to embed
	$member = new Model\Member(array('_id'=>$memberId), $app);
	$member = $member->findById();

	$delegate = new Model\Delegate(array('_id'=>$id), $app);
	$delegate->addMember($member);
	return new Response(json_encode(array('displayName'=>$member['displayName'],'id'=>$memberId,'email'=>$member['email'], 'message' => 'added successfully.')), 200,array('Content-Type' => 'application/json'));
	//*/
})->before($mustbeADMIN);
$app->get('/delegate/{id}/member/delete/{memberId}', function ($id, $memberId, Request $request) use ($app) {
    
    $delegate = new Model\Delegate(array('_id'=>$id), $app);
	$delegate->removeMember($memberId);
	
    return new Response(json_encode(array('message' => 'removed successfully.')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeADMIN);

///////////
// event //
///////////
$app->post('/delegate/{id}/event/add', function ($id, Request $request) use ($app) {
	//*	
	// retrieve document from request
    $document = $request->get('doc');
 	
	$stateseminar = new Model\StateSeminar($document, $app);
    // validate the model
   	$app['validateModel']($app,$stateseminar);
    $ss_id = $stateseminar->saveEdit();
    $ss = $stateseminar->__toArray();
    $ss['_id'] = $ss_id;
    

	$delegate = new Model\Delegate(array('_id'=>$id), $app);
	$delegate->addEvent($ss);
	return new Response(json_encode(array('delegateid'=>$id,'name'=>$ss['name'],'id'=>(string)$ss['_id'],'date'=>$ss['date']['fullMonth'], 'message' => 'added successfully.')), 200,array('Content-Type' => 'application/json'));
	//*/
})->before($mustbeMEMBER);
$app->get('/delegate/{id}/event/delete/{eventId}', function ($id, $eventId, Request $request) use ($app) {
    
    $delegate = new Model\Delegate(array('_id'=>$id), $app);
	$delegate->removeEvent($eventId);
	
    return new Response(json_encode(array('message' => 'removed successfully.')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeMEMBER);

return $app;