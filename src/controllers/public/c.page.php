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
use Cocur\Slugify\Slugify;

////////////////////////////////////////////////
// GETS ALL URLS FOR MAKING THE DROP DOWN NAV //
////////////////////////////////////////////////
$app['get_pages'] = $app->protect(function ($slug='') use($app) {
	
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$result = $page->findById('slug');
    
    $pages['DISCOVER'] = $page->fetchBySectionPublishedOnly('DISCOVER');
	$pages['LEARN'] = $page->fetchBySectionPublishedOnly('LEARN');
	$view_vars = array('page'=>$result
						,'pages'=>$pages
	);
	return $view_vars;
});

////////////////////////
// ALL PREVIEW ROUTES //
// managed routes need to have a place in the switch statement for a custom look in the nav menu
// other wise it's just their body content that gets placed there.
////////////////////////

$app->get('/preview/{slug}', function ($slug, Request $request) use ($app) {
	
	switch ($slug) {
		case 'sessions-and-seminars':
			$seminar = new Model\Seminar($doc=array(), $app);
			$seminars = $seminar->find($query=array(),$fields=array(),true,$sort=array('startDate.date'=>1),0,3);
			if(!empty($seminars)):
				for ($i=0; $i < count($seminars); $i++) {
					$agenda = new Model\Agenda(array('seminarId'=>$seminars[$i]['_id']),$app);
					$agendas = $agenda->findBySeminarId();
					$seminars[$i]['agendas'] = $agendas;
				}
			endif;
			$view_vars = array('seminars'=>$seminars);
			return $app['view']->render('page/cp-sessions-and-seminars', 'blank', $view_vars);
			break;
		
		default:
			$page = new Model\Page($doc=array('slug'=>$slug), $app);
			$page = $page->findById('slug');
			$view_vars = array('page'=>$page);
			return $app['view']->render('page/content-preview', 'blank', $view_vars);
			break;
	}
});



////////////////////
// MANAGED ROUTES //
////////////////////

//home
$app->get('/', function (Request $request) use ($app) {
	$view_vars['slogan_block'] = 'home';

	$page = new Model\Page($doc=array('slug'=>'welcome'), $app);
	$welcome = $page->findById('slug');
	$view_vars['welcome'] = $welcome;

	$page = new Model\Page($doc=array('slug'=>'notice-to-members'), $app);
	$ntm = $page->findById('slug');
	$view_vars['ntm'] = $ntm;

	$page = new Model\Page($doc=array('slug'=>'mission-statement'), $app);
	$ms = $page->findById('slug');
	$view_vars['ms'] = $ms;
	
	$page = new Model\Page($doc=array('slug'=>'nationally-recognized'), $app);
	$nr = $page->findById('slug');
	$view_vars['nr'] = $nr;

	$page_vars = $app['get_pages']();
	$view_vars = array_merge($page_vars,$view_vars);

	$blog = new Model\Blog(array(),$app);
	$posts = $blog->fetchByStatus('PUBLISH','yes',0,4);
	$view_vars['posts'] = $posts;

	$seminar = new Model\Seminar($doc=array(), $app);
	$seminars = $seminar->find($query=array(),$fields=array(),true,$sort=array('startDate.date'=>1),0,4);
	if(!empty($seminars)):
		for ($i=0; $i < count($seminars); $i++) {
			$agenda = new Model\Agenda(array('seminarId'=>$seminars[$i]['_id']),$app);
			$agendas = $agenda->findBySeminarId();
			$seminars[$i]['agendas'] = $agendas;
		}
	endif;
	$view_vars['seminars'] = $seminars;
	
	// force the expiration of the home page in an attempt to refresh the twitter feed.  the expire time is 6 months ago in seconds
	return new Response($app['view']->render('page/home', 'content',$view_vars), 200,array('Content-Type' => 'text/html', 'Expires'=>gmdate("D, d M Y H:i:s", time() -15552000) . " GMT"));
});

$app->get('/dui-news', function (Request $request) use ($app) {
	$view_vars['slogan_block'] = '';
	$page_vars = $app['get_pages']('dui-news');
	$view_vars = array_merge($page_vars,$view_vars);

	// forece the expiration of the home page in an attempt to refresh the twitter feed.  the expire time is 6 months ago in seconds
	return new Response($app['view']->render('page/dui-news', 'content',$view_vars), 200,array('Content-Type' => 'text/html', 'Expires'=>gmdate("D, d M Y H:i:s", time() -15552000) . " GMT"));
});

// blog roll
$app->get('/blog', function (Request $request) use ($app) {
	$view_vars=array();
	$page_vars = $app['get_pages']('blog');
	$view_vars = array_merge($page_vars,$view_vars);

	$blog = new Model\Blog(array(),$app);
	$posts = $blog->fetchByStatus('PUBLISH','yes');
	$archives = $blog->fetchArchiveCounts();

	$view_vars['posts'] = $posts;
	$view_vars['archives'] = $archives;
	$view_vars['tags'] = Model\Blog::getAvailableTags($app);

	return $app['view']->render('page/blog-roll', 'content',$view_vars);
});

// blog archives
$app->get('/blog/archives/{month}/{year}', function ($month, $year, Request $request) use ($app) {
	$view_vars=array();
	$page_vars = $app['get_pages']('blog');
	$view_vars = array_merge($page_vars,$view_vars);

	$blog = new Model\Blog(array(),$app);
	$posts = $blog->fetchArchives($month,$year);
	$archives = $blog->fetchArchiveCounts();

	$view_vars['posts'] = $posts;
	$view_vars['archives'] = $archives;
	$view_vars['tags'] = Model\Blog::getAvailableTags($app);

	$view_vars['page']['headline'] = 'Blog - '.$month.' '.$year;

	return $app['view']->render('page/blog-roll', 'content',$view_vars);
});

