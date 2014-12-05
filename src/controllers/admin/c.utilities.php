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
use TTools\App;

$utilities = $app['controllers_factory'];
$utilities->before($mustbeADMIN);

////////////////////////////////////////////////////
// move the payment records to the member objects //
////////////////////////////////////////////////////
$utilities->get('/memberpayment', function () use ($app) {
    $cnt = 0;
    $cntp = 0;
    $mems = '';
    $payment = new Model\Payment(array(),$app);
    $payments = $payment->find($query=array(),$fields=array(),$slaveOkay=true,$sort=array(),$offset=0,$limit=1000000);
    foreach ($payments as $record){
        echo '<pre>';print_r($record);echo '</pre>';
        $paymentlite = new Model\PaymentLite($record,$app);
        if(strlen($record['number']) > 9 && strpos($record['number'], '.x') !== false){
            $cnt++;
            $member = new Model\Member(array('email'=>$record['email']),$app);
            $memberarr = $member->findById('email');
            if(!empty($memberarr) && is_array($memberarr)){
                $mems.=$memberarr['displayName'].'<br>'; 
                $member = new Model\Member(array('_id'=>$memberarr['_id'],'payment'=>$paymentlite),$app);
                $member->saveSafe();
            }else{
                echo '<pre>';print_r($record['name'].' = '.$record['email'].' = '.$record['number']);echo '</pre>';
                echo '<pre>';print_r($paymentlite);echo '</pre>';
                $cntp++;
            }
        }
    }
    echo "cnt:".$cnt;
    echo "cntp:".$cntp;
    echo "<br><br>";
    echo "auto-matched and saved payment info to member record:<br><br>".$mems;
    return new Response('',200,array('Content-Type' => 'text/html')); 
    
});
/////////////////////////////
// TTools Twitter api test //
// reference: http://ttools.readthedocs.org/en/latest/example_silex.html
/////////////////////////////
$utilities->get('/ttools', function () use ($app) {
    return false;
    // configuration keys for the ncdd test app on @pricepost
    $config = array(
        'consumer_key'        => TWITTER_CONSUMER_KEY,
        'consumer_secret'     => TWITTER_CONSUMER_SECRET,
        'access_token'        => TWITTER_ACCESS_TOKEN,
        'access_token_secret' => TWITTER_ACCESS_TOKEN_SECRET,
    );

    $tapp = new \TTools\App($config);
    echo '<pre>';print_r($tapp->update('Office Policies Legal?Office Policies Legal?Office Policies Legal?Office Policies Legal?Office Policies Legal?Office Policies Legal?Office Policies Legal?Office Policies Legal?Office Policies Legal?Office Policies Legal?Office Policies Legal?Office Policies Legal?Office Policies Legal?Office Policies Legal? https://ncdd.com/blog/527aa72ea6ec613578e680b4/are-prosecutor-s-office-policies-legal'));echo '</pre>';
        

    //array('extra_info' => '123456','file_contents'=>'@'.$file_name_with_full_path.';type=image/jpeg;filename=a-differnent-name.jpeg');
    //$tapp->update('This is my awesome tweet update');    
    //$tapp->updateWithMedia('/var/www/ncdd/www/ncdd.com/public_html/assets/img/logo.png','our new logo')

    return new Response('',200,array('Content-Type' => 'text/html')); 
    
});
///////////////////////////////////////////////
// joinDate update via membertemp collection //
///////////////////////////////////////////////
$utilities->get('/joindatememberupdate', function () use ($app) {
    return false;
    $membertemp = new Model\MemberTemp(array(),$app);
    $mts = $membertemp->find($query=array(),$fields=array('joinDate.feed'=>1,'memberId'=>1,'_id'=>1),$slaveOkay=true,$sort=array(),$offset=0,$limit=1000000);
    //*
    $count = 0;
    foreach($mts as $mt):
        if(!empty($mt['memberId'])){
            $member = new Model\Member(array('_id'=>$mt['memberId'],'joinDate'=>$mt['joinDate']['feed']),$app);
            $member->saveEdit();
            $count++;
        }
    endforeach;
    //*/
    
    // now fix all members' joinDate in the location collection
    $member = new Model\Member(array(),$app);
    $ms = $member->find($query=array(),$fields=array('joinDate.feed'=>1,'_id'=>1),$slaveOkay=true,$sort=array(),$offset=0,$limit=1000000);
    //*
    $count2 = 0;
    foreach($ms as $m):
        if(!empty($m['_id'])){
            $member = new Model\Member(array('_id'=>$m['_id'],'joinDate'=>$m['joinDate']['feed']),$app);
            $member->saveEdit();
            $count2++;
        }
    endforeach;
    


    return new Response('count - '.$count.' count2 - '.$count2,200,array('Content-Type' => 'text/html')); 
    
});

