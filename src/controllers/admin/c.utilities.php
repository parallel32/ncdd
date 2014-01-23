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


//////////////////////
// migrate products //
//////////////////////

$utilities->get('/importproducts', function () use ($app) {
    
    ini_set('memory_limit','1024M');
    
    $fields = array();
    $fields[]='name';
    $fields[]='type';
    $fields[]='description';
    $fields[]='price';
    $fields[]='memberprice';
    $fields[]='shipping';

    //*
    $cnt = 1;
    $row = 1;
    if (($handle = fopen("/var/www/upload/prodcuts.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE) {
            $num = count($data);
            //echo "<p> $num fields in line $row: <br /></p>\n";
            $row++;
            for ($c=0; $c < $num; $c++) {
                $output[$row][$fields[$c]] = trim($data[$c]);
                //echo $data[$c] . "<br />\n";
            }
            echo "<pre>";print_r($output[$row]);echo "</pre>";
        }
        fclose($handle);
    }
    //echo "<pre>";print_r($output);echo "</pre>";
    //*

    //*
    // create the topics
    $cnt = 1;
    $total = count($output);
    foreach ($output as $record):
        if(array_key_exists('price',$record) && array_key_exists('name',$record) && array_key_exists('description',$record) && array_key_exists('type',$record) && array_key_exists('memberprice',$record) && array_key_exists('shipping',$record)){
            
            $doc = array();
            $doc['name'] = $record['name'];
            $doc['description'] = (array_key_exists('price',$record)) ? $record['description'] : 0;
            $doc['category'] = $record['type'];
            $doc['price'] = (array_key_exists('price',$record)) ? $record['price'] : 0;
            $doc['memberPrice'] = (array_key_exists('memberprice',$record)) ? $record['memberprice'] : 0;
            $doc['shippingPrice'] = (array_key_exists('shipping',$record)) ? $record['shipping'] : 0;
            $doc['currentStatus'] = Model\Product::$status['PUBLISH'];
            $doc['add'] = 'yes';
            $product = new Model\Product($doc,$app);
            $product->saveEdit();
            $cnt++;        
        }
        
    endforeach;
    //*/
    return new Response('cool: '.$cnt.' products created',200,array('Content-Type' => 'text/html')); 
});


/////////////////////////
// migrate forum posts // 
/////////////////////////
$utilities->get('/importforumssdfsdfsdfsdfds', function () use ($app) {
    return 'disabled';
    ini_set('memory_limit','1024M');
    
    $author_map = array();
    $author_map['BarrySimons'] = '5208d6159afe0b53323e9032';
    $author_map['simons'] = '5208d6159afe0b53323e9032';
    $author_map['pmcglone'] = '5208d6409afe0b53323e9333';
    $author_map['admin'] = '';
    $author_map['wkirk'] = '5208d5ee9afe0b53323e8d7d';
    $author_map['DRamsell'] = '5208d5fc9afe0b53323e8e76';
    $author_map['lstamm'] = '5208d6119afe0b53323e8fef';
    $author_map['KStewart'] = '5208d5be9afe0b53323e8a22';
    $author_map['pquinn'] = '5208d64f9afe0b53323e9441';
    $author_map['Tiftickjian'] = '5208d6539afe0b53323e9484';
    $author_map['justinthemcshanelawfirmc'] = '5208d5c29afe0b53323e8a6e';
    $author_map['mjnichols'] = '5208d6309afe0b53323e921c';
    $author_map['cowan'] = '5208d6149afe0b53323e9026';
    $author_map['KRiffel'] = '5208d6149afe0b53323e901d';
    $author_map['apalacios'] = '5208d66a9afe0b53323e9618';
    $author_map['pbarone'] = '5208d6019afe0b53323e8ed5';
    $author_map['CJohnson'] = '5208d5e79afe0b53323e8d04';
    $author_map['SCurtis'] = '5208d61a9afe0b53323e9097';
    $author_map['TVosk'] = '5208d61a9afe0b53323e9097';
    $author_map['JFox'] = '5208d6039afe0b53323e8efc';
    $author_map['jrichey'] = '';
    $author_map['mhawkm'] = '5208d6109afe0b53323e8fda';
    $author_map['JRuane'] = '5208d5dc9afe0b53323e8c3e';
    $author_map['rlapier'] = '5208d67b9afe0b53323e9738';
    $author_map['JMeadows'] = '5208d5e79afe0b53323e8d00';
    $author_map['MFoster'] = '5208d60c9afe0b53323e8f90';
    $author_map['garywilson'] = '5208d5f59afe0b53323e8dfb';
    $author_map['jsemenoff'] = '5208d66a9afe0b53323e9621';
    $author_map['McShane'] = '5208d5c29afe0b53323e8a6e';
    $author_map['jhilliard'] = '5208d65f9afe0b53323e955d';
    $author_map['VLandry'] = '5208d5d89afe0b53323e8c00';
    $author_map['jcosta'] = '5208d5d99afe0b53323e8c15';
    $author_map['jvalentine'] = '5208d6719afe0b53323e968e';

    $forums = array();
    $forums['Don Ramsell'] = '5208d5fc9afe0b53323e8e76';
    $forums['Cleve Johnsons Persuasion is Key'] = '5208d5e79afe0b53323e8d04';
    $forums['BAC Datamaster'] = '';
    $forums['Don Ramsells Appeal of the Day'] = '5208d5fc9afe0b53323e8e76';
    $forums['DUI Seminars and Training'] = '';
    $forums['ECIR II'] = '';
    $forums['Source Code Litigation'] = '';
    $forums['Interstate Drivers License Issues'] = '';
    $forums['Alcosenor V'] = '';
    $forums['Confrontation and the 6th Amendment'] = '';
    $forums['Uncertainty and Metrology'] = '';
    $forums['Closers Club'] = '';
    $forums['Gas ChromatographyMassSpectrometry GC MS'] = '';
    $forums['State Delegate Forum'] = '';
    $forums['Ethics'] = '';
    $forums['Checkpoints and Roadblocks'] = '';
    $forums['DRE  Drug Recognition Expert'] = '';
    $forums['Blood Collection and Storage'] = '';
    $forums['Alcohol Absorption  Elimination'] = '';
    $forums['PowerPoint Library Trial'] = '';
    $forums['PowerPoint Library Presentation'] = '';
    $forums['Field Sobriety Testing'] = '';
    $forums['Trial Skills and Techniques'] = '';
    $forums['Breath Testing General'] = '';
    $forums['Boating Under the Influence'] = '';
    $forums['Intoxilyzer'] = '';
    $forums['The McShane Blog'] = '5208d5c29afe0b53323e8a6e';
    
    $fields = array();
    $fields[]='section_title';
    $fields[]='post_author';
    $fields[]='thread_title';
    $fields[]='post_body';

    //*
    // create the fourums
    foreach ($forums as $forum_title => $owner) {
        
        if(!empty($owner)){
            $owner = new Model\Member(array('_id'=>$owner),$app);
            $owner->findById();
        }else{
            $owner = array();
        }

        $forum_doc = array('add'=>'yes','name'=>$forum_title,'currentStatus'=>Model\Forum::$status['PUBLISH']);
        $forum = new Model\Forum($forum_doc, $app, $owner);
        $forum_id = $forum->saveEdit();

        $forum_map[$forum_title] = (string)$forum_id;
    }
    
    
    $cnt = 1;
    $row = 1;
    if (($handle = fopen("/var/www/upload/forum-posts.csv", "r")) !== FALSE) {
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

    //*
    // create the topics
    $cnt = 1;
    $total = count($output);
    foreach ($output as $record):
        
        if(array_key_exists($record['section_title'],$forum_map)){
            $topic_doc = array();
            $topic_doc['headline'] = $record['thread_title'];
            $topic_doc['body'] = $record['post_body'];
            $topic_doc['currentStatus'] = Model\Topic::$status['PUBLISH'];
            $forum = new Model\Forum(array('_id'=>$forum_map[$record['section_title']]),$app);
            $forum->findById();
            $topic_doc['forum'] = $forum->_id;
            $topic_doc['add'] = 'yes';
            $topic_doc['published'] = 'yes';
            $topic_doc['publishDate'] = new Model\Date($app,'now');
            $topic_doc['reviewDate'] = new Model\Date($app,'now');
            $topic_doc['draftDate'] = new Model\Date($app,'now');

            if(!empty($author_map[$record['post_author']])){
                $author = new Model\Member(array('_id'=>$author_map[$record['post_author']]),$app);
                $author->findById();
            }else{
                $author = array();
            }

            $topic = new Model\Topic($topic_doc,$app,$author);
            $topic->saveEdit();

            $cnt++;
        }
    endforeach;
    //*/
    return new Response('cool: '.$cnt.' topics created',200,array('Content-Type' => 'text/html')); 
});

//////////////////////////////////////////////
// MIGRATE FROM MEMBER.LOCATION TO LOCATION //
//////////////////////////////////////////////
/*

in order to run this script this must be done:

1. db.location.remove();
2. run this script
3. db.member.update({},{$unset:{location:1}},{multi:true});
*/
$utilities->get('/migrate-locationssdfafadfsadfasdfasdfaf', function () use ($app) {
    return 'disabled';
    ini_set('memory_limit','1024M');

    $l_member = new Model\Member(array(),$app);
    $location = new Model\Location(array(),$app);

    $members = $l_member->find(array(),array('location'=>true),true,array(),0,3000);
    //echo " <pre>members";print_r($members);echo "</pre>";
    //*
    $i=0;
    foreach ($members as $_member) {
        
        $member_obj = new Model\Member(array('_id'=>$_member['_id']),$app);
        $_member['location']['member'] = $member_obj->findById();
        //echo "<pre>";print_r($_member['location']['member']['listed']);echo "<pre>";
        $_member['location']['ownerId'] = $_member['_id'];


        $new_location = new Model\Location($_member['location'],$app);
        $new_location->insert();
            $temp = $new_location->__toArray();
            if(!empty($temp['point'])){
                echo "<pre>";print_r($temp['point']);echo "<pre>";    
                echo "force to float: ".(float)$temp['point'][0].' id:'.$temp['ownerId'];
            }
            
        $i++;
        error_log(count($members).' - '.$i);
    }
    //*/

    return new Response('cool',200,array('Content-Type' => 'text/html')); 
});


$utilities->get('/importmembersxcvxcvxcvxsdfse', function () use ($app) {
    return 'disabled';
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
    $position['Treasurer'] = 40;
    $position['Secretary'] = 50;
    $position['Assistant Dean'] = 60;
    $position['Dean'] = 80;
    
    $formerRegent['Yes'] = 10;
    $formerRegent['No'] = null;

    $regent['Yes'] = 30;
    $regent['No'] = null;
    
    $fellow['Yes'] = 90;
    $fellow['No'] = null;
    
    $boardCertified['Yes'] = 'yes';
    $boardCertified['No'] = 'no';
    $boardCertified[''] = 'no';

    $membership = array();
    $membership['Founding Member'] = 40;
    $membership['General Member'] = 10;
    $membership['Former Regent'] = Model\Member::$facultyPosition['FORMER REGENT'];
    $membership['Sustaining Member'] = 30;
    


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

            $member_doc['orderNum'] = trim($record['ordernum'])+0;

            $member_doc['listed'] = strtolower($record['haslisting']);
            if($record['creationdate'] != '0000-00-00 00:00:00')
                $member_doc['joinDate'] = new Model\Date($app, $record['creationdate']);

            $member_doc['location'] = $location->__toArray();
            $member_doc['firstName'] = str_replace("\\", "", $record['fname']);
            $member_doc['email'] = $record['email'];
            $member_doc['password'] = $record['password'];
            $member_doc['slug'] = Model\Seminar::slugify($record['fname']);
            if(!empty($record['website']))
                $member_doc['websites'] = array(0=>array('website'=>str_replace('http://','',$record['website']),'websiteDesc'=>''));
            $member_doc['listServEmail'] = $record['email'];
            $member_doc['primaryPhone'] = $record['num'];
            $member_doc['primaryFax'] = $record['fax'];
            //if($record['fname'] != 'Joseph S. Passanise' && $record['fname'] != 'Christopher J. Angles')
                //*
                try {
                    $encoding = mb_detect_encoding($record['bio']);
                    error_log('encoding: '.$encoding);
                    if(empty($encoding)){
                        throw new \Exception();
                    }
                    $member_doc['aboutMe'] = html_entity_decode(str_replace("\\", "", $record['bio']));
                } catch (Exception $e) {
                    error_log('encoding off EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE ---- ----- ----- ----- '.$member_doc['firstName']);
                    $member_doc['aboutMe'] = utf8_encode(html_entity_decode(str_replace("\\", "" ,$record['bio'])));    

                }
                $member_doc['aboutMe'] = str_replace("</p>", "</p><br>", $member_doc['aboutMe']);
                //*/
            //else
            //    $member_doc['aboutMe'] = '';
            $member_doc['yearsinpractice'] = $record['yearsinpractice'];
            $member_doc['boardCertified'] = $boardCertified[$record['boardcertified']];

            if($record['membertype'] == 'Former Regent'){
                $member_doc['currentFacultyPosition'] = $membership['Former Regent'];
                error_log('FFFFFFFFFFFFFFFFFFFFF ---- RRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR    '.$record['membertype']);
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