// blog tags
$app->get('/blog/tag/{tag}', function ($tag, Request $request) use ($app) {
	$view_vars=array();
	$page_vars = $app['get_pages']('blog');
	$view_vars = array_merge($page_vars,$view_vars);

	$blog = new Model\Blog(array(),$app);
	$posts = $blog->fetchTag($tag);
	$archives = $blog->fetchArchiveCounts();

	$view_vars['posts'] = $posts;
	$view_vars['archives'] = $archives;
	$view_vars['tags'] = Model\Blog::getAvailableTags($app);

	$cat = new Model\Category(array('slug'=>'/'.$tag),$app);
	$tagArr = $cat->findById('slug');
	$view_vars['page']['headline'] = (is_array($tagArr)) ? 'Blog - '.$tagArr['name']: 'Blog - This tag does not exist';

	return $app['view']->render('page/blog-roll', 'content',$view_vars);
});


// single blog post
$app->get('/blog/{id}/{slug}', function ($id, $slug, Request $request) use ($app) {
	$view_vars=array();
	$page_vars = $app['get_pages']('blog');
	$view_vars = array_merge($page_vars,$view_vars);

	$blog = new Model\Blog(array('_id'=>$id),$app);
	$post = $blog->findById();
	$archives = $blog->fetchArchiveCounts();

	$view_vars['post'] = $post;
	$view_vars['archives'] = $archives;
	$view_vars['tags'] = Model\Blog::getAvailableTags($app);
	
	return $app['view']->render('page/blog-post', 'content',$view_vars);
});

// contact
$app->get('/contact', function (Request $request) use ($app) {
	$view_vars['slogan_block'] = 'contact';
	$page_vars = $app['get_pages']('contact');
	$view_vars = array_merge($page_vars,$view_vars);

	return $app['view']->render('page/contact', 'content',$view_vars);
});
$app->post('/contact', function (Request $request) use ($app) {
	$doc = $request->get('doc');
	$errors = '';
	if(empty($doc['name']))
		$errors.= 'Please enter your name.<br>';
	if(empty($doc['email']))
		$errors.= 'Please enter your email.<br>';
	if(empty($doc['message']))
		$errors.= 'Please enter a message.';

	if(empty($errors)){
	    // send admin the email notification
		$subject = 'NCDD.com Contact Form Submitted';
		$to = SAW_ADMIN_EMAIL;
		$view_vars = array('name'=>$doc['name']
							,'message'=>$doc['message']
							,'email'=>$doc['email']
		);
		$body = $app['view']->render('email/new-contact','email', $view_vars);
		$app['sendMail']($subject, $body, $to);

	    return new Response(json_encode(array('message' =>'We received your message.  Thank you for contacting us.  We will get back to you as soon as we can.')), 200,array('Content-Type' => 'application/json'));
	}else{
		return new Response(json_encode(array('message' =>'<strong>Oops!</strong> looks we have some errors:<br>'.$errors)), 400,array('Content-Type' => 'application/json'));
	}
});

