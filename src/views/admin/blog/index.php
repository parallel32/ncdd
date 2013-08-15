
<!-- BEGIN PAGE -->
      <div class="page-content">
         
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                  <?=$this->element('page-title-and-bread-crumb');?>
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT--> 
            <div class="row-fluid">
               <div class="span12">
                  <? $accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app); ?>
                  <h2>Blog Roll <? if($accessLevel == MEMBER): ?><small>Participate in the NCDD.com DUI Blog.  Draft a blog post and submit it for publishing: </small><a class="btn green" href="/blog/<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>/edit">Add Blog Post <i class="icon-plus"></i></a><? endif; ?></h2> 
               </div>
            </div>
            
            <!-- END PAGE CONTENT-->

         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->