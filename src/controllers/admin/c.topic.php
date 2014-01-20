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


// view a topic post
$app->get('/topic/{topicId}/view', function ($topicId, Request $request) use ($app) {
	
	$topic = new Model\Topic(array('_id'=>$topicId),$app);
	$topic = $topic->findById();

	$comment = new Model\Comment(array('belongsTo'=>$topic['_id']),$app);
	$comments = $comment->fetchByBelongsTo();


	$crumbs = array(array('name'=>'DUI Forum','href'=>'/forum')
				,array('name'=>$topic['forum']['name'],'href'=>'/forum/view/'.$topic['forum']['_id'])
				,array('name'=>$topic['headline'],'href'=>'/topic/'.$topicId.'/view')
		);
	$view_vars = array(
						 'active'=>'Forum/My'
						,'page-plugin'=>'datatables'
						,'headline'=>'DUI Forum'
						,'description'=>"forum topic."
						,'crumbs'=>$crumbs
						,'topic'=>$topic
						,'comments'=>$comments
						);
	return $app['view']->render('forum/view', 'default', $view_vars);
})->before($mustbeMEMBER);



// add / save topic post
$app->post('/topic/edit', function (Request $request) use ($app) {
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	// retrieve document from request
    $document = $request->get('doc');
    
    if($user['accessLevel'] >= EDITOR){
    	$member = array();
    } else {
    	$member = new Model\Member(array('_id'=>$user['user_id']),$app);
	    $member_doc = $member->findById();
	    $member = new Model\MemberLite($member_doc,$app);
    }
    

    $topic = new Model\Topic($document, $app, $member);
    // validate the model
   	$app['validateModel']($app,$topic);
    $topic->saveEdit();
    
    // set the global parameter manually to use the _id in the after() handler below
    $_POST['current_id'] = $topic->_id->__toString();
    $_POST['forum_id'] = $document['forum'];
    
    return new Response(json_encode(array('topicId'=>$topic->_id->__toString(), 'message' => 'Topic details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
})
->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
			// retrieve document from request
    		$doc = $request->get('doc');
    
	    	
	    	if((int)$doc['currentStatus'] == (int)Model\Topic::$status['REVIEW']){
	    		$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	    		$accessLevel = $user['accessLevel'];
	    		$user_id = $user['user_id'];

	    		if($accessLevel == MEMBER){
	    			// send out the email to the admin notifying to review the topic post
			    	$topic = new Model\Topic(array('_id'=>$_POST['current_id']),$app);
		    		$topic->findById();
			    	$forum = new Model\Forum(array('_id'=>$_POST['forum_id']),$app);
		    		$forum = $forum->findById();
			    	//error_log('send ADMIN email......for:'.$topic->headline);
			    	//*
			    	// send admin the email notification if the owner of forum is not the same as the author of the topic
			    	if(array_key_exists('_id',$topic->author) && (string)$topic->author['_id'] != (string)$user_id){
				    	$subject = 'Topic Submitted for Review';
				    	// logic for the sender:  if the forum has an owner, then send it to him otherwise send it to the admin
				    	$to = (!empty($forum) && array_key_exists('owner',$forum) && array_key_exists('_id',$forum['owner']) ) ? $forum['owner']['email']: SAW_ADMIN_EMAIL;
				    	$view_vars = array('firstName'=>$topic->author['firstName']
				    						,'middleName'=>$topic->author['middleName']
				    						,'lastName'=>$topic->author['lastName']
				    						,'headline'=>$topic->headline
				    						,'email'=>$topic->author['email']
				    	);
				    	$body = $app['view']->render('email/forum-topic-review','email', $view_vars);
				    	$app['sendMail']($subject, $body, $to);
				    }
			    	//*/
	    		}
		    }
	    	if((int)$doc['currentStatus'] >= (int)Model\Topic::$status['SCHEDULE']){
	    		$accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$app);
	    		if($accessLevel >= EDITOR){

	    			// send out the email to topic author notifying that the topic posted
			    	$topic = new Model\Topic(array('_id'=>$_POST['current_id']),$app);
		    		$topic->findById();
			    	//error_log('send ADMIN email......for:'.$topic->author);
			    	//*
		    		//error_log('send Author email......for:'.$topic->headline);
			    	//*
			    	// send admin the email notification
			    	$subject = 'Topic Approved';
			    	$to = $topic->author['email'];
			    	$view_vars = array('headline'=>$topic->headline);
			    	$body = $app['view']->render('email/forum-topic-approved','email', $view_vars);
			    	$app['sendMail']($subject, $body, $to);
					//*/
	    		}
		    }
	    endif;
})->before($mustbeMEMBER);

// edit the photo
$app->get('/topic/edit/{topicId}/edit-photo', function ($topicId, Request $request) use ($app) {

	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);

	$topic = new Model\Topic($doc=array('_id'=>new MongoId($topicId)), $app);
	$topic = $topic->findById();
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	$second_crumb = ($user['accessLevel'] >= EDITOR) ? array('name'=>'Manage Forums','href'=>'/forum/admin'): array('name'=>'Manage My Forums','href'=>'/forum/my-admin');
	
	$crumbs = array(array('name'=>'DUI Forum','href'=>'/forum')
					,$second_crumb
					,array('name'=>$topic['headline'],'href'=>'/topic/edit/'.$topicId)
					,array('name'=>'edit','href'=>'/topic/edit/'.$topicId)
					,array('name'=>'photo','href'=>'/topic/edit/'.$topicId.'/edit-photo')
	);

	$view_vars = array(
						 'active'=>'Forum/My'
						,'page-plugin'=>'fileupload'
						,'headline'=>'Topic'
						,'description'=>"Edit topic photo"
						,'crumbs'=>$crumbs
						,'topic'=>$topic
						,'image'=>(!empty($topic['image'])) ? $app['getImageURL']($topic['image'],'large') : '/placeholder'
						,'imageDelete'=>(!empty($topic['image'])) ? '/image/delete/'.$topic['image']['context'].'/'.$topic['image']['belongsTo'] : '');
	return $app['view']->render('forum/edit-photo', 'default', $view_vars);
})->value('topicId','')->before($mustbeMEMBER);

