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

            <!-- INVOICE -->
            <div class="row-fluid invoice">
               <div class="row-fluid invoice-logo">
                  <div class="span6 invoice-logo-space"><img src="/assets/img/ncdd-login2-logo.png" alt="" /> </div>
                  <div class="span6">
                     <p>#<?=$this->vars['application']['_id']?> / <? $date = new \DateTime(); echo $date->format('d');?> <?echo $date->format('M');?>, <?echo $date->format('Y');?> <span class="muted">Application ID and Date</span></p>
                  </div>
               </div>
               <hr />
               <div class="row-fluid">
                  <div class="span3">
                     <h4>Member:</h4>
                     <ul class="unstyled">
                        <? $middleName = (!empty($this->vars['application']['middleName'])) ? ' '.$this->vars['application']['middleName'].' ':' '; ?>
                        <li><?=$this->vars['application']['firstName']?><?=$middleName?><?=$this->vars['application']['lastName']?></li>
                        <li><?=$this->vars['application']['formattedAddress']?></li>
                        <li>email: <?=$this->vars['application']['email']?></li>
                        <li>phone: <?=$this->vars['application']['phone']?></li>
                        <li>fax: <?=$this->vars['application']['fax']?></li>
                     </ul>
                  </div>
                  <div class="span4">
                     <h4>About:</h4>
                     <ul class="unstyled">
                        <li><?=$this->vars['application']['type']?></li>
                        <li><?=$this->vars['application']['executed']?></li>
                     </ul>
                  </div>
                  <div class="span4 invoice-payment">
                     <h4></h4>
                     <ul class="unstyled">
                        
                     </ul>
                  </div>
               </div>
               <div class="row-fluid">
                  <table class="table table-striped table-hover">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Item</th>
                           <th class="hidden-480">Description</th>
                           <th class="hidden-480">Quantity</th>
                           <th class="hidden-480">Unit Cost</th>
                           <th>Total</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>1</td>
                           <td>Application</td>
                           <td class="hidden-480"><?=$this->vars['application']['type']?></td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">$<?=$this->vars['application']['membershipDues']?></td>
                           <td>$<?=$this->vars['application']['membershipDues']?></td>
                        </tr>
                        
                     </tbody>
                  </table>
               </div>
               <div class="row-fluid">
                  <div class="span12 invoice-block">
                     <ul class="unstyled amounts">
                        <li><strong>Sub - Total amount:</strong> $<?=$this->vars['application']['membershipDues']?></li>
                        <li><strong>Grand Total:</strong> $<?=$this->vars['application']['membershipDues']?></li>
                     </ul>
                  </div>
               </div>
            </div>

            <!--/ INVOICE -->

            <!-- PAYMENT -->
            <div class="row-fluid">
               <div class="span12">
                  <?
                     $payment_vars['memberId'] = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);
                     $payment_vars['ownerId'] = $this->vars['application']['_id'];
                     $payment_vars['ownerClass'] = $this->vars['application']['class'];
                     $payment_vars['description'] = 'INV-'.time();
                     $payment_vars['title'] = $this->vars['application']['type'];
                     $payment_vars['amount'] = $this->vars['application']['membershipDues'];
                     $payment_vars['firstName'] = $this->vars['application']['firstName'];
                     $payment_vars['lastName'] = $this->vars['application']['lastName'];
                     $payment_vars['email'] = $this->vars['application']['email'];
                     $payment_vars['phone'] = $this->vars['application']['phone'];
                     $payment_vars['address1'] = $this->vars['application']['address1'];
                     $payment_vars['address2'] = $this->vars['application']['address2'];
                     $payment_vars['city'] = $this->vars['application']['city'];
                     $payment_vars['state'] = $this->vars['application']['state'];
                     $payment_vars['postalCode'] = $this->vars['application']['postalCode'];
                     $payment_vars['country'] = $this->vars['application']['country'];
                     $payment_vars['chargeOnSuccess'] = <<< EOT
{chargeOnSuccess:function(responseObj,paymentId){
   $('#save-success .continue.payment').attr('data-insertid',paymentId);
   io.saw.FormGet.activate({postUrl:'/application/'+paymentId+'/pay/{$this->vars['application']['_id']}'
      ,postOnComplete:function(responseObj,responseStatus){}
      ,postOnSuccess:function(responseObj){
         //document.location.href='/applications';
      }
   });
}}
EOT;
                  ?>
                  <?=$this->element('payment',$payment_vars);?>
               </div>
            </div>
            <!--/ PAYMENT -->

            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->