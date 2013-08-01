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


////////////////////////////////////////////////
// GETS ALL URLS FOR MAKING THE DROP DOWN NAV //
////////////////////////////////////////////////
$app['get_pages'] = $app->protect(function ($slug='') use($app) {
	
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$result = $page->findById('slug');
    
    $pages['DISCOVER'] = $page->fetchBySectionPublishedOnly('DISCOVER');
	$pages['LEARN'] = $page->fetchBySectionPublishedOnly('LEARN');
	$pages['BOARD CERTIFICATION'] = $page->fetchBySectionPublishedOnly('BOARD CERTIFICATION');
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
			# code...
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

	$page_vars = $app['get_pages']();
	$view_vars = array_merge($page_vars,$view_vars);

	return $app['view']->render('page/home', 'content',$view_vars);
});

// blog
$app->get('/blog', function (Request $request) use ($app) {
	$view_vars=array();
	$page_vars = $app['get_pages']();
	$view_vars = array_merge($page_vars,$view_vars);
	return $app['view']->render('page/blog-roll', 'content',$view_vars);
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
	$view_vars['slogan_block'] = 'attorneys';

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
	$state_reversed = array('AL'=>'Alabama','AK'=>'Alaska',    'AZ'=>'Arizona',    'AR'=>'Arkansas',    'CA'=>'California',    'CO'=>'Colorado',    'CT'=>'Connecticut',    'DE'=>'Delaware',    'DC'=>'District of Columbia',    'FL'=>'Florida',    'GA'=>'Georgia',    'HI'=>'Hawaii',    'ID'=>'Idaho',    'IL'=>'Illinois',    'IN'=>'Indiana',    'IA'=>'Iowa',    'KS'=>'Kansas',    'KY'=>'Kentucky',    'LA'=>'Louisiana',    'ME'=>'Maine',    'MD'=>'Maryland',    'MA'=>'Massachusetts',    'MI'=>'Michigan',    'MN'=>'Minnesota',    'MS'=>'Mississippi',    'MO'=>'Missouri',    'MT'=>'Montana',     'NV'=>'Nevada',    'NH'=>'New Hampshire',    'NJ'=>'New Jersey',    'NM'=>'New Mexico',    'NY'=>'New York',    'NC'=>'North Carolina',    'ND'=>'North Dakota',    'OH'=>'Ohio',    'OK'=>'Oklahoma',    'OR'=>'Oregon',    'PA'=>'Pennsylvania',    'RI'=>'Rhode Island',    'SC'=>'South Carolina',    'SD'=>'South Dakota',    'TN'=>'Tennessee',    'TX'=>'Texas',    'UT'=>'Utah',    'VT'=>'Vermont',    'VA'=>'Virginia',    'WA'=>'Washington',    'WV'=>'West Virginia',   'WI'=>'Wisconsin',    'WY'=>'Wyoming','ON'=>'Ontario','SK'=>'Saskatchewan','QC'=>'Quebec');
	
	$member = new Model\Member(array(), $app);
	$members = $member->searchByState($state);

	$view_vars['slogan_block'] = 'attorneys';
	$view_vars['state'] = $state_reversed[$state];
	$view_vars['members'] = $members;
	$page_vars = $app['get_pages']($state);
	$view_vars = array_merge($page_vars,$view_vars);
	
	return $app['view']->render('page/find-attorney/state', 'content', $view_vars);

});

// dui laws in your state routes // 
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
// founding members
$app->get('/founding-members', function (Request $request) use ($app) {
	$slug = 'founding-members';
	$page = new Model\Page($doc=array('slug'=>$slug), $app);
	$page = $page->findById('slug');

	$view_vars = array('page'=>$page);
	$view_vars['slogan_block'] = 'attorneys';

	$page_vars = $app['get_pages']($slug);
	
	$member = new Model\Member(array(), $app);
	$members = $member->search('Founding Members',true);

	$view_vars['members'] = $members;
	$view_vars = array_merge($page_vars,$view_vars);
	
	return $app['view']->render('page/founding-members', 'content', $view_vars);
});



////////////////////////
// NON MANAGED ROUTES //
////////////////////////
$app->get('/{slug}', function ($slug, Request $request) use ($app) {
	
	$page_vars = $app['get_pages']($slug);
	$view_vars['slogan_block'] = strtolower($page_vars['page']['section']);
	
	switch ($slug) {
		case 'deans-message':
			$view_vars = array('slogan_block'=>'deansmessage');
			break;
		
		default:
			$view_vars = array();
			break;
	}

	
	$view_vars = array_merge($page_vars,$view_vars);

	return $app['view']->render('page/content', 'content', $view_vars);
});

return $app;