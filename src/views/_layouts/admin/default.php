
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
	<?=$this->element('page-styles')?>
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
<body class="page-header-fixed page-footer-fixed">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="/" style="margin-top:-7px">
				<img src="/assets/img/ncdd-dashboard-logo.png" alt="logo" />
				</a>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<img src="/assets/img/menu-toggler.png" alt="" />
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->            
				<!-- BEGIN TOP NAVIGATION MENU -->              
	            <ul class="nav pull-right">
	               <!-- BEGIN USER LOGIN DROPDOWN -->
	               <li class="dropdown user">
	                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                  <span class="username"><?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['displayName'];},$this->app); ?></span>
	                  <i class="icon-angle-down"></i>
	                  </a>
	                  <ul class="dropdown-menu">
	                     <li><a href="/logout"><i class="icon-key"></i> Log Out</a></li>
	                  </ul>
	               </li>
	               <!-- END USER LOGIN DROPDOWN -->
	            </ul>
	            <!-- END TOP NAVIGATION MENU -->
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->   
	<div class="page-container row-fluid">
		
	    <?=$this->element('sidebar-menu')?>
      	<?=$this->content($view)?>

	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		<div class="footer-inner">
			<?=date('Y')?> &copy; National College for DUI Defense, Inc.
		</div>
		<div class="footer-tools">
			<span class="go-top">
			<i class="icon-angle-up"></i>
			</span>
		</div>
	</div>
	<!-- END FOOTER -->
	<?=$this->element('page-plugins');?>
</body>
<!-- END BODY -->
</html>