// find an attorney routes //
$app->get('/find-an-attorney', function (Request $request) use ($app) {
	$slug = 'find-an-attorney';
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$page = $page->findById('slug');

	$view_vars = array('page'=>$page);
	$view_vars['slogan_block'] = '';

	$page_vars = $app['get_pages']($slug);
	$view_vars = array_merge($page_vars,$view_vars);

	return $app['view']->render('page/find-an-attorney', 'content', $view_vars);
});
$app->get('/find-an-attorney/{country}/{state}', function ($country, $state, Request $request) use ($app) {

	switch (strtolower($country)) {
		case 'usa':
			$country = 'US';
			break;
		case 'canada':
			$country = 'CA';
			break;
	}
	$states = array('alabama'=>'AL','alaska'=>'AK','arizona'=>'AZ','arkansas'=>'AR','california'=>'CA','colorado'=>'CO','connecticut'=>'CT','delaware'=>'DE','washington-dc'=>'DC','florida'=>'FL','georgia'=>'GA','hawaii'=>'HI','idaho'=>'ID','illinois'=>'IL','indiana'=>'IN','iowa'=>'IA','kansas'=>'KS','kentucky'=>'KY','louisiana'=>'LA','maine'=>'ME','maryland'=>'MD','massachusetts'=>'MA','michigan'=>'MI','minnesota'=>'MN','mississippi'=>'MS','missouri'=>'MO','montana'=>'MT','nebraska'=>'NE','nevada'=>'NV','new-hampshire'=>'NH','new-jersey'=>'NJ','new-mexico'=>'NM','new-york'=>'NY','north-carolina'=>'NC','north-dakota'=>'ND','ohio'=>'OH','oklahoma'=>'OK','oregon'=>'OR','pennsylvania'=>'PA','rhode-island'=>'RI','south-carolina'=>'SC','south-dakota'=>'SD','tennessee'=>'TN','texas'=>'TX','utah'=>'UT','vermont'=>'VT','virginia'=>'VA','washington'=>'WA','west-virginia'=>'WV','wisconsin'=>'WI','wyoming'=>'WY','ontario'=>'ON','quebec'=>'QC','saskatchewan'=>'SK');
	$state = $states[$state];
	$state_reversed = array('AL'=>'Alabama','AK'=>'Alaska',    'AZ'=>'Arizona',    'AR'=>'Arkansas',    'CA'=>'California',    'CO'=>'Colorado',    'CT'=>'Connecticut',    'DE'=>'Delaware',    'DC'=>'District of Columbia',    'FL'=>'Florida',    'GA'=>'Georgia',    'HI'=>'Hawaii',    'ID'=>'Idaho',    'IL'=>'Illinois',    'IN'=>'Indiana',    'IA'=>'Iowa',  'IO'=>'Iowa',    'KS'=>'Kansas',    'KY'=>'Kentucky',    'LA'=>'Louisiana',    'ME'=>'Maine',    'MD'=>'Maryland',    'MA'=>'Massachusetts',    'MI'=>'Michigan',    'MN'=>'Minnesota',    'MS'=>'Mississippi',    'MO'=>'Missouri',    'MT'=>'Montana', 'NE'=>'Nebraska',    'NV'=>'Nevada',    'NH'=>'New Hampshire',    'NJ'=>'New Jersey',    'NM'=>'New Mexico',    'NY'=>'New York',    'NC'=>'North Carolina',    'ND'=>'North Dakota',    'OH'=>'Ohio',    'OK'=>'Oklahoma',    'OR'=>'Oregon',    'PA'=>'Pennsylvania',    'RI'=>'Rhode Island',    'SC'=>'South Carolina',    'SD'=>'South Dakota',    'TN'=>'Tennessee',    'TX'=>'Texas',    'UT'=>'Utah',    'VT'=>'Vermont',    'VA'=>'Virginia',    'WA'=>'Washington',    'WV'=>'West Virginia',   'WI'=>'Wisconsin',    'WY'=>'Wyoming','ON'=>'Ontario','SK'=>'Saskatchewan','QC'=>'Quebec');
	
	$member = new Model\Member(array(), $app);
	$members = $member->searchByState($state);

	$view_vars['slogan_block'] = '';
	$view_vars['state'] = $state_reversed[$state];
	$view_vars['members'] = $members;
	$page_vars = $app['get_pages']($state);
	$view_vars = array_merge($page_vars,$view_vars);
	
	return $app['view']->render('page/find-attorney/state', 'content', $view_vars);

});


// dui laws in your state routes // 
// redirects the old foundingmembers.php?location=State to the new routes
// because Redirect 301 doesn't work with querystrings..
$app->get('/duilawsinyourstate.php', function (Request $request) use ($app) {

	$location = $request->get('location');
	$slugify = new \Cocur\Slugify\Slugify();//for iconv translit
	$slug = $slugify->slugify($location);
	if($slug == 'n-a'){
		return $app->redirect('/dui-laws-in-your-state');
	}
	return $app->redirect('/dui-laws-in-your-state/usa/'.$slug);	

});

$app->get('/dui-laws-in-your-state', function (Request $request) use ($app) {
	$slug = 'dui-laws-in-your-state';
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$page = $page->findById('slug');

	$view_vars = array('page'=>$page);
	$view_vars['slogan_block'] = 'discover';

	$page_vars = $app['get_pages']($slug);
	$view_vars = array_merge($page_vars,$view_vars);

	return $app['view']->render('page/dui-laws-in-your-state', 'content', $view_vars);
});
$app->get('/dui-laws-in-your-state/{country}/{state}', function ($country, $state, Request $request) use ($app) {

	switch (strtolower($country)) {
		case 'usa':
			$section = 'DUI-LAWS-USA';
			break;
		case 'canada':
			$section = 'DUI-LAWS-CANADA';
			break;
	}
	$page = new Model\Page($doc=array('slug'=>$state,'section'=>$section), $app);
	$page = $page->fetchBySectionSlugPublishedOnly();
	$view_vars = array('page'=>$page);
	$view_vars['slogan_block'] = 'discover';
	$page_vars = $app['get_pages']($state);
	$view_vars = array_merge($page_vars,$view_vars);

	return $app['view']->render('page/dui-laws/state', 'content', $view_vars);

});

