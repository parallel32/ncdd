<?
$registration = $this->vars['registration'];
$seminar = $this->vars['seminar'];
?>
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
            <? 
            $user = $this->app['session']->get('user');
            $accessLevel = $user['accessLevel'];
            $user_id = $user['user_id'];
            ?>
            <? if($accessLevel == ADMIN): ?>
            <div class="row-fluid invoice">
               <div class="span12 alert">
                  <p><h3><b>Credit card payment screen</b></h3></p>
                  <p><h3>To pay without a credit card:</h3></p> <a class="btn blue" href="/registration/seminar/<?=$registration['_id']?>/pay-other"><i class="icon-money"></i> Goto the Alternate Payment Form</a>
               </div>
            </div>
            <hr />
            <? endif; ?>
            <div class="row-fluid invoice">
               <div class="row-fluid invoice-logo">
                  <div class="span6 invoice-logo-space"><img src="/assets/img/ncdd-login2-logo.png" alt="" /> </div>
                  <div class="span6">
                     <p>#<?=$registration['_id']?> / <? $date = new \DateTime(); echo $date->format('d');?> <?echo $date->format('M');?>, <?echo $date->format('Y');?> <span class="muted">Registration ID and Date</span></p>
                  </div>
               </div>
               <hr />
               <div class="row-fluid">
                  <div class="span3">
                     <h4>Member:</h4>
                     <ul class="unstyled">
                        <li><?=$registration['name']?></li>
                        <li>
                           <?=$registration['address1']?><?=(!empty($registration['address2'])) ?' '.$registration['address2'] :'' ;?>
                           <?=$registration['city']?>, <?=$registration['state']?> <?=$registration['country']?>
                        </li>
                        <li>email: <?=$registration['email']?></li>
                        <li>phone: <?=$registration['phone']?></li>
                        <li>fax: <?=$registration['fax']?></li>
                     </ul>
                  </div>
                  <div class="span4">
                     <h4>About:</h4>
                     <ul class="unstyled">
                        <li><?=$registration['type']?></li>
                        <li><?=$registration['attendanceCertificationStatement']?></li>
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
                        <? 
                           
                           $is_deposit = false;
                           $is_balance_due = false;
                           $is_full_payment = false;
                           if(empty($registration['paymentId']) && (array_key_exists('depositPaymentId', $registration) && empty($registration['depositPaymentId']))) {
                              $registration['registrationFee'] = $registration['deposit'];
                              $label = 'Registration Deposit';
                              $is_deposit = true;
                           }else if(!empty($registration['paymentId']) || (array_key_exists('depositPaymentId', $registration) && !empty($registration['depositPaymentId']))){
                              // a deposit has been paid so derive the amount
                              $label = 'Registration Balance Due';
                              $registration['registrationFee'] = $registration['registrationFee'] - $seminar['register']['deposit'];
                              $is_balance_due = true;
                           }else{
                              $label = "Registration Full Payment";
                              $is_full_payment = true;
                           }
                        ?>
                        <tr>
                           <td>1</td>
                           <td><?=$label?></td>
                           <td class="hidden-480"><?=$registration['type']?></td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">$<?=$registration['registrationFee']?></td>
                           <td>$<?=$registration['registrationFee']?></td>
                        </tr>
                        
                        <? if($is_deposit && array_key_exists('hardCopy',$registration) && !empty($registration['hardCopy'])): ?>
                        <? if($registration['hardCopy'] == 'YES'): 
                        ?>
                        <tr>
                           <td>2</td>
                           <td>Hard Copy</td>
                           <td class="hidden-480">Printed and Prepared Hard Copy</td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">$<?=$registration['hardCopyFee']?></td>
                           <td>$<?=$registration['hardCopyFee']?></td>
                        </tr>
                        <? endif; ?>
                        <? endif; ?>
                     </tbody>
                  </table>
               </div>
               <div class="row-fluid">
                  <div class="span12 invoice-block">
                     <ul class="unstyled amounts"> 
                        <li><strong>Total:</strong> $<?=$registration['registrationFee']?></li>
                     </ul>
                  </div>
               </div>
            </div>
            <? if(false): ?>
            <!--/ INVOICE -->

            <!-- PAYMENT  only show for members -->
            <? endif; ?>
            <div class="row-fluid">
               <div class="span12">
                  <?
                     $payment_vars['memberId'] = $registration['memberId'];
                     $payment_vars['ownerId'] = $registration['_id'];
                     $payment_vars['ownerClass'] = $registration['class'];
                     $payment_vars['description'] = 'INV-'.time();
                     $payment_vars['title'] = $label.' - '.$registration['type'].' - '.$this->vars['seminar']['headline'].' - '.$this->vars['seminar']['location'].' - '.$this->vars['seminar']['startDate']['monthDay'].' - '.$this->vars['seminar']['endDate']['monthDay'].', '.$this->vars['seminar']['startDate']['year'];
                     $payment_vars['amount'] = $registration['registrationFee'];
                     $payment_vars['firstName'] = $registration['name'];
                     $payment_vars['lastName'] = '';
                     $payment_vars['email'] = $registration['email'];
                     $payment_vars['phone'] = (!empty($registration['phone'])) ? $registration['phone']: $this->vars['location']['phone'];
                     $payment_vars['address1'] = (!empty($registration['address1'])) ? $registration['address1']: $this->vars['location']['addressLine1'];
                     $payment_vars['address2'] = $registration['address2'];
                     $payment_vars['city'] = (!empty($registration['city'])) ? $registration['city']: $this->vars['location']['city'];
                     $payment_vars['state'] = (!empty($registration['state'])) ? $registration['state']: $this->vars['location']['state'];
                     $payment_vars['postalCode'] = (!empty($registration['postalCode'])) ? $registration['postalCode']: $this->vars['location']['zip'];
                     $payment_vars['country'] = (!empty($registration['country'])) ? $registration['country']: $this->vars['location']['country'];
                     $payment_vars['redirect_label'] = 'Go To Registrations';
                     $payment_vars['redirect_url'] = '/registrations/seminar/'.$registration['seminarId'];
                     $payment_vars['chargeOnSuccess'] = <<< EOT
{chargeOnSuccess:function(responseObj,paymentId){
   $('#save-success .continue.payment').attr('data-insertid',paymentId);
   io.saw.FormGet.activate({postUrl:'/registration/'+paymentId+'/pay/{$registration['_id']}'
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