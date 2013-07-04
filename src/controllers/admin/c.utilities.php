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

// query path testing
$utilities->get('/qp-html', function () use ($app, $checkPermissions) {
ob_start();

$site =<<<EOF
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <pagetype name="/features">
        <meta charset="utf-8">

        <title>bulb - creative agency</title>
        <meta name="description" content="bulb is a creative agency that create websites, mobile apps & digital content">
        <meta name="author" content="Vincent Bianciotto">
        <meta name="viewport" content="width=device-width">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800|Rouge+Script|Kaushan+Script' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/style.css">
        <!--[if lt IE 8]>
        <link rel="stylesheet" href="css/easycons-ie7.css">
        <![endif]-->
        
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body class="homepage1">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->        
        <div class="wrapper">
        
            <header class="header-wrapper">
                <div class="header container">
                    <div class="row">
                        <div class="span12">
                            <a href="./index.html" class="logo-top"><img src="images/logo.png" alt="bulb, creative agency" /></a>
                            <a href="#" class="toggle-mobilenav" id="toggleMobilenav"><i class="easycons-mobile-nav"></i></a>
                        </div>
                    </div>
                </div>
            </header>

            <nav class="menu-wrapper">
                <ul class="menu transitions">
                    <li>
                        <a href="./index.html" class="active">Home</a>
                        <ul class="sub-menu">
                            <li><a href="./index.html">Homepage 1 - without slider</a></li>
                            <li><a href="./homepage2.html">Homepage 2 - with a big slider</a></li>
                            <li><a href="./homepage3.html">Homepage 3 - with a small slider</a></li>
                            <li>
                                <a href="#">A sub-menu item</a>
                                <ul class="sub-menu">
                                    <li><a href="#">Menu item 1</a></li>
                                    <li><a href="#">Menu item 2</a></li>
                                    <li><a href="#">Menu item 3</a></li>
                                    <li><a href="#">Menu item 4</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./portfolio1.html">Portfolio</a>
                        <ul class="sub-menu">
                            <li><a href="./portfolio1.html">Portfolio 1 - 3 columns</a></li>
                            <li><a href="./portfolio2.html">Portfolio 2 - 2 columns</a></li>
                            <li><a href="./portfolio3.html">Portfolio 3 - Full width</a></li>
                            <li><a href="./project.html">Single project template</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="./team1.html">Team</a>
                        <ul class="sub-menu">
                            <li><a href="./team1.html">Team template 1</a></li>
                            <li><a href="./team2.html">Team template 2</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="./elements.html">Pages</a>
                        <ul class="sub-menu">
                            <li><a href="./elements.html">Elements</a></li>
                            <li><a href="./features.html">Features</a></li>
                            <li><a href="./pricing.html">Plan & pricing</a></li>
                            <li><a href="./404.html">404 - Page not found</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="./blog.html">Blog</a>
                        <ul class="sub-menu">
                            <li><a href="./post.html">Single post</a></li>
                        </ul>
                    </li>
                    <li><a href="./contact.php">Contact</a></li>
                </ul>
            </nav>
            
            <div class="page-heading-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="page-heading span12">
                            <h1>We are blub, we create websites, mobile apps & digital content</h1>
                            <a href="#" class="btn shaded">Read more</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="features-wrapper">
                <div class="container">
                    <div class="row">
                        <ul class="features">
                            <li class="span3">
                                <a href="#" id="modVar">
                                    <span class="icon-rounded center"><i class="easycons-heart"></i></span>
                                    <h2 class="title" contenteditable="true" data-section="A" data-pageid="xxxxxxxxxxxxxxxxx"><strong>We work with love.</strong> That's why we care about your project as if it was ours.</h2>
                                    <span class="more">Read more</span>
                                </a>
                            </li>
                            <li class="span3">
                                <a href="#">
                                    <span class="icon-rounded center"><i class="easycons-calculator"></i></span>
                                    <h2 class="title" contenteditable="true" datasection="A" data-pageid="ccccccccc"><strong>We fit in your budget.</strong> Because we always make the best choices for your business.</h2>
                                    <span class="more">Read more</span>
                                </a>
                            </li>
                            <li class="span3">
                                <a href="#">
                                    <span class="icon-rounded center"><i class="easycons-cogs"></i></span>
                                    <h2 class="title"><strong>We develop as needed.</strong> Because every project deserve custom development.</h2>
                                    <span class="more">Read more</span>
                                </a>
                            </li>
                            <li class="span3">
                                <a href="#">
                                    <span class="icon-rounded center"><i class="easycons-sandglass"></i></span>
                                    <h2 class="title"><strong>We respect deadlines.</strong> Because we schedule all projects, tasks and meetings.</h2>
                                    <span class="more">Read more</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <h2 class="retro">Latest Work</h2>
                        
                        <div class="project-wrapper">
                            <div class="project project3">
                                <a href="project.html">
                                    <span class="project-desc">
                                        <span>My first trip in Marocco</span>
                                        <span>Webdesign</span>
                                    </span>
                                    <img src="images/portfolio1/project-1.jpg" alt="project1" />
                                </a>
                            </div>
                            <div class="project project3">
                                <a href="project.html">
                                    <span class="project-desc">
                                        <span>A wonderful serenity</span> 
                                        <span>Webdesign</span>
                                    </span>
                                    <img src="images/portfolio1/project-2.jpg" alt="project2" />
                                </a>
                            </div>
                            <div class="project project3">
                                <a href="project.html">
                                    <span class="project-desc">
                                        <span>Red Wine tasting in South of France during my last vacation</span>
                                        <span>Print</span>
                                    </span>
                                    <img src="images/portfolio1/project-3.jpg" alt="project3" />
                                </a>
                            </div>
                            <div class="project project3">
                                <a href="project.html">
                                    <span class="project-desc">
                                        <span>Mercedes Benz</span>
                                        <span>Webdesign</span>
                                    </span>
                                    <img src="images/portfolio1/project-4.jpg" alt="project4" />
                                </a>
                            </div>
                            <div class="project project3">
                                <a href="project.html">
                                    <span class="project-desc">
                                        <span>European Gymnastic Championship</span>
                                        <span>Webdesign</span>
                                    </span>
                                    <img src="images/portfolio1/project-5.jpg" alt="project5" />
                                </a>
                            </div>
                            <div class="project project3">
                                <a href="project.html">
                                    <span class="project-desc">
                                        <span>The final cut</span>
                                        <span>Motion</span>
                                    </span>
                                    <img src="images/portfolio1/project-6.jpg" alt="project6" />
                                </a>
                            </div>
                        </div>

                        <div class="center">
                            <a href="#" class="btn shaded">All projects</a>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="span12">
                        <div class="brands-wrapper">
                            <h2>They trusted us</h2>
                            <div class="brands">
                                <div><a href="#"><img src="images/brands/google.png" alt="Google" /></a></div>
                                <div><a href="#"><img src="images/brands/linkedin.png" alt="Linked in" /></a></div>
                                <div><a href="#"><img src="images/brands/skype.png" alt="Skype" /></a></div>
                                <div><a href="#"><img src="images/brands/twitter.png" alt="Twitter" /></a></div>
                                <div><a href="#"><img src="images/brands/yahoo.png" alt="Yahoo" /></a></div>
                                <div><a href="#"><img src="images/brands/youtube.png" alt="Youtube" /></a></div>
                                <div><a href="#"><img src="images/brands/facebook.png" alt="Facebook" /></a></div>
                                <div><a href="#"><img src="images/brands/html5.png" alt="HTML5" /></a></div>
                                <div><a href="#"><img src="images/brands/microsoft.png" alt="Microsoft" /></a></div>
                                <div><a href="#"><img src="images/brands/adobe.png" alt="Adobe" /></a></div>
                                <div><a href="#"><img src="images/brands/samsung.png" alt="Samsung" /></a></div>
                                <div><a href="#"><img src="images/brands/intel.png" alt="Intel" /></a></div>
                                <div><a href="#"><img src="images/brands/coca-cola.png" alt="Coca-Cola" /></a></div>
                                <div><a href="#"><img src="images/brands/sony.png" alt="Sony" /></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="push"></div>
        </div> <!-- #wrapper -->

        <footer class="footer-wrapper">
            <div class="footer-slogan">
                <div class="container">
                    <div class="row">
                        <div class="span6">
                            <h4>You've got a new project in mind?</h4>
                        </div>
                        <a href="#" class="ribbon">
                            <span>Get started now!</span>
                        </a>
                        <div class="span6">
                            <h4>Or check out our <a href="#">portfolio</a>.</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-top container">
                <div class="row">
                    <div class="span4">
                        <h3><span>About Us</span></h3>
                        <p class="about-us-text">The great cat clawed at the shaggy head until eyes and ears were gone, and naught but a few strips of ragged, bloody flesh remained upon the skull.</p>
                    </div>
                    <div class="span4">
                        <h3><span>Last tweet</span></h3>
                        <p class="latest-tweet">Divshot: Bootstrap-based mockup interface builder for Web apps (in beta) - <a href="#">divshot.com</a> <span class="timeago">1 day ago</span><i class="easycons-twitter"></i></p>
                    </div>
                    <div class="span4">
                        <h3><span>Get in touch</span></h3>
                        <address>
                            <strong class="company">bulb creative agency</strong>
                            <p class="street">679 North Michigan Avenue, Chicago, IL, États-Unis</p>
                            <strong class="phone">+1 312-529-9500</strong>
                        </address>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="span8">
                            <span class="copyright">bulb creative agency <small>&copy; 2012</small></span>
                            <nav class="footer-menu">
                                <ul>
                                    <li><a href="#">Legal</a></li>
                                    <li><a href="#">About</a></li>
                                    <li><a href="#">Blog</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="span4">
                            <nav class="social-icons">
                                <ul>
                                    <li><a href="#"><i class="easycons-facebook-rounded"></i></a></li>
                                    <li><a href="#"><i class="easycons-twitter-rounded"></i></a></li>
                                    <li><a href="#"><i class="easycons-google-plus-rounded"></i></a></li>
                                    <li><a href="#"><i class="easycons-vimeo-rounded"></i></a></li>
                                    <li><a href="#"><i class="easycons-pinterest-rounded"></i></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        
        
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>

    <script src="js/script.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/vendor/responsiveslides.js"></script>
    <script src="/tfs/js/vendor/retina.js"></script>
    <script src="js/vendor/jquery.fitvids.min.js"></script>
</body>
</html>
EOF;
/*
$output = '<b>images</b>:<br>';
foreach(htmlqp($site,'img') as $img){
    $src = $img->attr('src');
    $output.=$src."<br>";
}

$output.= '<br><b>css links</b>:<br>';
foreach(htmlqp($site,'link') as $img){
    $src = $img->attr('href');
    $output.=$src."<br>";
}
$output.= '<br><b>javascript source</b>:<br>';
foreach(htmlqp($site,'script') as $img){
    $src = $img->attr('src');
    $output.=$src."<br>";
}
//*/

/*
htmlqp($site,'script')->each(function($index,$item){
    error_log('index:'.$index);
    error_log('item:'.print_r($item,true));
    $src = $item->attr('src');
    $item->attr('src','/tfs/'.$src);
})->find('img')->each(function($index,$item){
    $src = $item->attr('src');
    $item->attr('src','/tfs/'.$src);
})->find('link')->each(function($index,$item){
    $src = $item->attr('href');
    $item->attr('href','/tfs/'.$src);
})->writeHTML();
//*/

$qpObj = htmlqp($site);

/*
foreach($qpObj->find('img') as $item){
    if($item->hasAttr('src')){
        if(strpos($item->attr('src'),'//') === false && strpos($item->attr('src'),'/tfs/') === false){
            $src = $item->attr('src');
            $item->attr('src','/tfs/'.$src);
        }
    }
}
foreach($qpObj->find('script') as $item){
    if($item->hasAttr('src')){
        if(strpos($item->attr('src'),'//') === false && strpos($item->attr('src'),'/tfs/') === false){
            $src = $item->attr('src');
            $item->attr('src','/tfs/'.$src);
        }
    }
}
foreach($qpObj->find('link') as $item){
    if($item->hasAttr('href')){
        if(strpos($item->attr('href'),'//') === false && strpos($item->attr('href'),'/tfs/') === false){
            $src = $item->attr('href');
            $item->attr('href','/tfs/'.$src);
        }
    }
}
// find the page types
$page_types = array();
foreach($qpObj->find('pagetype') as $item){
    error_log('page type found');
    if($item->hasAttr('name')){
        error_log('pagetype:'.$item->attr('name'));
    }
}
//*/

foreach($qpObj->find('[contenteditable]') as $item){
    error_log('found it');
    if($item->hasAttr('contenteditable')){
        error_log('contenteditable:'.$item->attr('contenteditable'));
        $item->attr('contenteditable','false');
        error_log('contenteditable:'.$item->attr('contenteditable'));
        
    }
}


$append_js =<<<EOF
<script>
        var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
EOF;

// need to include in the javascript if jQuery not present and not the right version insert it!!

$qpObj->find('body')->append($append_js);
$qpObj->writeHTML();


$html = ob_get_contents();
ob_end_clean();

     return new Response($html,200,array('Content-Type' => 'text/html'));
});

