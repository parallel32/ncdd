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


$app->get('/blog', function (Request $request) use ($app) {
	
	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog'));
	$view_vars = array(
						 'active'=>'Blog'
						,'page-plugin'=>'datatables'
						,'headline'=>'DUI Blog'
						,'description'=>"Participate in all blogs here."
						,'crumbs'=>$crumbs
						);
	return $app['view']->render('blog/index', 'default', $view_vars);
})->before($mustbeMEMBER);

// member blog posts index page.. has drafts and posts approved and posted or scheduled to post.
$app->get('/blog/all-posts', function (Request $request) use ($app) {
	
	$blog = new Model\Blog(array(),$app);
	$reviews = $blog->fetchByStatus('REVIEW','no');
	$scheduled = $blog->fetchByStatus('SCHEDULE','no');
	$published = $blog->fetchByStatus('PUBLISH','yes');
	$unpublished = $blog->fetchByStatus('UNPUBLISH','no');

	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog')
					,array('name'=>'All Blog Posts','href'=>'/blog/all-posts')
	);
	$view_vars = array(
						 'active'=>'Blog/All'
						,'page-plugin'=>'datatables'
						,'headline'=>'All Blog Posts'
						,'description'=>"All blog posts and their status"
						,'crumbs'=>$crumbs
						,'reviews'=>$reviews
						,'scheduled'=>$scheduled
						,'published'=>$published
						,'unpublished'=>$unpublished
						);
	return $app['view']->render('blog/all-posts', 'default', $view_vars);
})->before($mustbeEDITOR);

