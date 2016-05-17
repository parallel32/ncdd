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
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Saw\Model;


$app->get('/change/streamcsv', function (Request $request) use ($app) {
    
    $change = new Model\Change(array(),$app);
    $changes = $change->fetch($offset=0, $limit=100000);
    
    $csv = '';  
    if(is_array($changes) && !empty($changes)): 
    foreach ($changes as $row) {
        $formatted_row['who'] = $row['label'];
        $formatted_row['what'] = '';
        foreach ($row['values'] as $key => $value) {
            $formatted_row['what'].='['.$key.']::'.$value.',';
             
        }
        $formatted_row['when'] = $row['date']['fullDateTime'];

        $line = '';
        foreach ($formatted_row as $key => $value) {
            $line.=''.$value.'{}'; 
        }
        $csv.= substr($line, 0, -1).PHP_EOL;
    }
    endif;

    $response = new Response($csv, 200, array('Content-Type' => 'text/csv'));
    $d = $response->headers->makeDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'member-change-log.csv'
    );
    $response->headers->set('Content-Disposition', $d);
    
    return $response;
    //return $app['view']->render('member/search', 'blank', $view_vars);

})->before($mustbeADMIN);


$app->get('/change/streamcsvrawaddressonly', function (Request $request) use ($app) {
    
    $change = new Model\Change(array(),$app);
    $changes = $change->fetchAddressChanges($offset=0, $limit=100000);
    
    $csv = '';  
    if(is_array($changes) && !empty($changes)): 
    foreach ($changes as $row) {
        $formatted_row['a-who'] = $row['label'];
        foreach ($row['values'] as $key => $value) {
            if($key == 'raw'){
                $formatted_row['b-raw'] = $value;
            }
            if($key == 'addressLine1'){
                $formatted_row['c-addressLine1'] = $value;
            }
            if($key == 'addressLine2'){
                $formatted_row['d-addressLine2'] = $value;
            }
            if($key == 'city'){
                $formatted_row['e-city'] = $value;
            }
            if($key == 'state'){
                $formatted_row['f-state'] = $value;
            }
            if($key == 'zip'){
                $formatted_row['g-zip'] = $value;
            }
            
        }
        $formatted_row['h-when'] = $row['date']['fullDateTime'];

        $line = '';
        ksort($formatted_row);
        foreach ($formatted_row as $key => $value) {
            $line.=''.$value.'|'; 
        }
        $csv.= substr($line, 0, -1).PHP_EOL;
    }
    endif;

    $response = new Response($csv, 200, array('Content-Type' => 'text/csv'));
    $d = $response->headers->makeDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'member-change-log.csv'
    );
    $response->headers->set('Content-Disposition', $d);
    
    return $response;
    //return $app['view']->render('member/search', 'blank', $view_vars);

})->before($mustbeADMIN);


$app->get('/change/{offset}/{limit}', function ($offset,$limit, Request $request) use ($app) {
    
    $change = new Model\Change(array(),$app);
    $changes = $change->fetch($offset, $limit);
    $count = (empty($changes)) ? 0 : count($changes);
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