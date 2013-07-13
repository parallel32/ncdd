<?php
///////////////
// UTILITIES //
///////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;
use QueryPath\QueryPath;

$utilities = $app['controllers_factory'];
$utilities->before($mustbeADMIN);

$utilities->get('/getfile', function () use ($app) {
    $domain = new Model\Domain(array('_id'=>'51b495a0fc14f10907000000'),$app);

    $files = $domain->getFilesToProcess(true);
    $file_content = $app['mongo']->getFile($files[0]['_id'],'domain');
    return new Response($file_content,200,array('Content-Type' => 'text/html')); 
});

$utilities->get('/phpinfo', function () use ($app, $checkPermissions) {
    //$checkPermissions(CONSUMER);
    return $app['view']->render('utilities/phpinfo', 'none');
});

$utilities->get('/gdrive', function () use ($app, $checkPermissions) {
    //$checkPermissions(CONSUMER);
    return $app['view']->render('utilities/gdrive', 'none');
});

// view user sessions
$utilities->get('/viewusersessions/{userId}', function ($userId) use ($app, $checkPermissions) {
    //$checkPermissions(CONSUMER);
    if (empty($userId)) {
        $user_id = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$app);
        if(!empty($user_id)) {
            $userId = $user_id->__toString();
        }
    }

    //$query = array('user_id'=>new \MongoId($userId));

    $regex = new MongoRegex('/'.$userId.'/i');
    $query = array('data'=>$regex);
    $sessions = $app['mongo']->find('session', $query, $fields=array(),$slaveOkay=true);

    $query = array('_id'=>new \MongoId($userId));
    $user = $app['mongo']->findOne('user', $query, $fields=array(),$slaveOkay=true);

    return $app['view']->render('utilities/view_user_session',array('sessions'=>$sessions,'user'=>$user));
    
})->value('userId', '');





return $utilities;