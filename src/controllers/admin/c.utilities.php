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
use Cocur\Slugify\Slugify;

$utilities = $app['controllers_factory'];
$utilities->before($mustbeADMIN);


$utilities->get('/importmembers', function () use ($app) {
    ini_set('memory_limit','1024M');
    $stateMap = array();
    $stateMap['Alabama']='AL';
    $stateMap['Oklahoma']='OK';
    $stateMap['Arizona']='AZ';
    $stateMap['Washington']='WA';
    $stateMap['Texas']='TX';
    $stateMap['Maryland']='MD';
    $stateMap['Georgia']='GA';
    $stateMap['North Carolina']='NC';
    $stateMap['West Virginia']='WV';
    $stateMap['Utah']='UT';
    $stateMap['Colorado']='CO';
    $stateMap['Virginia']='VA';
    $stateMap['Ohio']='OH';
    $stateMap['Florida']='FL';
    $stateMap['California']='CA';
    $stateMap['Nevada']='NV';
    $stateMap['Pennsylvania']='PA';
    $stateMap['Indiana']='IN';
    $stateMap['Tennessee']='TN';
    $stateMap['Massachusetts']='MA';
    $stateMap['Arkansas']='AR';
    $stateMap['New York']='NY';
    $stateMap['Illinois']='IL';
    $stateMap['New Hampshire']='NH';
    $stateMap['Mississippi']='MS';
    $stateMap['Missouri']='MO';
    $stateMap['South Carolina']='SC';
    $stateMap['Minnesota']='MN';
    $stateMap['Michigan']='MI';
    $stateMap['Maine']='ME';
    $stateMap['Idaho']='ID';
    $stateMap['Kansas']='KS';
    $stateMap['South Dakota']='SD';
    $stateMap['Nebraska']='NE';
    $stateMap['Iowa']='IO';
    $stateMap['Montana']='MT';
    $stateMap['New Jersey']='NJ';
    $stateMap['Oregon']='OR';
    $stateMap['Connecticut']='CT';
    $stateMap['Wisconsin']='WI';
    $stateMap['New Mexico']='NM';
    $stateMap['Louisiana']='LA';
    $stateMap['Delaware']='DE';
    $stateMap['Alaska']='AL';
    $stateMap['Wyoming']='WY';
    $stateMap['Washington, D.C.']='DC';
    $stateMap['Rhode Island']='RI';
    $stateMap['Kentucky']='KY';
    $stateMap['Vermont']='VT';
    $stateMap['Ontario']='ON';
    $stateMap['Hawaii']='HI';
    $stateMap['Saskatchewan']='SK';
    $stateMap['North Dakota']='ND';
    $stateMap['Quebec']='QC';
    $stateMap['']='';
    $stateMap['Select a State']='';

    $stateCountryMap = array();
    $stateCountryMap['Ontario'] = 'CA';
    $stateCountryMap['Saskatchewan'] = 'CA';
    $stateCountryMap['Quebec'] = 'CA';

    $countryMap = array();
    $countryMap['United States'] = 'US';
    $countryMap['Canada'] = 'CA';

    // facultyPositon
    $position = array();
    $position[''] = null;
    $position['None'] = null;
    $position['Delegate'] = 20;
    $position['Treasurer'] = 30;
    $position['Secretary'] = 40;
    $position['Assistant Dean'] = 50;
    $position['Dean'] = 70;
    
    $formerRegent['Yes'] = 10;
    $formerRegent['No'] = null;

    $regent['Yes'] = 60;
    $regent['No'] = null;
    
    $fellow['Yes'] = 90;
    $fellow['No'] = null;
    
    $boardCertified['Yes'] = 'yes';
    $boardCertified['No'] = 'no';
    $boardCertified[''] = 'no';

    $membership = array();
    $membership['Founding Member'] = 30;
    $membership['General Member'] = 20;
    $membership['Former Regent'] = Model\Member::$facultyPosition['FORMER REGENT'];
    $membership['Sustaining Member'] = 40;
    


    $fields = array();
    $fields[]='id';
    $fields[]='fname';
    $fields[]='lname';
    $fields[]='practice';
    $fields[]='num';
    $fields[]='num2';
    $fields[]='fax';
    $fields[]='fax2';
    $fields[]='email';
    $fields[]='website';
    $fields[]='addr';
    $fields[]='city';
    $fields[]='state';
    $fields[]='image';
    $fields[]='admin';
    $fields[]='password';
    $fields[]='zip';
    $fields[]='country';
    $fields[]='haslisting';
    $fields[]='yearsinpractice';
    $fields[]='creationdate';
    $fields[]='paiddate';
    $fields[]='membertype';
    $fields[]='ordernum';
    $fields[]='bio';
    $fields[]='position';
    $fields[]='formerRegent';
    $fields[]='regent';
    $fields[]='fellow';
    $fields[]='username';
    $fields[]='boardcertified';
    $fields[]='rfordernumber';
    $fields[]='blogid';
    $fields[]='addr2';
    $fields[]='city2';
    $fields[]='state2';
    $fields[]='zip2';
    $fields[]='country2';

    $row = 1;
    if (($handle = fopen("/var/www/upload/members.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE) {
            $num = count($data);
            //echo "<p> $num fields in line $row: <br /></p>\n";
            $row++;
            for ($c=0; $c < $num; $c++) {
                $output[$row][$fields[$c]] = trim($data[$c]);
                //echo $data[$c] . "<br />\n";
            }
        }
        fclose($handle);
    }
    //echo "<pre>";print_r($output);echo "</pre>";

    //*
    $cnt = 1;
    $total = count($output);
    foreach ($output as $record):
        if($record['fname'] !='Administrator' && $record['fname'] !='Webmaster' && $record['fname'] !='TestT' ):
            $loc_doc['raw'] = $record['addr'].' '.$record['city'].', '.$stateMap[$record['state']].' '.$record['zip'].', '.$countryMap[$record['country']];
            $loc_doc['name'] = $record['practice'];
            $loc_doc['addressLine1'] = $record['addr'];
            $loc_doc['city'] = $record['city'];
            $loc_doc['state'] = $stateMap[$record['state']];
            $loc_doc['zip'] = $record['zip'];
            $loc_doc['country'] = $countryMap[$record['country']];
            $loc_doc['phone'] = $record['num'];
            $loc_doc['fax'] = $record['fax'];

            $location = new Model\Location($loc_doc,$app);

            $member_doc['location'] = $location->__toArray();
            $member_doc['firstName'] = $record['fname'];
            $member_doc['email'] = $record['email'];
            $member_doc['password'] = $record['password'];
            $member_doc['slug'] = Model\Seminar::slugify($record['fname']);
            if(!empty($record['website']))
                $member_doc['websites'] = array(0=>array('website'=>str_replace('http://','',$record['website']),'websiteDesc'=>''));
            $member_doc['listServEmail'] = $record['email'];
            $member_doc['primaryPhone'] = $record['num'];
            $member_doc['primaryFax'] = $record['fax'];
            //if($record['fname'] != 'Joseph S. Passanise' && $record['fname'] != 'Christopher J. Angles')
                $member_doc['aboutMe'] = utf8_encode($record['bio']);
            //else
            //    $member_doc['aboutMe'] = '';
            $member_doc['yearsinpractice'] = $record['yearsinpractice'];
            $member_doc['boardCertified'] = $boardCertified[$record['boardcertified']];

            if($record['membertype'] == 'Former Regent'){
                $member_doc['currentFacultyPosition'] = $membership['Former Regent'];
                error_log('record membertype:'.$record['membertype']. 'currentFP:'.$membership['Former Regent']);
            }else{
                $member_doc['currentMembership'] = $membership[$record['membertype']];    
                error_log('else ... record membertype:'.$record['membertype']. 'currentMembership:'.$member_doc['currentMembership']);
            }
            if($record['regent'] == 'Yes'){
                error_log('RRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR    '.$regent[$record['regent']]);
                $member_doc['currentFacultyPosition'] = $regent[$record['regent']];
            }
        
            if($record['fellow'] == 'Yes'){
                $member_doc['currentFacultyPosition'] = $fellow[$record['fellow']];
                error_log('FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF    '.$fellow[$record['fellow']]);
            }
            
            if($record['position'] != '' && $record['position'] != 'None'){
                $member_doc['currentFacultyPosition'] = $position[$record['position']];
                error_log('PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP    '.$position[$record['position']].' '.$record['position']);
            }
            
            if(array_key_exists('currentFacultyPosition', $member_doc) && $member_doc['currentFacultyPosition'] == 10){
                echo "<pre>";print_r($record);echo "</pre>";
                echo "<pre>";print_r($member_doc);echo "</pre>";
            }
            $member = new Model\Member($member_doc,$app);
            $mem_id = $member->insert();
            $member_arr = $member->findById();

            $location->ownerId = $mem_id;
            $location->member = $member_arr;
            $location->insert();

            if(!empty($record['image'])){


                $img_name = str_replace('lawyerimages/','',$record['image']);
                $img_path = '/var/www/upload/'.$img_name;
                if(file_exists($img_path)){
        //error_log('imag_name:'.$img_name);
        //error_log('img_path:'.$img_path);

                    $image = $app['imageFactory']('member',$mem_id);
                    $image->prepareFile($img_name);

                    // store the file
                    $image->sizes['small']['id'] = (string)$app['mongo']->storeFile($img_path
                                                                ,'image'
                                                                ,$doc=array('belongsTo'=>$image->belongsTo,'size'=>'small'));
                    $image->makeUrls();
                    $modelObj = $image->instantiateParent($app);
                    $modelObj->saveEdit();
                }
            }   
            error_log($cnt.' of '.$total);
            //echo "<pre>";print_r($member_doc);echo "</pre>";
            unset($member_doc);
            unset($loc_doc);
        endif;
        $cnt++;
        
    endforeach;
    //*/
    return new Response('cool',200,array('Content-Type' => 'text/html')); 
});

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