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
                  <p><h3>To pay without a credit card:</h3></p> <a class="btn blue" href="/application/<?=$this->vars['application']['_id']?>/pay-other"><i class="icon-money"></i> Goto the Alternate Payment Form</a>
               </div>
            </div>
            <hr />
            <? endif; ?>
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
                        <li>phone: <?=(!empty($this->vars['application']['phone'])) ? $this->vars['application']['phone']: $this->vars['location']['phone']?></li>
                        <li>fax: <?=(!empty($this->vars['application']['fax'])) ? $this->vars['application']['fax']: $this->vars['location']['fax']?></li>
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
                           <th>Item</th>
                           <th class="hidden-480">Description</th>
                           <th class="hidden-480">Quantity</th>
                           <th class="hidden-480">Unit Cost</th>
                           <th>Total</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>Application</td>
                           <td class="hidden-480"><?=$this->vars['application']['type']?></td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">$<?=$this->vars['application']['membershipDues']?></td>
                           <td>$<?=$this->vars['application']['membershipDues']?></td>
                        </tr>
                        
                       <?
                        // EARLY BIRD DISCOUNT FOR 2014 
                        if($this->vars['application']['type'] == 'UPDATE MEMBER APPLICATION'
                            && strtotime($this->vars['application']['approvedDate']['iso']) < strtotime('December 31, 2014')
                            && $this->vars['application']['membershipDues'] > 50
                        ): 
                           $discount = 50;
                        ?>
                        <tr>
                           <td>Discount</td>
                           <td class="hidden-480">Early Payment 2014 Discount</td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">-$50</td>
                           <td>-$50</td>
                        </tr>
                        <? endif; ?>
                        <?
                        // CREDIT DISCOUNT FOR MEMBERS WHO HOLD A CREDIT WITH US
                        $discount2 = 0;
                        if(array_key_exists('payment',$this->vars['member']) 
                              && !empty($this->vars['member']['payment'])
                              && is_array($this->vars['member']['payment'])
                              && array_key_exists('renewalCredit',$this->vars['member']['payment'])
                              && !empty($this->vars['member']['payment']['renewalCredit'])
                              && $this->vars['member']['payment']['renewalCredit'] > 0
                        ): 
                           $discount2  = $this->vars['member']['payment']['renewalCredit'];
                        ?>
                        <tr>
                           <td>Credit</td>
                           <td class="hidden-480">Prior Membership Dues Credit</td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">-$<?=$this->vars['member']['payment']['renewalCredit']?></td>
                           <td>-$<?=$this->vars['member']['payment']['renewalCredit']?></td>
                        </tr>
                        <? endif; ?>

                        <? if($this->vars['pro_rated_membership_dues']['q'] > 1): 
                           $amount = $this->vars['pro_rated_membership_dues']['a'];
                        ?>
                        <tr>
                           <td>Discount</td>
                           <td class="hidden-480">Pro-rated Discount</td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">-$<?=$this->vars['application']['membershipDues']-$this->vars['pro_rated_membership_dues']['a']?></td>
                           <td>-$<?=$this->vars['application']['membershipDues']-$this->vars['pro_rated_membership_dues']['a']?></td>
                        </tr>
                        <? else: 
                           $amount = $this->vars['application']['membershipDues'];
                         endif; ?>
                     </tbody>
                  </table>
               </div>
               <div class="row-fluid">
                  <div class="span12 invoice-block">
                     <ul class="unstyled amounts">
                        <li><strong>Total:</strong> $<?$amount = $amount-$discount-$discount2; echo ($amount <= 0) ? 0:$amount;?></li>
                     </ul>
                  </div>
               </div>
               <? if($amount <= 0): ?>
               <div class="row-fluid">
                  <div class="span12">
                     <div class="alert alert-error">
                        If you're seeing this, it means your invoice total is either $0 or less than $0.  
                        <br><br>
                        Your invoice has yet to be auto-paid by our automated system.  
                        <br><br>
                        Please wait a few more days or you may contact NCDD and they will take care of this.
                        <br><br>
                        Please note: if you're total is less than $0, the remaining amount of credit will persist in your account and will be applied in your upcoming membership renewal.
                     </div>   
                  </div>
               </div>
               <? endif; ?>
            </div>
            <? if(false): ?>
            <!--/ INVOICE -->

            <!-- PAYMENT  only show for members -->
            <? endif; ?>
            <div class="row-fluid">
               <div class="span12">
                  <?
                     $payment_vars['memberId'] = $this->vars['application']['memberId'];
                     $payment_vars['ownerId'] = $this->vars['application']['_id'];
                     $payment_vars['ownerClass'] = $this->vars['application']['class'];
                     $payment_vars['description'] = 'INV-'.time();
                     $payment_vars['title'] = $this->vars['application']['type'];
                     $payment_vars['amount'] = $amount;
                     $payment_vars['firstName'] = $this->vars['application']['firstName'];
                     $payment_vars['lastName'] = $this->vars['application']['lastName'];
                     $payment_vars['email'] = $this->vars['application']['email'];
                     $payment_vars['phone'] = (!empty($this->vars['application']['phone'])) ? $this->vars['application']['phone']: $this->vars['location']['phone'];
                     $payment_vars['address1'] = (!empty($this->vars['application']['address1'])) ? $this->vars['application']['address1']: $this->vars['location']['addressLine1'];
                     $payment_vars['address2'] = (!empty($this->vars['application']['address2'])) ? $this->vars['application']['address2']: $this->vars['location']['addressLine2'];
                     $payment_vars['city'] = (!empty($this->vars['application']['city'])) ? $this->vars['application']['city']: $this->vars['location']['city'];
                     $payment_vars['state'] = (!empty($this->vars['application']['state'])) ? $this->vars['application']['state']: $this->vars['location']['state'];
                     $payment_vars['postalCode'] = (!empty($this->vars['application']['postalCode'])) ? $this->vars['application']['postalCode']: $this->vars['location']['zip'];
                     $payment_vars['country'] = (!empty($this->vars['application']['country'])) ? $this->vars['application']['country']: $this->vars['location']['country'];
                     $payment_vars['redirect_label'] = 'Go To Applications';
                     $payment_vars['redirect_url'] = '/applications';
                     $resetSession = ($accessLevel == ADMIN) ? 'no' : 'yes';
                     $payment_vars['chargeOnSuccess'] = <<< EOT
{chargeOnSuccess:function(responseObj,paymentId){
   $('#save-success .continue.payment').attr('data-insertid',paymentId);
   io.saw.FormGet.activate({postUrl:'/application/'+paymentId+'/pay/{$this->vars['application']['_id']}/{$resetSession}'
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