// Founding Members
// redirects the old foundingmembers.php?location=State to the new routes
// because Redirect 301 doesn't work with querystrings..
$app->get('/foundingmembers.php', function (Request $request) use ($app) {
	
	$location = $request->get('location');
	$slugify = new \Cocur\Slugify\Slugify();//for iconv translit
	$slug = $slugify->slugify($location);
	if($slug == 'n-a'){
		return $app->redirect('/founding-members');
	}
	return $app->redirect('/founding-members/usa/'.$slug);	

});
$app->get('/founding-members', function (Request $request) use ($app) {
	$slug = 'founding-members';
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$page = $page->findById('slug');

	$view_vars = array('page'=>$page);
	$view_vars['slogan_block'] = 'founding-members';

	$page_vars = $app['get_pages']($slug);
	
	$member = new Model\Member(array(), $app);
	$members = $member->search('Founding Members',true);

	$view_vars['members'] = $members;
	$view_vars = array_merge($page_vars,$view_vars);
	
	return $app['view']->render('page/founding-members', 'content', $view_vars);
});
$app->get('/founding-members/{country}/{state}', function ($country, $state, Request $request) use ($app) {

	switch (strtolower($country)) {
		case 'usa':
			$country = 'US';
			break;
		case 'canada':
			$country = 'CA';
			break;
	}
	$states = array('alabama'=>'AL','alaska'=>'AK','arizona'=>'AZ','arkansas'=>'AR','california'=>'CA','colorado'=>'CO','connecticut'=>'CT','delaware'=>'DE','washington-dc'=>'DC','florida'=>'FL','georgia'=>'GA','hawaii'=>'HI','idaho'=>'ID','illinois'=>'IL','indiana'=>'IN','iowa'=>'IA','kansas'=>'KS','kentucky'=>'KY','louisiana'=>'LA','maine'=>'ME','maryland'=>'MD','massachusetts'=>'MA','michigan'=>'MI','minnesota'=>'MN','mississippi'=>'MS','missouri'=>'MO','montana'=>'MT','nebraska'=>'NE','nevada'=>'NV','new-hampshire'=>'NH','new-jersey'=>'NJ','new-mexico'=>'NM','new-york'=>'NY','north-carolina'=>'NC','north-dakota'=>'ND','ohio'=>'OH','oklahoma'=>'OK','oregon'=>'OR','pennsylvania'=>'PA','rhode-island'=>'RI','south-carolina'=>'SC','south-dakota'=>'SD','tennessee'=>'TN','texas'=>'TX','utah'=>'UT','vermont'=>'VT','virginia'=>'VA','washington'=>'WA','west-virginia'=>'WV','wisconsin'=>'WI','wyoming'=>'WY','ontario'=>'ON','quebec'=>'QC','saskatchewan'=>'SK');
	$state = $states[$state];
	$state_reversed = array('AL'=>'Alabama','AK'=>'Alaska',    'AZ'=>'Arizona',    'AR'=>'Arkansas',    'CA'=>'California',    'CO'=>'Colorado',    'CT'=>'Connecticut',    'DE'=>'Delaware',    'DC'=>'District of Columbia',    'FL'=>'Florida',    'GA'=>'Georgia',    'HI'=>'Hawaii',    'ID'=>'Idaho',    'IL'=>'Illinois',    'IN'=>'Indiana',    'IA'=>'Iowa',  'IO'=>'Iowa',    'KS'=>'Kansas',    'KY'=>'Kentucky',    'LA'=>'Louisiana',    'ME'=>'Maine',    'MD'=>'Maryland',    'MA'=>'Massachusetts',    'MI'=>'Michigan',    'MN'=>'Minnesota',    'MS'=>'Mississippi',    'MO'=>'Missouri',    'MT'=>'Montana', 'NE'=>'Nebraska',    'NV'=>'Nevada',    'NH'=>'New Hampshire',    'NJ'=>'New Jersey',    'NM'=>'New Mexico',    'NY'=>'New York',    'NC'=>'North Carolina',    'ND'=>'North Dakota',    'OH'=>'Ohio',    'OK'=>'Oklahoma',    'OR'=>'Oregon',    'PA'=>'Pennsylvania',    'RI'=>'Rhode Island',    'SC'=>'South Carolina',    'SD'=>'South Dakota',    'TN'=>'Tennessee',    'TX'=>'Texas',    'UT'=>'Utah',    'VT'=>'Vermont',    'VA'=>'Virginia',    'WA'=>'Washington',    'WV'=>'West Virginia',   'WI'=>'Wisconsin',    'WY'=>'Wyoming','ON'=>'Ontario','SK'=>'Saskatchewan','QC'=>'Quebec');
	
	$member = new Model\Member(array(), $app);
	$members = $member->searchFoundingMembersByState($state);

	$view_vars['slogan_block'] = 'founding-members';
	$view_vars['state'] = $state_reversed[$state];
	$view_vars['members'] = $members;
	$page_vars = $app['get_pages']($state);
	$view_vars = array_merge($page_vars,$view_vars);
	
	return $app['view']->render('page/founding-members/state', 'content', $view_vars);

});