/////////////////////////////////
// joinDate member matchup //
/////////////////////////////////
$utilities->get('/joindatemembermatch', function () use ($app) {
    return false;
    $membertemp = new Model\MemberTemp(array(),$app);
    $member     = new Model\Member(array(),$app);
    $mts = $membertemp->find($query=array(),$fields=array('firstName'=>1,'lastName'=>1,'state'=>1,'_id'),$slaveOkay=true,$sort=array(),$offset=0,$limit=1000000);

    $notfound  = 0;
    $found_a  = 0;
    $found_b  = 0;
    $notfound_table=" <table>";
    $found_table=" <table>";
    $duplicates_table=" <table>";
    $found_records = array();
    foreach ($mts as $mt) {
        $found  = false;
        $name   = $mt['firstName'].' '.$mt['lastName'];
        $state  = $mt['state'];

        $mem_a = $member->find(array('firstName'=>$mt['firstName'],'lastName'=>$mt['lastName']),array('firstName'=>1,'lastName'=>1,'displayName'=>1,'state'=>1,'_id'=>1));
        $mem_b = $member->find(array('displayName'=>$name),array('firstName'=>1,'lastName'=>1,'displayName'=>1,'_id'=>1,'state'=>1));
        
        if(!empty($mem_a)){
            //echo "<pre>mem_a";print_r($mem_a);echo "</pre>";
            $found = true;
            $found_a++;
            $found_table.="<tr><td>{A} ".count($mem_a)." ".$mem_a[0]['firstName']."</td> <td>".$mem_a[0]['lastName']."</td> <td>".$mem_a[0]['displayName']."</td> <td>".$mem_a[0]['_id']."</td>  ";
            if(count($mem_a) > 1){
                $duplicates_table.="<tr><td>{A} MT ".$mt['firstName']."</td> <td>".$mt['lastName']."</td> <td>".$name."</td> <td>".$mt['state']."</td> <td>".$mt['_id']."</td>  ";
                $duplicates_table.='<tr><td colspan=5>db.membertemp.update({_id:ObjectId("'.$mt['_id'].'")}{$set:{memberId:ObjectId("")}})</td>  ';
                $duplicates_table.="<tr><td>{A} M ".$mem_a[0]['firstName']."</td> <td>".$mem_a[0]['lastName']."</td> <td>".$mem_a[0]['displayName']."</td> <td>".$mem_a[0]['_id']."</td>  ";
                $duplicates_table.="<tr><td>{A} M ".$mem_a[1]['firstName']."</td> <td>".$mem_a[1]['lastName']."</td> <td>".$mem_a[1]['displayName']."</td> <td>".$mem_a[1]['_id']."</td>  ";
            }elseif(count($mem_a) == 1){
                $mt['memberId'] = $mem_a[0]['_id'];
                $found_record = $mt;    
            }
            
        }
        if(!empty($mem_b) && $found == false){
            //echo "<pre>mem_b";print_r($mem_b);echo "</pre>";
            $found = true;
            $found_b++;
            $found_table.="<tr><td>{B} ".count($mem_b)." ".$mem_b[0]['firstName']."</td> <td>".$mem_b[0]['lastName']."</td> <td>".$mem_b[0]['displayName']."</td> <td>".$state."</td> <td>".$mem_b[0]['_id']."</td>  ";
            if(count($mem_b) > 1){
                $duplicates_table.="<tr><td>{A} MT ".$mt['firstName']."</td> <td>".$mt['lastName']."</td> <td>".$mt['displayName']."</td> <td>".$mt['state']."</td> <td>".$mt['_id']."</td>  ";
                $duplicates_table.="<tr><td>{B} M ".$mem_b[0]['firstName']."</td> <td>".$mem_b[0]['lastName']."</td> <td>".$mem_b[0]['displayName']."</td> <td>".$mem_b[0]['_id']."</td>  ";
                $duplicates_table.="<tr><td>{B} M ".$mem_b[1]['firstName']."</td> <td>".$mem_b[1]['lastName']."</td> <td>".$mem_b[1]['displayName']."</td> <td>".$mem_b[1]['_id']."</td>  ";
            }elseif(count($mem_b) == 1){
                $mt['memberId'] = $mem_b[0]['_id'];
                $found_record = $mt;    
            }
        }
        
        if(!$found){
            //echo "<pre>Not Found:";print_r($mt);echo "</pre>";
            $notfound_table.="<tr><td>".$mt['firstName']."</td> <td>".$mt['lastName']."</td> <td>".$mt['state']."</td> <td>".'db.membertemp.update({_id:ObjectId("'.$mt['_id'].'")},{$set:{memberId:ObjectId("")}})</td>  ';
            $notfound++;
        }
        /*
        if($found && $found_record){
            $memtemp = new Model\MemberTemp($found_record,$app);
            $memtemp->saveSafe();    
        }
        //*/

    }
    $notfound_table.="</table>";
    $found_table.="</table>";
    $duplicates_table.="</table>";

    echo " <table>";
    echo "<tr><td>notfound:".$notfound."</td></tr>";
    echo "<tr><td>".$found_a."</td></tr>";
    echo "<tr><td>".$found_b."</td></tr>";
    echo "</table>";
    echo "<h2>Duplicates</h2>";
    echo $duplicates_table;
    echo "<h2>Not Found (mt records)</h2>";
    echo $notfound_table;
    echo "<h2>Found</h2>";
    echo $found_table;

    
    return new Response('',200,array('Content-Type' => 'text/html')); 
    
});