// remove a blog completely
$app->get('/blog/{blogId}/remove', function ($blogId, Request $request) use ($app) {
	$user = $app['session']->get('user');
	$accessLevel = $user['accessLevel'];
	$user_id = $user['user_id'];
	
	$blog = new Model\Blog(array('_id'=>$blogId), $app);
    $blog->findById();
	if(($accessLevel == MEMBER && $blog->author['_id'] == $user_id) || $accessLevel >= EDITOR){
		$blog->remove();
		return new Response(json_encode(array('message' => 'Blog details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
	}else{
		return new Response(json_encode(array('message' => 'Permission Denied.  Insufficient Privileges.')), 400,array('Content-Type' => 'application/json'));
	}
    
    
    
    

})->before($mustbeMEMBER);

// member blog posts index page.. has drafts and posts approved and posted or scheduled to post.
$app->get('/blog/{memberId}', function ($memberId, Request $request) use ($app) {
	
	$blog = new Model\Blog(array(),$app);
	$drafts = $blog->fetchByAuthorByDraft($memberId);
	$reviews = $blog->fetchByAuthorByReview($memberId);
	$approved = $blog->fetchByAuthorByApproved($memberId);

	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog')
					,array('name'=>'My Blog Posts','href'=>'/blog/'.$memberId)
	);
	$view_vars = array(
						 'active'=>'Blog/My'
						,'page-plugin'=>'datatables'
						,'headline'=>'My Blog Posts'
						,'description'=>"Participate in the public DUI Blog by drafting a post and submitting it for review."
						,'crumbs'=>$crumbs
						,'drafts'=>$drafts
						,'reviews'=>$reviews
						,'approved'=>$approved
						);
	return $app['view']->render('blog/my-posts', 'default', $view_vars);
})->before($mustbeMEMBER);
// member add / edit a post
$app->get('/blog/{memberId}/edit/{blogId}', function ($memberId, $blogId, Request $request) use ($app) {
	
	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog')
					,array('name'=>'My Blog Posts','href'=>'/blog/'.$memberId)
	);
	$view_vars = array(
						 'active'=>'Blog/My'
						,'page-plugin'=>'editor'
						,'headline'=>(empty($blogId)) ? 'Add a new blog post' : 'Edit your blog posts' 
						,'description'=>"Edit your post and submit it for review when finished."
						,'crumbs'=>$crumbs
						,'availableTags'=>Model\Blog::getAvailableTags()
						,'memberId'=>$memberId
						);
	
	if(!empty($blogId)){	
		$blog = new Model\Blog(array('_id'=>$blogId),$app);
		$blog = $blog->findById();

		$view_vars['crumbs'][] = array('name'=>$blog['headline'],'href'=>'/blog/'.$memberId.'/edit/'.$blogId);
		$view_vars['crumbs'][] = array('name'=>'edit','href'=>'/blog/'.$memberId.'/edit/'.$blogId);

		$view_vars['blog'] = $blog;
		$view_vars['add'] = 'no';
		$view_vars['image'] = (!empty($blog['image'])) ? $app['getImageURL']($blog['image'],'large') : '/placeholder';
	}else{
		$view_vars['crumbs'][] = array('name'=>'add','href'=>'/blog/'.$memberId.'/edit');
		$view_vars['add'] = 'yes';
		$view_vars['image'] = '/placeholder';
	}

	
	return $app['view']->render('blog/edit', 'default', $view_vars);
})->before($mustbeMEMBER)
->value('blogId','');

// add / save blog post
$app->post('/blog/{memberId}/edit', function ($memberId, Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    if(array_key_exists('tags',$document)){
    	$document['tags'] = implode(',',$document['tags']);
    }
    $member = new Model\Member(array('_id'=>$memberId),$app);
    $member->findById();
    $blog = new Model\Blog($document, $app, $member);
    // validate the model
   	$app['validateModel']($app,$blog);
    $blog->saveEdit();
    
    // set the global parameter manually to use the _id in the after() handler below
    $_POST['current_id'] = $blog->_id->__toString();
    
    return new Response(json_encode(array('blogId'=>$blog->_id->__toString(), 'message' => 'Blog details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeMEMBER)
->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
			// retrieve document from request
    		$doc = $request->get('doc');
    
	    	
	    	if((int)$doc['currentStatus'] == (int)Model\Blog::$status['REVIEW']){
	    		$accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$app);
	    		if($accessLevel == MEMBER){
	    			// send out the email to the admin notifying to review the blog post
			    	$blog = new Model\Blog(array('_id'=>$_POST['current_id']),$app);
		    		$blog->findById();
			    	error_log('send ADMIN email......for:'.$blog->headline);
	    		}
		    }
	    	if((int)$doc['currentStatus'] >= (int)Model\Blog::$status['SCHEDULE']){
	    		$accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$app);
	    		if($accessLevel >= EDITOR){
	    			// send out the email to blog author notifying that the blog posted
			    	$blog = new Model\Blog(array('_id'=>$_POST['current_id']),$app);
		    		$blog->findById();
			    	error_log('send Author email......for:'.$blog->headline);
	    		}
		    }
	    	//error_log('inside after function for EDIT blog:'.print_r($blog['headline'],true));
	    	/*
	    	// send admin the email notification
	    	$subject = 'General Member Application Form Submitted';
	    	$to = SAW_ADMIN_EMAIL;
	    	$view_vars = array('firstName'=>$doc['firstName']
	    						,'lastName'=>$doc['lastName']
	    						,'city'=>$doc['city']
	    						,'state'=>$doc['state']
	    						,'email'=>$doc['email']
	    	);
	    	$body = $app['view']->render('email/new-member','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);
	    	//*/
	    endif;
});

// edit the photo
$app->get('/blog/{memberId}/edit/{blogId}/edit-photo', function ($memberId, $blogId, Request $request) use ($app) {

	$blog = new Model\Blog($doc=array('_id'=>new MongoId($blogId)), $app);
	$blog = $blog->findById();
	
	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog')
					,array('name'=>'My Blog Posts','href'=>'/blog/'.$memberId)
					,array('name'=>$blog['headline'],'href'=>'/blog/'.$memberId.'/edit/'.$blogId)
					,array('name'=>'edit','href'=>'/blog/'.$memberId.'/edit/'.$blogId)
					,array('name'=>'photo','href'=>'/blog/'.$memberId.'/edit/'.$blogId.'/edit-photo')
	);

	$view_vars = array(
						 'active'=>'Blog/My'
						,'page-plugin'=>'fileupload'
						,'headline'=>'Blog'
						,'description'=>"Edit blog photo"
						,'crumbs'=>$crumbs
						,'blog'=>$blog
						,'image'=>(!empty($blog['image'])) ? $app['getImageURL']($blog['image'],'large') : '/placeholder'
						,'imageDelete'=>(!empty($blog['image'])) ? '/image/delete/'.$blog['image']['context'].'/'.$blog['image']['belongsTo'] : '');
	return $app['view']->render('blog/edit-photo', 'default', $view_vars);
})
->before($mustbeMEMBER)
->value('memberId','')
->value('blogId','');

$app->get('/blog/{memberId}/edit/{blogId}/edit-photo-crop', function ($memberId, $blogId, Request $request) use ($app) {

	$blog = new Model\Blog($doc=array('_id'=>new MongoId($blogId)), $app);
	$blog = $blog->findById();
	
	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog')
					,array('name'=>'My Blog Posts','href'=>'/blog/'.$memberId)
					,array('name'=>$blog['headline'],'href'=>'/blog/'.$memberId.'/edit/'.$blogId)
					,array('name'=>'edit','href'=>'/blog/'.$memberId.'/edit/'.$blogId)
					,array('name'=>'photo','href'=>'/blog/'.$memberId.'/edit/'.$blogId.'/edit-photo')
					,array('name'=>'crop','href'=>'/blog/'.$memberId.'/edit/'.$blogId.'/edit-photo-crop')
	);
	
	$view_vars = array(
						 'active'=>'Blog/My'
						,'page-plugin'=>'crop'
						,'headline'=>'Blog'
						,'description'=>"Crop blog photo"
						,'crumbs'=>$crumbs
						,'blog'=>$blog
						,'image'=>(!empty($blog['image'])) ? $app['getImageURL']($blog['image'],'large') : '/placeholder'
						);
	return $app['view']->render('blog/edit-photo-crop', 'default', $view_vars);
})
->before($mustbeMEMBER)
->value('memberId','')
->value('blogId','');




// slugify
$app->post('/blog/slugify', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $slug = Model\Blog::slugify($doc['headline']);
    
    return new Response(json_encode(array('slug'=>$slug, 'message' => 'successful operation.')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeMEMBER);



return $app;