// query path testing
$utilities->get('/qp-css', function () use ($app, $checkPermissions) {
ob_start();

$site =<<<EOF
nothing here because can't process css files

EOF;


$qpObj = htmlqp($site);
foreach($qpObj->find('img') as $item){
    if($item->hasAttr('src')){
        if(strpos($item->attr('src'),'//') === false && strpos($item->attr('src'),'/tfs/') === false){
            $src = $item->attr('src');
            $item->attr('src','/tfs/'.$src);
        }
    }
}
foreach($qpObj->find('script') as $item){
    if($item->hasAttr('src')){
        if(strpos($item->attr('src'),'//') === false && strpos($item->attr('src'),'/tfs/') === false){
            $src = $item->attr('src');
            $item->attr('src','/tfs/'.$src);
        }
    }
}
foreach($qpObj->find('link') as $item){
    if($item->hasAttr('href')){
        if(strpos($item->attr('href'),'//') === false && strpos($item->attr('href'),'/tfs/') === false){
            $src = $item->attr('href');
            $item->attr('href','/tfs/'.$src);
        }
    }
}

$qpObj->writeHTML();


$html = ob_get_contents();
ob_end_clean();

     return new Response($html,200,array('Content-Type' => 'text/html'));
});


$utilities->get('/tidytest', function () use ($app) {

$html = "<html>a html document</html>";

// Specify configuration
$config = array(
           'indent'         => true,
           'output-xhtml'   => true,
           'wrap'           => 200);

// Tidy
$tidy = new tidy;
$tidy->parseString($html, $config, 'utf8');
$tidy->cleanRepair();

// Output

    return new Response(tidy_get_output($tidy),200,array('Content-Type' => 'text/html'));
});
$utilities->get('/mongotest', function () use ($app) {
    

    $criteria = array('_id'=>new \MongoId('519d16d9fc14f1a405000000'));
    //$criteria = array('$addToSet'=>array('sections'=>array('label'=>'mike','value'=>'haireits')));
    $document = array('$set'=>array('businessName'=>'whatevervvvvvvv'));
    $update_res = $app['mongo']->update($document, 'client', $criteria, $multiple=false, $upsert=false, $options=array());


    return new Response(print_r($update_res,true),200,array('Content-Type' => 'text/html'));
});
$utilities->get('/viewTest', function () use ($app) {
    $page_contents = $app['view']->renderPageTypeByRoute('/blog','519d16f6fc14f1ab05000000-gamma.com');
    //$html = "<pre>".print_r($page_contents,true)."</pre>";
    $html = $page_contents;
    return new Response($html,200,array('Content-Type' => 'text/html'));
});
$utilities->get('/viewTemplateFile', function () use ($app) {
    $page_contents = $app['view']->renderPageTypeByRoute('/elements','519d16d9fc14f1a405000000-alpha.com');
    //$html = "<pre>".print_r($page_contents,true)."</pre>";
    $html = $page_contents;
    return new Response($html,200,array('Content-Type' => 'text/html'));
});



