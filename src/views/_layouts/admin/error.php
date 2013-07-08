
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>NCDD Member Portal | Private</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <!-- BEGIN GLOBAL MANDATORY STYLES -->
   <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/css/style-metro.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/css/style.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
   <link href="/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
   <!-- END GLOBAL MANDATORY STYLES -->
   <!-- BEGIN PAGE LEVEL STYLES -->
   <link href="/assets/css/pages/error.css" rel="stylesheet" type="text/css"/>
   <!-- END PAGE LEVEL STYLES -->
   <link rel="shortcut icon" href="favicon.ico" />
   <!-- jquery included here instead of in page level plugins section at the bottom because I need access to the document.ready function to 
   initialize page level scripts within the page itself -->
   <script src="/assets/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>   
   <!-- define the namespace as early as possible to make it accessible to page level scripts defined in the page itself. -->
   <?=$this->element('js/Namespace.js');?>
   <?=$this->element('js/BlockUI.Class.js');?>
   <?=$this->element('js/FormPostClass.js');?>
   <?=$this->element('js/FormGetClass.js');?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-500-full-page">

<?=$this->content($view)?>
</body>
<!-- END BODY -->
</html>