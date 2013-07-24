<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/assets/stylesheets/bootstrap.css" rel="stylesheet" media="screen">
        <link href="/assets/stylesheets/bootstrap-responsive.css" rel="stylesheet">
        <link href="/assets/stylesheets/screen.css" rel="stylesheet">
        <link href="/assets/stylesheets/responsive.css" rel="stylesheet">
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
</html>