<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/assets/stylesheets/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/assets/stylesheets/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="/assets/stylesheets/screenv5.3.min.css" rel="stylesheet">  <!--4522, 3364-->
        <link href="/assets/stylesheets/responsive.min.css" rel="stylesheet">
        <script src="/assets/js/jquery-1.10.1.min.js"></script>
        <script src="/assets/js/jquery.blockui.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/custom.js"></script>
        <link href="/assets/stylesheets/layout-content.min.css" rel="stylesheet" type="text/css"/>
        <link href="/assets/stylesheets/bootstrap-modal.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <style>
        p img{padding:20px;}
        p.embedly iframe {padding:20px;}
        .content .title h2, .content .title h3 {
          border-top: 1px solid #d1dbe1;
          color: #699bc6;
          letter-spacing: 1px;
          margin: 0;
          position: relative;
          text-shadow: 0 0 0 #dce8f0, 0 0 0 #bfccd5, 0 0 0 #bfccd5, 0 0 0 #bfccd5, 0 0 0 #bfccd5, 0 0 0 #bfccd5, 0 0 0 white;
          z-index: 10;
        }
        .content .recentNews .thumbnails .thumbnail .caption h4{
            font-family: bebasregular;
        }
        h4 {font-size:14px;}
    </style>
    <body>
        <div class="wrapper">
            <?=$this->element('nav')?>
            <?=$this->element('slogan-block',array('slogan_block'=>(array_key_exists('slogan_block',$this->vars)) ? $this->vars['slogan_block']:'' ))?>
            <div class="container">
                <div class="content contentBg">
                    <?=$this->content($view)?>
                </div>
            </div>
            <?=$this->element('footer')?>
        </div>
    </body>
    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39569903-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</html>