/////////////////////////////////
// joinDate member import //
/////////////////////////////////
// query to get members based on join date range
// var cutoffdate = new Date(2013, 1, 1);
// db.member.find({'joinDate.date': {$lt: cutoffdate}}).count();
$utilities->get('/joindatememberimport', function () use ($app) {
    return false;
    ini_set('memory_limit','1024M');
    
    $fields = array();
    $fields[]='ignore';
    $fields[]='firstName';
    $fields[]='lastName';
    $fields[]='state';
    $fields[]='joinDate';
    
    //*
    $cnt = 1;
    $row = 1;
    if (($handle = fopen("/var/www/upload/member-joindate-import.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE) {
            $num = count($data);
            //echo "<p> $num fields in line $row: <br /></p>\n";
            $row++;
            for ($c=0; $c < $num; $c++) {
                $output[$row][$fields[$c]] = trim($data[$c]);
                //echo $data[$c] . "<br />\n";
            }
            //echo "<pre>";print_r($output[$row]);echo "</pre>";
        }
        fclose($handle);
    }
    //echo "<pre>";print_r($output);echo "</pre>";
    //*

    //*
    // create the temporary member records
    // first remove all records
    Model\MemberTemp::purge($app);
    $cnt = 1;
    $total = count($output);
    foreach ($output as $record):
        unset($record['ignore']);
        $record['joinDate'] = new Model\Date($app, $record['joinDate']);
        $member = new Model\MemberTemp($record,$app);
        $member->insert();
        $cnt++;        
    endforeach;
    //*/
    return new Response('cool: '.$cnt.' members inserted',200,array('Content-Type' => 'text/html')); 
});

////////////////////////////////////
// import member name corrections //
///////////////////////////////////

$utilities->get('/importmembernamefix', function () use ($app) {
    return 'disabled';
    ini_set('memory_limit','1024M');
    
    $fields = array();
    $fields[]='lastName';
    $fields[]='firstName';
    $fields[]='middleName';
    $fields[]='_id';
    
    //*
    $cnt = 1;
    $row = 1;
    if (($handle = fopen("/var/www/upload/member-export-name-fix.csv", "r")) !== FALSE) {
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
        if(array_key_exists('lastName',$record) && array_key_exists('firstName',$record) && array_key_exists('middleName',$record) && array_key_exists('_id',$record) && $record['_id'] != '_id'){
            
            $doc = array();
            $doc['lastName'] = $record['lastName'];
            $doc['firstName'] = $record['firstName'];
            $doc['middleName'] = $record['middleName'];
            $doc['_id'] = trim($record['_id']);
            $member = new Model\Member($doc,$app);
            $member->saveEdit();
            $cnt++;        
        }
        
    endforeach;
    //*/
    return new Response('cool: '.$cnt.' members updated',200,array('Content-Type' => 'text/html')); 
});



////////////////////
// wizzywig tests //
////////////////////
$utilities->get('/tinymce/{id}', function ($id) use ($app) {
    $view_vars = array(
                     'active'=>''
                    ,'page-plugin'=>''
                    ,'headline'=>'TinyMCE'
                    ,'description'=>"TinyMCE wizzy testing"
                    ,'crumbs'=>array()
                    ,'_id'=>$id
                    );

    ////////////////////////////////////////////////
    // PREPARE ACCESS TOKEN AND DRIVE CREDENTIALS //
    ////////////////////////////////////////////////
    try {
            
    $client = new Google_Client();
    $client->setApplicationName(GOOGLE_DRIVE_APPLICATION_NAME);
    
    $key = file_get_contents(GOOGLE_DRIVE_KEY_FILE_LOCATION);

    $cred = new Google_Auth_AssertionCredentials(
        GOOGLE_DRIVE_SERVICE_ACCOUNT_NAME,
        array(GOOGLE_DRIVE_API_SCOPE),
        $key
    );
    $cred->sub = GOOGLE_DRIVE_PRN;
    $cred->prn = GOOGLE_DRIVE_PRN;
    $client->setAssertionCredentials($cred);

    $session_service_token = $app['session']->get('service_token');
    if (isset($session_service_token)) {
        $client->setAccessToken($session_service_token);
        if($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
            $app['session']->set('service_token',$client->getAccessToken());
        }
    }else{
        $session_service_token = $client->getAccessToken();
        if(empty($session_service_token)){
            $client->getAuth()->refreshTokenWithAssertion($cred);
            $session_service_token = $client->getAccessToken();
            $app['session']->set('service_token',$session_service_token);
        }
        $app['session']->set('service_token',$session_service_token);
    }
    
    $access_token = json_decode($session_service_token);
    $access_token = $access_token->access_token;

    $picker_view_vars = array(
                         'access_token'=>$access_token
                        ,'client_id'=>GOOGLE_DRIVE_CLIENT_ID
                        );

    $view_vars = array_merge($view_vars,$picker_view_vars);
    } catch (Exception $e) {
      // do nothing so the page can keep loading the fall back is to not allow the 
      // vfl button on the editor to appear  
    }
    ////////////////////////////////////////////////
    // PREPARE ACCESS TOKEN AND DRIVE CREDENTIALS //
    ////////////////////////////////////////////////

   return $app['view']->render('utilities/tinymce', 'default',$view_vars);
});
$utilities->get('/redactor', function () use ($app) {
      $view_vars = array(
                         'active'=>''
                        ,'page-plugin'=>''
                        ,'headline'=>'Redactor'
                        ,'description'=>"Redactor wizzy testing"
                        ,'crumbs'=>array()
                        );
   return $app['view']->render('utilities/redactor', 'default',$view_vars);
});


///////////////////////////
// google drive api test //
///////////////////////////
$utilities->get('/g-drive', function () use ($app) {
    /*
    $client = new Google_Client();
    $client->setApplicationName("Google Search API Project");
    $client->setDeveloperKey("AIzaSyDSPPIQdSKTwwVnzINjbaEFVK422DRxfnM"); // API Key
    $service = new Google_Service_Drive($client);
    $optParams = array('q' => 'gymnastics');
    $results = $service->files->listFiles($optParams);
    echo "<pre>";print_r($results);echo "</pre>";
    foreach ($results as $item) {
    //echo $item['volumeInfo']['title'], "<br /> \n";
    }
    //*/


    /************************************************
      ATTENTION: Fill in these values! You can get
      them by creating a new Service Account in the
      API console. Be sure to store the key file
      somewhere you can get to it - though in real
      operations you'd want to make sure it wasn't
      accessible from the webserver!
      The name is the email address value provided
      as part of the service account (not your
      address!)
      Make sure the Books API is enabled on this
      account as well, or the call will fail.
     ************************************************/
    $client_id = '947790988235-s2hrf1br8m3ug2gpohu744crltruqcmc.apps.googleusercontent.com';
    $service_account_name = '947790988235-s2hrf1br8m3ug2gpohu744crltruqcmc@developer.gserviceaccount.com';
    $key_file_location = '/var/www/ncdd/config/78c3d71f31e8d1d74bc713ee11e09bfa92978288-privatekey-kinollc-Drive-Porject.p12';

//    echo pageHeader("Service Account Access");
    /*if ($client_id == '969032818706-of08353gcintafrkaq5i33maghh342v8.apps.googleusercontent.com'
        || !strlen($service_account_name)
        || !strlen($key_file_location)) {
      echo 'missingServiceAccountDetailsWarning';//echo missingServiceAccountDetailsWarning();
    }*/

    if(false):
        unset($_SESSION['service_token']);
        return 'disabled';
    endif;

    $client = new Google_Client();
    $client->setApplicationName("Drive Project");
    

    /************************************************
      If we have an access token, we can carry on.
      Otherwise, we'll get one with the help of an
      assertion credential. In other examples the list
      of scopes was managed by the Client, but here
      we have to list them manually. We also supply
      the service account
     ************************************************/
    if (isset($_SESSION['service_token'])) {
      $client->setAccessToken($_SESSION['service_token']);
    }
    $key = file_get_contents($key_file_location);

    $cred = new Google_Auth_AssertionCredentials(
        $service_account_name,
        array('https://www.googleapis.com/auth/drive'),
        $key
    );
    $cred->sub = 'mike@kinollc.com';
    $cred->prn = 'mike@kinollc.com';

    $client->setAssertionCredentials($cred);
    if($client->getAuth()->isAccessTokenExpired()) {
      $client->getAuth()->refreshTokenWithAssertion($cred);
    }
    $token = $client->getAccessToken();
    error_log('token:'.print_r($token,true));
    $_SESSION['service_token'] = $token;
    $access_token = json_decode($token);
    $access_token = $access_token->access_token;

    echo "service token is set:";echo $_SESSION['service_token'];echo "<br>";
    /************************************************
      We're just going to make the same call as in the
      simple query as an example.
     ************************************************/
    $service = new Google_Service_Drive($client);
    $parameters = array('q' => "fullText contains 'Hairetis Bos'"
                      ,'fields' =>"items/originalFilename"
                      ,'maxResults' =>"100"
    );
    //$files = $service->files->listFiles($parameters);

    //echo "<pre>";print_r($files);echo "</pre>";
    /*
    $result = array();
      $pageToken = NULL;

      do {
        try {
          //$parameters = array();
          if ($pageToken) {
            $parameters['pageToken'] = $pageToken;
          }
          $files = $service->files->listFiles($parameters);
    
          $result = array_merge($result, $files->getItems());
          $pageToken = $files->getNextPageToken();
        } catch (Exception $e) {
          print "An error occurred: " . $e->getMessage();
          $pageToken = NULL;
        }
      } while ($pageToken);
      //*/

      $view_vars = array(
                         'active'=>'Members/search'
                        ,'page-plugin'=>'datatables'
                        ,'headline'=>'Members Search'
                        ,'description'=>"Search for all members here."
                        ,'crumbs'=>array()
                        ,'access_token'=>$access_token
                        ,'client_id'=>$client_id
                        );


   return $app['view']->render('utilities/g-drive', 'default',$view_vars);
});






//////////////////////////////////////////
// update blogs with new db driven tags //
//////////////////////////////////////////

$utilities->get('/update-blogssdfsdfsdfsdf', function () use ($app) {
    return 'disabled';
    // FIRST CREATE THE CATEGORIES
    $cat_cnt=0;
    if(true):
        $oldtags = array('Breath Testing', 'Blood Testing', 'Boating Under the Influence','FAA Issues','Public Policy','Interstate Compact', 'Field Sobriety Tests', 'Drug Dui (DRE)', 'Constitutional Issues', 'Forensic Science', 'Evidence', 'Ethics', 'Recent Case Law');
        foreach ($oldtags as $oldtag):
            $doc = array(
                'currentType'=>Model\Category::$type['BLOG']
                ,'name'=>$oldtag
                ,'slug'=>'/'.Model\Category::slugify($oldtag)
            );
        
            $category = new Model\Category($doc,$app);
            $category->insert();
            
            $cat_cnt++;
        endforeach;
    endif;    
    // SECOND UPDATE THE BLOGS
    $blog = new Model\Blog(array(),$app);
    $blogs = $blog->find();
    $blog_cnt = 0;
    $availableTags = Model\Blog::getAvailableTags($app);
    foreach ($blogs as $blog):
        $new_blog_tags = array();
        if(is_string($blog['tags'])){
            foreach ($availableTags as $id => $tag):
                $blog_tags_arr = explode(',', $blog['tags']);
                if(is_string($blog_tags_arr)){
                    $blog_tags_arr = array($blog_tags_arr);
                }
                
                for ($i=0; $i < count($blog_tags_arr); $i++) { 
                    if(strpos($blog_tags_arr[$i],$tag['name']) !== false){
                        //error_log('blog:'.$blog['headline'].'  '.$id.' name:'.$name);
                        $catObj = new Model\Category(array('_id'=>$id),$app);
                        $catObj->findById();

                        $new_blog_tags[] = $catObj;
                    }
                }
            endforeach;
            
            $blogObj = new Model\Blog(array('_id'=>$blog['_id'],'tags'=>$new_blog_tags),$app);
            //echo "<pre>";print_r($blogObj->__toArray(false));echo "</pre>";
            $blogObj->saveSafe();

            $blog_cnt++;
        }
    endforeach;



    return new Response('categories made: '.$cat_cnt.' blogs updated: '.$blog_cnt,200,array('Content-Type' => 'text/html')); 
});
//////////////////////
// migrate products //
//////////////////////

$utilities->get('/importproductsssdfsdfsdf', function () use ($app) {
    return 'disabled';
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
//////////////////////////////////////
// import forum post attached files // 
//////////////////////////////////////
$utilities->get('/importforumpostattachments-sdfsdfsdfsdf', function () use ($app) {
    return false;
    ini_set('memory_limit','1024M');
    // id, section_title, thread_title, post_author,date_time,section_id
    
    $fields = array();
    $fields[]='id';
    $fields[]='section_title';
    $fields[]='thread_title';
    $fields[]='post_author';
    $fields[]='date_time';
    $fields[]='section_id';

    //*
    
    $cnt = 1;
    $row = 1;
    if (($handle = fopen("/var/www/upload/forum_posts.csv", "r")) !== FALSE) {
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
        
        if(!empty($record['thread_title'])){
            
            // get the full file path to each file contained in the corresponding directory
            if (file_exists('/var/www/upload/topics/'.$record['id']) && $handle = opendir('/var/www/upload/topics/'.$record['id'])) {
                $recprd['attachements'] = array();
                /* This is the correct way to loop over the directory. */
                while (false !== ($entry = readdir($handle))) {
                    if($entry != '.' && $entry != '..'){
                        $record['attachments'][] = array('url'=>'/var/www/upload/topics/'.$record['id'].'/'.$entry, 'name'=>$entry);
                    }
                }
                closedir($handle);
            }
            // get the topic record in mongo
            $topic = new Model\Topic(array('headline'=>$record['thread_title']),$app);
            $topic_record = $topic->findById('headline');
            echo '<pre>';print_r('=========    START     ==================================================================================');echo '</pre>';
            echo '<pre>';print_r($topic_record['headline'].' - '.$topic_record['_id']);echo '</pre>';
            echo '<pre>';print_r($record);echo '</pre>';
            if(!empty($topic_record)):
            // upload the files to the topic
                if(array_key_exists('attachments', $record) && !empty($record['attachments'])){
                    foreach($record['attachments'] as $file):

                        // create the drive document record
                        $drive = new Model\Drive(array('add'=>'yes','belongsTo'=>$topic_record['_id']),$app);
                        $drive_id = $drive->saveEdit();

                        $img_name = $file['name'];
                        $img_path = $file['url'];
                        $image = $app['imageFactory']('drivefile',$drive_id);
                        $image->prepareFile($img_name);
echo '<pre>IMAGE';print_r($image);echo '</pre>';
                        // store the file
                        $image->originalFileName = $img_name;
                        $image->sizes['small']['id'] = (string)$app['mongo']->storeFile($img_path
                                                                    ,'image'
                                                                    ,$doc=array('belongsTo'=>$image->belongsTo,'size'=>'small'));
                        $image->makeUrls();
                        $modelObj = $image->instantiateParent($app);
                        $_id = $modelObj->saveEdit();
                        
                        $file_arr['name'] = $file['name'];
                        $file_arr['embedUrl'] = $app['getImageURL']($image,'small');
                        $file_arr['id'] = $_id;

                        $topic_record['files'] = (empty($topic_record['files']) || !array_key_exists('files', $topic_record)) ? array() : $topic_record['files'];
                        array_push($topic_record['files'], $file_arr);

                    endforeach;
                    if(array_key_exists('files', $topic_record)){
                        echo '<pre>';print_r($topic_record['files']);echo '</pre>';
                        $utopic = new Model\Topic(array('_id'=>$topic_record['_id'],'files'=>$topic_record['files']),$app);
                        $utopic->saveSafe();
                    }
                }

            endif;

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
$utilities->get('/viewusersessions/{userId}', function ($userId) use ($app) {
    return false;
    if (empty($userId)) {
        $user_id = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$app);
        if(!empty($user_id)) {
            $userId = (string)$user_id;
        }
    }
echo '<pre>';print_r(session_id());echo '</pre>';
echo '<pre>';print_r($_SESSION);echo '</pre>';
    //$query = array('user_id'=>new \MongoId($userId));

    $regex = new MongoRegex('/'.$userId.'/i');
    $query = array('data'=>$regex);
    $query = array('_id'=>'23rred3vbdihd13nrsa7ca1rl3');
    $sessions = $app['mongo']->find('session', $query, $fields=array(),$slaveOkay=true);

echo '<pre>';print_r($sessions);echo '</pre>';
    /*
    $session_string = $sessions['data']->bin;

    $current_session = session_encode();
    echo '<pre>';print_r($session_string);echo '</pre>';
    echo '<pre>';print_r($current_session);echo '</pre>';
    //*/
    /*
    foreach ($_SESSION as $key => $value){
        unset($_SESSION[$key]);
    }
    session_decode($session_string);
    $restored_session = $_SESSION;
    foreach ($_SESSION as $key => $value){
        unset($_SESSION[$key]);
    }
    session_decode($current_session);
    echo '<pre>';print_r($restored_session);echo '</pre>';
    //*/



    $query = array('_id'=>new \MongoId($userId));
    $user = $app['mongo']->findOne('user', $query, $fields=array(),$slaveOkay=true);
echo '<pre>';print_r($user);echo '</pre>';
    return $app['view']->render('utilities/view_user_session',array('sessions'=>$sessions,'user'=>$user));
    
})->value('userId', '');
/*
// view my session
$app->get('/utilities/viewsession', function (Request $request) use ($app, $checkPermissions) {
    try{
        $checkPermissions(ADMIN);
        $user = array();//Model\Consumer::getUserBySession($app);
        $consumer_doc['firstName'] = 'Mike';
        $consumer_doc['lastName'] = 'Hairetis';
        $consumer_doc['parent'] = new \MongoId('1352224210401664');
        
        $consumer = new Model\Merchant($consumer_doc,$app);
        $consumer->insert();
        
        return $app['view']->render('utilities/view_my_session','admin',array('user'=>$user));  
    } catch (Grapeword\Exceptions\GrapewordException $e) {
        $http_status_code = $e->getHttpStatusCode();
        $abort_response = $e->getAbortResponse();  
        $app->abort($http_status_code, $abort_response);
    }
});

// view user sessions
$app->get('/utilities/viewusersessions/{userId}', function ($userId) use ($app, $checkPermissions) {
    try{
        $checkPermissions(ADMIN);
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
    
        return $app['view']->render('utilities/view_user_session','admin',array('sessions'=>$sessions,'user'=>$user));
    } catch (Grapeword\Exceptions\GrapewordException $e) {
        $http_status_code = $e->getHttpStatusCode();
        $abort_response = $e->getAbortResponse();  
        $app->abort($http_status_code, $abort_response);
    }
})->value('userId', '');

//*/


return $utilities;