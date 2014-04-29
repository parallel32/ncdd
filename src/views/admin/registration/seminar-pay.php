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
                  <p><h3>To pay without a credit card:</h3></p> <a class="btn blue" href="/registration/seminar/<?=$this->vars['registration']['_id']?>/pay-other"><i class="icon-money"></i> Goto the Alternate Payment Form</a>
               </div>
            </div>
            <hr />
            <? endif; ?>
            <div class="row-fluid invoice">
               <div class="row-fluid invoice-logo">
                  <div class="span6 invoice-logo-space"><img src="/assets/img/ncdd-login2-logo.png" alt="" /> </div>
                  <div class="span6">
                     <p>#<?=$this->vars['registration']['_id']?> / <? $date = new \DateTime(); echo $date->format('d');?> <?echo $date->format('M');?>, <?echo $date->format('Y');?> <span class="muted">Registration ID and Date</span></p>
                  </div>
               </div>
               <hr />
               <div class="row-fluid">
                  <div class="span3">
                     <h4>Member:</h4>
                     <ul class="unstyled">
                        <li><?=$this->vars['registration']['name']?></li>
                        <li>
                           <?=$this->vars['registration']['address1']?><?=(!empty($this->vars['registration']['address2'])) ?' '.$this->vars['registration']['address2'] :'' ;?>
                           <?=$this->vars['registration']['city']?>, <?=$this->vars['registration']['state']?> <?=$this->vars['registration']['country']?>
                        </li>
                        <li>email: <?=$this->vars['registration']['email']?></li>
                        <li>phone: <?=$this->vars['registration']['phone']?></li>
                        <li>fax: <?=$this->vars['registration']['fax']?></li>
                     </ul>
                  </div>
                  <div class="span4">
                     <h4>About:</h4>
                     <ul class="unstyled">
                        <li><?=$this->vars['registration']['type']?></li>
                        <li><?=$this->vars['registration']['attendanceCertificationStatement']?></li>
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
                        <? //echo "<pre>";print_r($this->vars['registration']);echo "</pre>";
                           /*
                           if(array_key_exists('deposit',$this->vars['seminar']['register'])
                              && array_key_exists('depositQuestion',$this->vars['registration']) 
                              && !empty($this->vars['registration']['deposit']) 
                              && $this->vars['registration']['depositQuestion'] == 'yes'):
                              //*/
                           if($this->vars['registration']['currentStatus'] == \Saw\Model\Registration::$status['DEPOSIT']):
                              
                              $this->vars['registration']['registrationFee'] = $this->vars['registration']['deposit'];
                              $label = 'Registration Deposit';

                           elseif($this->vars['registration']['currentStatus'] == \Saw\Model\Registration::$status['DEPOSITBALANCE']):
                              $this->vars['registration']['registrationFee'] = (int)$this->vars['registration']['registrationFeeOriginal'] - (int)$this->vars['registration']['deposit'];
                              $label = 'Registration Balance Due';
                           else:
                              $label = "Registration Full Payment";
                           endif;
                        ?>
                        <tr>
                           <td>1</td>
                           <td><?=$label?></td>
                           <td class="hidden-480"><?=$this->vars['registration']['type']?></td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">$<?=$this->vars['registration']['registrationFee']?></td>
                           <td>$<?=$this->vars['registration']['registrationFee']?></td>
                        </tr>
                        
                        <? if(array_key_exists('hardCopy',$this->vars['registration']) && !empty($this->vars['registration']['hardCopy'])): ?>
                        <? if($this->vars['registration']['hardCopy'] == 'YES'): 
                        ?>
                        <tr>
                           <td>2</td>
                           <td>Hard Copy</td>
                           <td class="hidden-480">Printed and Prepared Hard Copy</td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">$<?=$this->vars['registration']['hardCopyFee']?></td>
                           <td>$<?=$this->vars['registration']['hardCopyFee']?></td>
                        </tr>
                        <? endif; ?>
                        <? endif; ?>
                     </tbody>
                  </table>
               </div>
               <div class="row-fluid">
                  <div class="span12 invoice-block">
                     <ul class="unstyled amounts"> 
                        <? if($this->vars['registration']['currentStatus'] == \Saw\Model\Registration::$status['DEPOSITBALANCE']): 
                           $this->vars['registration']['total'] = $this->vars['registration']['registrationFee'];
                           endif; ?>
                        <li><strong>Total:</strong> $<?=$this->vars['registration']['total']?></li>
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
                     $payment_vars['memberId'] = $this->vars['registration']['memberId'];
                     $payment_vars['ownerId'] = $this->vars['registration']['_id'];
                     $payment_vars['ownerClass'] = $this->vars['registration']['class'];
                     $payment_vars['description'] = 'INV-'.time();
                     $payment_vars['title'] = $label.' - '.$this->vars['registration']['type'].' - '.$this->vars['seminar']['headline'].' - '.$this->vars['seminar']['location'].' - '.$this->vars['seminar']['startDate']['monthDay'].' - '.$this->vars['seminar']['endDate']['monthDay'].', '.$this->vars['seminar']['startDate']['year'];
                     $payment_vars['amount'] = $this->vars['registration']['total'];
                     $payment_vars['firstName'] = $this->vars['registration']['name'];
                     $payment_vars['lastName'] = '';
                     $payment_vars['email'] = $this->vars['registration']['email'];
                     $payment_vars['phone'] = (!empty($this->vars['registration']['phone'])) ? $this->vars['registration']['phone']: $this->vars['location']['phone'];
                     $payment_vars['address1'] = (!empty($this->vars['registration']['address1'])) ? $this->vars['registration']['address1']: $this->vars['location']['addressLine1'];
                     $payment_vars['address2'] = $this->vars['registration']['address2'];
                     $payment_vars['city'] = (!empty($this->vars['registration']['city'])) ? $this->vars['registration']['city']: $this->vars['location']['city'];
                     $payment_vars['state'] = (!empty($this->vars['registration']['state'])) ? $this->vars['registration']['state']: $this->vars['location']['state'];
                     $payment_vars['postalCode'] = (!empty($this->vars['registration']['postalCode'])) ? $this->vars['registration']['postalCode']: $this->vars['location']['zip'];
                     $payment_vars['country'] = (!empty($this->vars['registration']['country'])) ? $this->vars['registration']['country']: $this->vars['location']['country'];
                     $payment_vars['redirect_label'] = 'Go To Registrations';
                     $payment_vars['redirect_url'] = '/registrations/seminar/'.$this->vars['registration']['seminarId'];
                     $payment_vars['chargeOnSuccess'] = <<< EOT
{chargeOnSuccess:function(responseObj,paymentId){
   $('#save-success .continue.payment').attr('data-insertid',paymentId);
   io.saw.FormGet.activate({postUrl:'/registration/'+paymentId+'/pay/{$this->vars['registration']['_id']}'
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