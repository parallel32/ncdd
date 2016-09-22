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
$profileImgUnavailable = __DIR__.'/../../../www/admin.ncdd.com/public_html/assets/img/404-profile-159.png';
$app->get('/noprofileimage', function (Request $request) use ($app,$profileImgUnavailable) {
    $file_contents = file_get_contents($profileImgUnavailable);
	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
});

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
	else if(!empty($member) && $member['boardCertifiedSr'])
		$badge_path = Model\Member::$boardCertifiedBadgeSr;

	if (!file_exists($badge_path)) {
        $img_path = $imgUnavailable;
    }else{
    	$img_path = $badge_path;
    }
	
	$file_contents = file_get_contents($img_path);
	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
		
});
$app->get('/badge/{id}/staff', function ($id, Request $request) use ($app, $imgUnavailable) {
	
	// return the badge
	$member = new Model\Member(array('_id'=>$id),$app);
	$member = $member->findById();
	$badge_path = '';
	if(!empty($member) && array_key_exists('staff',$member) && $member['staff'])
		$badge_path = Model\Member::$staffBadge;

	if (!file_exists($badge_path)) {
        $img_path = $imgUnavailable;
    }else{
    	$img_path = $badge_path;
    }
	
	$file_contents = file_get_contents($img_path);
	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
		
});
$app->get('/badge/{id}/sciencesCurriculum', function ($id, Request $request) use ($app, $imgUnavailable) {
	
	// return the badge
	$member = new Model\Member(array('_id'=>$id),$app);
	$member = $member->findById();
	$badge_path = '';
	if(!empty($member) && array_key_exists('sciencesCurriculum',$member) && $member['sciencesCurriculum'])
		$badge_path = Model\Member::$sciencesCurriculumBadge;

	if (!file_exists($badge_path)) {
        $img_path = $imgUnavailable;
    }else{
    	$img_path = $badge_path;
    }
	
	$file_contents = file_get_contents($img_path);
	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
		
});
$app->get('/badge/{id}/delegate', function ($id, Request $request) use ($app, $imgUnavailable) {
	$badge_path = '';
	// return the badge
	$member = new Model\Member(array('_id'=>$id),$app);
	$member = $member->findById();
	$delegate = new Model\Delegate(array(), $app);
	$delegate = $delegate->fetchByDelegate($id);
	if(!empty($delegate)){
		$badge_path = Model\Member::$facultyBadge[Model\Member::$facultyPosition['DELEGATE']];
	}

	if (!file_exists($badge_path)) {
        $img_path = $imgUnavailable;
    }else{
    	$img_path = $badge_path;
    }
	
	$file_contents = file_get_contents($img_path);
	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
		
});
$app->get('/member/{id}/{slug}', function ($id, $slug, Request $request) use ($app) {
	
	// return the badge
	$member = new Model\Member(array('_id'=>$id),$app);
	$member = $member->finbById();
	if(!empty($member)){

		$member['image'] = (!empty($member['image'])) ? $member['image']['urls']['small']['SSLCDN'] : '/noprofileimage';
		$member['currentMembership'] = (!empty($member['currentMembership'])) ? Model\Member::$membershipReversed[$member['currentMembership']] : '';
		$member['currentFacultyPosition'] = (!empty($member['currentFacultyPosition'])) ? Model\Member::$facultyPositionReversed[$member['currentFacultyPosition']] : '';
		$member['boardCertified'] = (array_key_exists('boardCertified',$member) && $member['boardCertified']) ? "Yes" : "No";
		$member['boardCertifiedBadge'] = Model\Member::$boardCertifiedBadge;
		$member['boardCertifiedSr'] = (array_key_exists('boardCertifiedSr',$member) && $member['boardCertifiedSr']) ? "Yes" : "No";
		$member['boardCertifiedBadgeSr'] = Model\Member::$boardCertifiedBadgeSr;
		$member['staff'] = ((array_key_exists('staff',$member)) ? $member['staff']: '') ? "Yes" : "No";
		$member['staffBadge'] = Model\Member::$staffBadge;
		$member['sciencesCurriculum'] = ((array_key_exists('sciencesCurriculum',$member)) ? $member['sciencesCurriculum']: '') ? "Yes" : "No";
		$member['sciencesCurriculumBadge'] = Model\Member::$sciencesCurriculumBadge;
		$member['aboutMe'] = (array_key_exists('aboutMe', $member)) ? $app['prepare_content']($member['aboutMe']) : '';

		$location = new Model\Location(array('ownerId'=>$member['_id']),$app);
		$locations = $location->getByOwner();
		$member['locations'] = $locations;
		$member['primary_location'] = $location->getPrimary($member['_id']);

		$view_vars['member'] = $member;
		$page_vars = $app['get_pages']('');
		$view_vars = array_merge($page_vars,$view_vars);

		return $app['view']->render('page/profile', 'content', $view_vars);
	}else{
		return $app->redirect('/find-an-attorney');
	}	
		
});

return $app;