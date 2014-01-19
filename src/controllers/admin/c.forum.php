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

$forum = $app['controllers_factory'];
$forum->before($mustbeMEMBER);

/////////////
//  INDEX  //
/////////////
$forum->get('/', function (Request $request) use ($app) {
	
	$forum = new Model\Forum(array(),$app);
	$forums = $forum->fetchOrderBy();

	$crumbs = array(array('name'=>'DUI Forum','href'=>'/forum'));
	$view_vars = array(
						 'active'=>'Forum'
						,'page-plugin'=>'datatables'
						,'headline'=>'Welcome to the DUI Forum'
						,'description'=>"Here you can participate in all topics by commenting or create your own topics for conversation."
						,'crumbs'=>$crumbs
						,'forums'=>$forums
						);
	return $app['view']->render('forum/index_new', 'default', $view_vars);
});

/////////////
//  ADMIN  //
/////////////
$forum->get('/admin', function (Request $request) use ($app) {
	
	$forum = new Model\Forum(array(),$app);
	$topic = new Model\Topic(array(),$app);
	$forums = $forum->fetchOrderBy();
	$reviews = $topic->fetchByAuthorByReview();
	$approved = $topic->fetchByAuthorByApproved();
	$scheduled = $topic->fetchByStatus('SCHEDULE','no');
	$published = $topic->fetchByStatus('PUBLISH','yes');
	$unpublished = $topic->fetchByStatus('UNPUBLISH','no');

	$crumbs = array(array('name'=>'DUI Forum','href'=>'/forum')
					,array('name'=>'Manage the DUI Forum','href'=>'/forum/admin')
	);
	$view_vars = array(
						 'active'=>'Forum/Admin'
						,'page-plugin'=>'datatables'
						,'headline'=>'Forums and Topics'
						,'description'=>"All forums, their topics and comments"
						,'crumbs'=>$crumbs
						,'forums'=>$forums
						,'reviews'=>$reviews
						,'approved'=>$approved
						,'scheduled'=>$scheduled
						,'published'=>$published
						,'unpublished'=>$unpublished
						);
	return $app['view']->render('forum/admin', 'default', $view_vars);
})->before($mustbeEDITOR);

////////////////
//  MY ADMIN  //
////////////////
$forum->get('/my-admin', function (Request $request) use ($app) {
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);

	$forum = new Model\Forum(array(),$app);
	$topic = new Model\Topic(array(),$app);
	$forums = $forum->fetchOrderBy(array('owner._id'=>$user['user_id']));
	$drafts = $topic->fetchByAuthorByDraft();
	$reviews = $topic->fetchByAuthorByReview();
	$approved = $topic->fetchByAuthorByApproved();
	$scheduled = $topic->fetchByStatus('SCHEDULE','no');
	$published = $topic->fetchByStatus('PUBLISH','yes');
	$unpublished = $topic->fetchByStatus('UNPUBLISH','no');

	$crumbs = array(array('name'=>'DUI Forum','href'=>'/forum')
					,array('name'=>'Manage My Forums','href'=>'/forum/my-admin')
	);
	$view_vars = array(
						 'active'=>'Forum/My'
						,'page-plugin'=>'datatables'
						,'headline'=>'My Forum Posts'
						,'description'=>"Participate in the public DUI Forum by drafting a post and submitting it for review."
						,'crumbs'=>$crumbs
						,'forums'=>$forums
						,'drafts'=>$drafts
						,'reviews'=>$reviews
						,'approved'=>$approved
						,'scheduled'=>$scheduled
						,'published'=>$published
						,'unpublished'=>$unpublished
						);
	return $app['view']->render('forum/my-admin', 'default', $view_vars);
});