// markdown parser
$utilities->post('/markdown', function (Request $request) use ($app) {
    $txt = $request->get('txt');
    $parser = new MarkdownParser();
    $result = $parser->transformMarkdown($txt);
    return new Response($result,200,array('Content-Type' => 'text/html'));
});

$utilities->get('/listenerTest', function () use ($app) {
    //Saw\Exceptions\SawException::throwNew();
});


$utilities->get('/getfile', function () use ($app) {
    $domain = new Model\Domain(array('_id'=>'51b495a0fc14f10907000000'),$app);

    $files = $domain->getFilesToProcess(true);
    $file_content = $app['mongo']->getFile($files[0]['_id'],'domain');
    return new Response($file_content,200,array('Content-Type' => 'text/html')); 
});

/**
 * Get an array that represents directory tree
 * @param string $directory     Directory path
 * @param bool $recursive         Include sub directories
 * @param bool $listDirs         Include directories on listing
 * @param bool $listFiles         Include files on listing
 * @param regex $exclude         Exclude paths that matches this regex
 */
function directoryToArray($directory, $recursive = true, $listDirs = false, $listFiles = true, $exclude = '') {
    $arrayItems = array();
    $skipByExclude = false;
    $handle = opendir($directory);
    if ($handle) {
        while (false !== ($file = readdir($handle))) {
        preg_match("/(^(([\.]){1,2})$|(\.(svn|git|md))|(Thumbs\.db|\.DS_STORE|MACOSX|\.zip))$/iu", $file, $skip);
        if($exclude){
            preg_match($exclude, $file, $skipByExclude);
        }
        if (!$skip && !$skipByExclude) {
            if (is_dir($directory. DIRECTORY_SEPARATOR . $file)) {
                if($recursive) {
                    $arrayItems = array_merge($arrayItems, directoryToArray($directory. DIRECTORY_SEPARATOR . $file, $recursive, $listDirs, $listFiles, $exclude));
                }
                if($listDirs){
                    $file = $directory . DIRECTORY_SEPARATOR . $file;
                    $arrayItems[] = $file;
                }
            } else {
                if($listFiles){
                    $file = $directory . DIRECTORY_SEPARATOR . $file;
                    $arrayItems[] = $file;
                }
            }
        }
    }
    closedir($handle);
    }
    return $arrayItems;
}