// State Delegates
// redirects the old foundingmembers.php?location=State to the new routes
// because Redirect 301 doesn't work with querystrings..
$app->get('/findstatedelegate.php', function (Request $request) use ($app) {
	
	$location = $request->get('location');
	$slugify = new \Cocur\Slugify\Slugify();//for iconv translit
	$slug = $slugify->slugify($location);
	if($slug == 'n-a'){
		return $app->redirect('/state-delegates');
	}
	return $app->redirect('/state-delegates/usa/'.$slug);	

});
$app->get('/state-delegates', function (Request $request) use ($app) {
	$slug = 'state-delegates';
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$page = $page->findById('slug');

	$view_vars = array('page'=>$page);
	$view_vars['slogan_block'] = 'founding-members';

	$page_vars = $app['get_pages']($slug);
	
	$member = new Model\Member(array(), $app);
	$members = $member->search('State Delegates',true);

	$view_vars['members'] = $members;
	$view_vars = array_merge($page_vars,$view_vars);
	
	return $app['view']->render('page/state-delegates', 'content', $view_vars);
});
$app->get('/state-delegates/{country}/{state}', function ($country, $state, Request $request) use ($app) {

	switch (strtolower($country)) {
		case 'usa':
			$country = 'US';
			break;
		case 'canada':
			$country = 'CA';
			break;
	}
	$states = array('alabama'=>'AL','alaska'=>'AK','arizona'=>'AZ','arkansas'=>'AR','california'=>'CA','colorado'=>'CO','connecticut'=>'CT','delaware'=>'DE','washington-dc'=>'DC','florida'=>'FL','georgia'=>'GA','hawaii'=>'HI','idaho'=>'ID','illinois'=>'IL','indiana'=>'IN','iowa'=>'IA','kansas'=>'KS','kentucky'=>'KY','louisiana'=>'LA','maine'=>'ME','maryland'=>'MD','massachusetts'=>'MA','michigan'=>'MI','minnesota'=>'MN','mississippi'=>'MS','missouri'=>'MO','montana'=>'MT','nebraska'=>'NE','nevada'=>'NV','new-hampshire'=>'NH','new-jersey'=>'NJ','new-mexico'=>'NM','new-york'=>'NY','north-carolina'=>'NC','north-dakota'=>'ND','ohio'=>'OH','oklahoma'=>'OK','oregon'=>'OR','pennsylvania'=>'PA','rhode-island'=>'RI','south-carolina'=>'SC','south-dakota'=>'SD','tennessee'=>'TN','texas'=>'TX','utah'=>'UT','vermont'=>'VT','virginia'=>'VA','washington'=>'WA','west-virginia'=>'WV','wisconsin'=>'WI','wyoming'=>'WY','ontario'=>'ON','quebec'=>'QC','saskatchewan'=>'SK');
	$state = $states[$state];
	$state_reversed = array('AL'=>'Alabama','AK'=>'Alaska',    'AZ'=>'Arizona',    'AR'=>'Arkansas',    'CA'=>'California',    'CO'=>'Colorado',    'CT'=>'Connecticut',    'DE'=>'Delaware',    'DC'=>'District of Columbia',    'FL'=>'Florida',    'GA'=>'Georgia',    'HI'=>'Hawaii',    'ID'=>'Idaho',    'IL'=>'Illinois',    'IN'=>'Indiana',    'IA'=>'Iowa',  'IO'=>'Iowa',    'KS'=>'Kansas',    'KY'=>'Kentucky',    'LA'=>'Louisiana',    'ME'=>'Maine',    'MD'=>'Maryland',    'MA'=>'Massachusetts',    'MI'=>'Michigan',    'MN'=>'Minnesota',    'MS'=>'Mississippi',    'MO'=>'Missouri',    'MT'=>'Montana', 'NE'=>'Nebraska',    'NV'=>'Nevada',    'NH'=>'New Hampshire',    'NJ'=>'New Jersey',    'NM'=>'New Mexico',    'NY'=>'New York',    'NC'=>'North Carolina',    'ND'=>'North Dakota',    'OH'=>'Ohio',    'OK'=>'Oklahoma',    'OR'=>'Oregon',    'PA'=>'Pennsylvania',    'RI'=>'Rhode Island',    'SC'=>'South Carolina',    'SD'=>'South Dakota',    'TN'=>'Tennessee',    'TX'=>'Texas',    'UT'=>'Utah',    'VT'=>'Vermont',    'VA'=>'Virginia',    'WA'=>'Washington',    'WV'=>'West Virginia',   'WI'=>'Wisconsin',    'WY'=>'Wyoming','ON'=>'Ontario','SK'=>'Saskatchewan','QC'=>'Quebec');
	
	$member = new Model\Member(array(), $app);
	$members = $member->searchStateDelegatesByState($state);

	$view_vars['slogan_block'] = 'founding-members';
	$view_vars['state'] = $state_reversed[$state];
	$view_vars['members'] = $members;
	$page_vars = $app['get_pages']($state);
	$view_vars = array_merge($page_vars,$view_vars);
	
	return $app['view']->render('page/state-delegates/state', 'content', $view_vars);

});

// Regents and Fellows
$app->get('/regents-and-fellows', function (Request $request) use ($app) {
	$slug = 'regents-and-fellows';
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$page = $page->findById('slug');

	$view_vars = array('page'=>$page);
	$view_vars['slogan_block'] = 'regents-and-fellows';

	$page_vars = $app['get_pages']($slug);
	
	$member = new Model\Member(array(), $app);
	$members = $member->search('Regents and Fellows',true);

	$view_vars['members'] = $members;
	$view_vars = array_merge($page_vars,$view_vars);
	
	return $app['view']->render('page/regents-and-fellows', 'content', $view_vars);
});

// Board Certification
$app->get('/board-certification', function (Request $request) use ($app) {
	$slug = 'board-certification';
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$page = $page->findById('slug');

	$view_vars = array('page'=>$page);
	$view_vars['slogan_block'] = 'board-certification';

	$page_vars = $app['get_pages']($slug);
	$view_vars = array_merge($page_vars,$view_vars);
	return $app['view']->render('page/board-certification', 'content', $view_vars);
});
$app->get('/apply-for-board-certification', function (Request $request) use ($app) {
	$slug = 'apply-for-board-certification';
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$page = $page->findById('slug');

	$view_vars = array('page'=>$page);
	$view_vars['slogan_block'] = 'board-certification';

	$page_vars = $app['get_pages']($slug);
	$view_vars = array_merge($page_vars,$view_vars);
	return $app['view']->render('page/board-certification-apply', 'content', $view_vars);
});
$app->get('/apply-for-re-certification', function (Request $request) use ($app) {
	$slug = 'apply-for-re-certification';
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$page = $page->findById('slug');

	$view_vars = array('page'=>$page);
	$view_vars['slogan_block'] = 'board-certification';

	$page_vars = $app['get_pages']($slug);
	$view_vars = array_merge($page_vars,$view_vars);
	return $app['view']->render('page/board-certification-apply', 'content', $view_vars);
});

