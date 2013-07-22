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
               <h3>application's payment details here..</h3>
               <?
                  $payment_vars['memberId'] = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);
                  $payment_vars['ownerId'] = $this->vars['application']['_id'];
                  $payment_vars['ownerClass'] = $this->vars['application']['class'];
                  $payment_vars['description'] = 'INV-'.time();
                  $payment_vars['title'] = $this->vars['application']['type'];
                  $payment_vars['amount'] = $this->vars['application']['membershipDues'];
               ?>
               <?=$this->element('payment',$payment_vars);?>
            </div>
         </div>
         <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->