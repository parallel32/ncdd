<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/assets/stylesheets/bootstrap.css?v=<?=time()?>" rel="stylesheet" media="screen">
        <link href="/assets/stylesheets/bootstrap-responsive.css" rel="stylesheet">
        <link href="/assets/stylesheets/screen.css?v=<?=time()?>" rel="stylesheet">  <!--4522, 3364-->
        <link href="/assets/stylesheets/responsive.css?v=<?=time()?>" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/custom.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
    </head>
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