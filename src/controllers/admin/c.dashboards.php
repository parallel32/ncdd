<?php
////////////////
// DASHBOARDS //
////////////////

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$common_view_vars = array(
	'active'=>'Dashboard'
	,'headline'=>'Dashboard'
	,'add-link'=>''
);

$app->get('/', function (Request $request) use ($app, $common_view_vars) {
	$user = Model\User::getUserAccessLevelBySession($app);
	$crumbs = array(array('name'=>'Dashboard','href'=>'/'));
	$view_vars = array(
						 'page-plugin'=>'dashboard,datatables,amcharts'
						,'description'=>"Welcome.  Here you'll find aggregated data from your account."
						,'crumbs'=>$crumbs);
	$view_vars = array_merge($common_view_vars, $view_vars);
	switch ($user['accessLevel']) {
		case ADMIN:
			$payment = new Model\Payment(array(),$app);
			$payments = $payment->fetchAllByClass('ApplyNewMember');
			$view_vars['graph']=$payments;
			$view_vars['graph_total']=$payment->countByClass('ApplyNewMember');
			
			$apply = new Model\Apply(array(),$app);
			$view_vars['submitted']=$apply->countByStatus('SUBMITTED',$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
			$view_vars['approved']=$apply->countByStatus('APPROVED',$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
			$view_vars['trial']=$apply->countByStatus('TRIAL',$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
			$view_vars['paid']=$apply->countByDatePaid(90, $filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION'))));
			$view_vars['ncdd2015promocode']=$apply->countByStatus('PAID',$filter=array('promocode'=>'NCDD2015'));
			$view_vars['ncdd2014promocode']=$apply->countByStatus('PAID',$filter=array('promocode'=>'NCDD2014'));
			$date = new Model\Date($app,'9/16/2014 5:00 PM');
			$end2014 =  new Model\Date($app,'12/31/2014 11:59 PM');
			$end2015 =  new Model\Date($app,'12/31/2015 11:59 PM');
			$view_vars['newlypaid2014']=$apply->countByStatus('PAID',$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION')),'promocode'=>array('$nin'=>array('NCDD2015','NCDD2014','TRIAL','DIVTRIAL','PDTRIAL','RFTRIAL')),'paidDate.date'=>array('$gte'=> new \MongoDate(strtotime($date->fullDateTime)), '$lte'=> new \MongoDate(strtotime($end2014->fullDateTime)))));
			$view_vars['newlypaid2015']=$apply->countByStatus('PAID',$filter=array('type'=>array('$in'=>array('NEW MEMBER APPLICATION','NEW SUSTAINING MEMBER APPLICATION')),'promocode'=>array('$nin'=>array('NCDD2015','NCDD2014','TRIAL','DIVTRIAL','PDTRIAL','RFTRIAL')),'paidDate.date'=>array('$gte'=> new \MongoDate(strtotime($end2014->fullDateTime)), '$lte'=> new \MongoDate(strtotime($end2015->fullDateTime)))));
	
			$blog = new Model\Blog(array(),$app);
			$blogs = $blog->countByStatus('REVIEW','no',0,5);
			$view_vars['blogs']=$blogs;

			$page = new Model\Page(array(), $app);
    		$pages = $page->fetchByStatus('PRIVATE',0,5);
			$view_vars['pages']=$pages;

			$order = new Model\Order(array(),$app);
			$new_orders = $order->countByStatus('NEW',0,5);
			$view_vars['newOrders']=$new_orders;

			$member = new Model\Member(array(),$app);
			$view_vars['auto-renew']=$member->searchCount('AutoRenew',true);
			$view_vars['sm']=$member->searchCount('Sustaining Members');
			$view_vars['gm']=$member->searchCount('General Members');
			$view_vars['fm']=$member->searchCount('Founding Members');
			$view_vars['pd']=$member->searchCount('Public Defenders');
			$view_vars['r']=$member->searchCount('Regents');
			$view_vars['f']=$member->searchCount('Fellows');
			$view_vars['sd']=$member->searchCount('State Delegates');
			$view_vars['fa']=$member->searchCount('Faculty');
			$view_vars['bc']=$member->searchCount('Board Certified');
			$view_vars['bcsr']=$member->searchCount('Board Certified Sr');
			$view_vars['fr']=$member->searchCount('Former Regents');

			//changes
			$change = new Model\Change(array(),$app);
			$view_vars['changes']=$change->fetch($offset=0, $limit=10);

			array_push($view_vars['crumbs'],array('name'=>'Admin','href'=>'/'));
			return $app['view']->render('dashboards/admin', 'default', $view_vars);
			break;
		case EDITOR:
			array_push($view_vars['crumbs'],array('name'=>'Client','href'=>'/'));
			return $app['view']->render('dashboards/editor', 'default', $view_vars);
			break;
		case UNPAIDMEMBER:
		case MEMBER:
			$member = new Model\Member(array('_id'=>$user['_id']),$app);
			$member = $member->findById();			
			$view_vars['renewal']=(array_key_exists('renewal',$member)) ? $member['renewal']: array();
			$view_vars['currentMembership']=$member['currentMembership'];
			$view_vars['member']=$member;
			
			$apply = new Model\Apply(array(),$app);
			$applications = $apply->fetchByMember('APPROVED',0,5);

			$view_vars['applications'] = (!empty($member) 
											&& is_array($member) 
											&& array_key_exists('renewal', $member) 
											&& is_array($member['renewal']) 
											&& array_key_exists('payByCheck', $member['renewal']) 
											&& $member['renewal']['payByCheck'] == 'yes') ? $applications: '';

			$blog = new Model\Blog(array(),$app);
			$blogs = $blog->fetchByStatus('PUBLISH','yes',0,5);
			$view_vars['blogs']=$blogs;

			$page = new Model\Page(array(), $app);
    		$pages = $page->fetchByStatus('PRIVATE',0,5);
			$view_vars['pages']=$pages;

			$delegate = new Model\Delegate(array(), $app);
    		$delegate = $delegate->fetchByDelegate($user['_id']);
			$view_vars['delegate']=$delegate;
			
			// determine if the member, who is signed in, has an outstanding balance on an upcoming seminar
			$seminar = new Model\Seminar($doc=array(), $app);
			$seminars = $seminar->find($query=array(),$fields=array(),true,$sort=array('startDate.date'=>1));
			$seminar_deposit_notices = array();
			if(!empty($seminars)){
				foreach ($seminars as $seminar) {
					$registration = new Model\RegistrationSeminar($doc=array(), $app);
					
					$depositbalance = $registration->fetchDepositStatus($seminar['_id'],0, 10000);
					$waitlist = $registration->fetchByStatusSeminar($seminar['_id'],'WAITLIST',0,10000);
					$submitted = $registration->fetchByStatusSeminar($seminar['_id'],'SUBMITTED',0,10000);
					$scholarship = $registration->fetchByStatusSeminar($seminar['_id'],'SCHOLARSHIP',0,10000);
					
					if(!empty($depositbalance) && is_array($depositbalance)){
						foreach ($depositbalance as $record) {
							if($record['memberId'] == $member['_id']){
								$seminar_deposit_notices[(string)$seminar['_id']] = array('seminar'=>$seminar,'registration'=>$record);
							}
						}
					}
					if(!empty($waitlist) && is_array($waitlist)){
						foreach ($waitlist as $record) {
							if($record['memberId'] == $member['_id']){
								$seminar_deposit_notices[(string)$seminar['_id']] = array('seminar'=>$seminar,'registration'=>$record);
							}
						}
					}
					if(!empty($submitted) && is_array($submitted)){
						foreach ($submitted as $record) {
							if($record['memberId'] == $member['_id']){
								$seminar_deposit_notices[(string)$seminar['_id']] = array('seminar'=>$seminar,'registration'=>$record);
							}
						}
					}
					if(!empty($scholarship) && is_array($scholarship)){
						foreach ($scholarship as $record) {
							if($record['memberId'] == $member['_id']){
								$seminar_deposit_notices[(string)$seminar['_id']] = array('seminar'=>$seminar,'registration'=>$record);
							}
						}
					}
				} // endforeach
			}
			
			$view_vars['seminar_deposit_notices'] = $seminar_deposit_notices;

			array_push($view_vars['crumbs'],array('name'=>'Editor','href'=>'/'));

			return $app['view']->render('dashboards/member', 'default', $view_vars);
			break;
	}
})->before($mustbeMEMBER)->after(function (Request $request, Response $response, Silex\Application $app) {
	$user = Model\User::getUserAccessLevelBySession($app);
	if($user['accessLevel'] == ADMIN){
		$rand = rand(1,100);
		if ($rand<=CHANCE_SERVICE){
			try {
				// publish blogs
				error_log('blogs published: '.file_get_contents('http://'.SAW_ADMIN_WEBSITE.'/blog/publish-schedule'));
				// publish forum posts
				error_log('forum topics published: '.file_get_contents('http://'.SAW_ADMIN_WEBSITE.'/topic/publish-schedule'));
				// retry email Q
				error_log('emails sent from the email queue: '.file_get_contents('http://'.SAW_ADMIN_WEBSITE.'/dashboard/emailq'));	
			} catch (Exception $e) {
				// no worries .. will just try again on the next chance.
			}
			
		}
	}
});
// retry email Q
$app->get('/dashboard/emailq', function (Request $request) use ($app) {
	
	$eq = new Model\EmailQ(array(),$app);
	$emails = $eq->fetchAll();
	if(is_array($emails) && count($emails) > 0){
		foreach($emails as $email):
			try {
				// send
				$app['sendMail']($email['subject'], $email['body'], $email['to']);
				// clear the Q
				$b = new Model\EmailQ(array('_id'=>$email['_id']),$app);
				$b->delete();	
			} catch (Exception $e) {
				return "sending emails from Q is failing..";
			}
		endforeach;
		$count = count($emails);
	}else{
		$count = 0;
	}
	return "emails sent from Q: ".$count;
});

return $app;