// add / edit a forum
$forum->get('/edit/{forumId}', function ($forumId, Request $request) use ($app) {
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	$second_crumb = ($user['accessLevel'] >= EDITOR) ? array('name'=>'Manage the DUI Forum','href'=>'/forum/admin'): array('name'=>'Manage my Forums','href'=>'/forum/my-admin');
	$crumbs = array(array('name'=>'DUI Forum','href'=>'/forum')
					,$second_crumb
	);
	$view_vars = array(
						 'active'=>($user['accessLevel'] >= EDITOR) ? 'Forum/Admin' : 'Forum/My'
						,'page-plugin'=>''
						,'headline'=>(empty($forumId)) ? 'Add a new forum' : 'Edit your forum' 
						,'description'=>(empty($forumId)) ? "Add a new forum here" : "Edit your forum here"
						,'crumbs'=>$crumbs
						);
	
	if(!empty($forumId)){	
		$forum = new Model\Forum(array('_id'=>$forumId),$app);
		$forum = $forum->findById();

		$view_vars['crumbs'][] = array('name'=>$forum['name'],'href'=>'/forum/edit/'.$forumId);
		$view_vars['crumbs'][] = array('name'=>'edit','href'=>'/forum/edit/'.$forumId);

		$view_vars['forum'] = $forum;
		$view_vars['add'] = 'no';
		$view_vars['image'] = (!empty($forum['image'])) ? $app['getImageURL']($forum['image'],'large') : '/placeholder';
	}else{
		$view_vars['crumbs'][] = array('name'=>'add','href'=>'/forum/edit');
		$view_vars['add'] = 'yes';
		$view_vars['image'] = '/placeholder';
	}

	
	return $app['view']->render('forum/edit-forum', 'default', $view_vars);
})
->value('forumId','');

// add / save forum 
$forum->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	if($user['accessLevel'] >= EDITOR){
		$member = array();
	}else{
		$member = new Model\Member(array('_id'=>$user['user_id']),$app);
	    $mem_doc = $member->findById();	
	    $member = new Model\MemberLite($mem_doc,$app);
	}
	
    $forum = new Model\Forum($document, $app, $member);
    // validate the model
   	$app['validateModel']($app,$forum);
    $forum->saveEdit();
    
    // set the global parameter manually to use the _id in the after() handler below
    $_POST['current_id'] = $forum->_id->__toString();
    
    return new Response(json_encode(array('forumId'=>$forum->_id->__toString(), 'message' => 'Forum details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
})
->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
			// retrieve document from request
    		$doc = $request->get('doc');
    
	    	if((int)$doc['currentStatus'] == (int)Model\Forum::$status['REVIEW']){
	    		$accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$app);
	    		if($accessLevel == MEMBER){
	    			// send out the email to the admin notifying to review the forum 
			    	$forum = new Model\Forum(array('_id'=>$_POST['current_id']),$app);
		    		$forum->findById();
			    	//error_log('send ADMIN email......for:'.$forum->headline);
			    	//*
			    	// send admin the email notification
			    	$subject = 'Forum Submitted for Review';
			    	$to = SAW_ADMIN_EMAIL;
			    	$view_vars = array('firstName'=>$forum->owner['firstName']
			    						,'middleName'=>$forum->owner['middleName']
			    						,'lastName'=>$forum->owner['lastName']
			    						,'name'=>$forum->name
			    						,'email'=>$forum->owner['email']
			    	);
			    	$body = $app['view']->render('email/forum-review','email', $view_vars);
			    	$app['sendMail']($subject, $body, $to);
			    	//*/
	    		}
		    }
	    	if((int)$doc['currentStatus'] == (int)Model\Forum::$status['PUBLISH']){
	    		// send out the email to forum owner notifying that the forum posted
		    	$forum = new Model\Forum(array('_id'=>$_POST['current_id']),$app);
	    		$forum->findById();
		    	
	    		$accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$app);
	    		if($accessLevel >= EDITOR && array_key_exists('owner',$forum) && array_key_exists('email',$forum->owner) ){
	    			//error_log('send Author email......for:'.$forum->headline);
			    	//*
			    	// send admin the email notification
			    	$subject = 'Forum Approved';
			    	$to = $forum->owner['email'];
			    	$view_vars = array('name'=>$forum->name);
			    	$body = $app['view']->render('email/forum-approved','email', $view_vars);
			    	$app['sendMail']($subject, $body, $to);
			    	//*/
	    		}
		    }
	    endif;
});


