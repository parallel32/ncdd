<?php
///////////////////////////////////
// PAYMENT MANAGEMENT SCREENS /////
///////////////////////////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$imgUnavailable = __DIR__.'/../../../www/admin.ncdd.com/public_html/assets/img/404-250.jpg';
$app->get('/badge/{id}/member', function ($id, Request $request) use ($app, $imgUnavailable) {
	// return the badge
	$member = new Model\Member(array('_id'=>$id),$app);
	$member = $member->findById();
	$badge_path = '';
	if(!empty($member)){
		$badge_path = Model\Member::$membershipBadge[$member['currentMembership']];
	}

	//Model\Member::$boardCertifiedBadge

	if (!file_exists($badge_path)) {
        $img_path = $imgUnavailable;
    }else{
    	$img_path = $badge_path;
    }
	
	$file_contents = file_get_contents($img_path);
	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
		
});
$app->get('/badge/{id}/exec', function ($id, Request $request) use ($app, $imgUnavailable) {
	// return the badge
	$member = new Model\Member(array('_id'=>$id),$app);
	$member = $member->findById();
	$badge_path = '';
	if(!empty($member)){
		$badge_path = Model\Member::$facultyBadge[$member['currentFacultyPosition']];
	}

	//Model\Member::$boardCertifiedBadge

	if (!file_exists($badge_path)) {
        $img_path = $imgUnavailable;
    }else{
    	$img_path = $badge_path;
    }
	
	$file_contents = file_get_contents($img_path);
	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
		
});
$app->get('/badge/{id}/boardcertified', function ($id, Request $request) use ($app, $imgUnavailable) {
	
	// return the badge
	$member = new Model\Member(array('_id'=>$id),$app);
	$member = $member->findById();
	$badge_path = '';
	if(!empty($member) && $member['boardCertified'])
		$badge_path = Model\Member::$boardCertifiedBadge;

	if (!file_exists($badge_path)) {
        $img_path = $imgUnavailable;
    }else{
    	$img_path = $badge_path;
    }
	
	$file_contents = file_get_contents($img_path);
	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
		
});

return $app;