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
            <?=$this->element('invoice-block',array('application'=>$this->vars['application'],'member'=>$this->vars['member'],'location'=>$this->vars['location'],'pro_rated_membership_dues'=>$this->vars['pro_rated_membership_dues']));?>
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
                     $payment_vars['amount'] = $this->vars['aamount'];
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

                     if(array_key_exists('payment',$this->vars['member']) && !empty($this->vars['member']['payment'])){
                        $payment_vars['number'] = str_replace('.x', '', $this->vars['member']['payment']['number']);
                        $payment_vars['cvc'] = str_replace('.x', '', $this->vars['member']['payment']['cvc']);
                        $payment_vars['expMonth'] = $this->vars['member']['payment']['expMonth'];
                        $payment_vars['expYear'] = $this->vars['member']['payment']['expYear'];
                        $payment_vars['name'] = $this->vars['member']['payment']['name'];
                        $payment_vars['address1'] = $this->vars['member']['payment']['addressLine1'];
                        $payment_vars['address2'] = $this->vars['member']['payment']['addressLine2'];
                        $payment_vars['city'] = $this->vars['member']['payment']['city'];
                        $payment_vars['state'] = $this->vars['member']['payment']['stateProvinceRegion'];
                        $payment_vars['postalCode'] = $this->vars['member']['payment']['zipPostalCode'];
                        $payment_vars['country'] = $this->vars['member']['payment']['country'];
                        
                     }
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