// seminar roll
$app->get('/sessions-and-seminars', function (Request $request) use ($app) {
	
	$seminar = new Model\Seminar($doc=array(), $app);
	$seminars = $seminar->find($query=array(),$fields=array(),true,$sort=array('startDate.date'=>1));
	if(!empty($seminars)):
		for ($i=0; $i < count($seminars); $i++) {
			$agenda = new Model\Agenda(array('seminarId'=>$seminars[$i]['_id']),$app);
			$agendas = $agenda->findBySeminarId();
			$seminars[$i]['agendas'] = $agendas;
		}
	endif;
	$view_vars['seminars'] = $seminars;
	$view_vars['slogan_block'] = 'learn';
	$page_vars = $app['get_pages']('sessions-and-seminars');
	$view_vars = array_merge($page_vars,$view_vars);


	return $app['view']->render('page/seminar-index', 'content',$view_vars);
});

// single seminar post
$app->get('/sessions-and-seminars/{id}/{slug}', function ($id, $slug, Request $request) use ($app) {
	$view_vars=array();
	$view_vars['slogan_block'] = 'learn';
	$page_vars = $app['get_pages']('sessions-and-seminars');
	$view_vars = array_merge($page_vars,$view_vars);

	$seminar = new Model\Seminar(array('_id'=>$id),$app);
	$seminar = $seminar->findById();

	$agenda = new Model\Agenda(array('seminarId'=>$seminar['_id']),$app);
	$agendas = $agenda->findBySeminarId();
	$seminar['agendas'] = $agendas;
	
	$view_vars['seminar'] = $seminar;
	
	return $app['view']->render('page/seminar-post', 'content',$view_vars);
});

// product categories
$app->get('/store', function (Request $request) use ($app) {
	
	$category = new Model\Category(array('currentType'=>Model\Category::$type['STORE']),$app);
	$categories = $category->fetchByType();
	
	$view_vars['categories'] = $categories;
	$page_vars = $app['get_pages']('store');
	$view_vars = array_merge($page_vars,$view_vars);

	return $app['view']->render('page/store-index', 'content',$view_vars);
});

// product roll
$app->get('/store/{category}', function ($category, Request $request) use ($app) {
	
	$category = new Model\Category(array('slug'=>'/'.$category),$app);
	$category = $category->findById('slug');
	
	$product = new Model\Product($doc=array(), $app);
	$products = $product->fetchByCategory($category['_id']);
	
	
	$view_vars['category'] = $category;
	$view_vars['products'] = $products;
	$page_vars = $app['get_pages']('store');
	$view_vars = array_merge($page_vars,$view_vars);
	$view_vars['page']['headline'] = (is_array($category)) ? $category['name']: '';

	return $app['view']->render('page/store-category-index', 'content',$view_vars);
});

// single product
$app->get('/store/{id}/{slug}', function ($id, $slug, Request $request) use ($app) {
	$view_vars=array();
	$page_vars = $app['get_pages']('store');
	$view_vars = array_merge($page_vars,$view_vars);

	$product = new Model\Product(array('_id'=>$id),$app);
	$product = $product->findById();

	$categoryProd = new Model\Product($doc=array(), $app);
	$catprods = $categoryProd->fetchByCategory($product['category']['_id']);
	$related_products = array();
	for ($i=0; $i < 3; $i++) { 
		array_push($related_products, $catprods[mt_rand(0,count($catprods)-1)]);
	}
	$view_vars['product'] = $product;
	$view_vars['related_products'] = $related_products;
	
	return $app['view']->render('page/store-product', 'content',$view_vars);
});

////////////////////
// 	SHOPPING CART //
////////////////////
$app['updateShoppingCart'] = $app->protect(function ($doc) use ($app) {
	$product_arr = array();
	$fields = array();
	foreach($doc as $productId => $item):
		$productObj = new Model\Product(array('_id'=>$productId),$app);
		$product = $productObj->findById();

		if(array_key_exists('preference', $item) && !empty($product['purchaseInstructions']) && empty($item['preference'])){
			
			$fields[] = array('name'=>'preference-'.$productId,
							  'message'=>'Please specify your preference based on the Purchase Instructions',
							  'invalid_value'=>'');
		}
		if(array_key_exists('quantity', $item) && $item['quantity'] <= 0){
			$fields[] = array('name'=>'quantity-'.$productId,
							  'message'=>'Must be atleast 1',
							  'invalid_value'=>'');	
		}
	endforeach;
	if(!empty($fields)){
		throw new Saw\Model\Exceptions\DomainException($productObj::$invalidFieldsMessage, $fields);
	}
	//*
	foreach($doc as $productId => $item):
		$product = array();

		$productObj = new Model\Product(array('_id'=>$productId),$app);
		$product = $productObj->findById();
		
		$product['quantity'] = $item['quantity'];
		$product['preference'] = (array_key_exists('preference', $item)) ? $item['preference']: '';

		$product_order = new Model\ProductOrder($product,$app);
		$product_order = $product_order->__toArray(false);

		$product_arr[$product_order['_id']->__toString()] = $product_order;
		
	endforeach;
	$shoppingcart = $app['session']->get('shoppingcart');
	if(empty($shoppingcart)){
		$app['session']->set('shoppingcart',$product_arr);
	}else{
		$cart = array_merge($shoppingcart,$product_arr);
		$app['session']->set('shoppingcart',$cart);		
	}
	//*/
});
// get shopping cart
$app->get('/shopping-cart', function (Request $request) use ($app) {

	$view_vars=array();
	$page_vars = $app['get_pages']('shopping-cart');
	$view_vars = array_merge($page_vars,$view_vars);

	$view_vars['cart_items'] = $app['session']->get('shoppingcart');
	$view_vars['user'] = $app['session']->get('user');
	//echo "<pre>";print_r($view_vars['cart_items']);echo "</pre>";
	return $app['view']->render('page/shopping-cart', 'content',$view_vars);
});
// add to shopping cart
$app->post('/shopping-cart/add', function (Request $request) use ($app) {
	$doc = $request->get('doc');
	if(array_key_exists('productId', $doc)){
		$arr[$doc['productId']]['quantity'] = $doc['quantity'];
		$arr[$doc['productId']]['preference'] = (array_key_exists('preference', $doc)) ? $doc['preference'] : '';
		$doc = $arr;
	}
	$app['updateShoppingCart']($doc);

	return new Response(json_encode(array('message' =>'success')), 200,array('Content-Type' => 'application/json'));
});
$app->get('/shopping-cart/add/{productId}/{quantity}', function ($productId, $quantity, Request $request) use ($app) {
	
	$doc[$productId]['quantity'] = (!empty($quantity)) ? $quantity: 1;

	$app['updateShoppingCart']($doc);

	return new Response(json_encode(array('message' =>'success')), 200,array('Content-Type' => 'application/json'));
})->value('productId','')
->value('quantity',1);

