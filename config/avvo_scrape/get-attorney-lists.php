<?php
if(true):
$states = array(
    //'AL'=>'Alabama',
    //'AK'=>'Alaska',
    //'AZ'=>'Arizona',
    //'AR'=>'Arkansas',
    //'CA'=>'California',
    /*'CO'=>'Colorado',
    'CT'=>'Connecticut',
    'DE'=>'Delaware',
    'DC'=>'Washington+DC',
    'FL'=>'Florida',
    'GA'=>'Georgia',
    'HI'=>'Hawaii',
    'ID'=>'Idaho',
    'IL'=>'Illinois',
    'IN'=>'Indiana',
    'IA'=>'Iowa',
    'KS'=>'Kansas',
    'KY'=>'Kentucky',
    'LA'=>'Louisiana',
    'ME'=>'Maine',
    'MD'=>'Maryland',
    'MA'=>'Massachusetts',
    'MI'=>'Michigan',
    'MN'=>'Minnesota',
    'MS'=>'Mississippi',
    'MO'=>'Missouri',
    'MT'=>'Montana',
    'NE'=>'Nebraska',
    'NV'=>'Nevada',*/
    'NH'=>'New+Hampshire',
    'NJ'=>'New+Jersey',
    'NM'=>'New+Mexico',
    'NY'=>'New+York',
    'NC'=>'North+Carolina',
    'ND'=>'North+Dakota',
    /*'OH'=>'Ohio',
    'OK'=>'Oklahoma',
    'OR'=>'Oregon',
    'PA'=>'Pennsylvania',*/
    'RI'=>'Rhode+Island',
    'SC'=>'South+Carolina',
    'SD'=>'South+Dakota',
    /*'TN'=>'Tennessee',
    'TX'=>'Texas',
    'UT'=>'Utah',
    'VT'=>'Vermont',
    'VA'=>'Virginia',
    'WA'=>'Washington',
    'WV'=>'West Virginia',
    'WI'=>'Wisconsin',
    'WY'=>'Wyoming',*/
);
foreach ($states as $abbr => $state) {
        // get and parse the attorney count.
        $url = 'http://www.avvo.com/search/lawyer_search?q=DUI+%2F+DWI&loc='.$state;
        $contents = file_get_contents($url);
    if(empty($contents)){
        $h = fopen("./missed-urls.txt", "a");
        fwrite($h, $url.",");
        fclose($h);
    }
    if(!empty($contents)){
        $start = strpos($contents,'Find, research and rate ')+strlen('Find, research and rate ');
        $count = substr($contents, $start, strpos($contents,'DUI',$start)-$start);
        echo "\r\n".$state.'-count:'.$count."\r\n";

        for ($i=0; $i < (int)trim($count); $i+=10) { 

            if($i==0){
                // already got the first page above
            }else{
                $contents = file_get_contents('http://www.avvo.com/search/lawyer_search?loc='.$state.'&q=DUI%20%2F%20DWI&start='.$i);
            }

            $file = './lists/'.strtolower($state).'-list-'.$i.'.txt';
            file_put_contents($file, $contents);
            $sleep = rand(2,30);
            echo $file." +".$sleep."\r\n";
            sleep($sleep);
        }
    }

}

/*
$content = file_get_contents('/var/www/upload/georgestein.com/_stephen-jones_ready/index.php');
    
    include_once __DIR__.'/../../src/Saw/Provider/HtmlDOM/simple_html_dom.php';
    $html = new \simple_html_dom();
    $html->load($content);
    $content = $html->save();
    $content = str_replace('$this->app', '$app', $content);
    ob_start();
    include ("data://text/plain;base64,".base64_encode($content));
    $content = ob_get_contents();
    ob_end_clean();

    $file_content = $df->data;
    
    include_once __DIR__.'/../Provider/HtmlDOM/simple_html_dom.php';
    $html = new \simple_html_dom();
    $html->load($file_content);
    
    // perform the fast forward of the link audit on each anchor and image tag
    foreach($html->find('a') as $item):
        $la = new LinkAudit(array('domainId'=>$this->_id,'route'=>$item->href,'type'=>LinkAudit::$types['ahref']),self::$app);
        $new_route = $la->getLastAudit();
        if(!empty($new_route)){
            $item->setAttribute('href',$new_route);
        }
    endforeach;
    foreach($html->find('img') as $item):
        $la = new LinkAudit(array('domainId'=>$this->_id,'route'=>$item->src,'type'=>LinkAudit::$types['imgsrc']),self::$app);
        $new_route = $la->getLastAudit(LinkAudit::$types['imgsrc']);
        if(!empty($new_route)){
            $item->setAttribute('src',$new_route);
        }
    endforeach;
    $file_content = $html->save();

*/


endif; 

?>