$utilities->get('/showdir', function () use ($app) {
    $response = "<pre>";
    $response.= print_r(directoryToArray('/var/www/upload'),true);
    $response.= "</pre>";
    return $response;
});


$utilities->get('/phpinfo', function () use ($app, $checkPermissions) {
    //$checkPermissions(CONSUMER);
    return $app['view']->render('utilities/phpinfo', 'none');
});
$utilities->get('/preg', function () use ($app) {
    

    $string=<<<EOF
<div class="span12">
                        <div class="center">
                            <img src="images/404/404-light.png" class="space-up more" alt="410 - Page not found" />
                        </div>

                        <h2 class="center">The message: 
                            <h2 class="php">
                                mike
                            </h2>.</h2>

                        <aside class="widget widget-search huge">
                            <form class="search-form" role="search" method="get" action="/">
                                <label class="screen-reader-text" for="s">Search for:</label>
                                <input type="text" placeholder="To search type and hit enter" value="" name="s" id="s">
                                <input type="submit" class="searchsubmit" id="searchsubmit" value="Search">
                            </form>
                        </aside>
                        <h2 class="php">
                                tom
                            </h2>
                    </div>
                    <h2 class="php">
                                joe
                            </h2>
EOF;



preg_match("'<h2 class=\"php\">(.*?)</h2>'si",$string,$match);
error_log('match.'.print_r($match,true));

$result = preg_replace('#<h2 class=\"php\">(.*?)</h2>#is','$1',$string);
error_log('result:'.$result);
return true;


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