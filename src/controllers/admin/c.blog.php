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
	
	$blog = new Model\Blog(array(),$app);
	$posts = $blog->fetchByStatus('PUBLISH','yes');

	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog'));
	$view_vars = array(
						 'active'=>'Blog'
						,'page-plugin'=>'datatables'
						,'headline'=>'DUI Blog'
						,'description'=>"Participate in all blogs here."
						,'crumbs'=>$crumbs
						,'posts'=>$posts
						,'tags'=>Model\Blog::getAvailableTags()
						);
	return $app['view']->render('blog/index', 'default', $view_vars);
})->before($mustbeMEMBER);

$app->get('/blog/archives/{month}/{year}', function ($month, $year, Request $request) use ($app) {
	
	$blog = new Model\Blog(array(),$app);
	$posts = $blog->fetchArchives($month,$year);

	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog')
					,array('name'=>'Archives for '.$month.', '.$year,'href'=>'/blog/archives/'.$month.'/'.$year)
	);
	$view_vars = array(
						 'active'=>'Blog'
						,'page-plugin'=>'datatables'
						,'headline'=>'DUI Blog'
						,'description'=>"Participate in all blogs here."
						,'crumbs'=>$crumbs
						,'posts'=>$posts
						,'month'=>$month
						,'year'=>$year
						,'tags'=>Model\Blog::getAvailableTags()
						);
	return $app['view']->render('blog/index', 'default', $view_vars);
})->before($mustbeMEMBER);

$app->get('/blog/tag/{tag}', function ($tag, Request $request) use ($app) {
	
	$blog = new Model\Blog(array(),$app);
	$posts = $blog->fetchTag($tag);

	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog')
					,array('name'=>'Tag: '.$tag, 'href'=>'/blog/tag/'.$tag)
	);
	$view_vars = array(
						 'active'=>'Blog'
						,'page-plugin'=>'datatables'
						,'headline'=>'DUI Blog'
						,'description'=>"Participate in all blogs here."
						,'crumbs'=>$crumbs
						,'posts'=>$posts
						,'tag'=>$tag
						,'tags'=>Model\Blog::getAvailableTags()
						);
	return $app['view']->render('blog/index', 'default', $view_vars);
})->before($mustbeMEMBER);

// publish scheduled
$app->get('/blog/publish-schedule', function (Request $request) use ($app) {
	
	$blog = new Model\Blog(array(),$app);
	$posts = $blog->fetchToPublish();
	if(is_array($posts) && count($posts) > 0){
		foreach($posts as $post):
			$b = new Model\Blog(array('_id'=>$post['_id'],'currentStatus'=>Model\Blog::$status['PUBLISH']),$app);
			$b->add = "no";
			$b->saveEdit();
		endforeach;
		$count = count($posts);
	}else{
		$count = 0;
	}
	return "posts affected: ".$count;
});


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

// view a blog post
$app->get('/blog/{blogId}/view', function ($blogId, Request $request) use ($app) {
	
	$blog = new Model\Blog(array('_id'=>$blogId),$app);
	$post = $blog->findById();

	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog')
					,array('name'=>'view','href'=>'/blog/'.$blogId.'/view')
		);
	$view_vars = array(
						 'active'=>'Blog'
						,'page-plugin'=>'datatables'
						,'headline'=>'DUI Blog'
						,'description'=>"Participate in all blogs here."
						,'crumbs'=>$crumbs
						,'post'=>$post
						,'tags'=>Model\Blog::getAvailableTags()
						);
	return $app['view']->render('blog/view', 'default', $view_vars);
})->before($mustbeMEMBER);


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
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	$second_crumb = ($user['accessLevel'] >= EDITOR) ? array('name'=>'All Blog Posts','href'=>'/blog/all-posts'): array('name'=>'My Blog Posts','href'=>'/blog/'.$memberId);
	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog')
					,$second_crumb
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
			    	//error_log('send ADMIN email......for:'.$blog->headline);
			    	//*
			    	// send admin the email notification
			    	$subject = 'Blog Post Submitted for Review';
			    	$to = SAW_ADMIN_EMAIL;
			    	$view_vars = array('firstName'=>$blog->author['firstName']
			    						,'middleName'=>$blog->author['middleName']
			    						,'lastName'=>$blog->author['lastName']
			    						,'headline'=>$blog->headline
			    						,'email'=>$blog->author['email']
			    	);
			    	$body = $app['view']->render('email/blog-post-review','email', $view_vars);
			    	$app['sendMail']($subject, $body, $to);
			    	//*/
	    		}
		    }
	    	if((int)$doc['currentStatus'] >= (int)Model\Blog::$status['SCHEDULE']){
	    		$accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$app);
	    		if($accessLevel >= EDITOR){
	    			// send out the email to blog author notifying that the blog posted
			    	$blog = new Model\Blog(array('_id'=>$_POST['current_id']),$app);
		    		$blog->findById();
			    	//error_log('send Author email......for:'.$blog->headline);
			    	//*
			    	// send admin the email notification
			    	$subject = 'Blog Post Approved';
			    	$to = $blog->author['email'];
			    	$view_vars = array('headline'=>$blog->headline);
			    	$body = $app['view']->render('email/blog-post-approved','email', $view_vars);
			    	$app['sendMail']($subject, $body, $to);
			    	//*/
	    		}
		    }
	    endif;
});

// edit the photo
$app->get('/blog/{memberId}/edit/{blogId}/edit-photo', function ($memberId, $blogId, Request $request) use ($app) {

	$blog = new Model\Blog($doc=array('_id'=>new MongoId($blogId)), $app);
	$blog = $blog->findById();
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	$second_crumb = ($user['accessLevel'] >= EDITOR) ? array('name'=>'All Blog Posts','href'=>'/blog/all-posts'): array('name'=>'My Blog Posts','href'=>'/blog/'.$memberId);
	
	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog')
					,$second_crumb
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
	
	$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$app);
	$second_crumb = ($user['accessLevel'] >= EDITOR) ? array('name'=>'All Blog Posts','href'=>'/blog/all-posts'): array('name'=>'My Blog Posts','href'=>'/blog/'.$memberId);
	
	$crumbs = array(array('name'=>'DUI Blog','href'=>'/blog')
					,$second_crumb
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