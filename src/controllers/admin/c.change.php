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


$app->get('/change/{offset}/{limit}', function ($offset,$limit, Request $request) use ($app) {
	
	$change = new Model\Change(array(),$app);
	$changes = $change->fetch($offset, $limit);
    $count = count($changes);
    $crumbs = array(array('name'=>'Members','href'=>'/member/search')
                    ,array('name'=>'Change','href'=>'/change')
                    );

    $view_vars = array(
                         'active'=>'Change/index'
                        ,'page-plugin'=>'datatables'
                        ,'headline'=>'Changes'
                        ,'description'=>""
                        ,'crumbs'=>$crumbs
                        ,'changes'=>$changes
                        ,'count'=>$count
                        );
    return $app['view']->render('change/index', 'default', $view_vars);

})->before($mustbeADMIN)->value('offset',0)->value('limit',10000);


return $app;