$app->get('/topic/edit/{topicId}/edit-photo-crop', function ($topicId, Request $request) use ($app) {

	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);

	$topic = new Model\Topic($doc=array('_id'=>new MongoId($topicId)), $app);
	$topic = $topic->findById();
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	$second_crumb = ($user['accessLevel'] >= EDITOR) ? array('name'=>'Manage Forums','href'=>'/forum/admin'): array('name'=>'Mange My Forums','href'=>'/forum/my-admin');
	
	$crumbs = array(array('name'=>'DUI Topic','href'=>'/topic')
					,$second_crumb
					,array('name'=>$topic['headline'],'href'=>'/topic/edit/'.$topicId)
					,array('name'=>'edit','href'=>'/topic/edit/'.$topicId)
					,array('name'=>'photo','href'=>'/topic/edit/'.$topicId.'/edit-photo')
					,array('name'=>'crop','href'=>'/topic/edit/'.$topicId.'/edit-photo-crop')
	);
	
	$view_vars = array(
						 'active'=>'Forum/My'
						,'page-plugin'=>'crop'
						,'headline'=>'Topic'
						,'description'=>"Crop topic photo"
						,'crumbs'=>$crumbs
						,'topic'=>$topic
						,'image'=>(!empty($topic['image'])) ? $app['getImageURL']($topic['image'],'large') : '/placeholder'
						);
	return $app['view']->render('forum/edit-photo-crop', 'default', $view_vars);
})->value('topicId','')->before($mustbeMEMBER);






// remove a topic completely
$app->get('/topic/{topicId}/remove', function ($topicId, Request $request) use ($app) {
	$user = $app['session']->get('user');
	$accessLevel = $user['accessLevel'];
	$user_id = $user['user_id'];
	
	$topic = new Model\Topic(array('_id'=>$topicId), $app);
    $topic->findById();
	if(($accessLevel == MEMBER && $topic->author['_id'] == $user_id) || $accessLevel >= EDITOR){
		$topic->remove();
		return new Response(json_encode(array('message' => 'Topic details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
	}else{
		return new Response(json_encode(array('message' => 'Permission Denied.  Insufficient Privileges.')), 400,array('Content-Type' => 'application/json'));
	}
    

})->before($mustbeMEMBER);


// publish the scheduled topics //
$app->get('/topic/publish-schedule', function (Request $request) use ($app) {
	
	$topic = new Model\Topic(array(),$app);
	$posts = $topic->fetchToPublish();
	if(is_array($posts) && count($posts) > 0){
		foreach($posts as $post):
			$b = new Model\Topic(array('_id'=>$post['_id'],'currentStatus'=>Model\Topic::$status['PUBLISH']),$app);
			$b->add = "no";
			$b->saveEdit();
		endforeach;
		$count = count($posts);
	}else{
		$count = 0;
	}
	return "posts affected: ".$count;
});

// member add / edit a post
$app->get('/topic/edit/{topicId}/{forumId}', function ($topicId, $forumId, Request $request) use ($app) {
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	
	$crumbs = array(array('name'=>'DUI Forum','href'=>'/forum')
					,array('name'=>'Manage My Forums','href'=>'/forum/my-admin')
	);
	
	$forum = new Model\Forum(array(),$app);
	$forums = $forum->fetchOrderBy(array('currentStatus'=>Model\Forum::$status['PUBLISH']));
	$view_vars = array(
						 'active'=>'Forum/My'
						,'page-plugin'=>'editor'
						,'headline'=>(empty($topicId)) ? 'Add a new topic' : 'Edit your topic' 
						,'description'=>"Edit your topic and submit it for review when finished."
						,'crumbs'=>$crumbs
						,'forums'=>$forums
						,'forumId'=>$forumId
						);
	
	if(!empty($topicId) && $topicId != 'null'){	
		$topic = new Model\Topic(array('_id'=>$topicId),$app);
		$topic = $topic->findById();

		$view_vars['crumbs'][] = array('name'=>$topic['headline'],'href'=>'/topic/edit/'.$topicId);
		$view_vars['crumbs'][] = array('name'=>'edit','href'=>'/topic/edit/'.$topicId);

		$view_vars['topic'] = $topic;
		$view_vars['add'] = 'no';
		$view_vars['image'] = (!empty($topic['image'])) ? $app['getImageURL']($topic['image'],'large') : '/placeholder';
	}else{
		$view_vars['crumbs'][] = array('name'=>'add','href'=>'/topic/edit');
		$view_vars['add'] = 'yes';
		$view_vars['image'] = '/placeholder';
	}

	
	return $app['view']->render('forum/edit', 'default', $view_vars);
})
->value('topicId','')
->value('forumId','')
->before($mustbeMEMBER);

return $app;