// remove a forum completely
$forum->get('/{forumId}/remove', function ($forumId, Request $request) use ($app) {
	$user = $app['session']->get('user');
	$accessLevel = $user['accessLevel'];
	$user_id = $user['user_id'];
	
	$forum = new Model\Forum(array('_id'=>$forumId), $app);
    $forum->findById();
	if(($accessLevel == MEMBER && $forum->author['_id'] == $user_id) || $accessLevel >= EDITOR){
		$forum->remove();
		return new Response(json_encode(array('message' => 'Forum details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
	}else{
		return new Response(json_encode(array('message' => 'Permission Denied.  Insufficient Privileges.')), 400,array('Content-Type' => 'application/json'));
	}
    

});
///////////////////
// PHOTO EDITING //
///////////////////
$forum->get('/edit/{forumId}/edit-photo', function ($forumId, Request $request) use ($app) {

	$forum = new Model\Forum($doc=array('_id'=>new MongoId($forumId)), $app);
	$forum = $forum->findById();
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	$second_crumb = ($user['accessLevel'] >= EDITOR) ? array('name'=>'Manage the DUI Forum','href'=>'/forum/admin'): array('name'=>'Manage My Forums','href'=>'/forum/my-admin');
	
	$crumbs = array(array('name'=>'DUI Forum','href'=>'/forum')
					,$second_crumb
					,array('name'=>$forum['name'],'href'=>'/forum/edit/'.$forumId)
					,array('name'=>'edit','href'=>'/forum/edit/'.$forumId)
					,array('name'=>'photo','href'=>'/forum/edit/'.$forumId.'/edit-photo')
	);

	$view_vars = array(
						 'active'=>'Forum/My'
						,'page-plugin'=>'fileupload'
						,'headline'=>'Forum'
						,'description'=>"Edit forum photo"
						,'crumbs'=>$crumbs
						,'forum'=>$forum
						,'image'=>(!empty($forum['image'])) ? $app['getImageURL']($forum['image'],'large') : '/placeholder'
						,'imageDelete'=>(!empty($forum['image'])) ? '/image/delete/'.$forum['image']['context'].'/'.$forum['image']['belongsTo'] : '');
	return $app['view']->render('forum/edit-forum-photo', 'default', $view_vars);
})
->value('forumId','');

$forum->get('/edit/{forumId}/edit-photo-crop', function ($forumId, Request $request) use ($app) {

	$forum = new Model\Forum($doc=array('_id'=>new MongoId($forumId)), $app);
	$forum = $forum->findById();
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	$second_crumb = ($user['accessLevel'] >= EDITOR) ? array('name'=>'Manage the DUI Forum','href'=>'/admin'): array('name'=>'Manage My Forums','href'=>'/my-admin');
	
	$crumbs = array(array('name'=>'DUI Forum','href'=>'/forum')
					,$second_crumb
					,array('name'=>$forum['name'],'href'=>'/forum/edit/'.$forumId)
					,array('name'=>'edit','href'=>'/forum/edit/'.$forumId)
					,array('name'=>'photo','href'=>'/forum/edit/'.$forumId.'/edit-photo')
					,array('name'=>'crop','href'=>'/forum/edit/'.$forumId.'/edit-photo-crop')
	);
	
	$view_vars = array(
						 'active'=>'Forum/My'
						,'page-plugin'=>'crop'
						,'headline'=>'Forum'
						,'description'=>"Crop forum photo"
						,'crumbs'=>$crumbs
						,'forum'=>$forum
						,'image'=>(!empty($forum['image'])) ? $app['getImageURL']($forum['image'],'large') : '/placeholder'
						);
	return $app['view']->render('forum/edit-forum-photo-crop', 'default', $view_vars);
})
->value('forumId','');



return $forum;