// remove from shopping cart
$app->get('/shopping-cart/remove/{productId}', function ($productId, Request $request) use ($app) {
	$cart = $app['session']->get('shoppingcart');
	unset($cart[$productId]);
	$app['session']->set('shoppingcart',$cart);
	return new Response(json_encode(array('message' =>'success')), 200,array('Content-Type' => 'application/json'));
})->value('productId','');


/////////////////////////////
// 	SHOPPING CART CHECKOUT //
/////////////////////////////
// get shopping cart
$app->get('/shopping-cart/checkout', function (Request $request) use ($app) {

	$view_vars=array();
	$page_vars = $app['get_pages']('checkout');
	$view_vars = array_merge($page_vars,$view_vars);
	$view_vars['cart_items'] = $app['session']->get('shoppingcart');
	$user = $app['session']->get('user');
	if(is_object($user['user_id'])){
		$member = new Model\Member(array('_id'=>$user['user_id']),$app);
		$location = new Model\Location(array(),$app,$member);
		$user = $member->findById();
		$location = $location->getByMemberId();
		$view_vars['location'] = $location;
	}elseif(!is_array($user)){
		$user = array();
	}
	$view_vars['user'] = $user;
	return $app['view']->render('page/shopping-cart-checkout', 'content',$view_vars);
});
$app->post('/shopping-cart/checkout', function (Request $request) use ($app) {
	// retrieve document from request
	$doc = $request->get('doc');
	if(!empty($doc['orderId'])){
		$order = new Model\Order(array('_id'=>$doc['orderId']),$app);
		$order->delete();
	}
	
	$payment = new Model\Payment($doc,$app);
	$app['validateModel']($app, $payment,$groups=array('product-purchase'));

	// once the payment has been validated, create the order object and re-create the payment object, finally charge the payment and return the orderId
	$order_doc['add'] = 'yes';
	$order_doc['orderTotal'] = $doc['orderTotal'];
	$order_doc['shippingTotal'] = $doc['shippingTotal'];
	$order_doc['discountTotal'] = $doc['discountTotal'];
	$order_doc['shoppingCart'] = $app['session']->get('shoppingcart');
	$order_doc['payment'] = $payment->__toArray();
	$order = new Model\Order($order_doc,$app);
	$orderId = $order->saveEdit();
	$doc['ownerId'] = $orderId;
	$doc['ownerClass'] = "Order";
	$doc['items'] = $order_doc['shoppingCart'];
	$payment = new Model\Payment($doc,$app);
	$paymentId = $payment->charge();

	$payment = new Model\Payment(array('_id'=>$paymentId),$app);
	$payment = $payment->findById();

	$order = new Model\Order(array('_id'=>$orderId,'payment'=>$payment),$app);
	$order->saveSafe();
	$order = $order->findById();

	// set the global parameter manually to use the _id in the after() handler below
    $_POST['order'] = $order;

    // empty the shopping cart
    $app['session']->set('shoppingcart',array());

    return new Response(json_encode(array('orderId'=>$orderId,'message'=>"success")), 200,array('Content-Type' => 'application/json'));
})->after(function (Request $request, Response $response, Silex\Application $app) {
		if((int)$response->getStatusCode() == 200):
	    	
	    	$order = $_POST['order'];
	    	if(!empty($order['payment']['memberId'])){
				$member = new Model\Member(array('_id'=>$order['payment']['memberId']),$app);
				$user = $member->findById();
			}else{
				$user = array();
			}		
	    	$view_vars = array('order'=>$order,'user'=>$user);

	    	// send admin the email notification
	    	$subject = 'New Order from the NCDD Store Submitted';
	    	$to = SAW_ADMIN_EMAIL;
	    	$body = $app['view']->render('email/new-order','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);

	    	// send customer the email receipt
	    	$subject = 'Your recent purchase on NCDD.com';
	    	$to = $order['payment']['email'];
	    	$body = $app['view']->render('email/new-order-receipt','email', $view_vars);
	    	$app['sendMail']($subject, $body, $to);
	    	
	    endif;
});
$app->get('/shopping-cart/checkout/receipt/{orderId}', function ($orderId, Request $request) use ($app) {
	$order = new Model\Order(array('_id'=>$orderId),$app);
	$order = $order->findById();

	if(!empty($order['payment']['memberId'])){
		$member = new Model\Member(array('_id'=>$order['payment']['memberId']),$app);
		$user = $member->findById();
	}else{
		$user = array();
	}		

	$view_vars = array('order'=>$order,'user'=>$user);
	return $app['view']->render('page/shopping-cart-checkout-receipt', 'empty',$view_vars);
});

/////////////
// 	SEARCH //
/////////////

// this route expects the "q" query string parameter to be there like this:
//  /search?q=key words go here
// must always check that it's present
$app->get('/search', function (Request $request) use ($app) {
	
	$query = $request->get('q');
	$results = array();
	if(!empty($query)){

		// members first
		$member = new Model\Member(array(),$app);
		$members = $member->search($query,true);

		if(!empty($members) && is_array($members)){
			//echo "<pre>".print_r($members);echo "</pre>";
			foreach ($members as $member) {
				$middleName = (!empty($member['middleName'])) ? ' '.$member['middleName'].' ':' ';
				$bio = (strlen($member['aboutMe']) > 200) ? substr($member['aboutMe'],0,strpos($member['aboutMe'], ' ',200)).'...': $member['aboutMe'];
				$website = (!empty($member['websites'])) ? '<a href="http://'.$member['websites'][0]['website'].'"> '.$member['websites'][0]['website'].'</a>' : '';

				$staff = ($member['staff'] =='Yes') ? '<a href="/member/'.$member['_id'].'/'.$member['slug'].'"><img class="sheild" width="100" src="https://'.SAW_CONSUMER_WEBSITE.'/badge/'.$member['_id'].'/staff" alt="NCDD National College for DUI Defense: '.$member['firstName'].$middleName.$member['lastName'].'" title="NCDD National College for DUI Defense: '.$member['firstName'].$middleName.$member['lastName'].'" /></a>':'';
                $boardCertified = ($member['boardCertified'] =='Yes') ? '<a href="/member/'.$member['_id'].'/'.$member['slug'].'"><img class="sheild" width="120" src="https://'.SAW_CONSUMER_WEBSITE.'/badge/'.$member['_id'].'/boardcertified" alt="NCDD National College for DUI Defense: '.$member['firstName'].$middleName.$member['lastName'].'" title="NCDD National College for DUI Defense: '.$member['firstName'].$middleName.$member['lastName'].'" /></a>':'';
                
				$results[] = array(
					'title'=>'<a href="/member/'.$member['_id'].'/'.$member['slug'].'">'.$member['firstName'].$middleName.$member['lastName'].'</a>'
					,'image'=>'<div class="span2">
                                    <div style="overflow-y: hidden;width: 130px;height: 150px;float: left; padding-right:20px">
                                        <a href="/member/'.$member['_id'].'/'.$member['slug'].'"><img src="'.$member['image'].'" width="130" alt=""></a>
                                    </div>
                                </div>'
					,'subtext'=>'<b>'.'<a href="tel:'.$member['primaryPhone'].'">'.$member['primaryPhone'].'</a>'.'</b>&nbsp;&nbsp;&nbsp;<b>'.$website.'</b> '
					//,'body'=> '<img class="sheild" width="100" src="https://'.SAW_CONSUMER_WEBSITE.'/badge/'.$member['_id'].'/member" alt="NCDD National College for DUI Defense: '.$member['firstName'].$middleName.$member['lastName'].'" title="NCDD National College for DUI Defense: '.$member['firstName'].$middleName.$member['lastName'].'" /> '.$bio
					,'body'=>strip_tags($bio).'&nbsp;&nbsp;&nbsp; </div><div class="span5"><a href="/member/'.$member['_id'].'/'.$member['slug'].'"><img class="sheild" width="100" src="https://'.SAW_CONSUMER_WEBSITE.'/badge/'.$member['_id'].'/member" alt="NCDD National College for DUI Defense: '.$member['firstName'].$middleName.$member['lastName'].'" title="NCDD National College for DUI Defense: '.$member['firstName'].$middleName.$member['lastName'].'" /></a>'.$boardCertified.''.$staff.' </div>'
				);
			}  
		}

		// blog

		// pages

		// seminars

		// store

	}
	$view_vars = array('results'=>$results, 'query'=>$query);
	$page_vars = $app['get_pages']('search');
	$view_vars = array_merge($page_vars,$view_vars);

	return $app['view']->render('page/search', 'content', $view_vars);
		
});

////////////////////////
// NON MANAGED ROUTES //
////////////////////////
// this also contaings manaaged pages .. just means the catchall route for all pages whether managed or dynamic //
$app->get('/{slug}', function ($slug, Request $request) use ($app) {
	
	$page_vars = $app['get_pages']($slug);
	$view_vars['slogan_block'] = strtolower($page_vars['page']['section']);
	
	switch ($slug) {
		case 'deans-message':
			$view_vars = array('slogan_block'=>'deansmessage');
			break;
		case 'erwin-taylor-award':
			$view_vars = array('slogan_block'=>'');
			break;
		
		default:
			$view_vars = array();
			break;
	}

	
	$view_vars = array_merge($page_vars,$view_vars);

	return $app['view']->render('page/content', 'content', $view_vars);
});


///////////////////
// SEMINAR FILES //
///////////////////
$app->get('/seminar/downloads/{file}', function ($file, Request $request) use ($app) {

	$file = './../../../www/admin.ncdd.com/public_html/assets/seminar-forms/'.$file;
    $file_contents = file_get_contents($file);
	return new Response($file_contents, 200, array('Content-Type' => 'application/octet-stream'));
});

return $app;