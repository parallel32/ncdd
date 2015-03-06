<? if(!empty($this->vars['member'])): 
   $signed_in = true;
else: 
   $signed_in = false;
endif; ?>
<!-- BEGIN CONTAINER -->   
<div class="page-container row-fluid">
   <!-- BEGIN PAGE CONTAINER-->
   <div class="container-fluid">
      <!-- BEGIN PAGE HEADER-->
         <div class="row-fluid">
            <div class="span12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title text-center">
                  <a href="//<?=SAW_CONSUMER_WEBSITE?>"><img src="/assets/img/ncdd-login2-logo.png"></a>
                  <br/>Seminar Registration Form
               </h3>
               <h3 class="text-center">
                  <?=$this->vars['seminar']['headline']?>
                  <br/><?=$this->vars['seminar']['location']?>
                  <br/><?=$this->vars['seminar']['startDate']['monthDay']?> - <?=$this->vars['seminar']['endDate']['monthDay']?>, <?=$this->vars['seminar']['startDate']['year']?>
               
               </h3>
               <p class="text-center">
                  
                  <br/>National College for DUI Defense, Inc. 
                  <br/>445 S. Decatur St. 
                  <br/>Montgomery, AL 36104
                  <br/>Tel: 334-264-1950 
                  <br/>Fax: 334-264-1920
               </p>
               <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
         </div>
         <!-- END PAGE HEADER-->
         <!-- BEGIN PAGE CONTENT-->
         <div class="row-fluid">
            <div class="span12">
               
               <? if($this->vars['seminar']['register']['currentStatus'] < \Saw\Model\SeminarRegister::$status['OFF']):?>
               <? if(is_array($this->vars['seminar']) && array_key_exists('registerNotice', $this->vars['seminar']) && !empty($this->vars['seminar']['registerNotice'])):?>
               <div class="alert alert-info text-center">
                  <h2><strong>NOTICE:</strong> <br><?=$this->vars['seminar']['registerNotice']?></h2>
               </div>
               <? endif; ?>

               <? if($this->vars['activate_waitlist'] == true): ?>

                  <div class="alert alert-info text-center">
                     <h2><strong>NOTICE:</strong> <br>Registration is currently full.  However, you can still register and be placed on our waiting list.</h2>
                  </div>

               <? endif; ?>


               <? if(!$signed_in):?>
               <!-- BEGIN FORM-->
               <form id="signin-form" class="form-horizontal portlet" novalidate="novalidate">
                  <input type="hidden" name="doc[message]" value="You will be redirected back to the registration form after sign in.">
                  <input type="hidden" name="doc[redirect]" value="/registration/seminar/<?=$this->vars['seminar']['_id']?>/<?=$this->vars['seminar']['slug']?>">

                  <h2 class="form-section"><b>Members, please use your user ID and password to log into the website to receive your discounted NCDD member registration fee.</b></h2>
                  <button type="button" class="btn big blue signin"><i class="icon-key"></i> <b>Click Here to Log-In</b></button>
                  <script>
                     jQuery(document).ready(function() {    
                        $('#signin-form .signin').click(function(e){
                           $(this).html('<i class="icon-key"></i> Please wait...');
                           io.saw.FormPost.activate({postUrl:'/flash/set'
                              ,formName:'#signin-form'
                              ,serializeSelector:':input'
                              ,blockUI:'no'
                              ,postOnComplete:function(responseObj,responseStatus){}
                              ,postOnSuccess:function(responseObj){
                                 document.location.href='/login';
                              }
                           });
                        });
                     });      
                  </script>
               </form>
                  
               <? endif; ?>

               <? if(!$signed_in && $this->vars['seminar']['register']['currentStatus'] == \Saw\Model\SeminarRegister::$status['MEMBERSONLY']):?>

               <? else: ?>
               <form id="saw-form" class="horizontal-form portlet">
                  <input type="hidden" class="seminarId" name="doc[seminarId]" value="<?=$this->vars['seminar']['_id']?>">
                  <input type="hidden" class="memberId" name="doc[memberId]" value="<?=($signed_in) ? $this->vars['member']['_id']: '';?>">
                  <input id="currentPaymentType" type="hidden" name="doc[currentPaymentType]" value="<?/*\Saw\Model\Registration::$paymentType['CREDIT']*/?>">
                  <input id="paymentId" type="hidden" name="doc[paymentId]" value="">
                  
                  <h3 class="form-section">1. Your Information</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Name</label>
                           <div class="controls">
                              <? $middleName = (!empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' '; ?>
                              <input type="text" autocomplete="on" name="doc[name]" value="<?=($signed_in) ? $this->vars['member']['firstName'].$middleName.$this->vars['member']['lastName'] :'' ?>" class="m-wrap span12 name">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Telephone</label>
                           <div class="controls">
                              <input id="phone" type="text" autocomplete="on" name="doc[phone]" value="<?=($signed_in) ? $this->vars['member']['primaryPhone'] :'' ?>" class="m-wrap span12 phone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Facsimile</label>
                           <div class="controls">
                              <input id="fax" type="text" autocomplete="on" name="doc[fax]" value="<?=($signed_in) ? $this->vars['member']['primaryFax'] :'' ?>" class="m-wrap span12 fax">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Bar Number / State</label>
                           <div class="controls">
                              <input type="text" autocomplete="on" name="doc[barNumber]" value="<?=($signed_in) ? $this->vars['member']['barNumber'] :'' ?>" class="m-wrap span12 barNumber">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Email</label>
                           <div class="controls">
                              <input type="text" autocomplete="on" name="doc[email]" value="<?=($signed_in) ? $this->vars['member']['email'] :'' ?>" class="m-wrap span12 email">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!-- BEGIN ADDRESS -->
                  <h3 class="form-section">2. Address</h3>
                  
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 1</label>
                           <div class="controls">
                              <input type="text" autocomplete="on" id="address1" name="doc[address1]" value="<?=($signed_in) ? $this->vars['location']['addressLine1'] :'' ?>" class="m-wrap span12 address1">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 2</label>
                           <div class="controls">
                              <input type="text" autocomplete="on" id="address2" name="doc[address2]" value="<?=($signed_in) ? $this->vars['location']['addressLine2'] :'' ?>" class="m-wrap span12 address2">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >City</label>
                           <div class="controls">
                              <input type="text" autocomplete="on" id="city" name="doc[city]" value="<?=($signed_in) ? $this->vars['location']['city'] :'' ?>" class="m-wrap span12 city"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >State / Province</label>
                           <div class="controls">
                              <input type="text" autocomplete="on" id="state" name="doc[state]" value="<?=($signed_in) ? $this->vars['location']['state'] :'' ?>" class="m-wrap span12 state"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!--/row-->           
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Postal Code</label>
                           <div class="controls">
                              <input type="text" autocomplete="on" id="zip" name="doc[postalCode]" value="<? if($signed_in){if(strlen($this->vars['location']['zip']) < 5){echo str_pad($this->vars['location']['zip'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['location']['zip']) > 5 && strlen($this->vars['location']['zip']) < 9){str_pad($this->vars['location']['zip'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['location']['zip'];}}?>" class="m-wrap span12 postalCode"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Country</label>
                           <div class="controls">
                              <input type="text" autocomplete="on" id="country" name="doc[country]" value="<?=($signed_in) ? $this->vars['location']['country'] :'' ?>" class="m-wrap span12 country"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!-- END ADDRESS -->
                  <h3 class="form-section">3. Registration Details</h3>
                  <? if((is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && is_array($this->vars['seminar']['register']) && array_key_exists('attendanceQuestion',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['attendanceQuestion'] == 'ON') || (is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && is_array($this->vars['seminar']['register']) && !array_key_exists('attendanceQuestion',$this->vars['seminar']['register'])) ): ?>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >How many times have you previously attended this Seminar?</label>
                           <div class="controls">
                              <input type="text" autocomplete="on" name="doc[previouslyAttended]" value="" class="m-wrap span12 previouslyAttended"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? endif; ?>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Name for Name Tag</label>
                           <div class="controls">
                              <input type="text" autocomplete="on" name="doc[nameTag]" value="<?=($signed_in) ? $this->vars['member']['firstName'].$middleName.$this->vars['member']['lastName'] :'' ?>" class="m-wrap span12 nameTag"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? if((is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && is_array($this->vars['seminar']['register']) && array_key_exists('rsvpQuestion',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['rsvpQuestion'] == 'ON') || (is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && is_array($this->vars['seminar']['register']) && !array_key_exists('rsvpQuestion',$this->vars['seminar']['register'])) ): ?>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Attendees Dinner RSVP</label>
                           <div class="controls">
                              <select name="doc[rsvp]" class="span6 m-wrap rsvp">
                                 <option value="1">1</option>
                                 <option value="2">2</option>
                              </select>
                              <span class="help-block">Please enter how many people you would like to RSVP for the dinner (2 maximum).</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? if((is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && is_array($this->vars['seminar']) && array_key_exists('rsvpKidsQuestion',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['rsvpKidsQuestion'] == 'ON') || (is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && is_array($this->vars['seminar']) && !array_key_exists('rsvpKidsQuestion',$this->vars['seminar']['register'])) ): ?>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Children Attendees Dinner RSVP</label>
                           <div class="controls">
                              <select name="doc[rsvpkids]" class="span6 m-wrap rsvpkids">
                                 <option value="0">0</option>
                                 <option value="1">1</option>
                                 <option value="2">2</option>
                                 <option value="3">3</option>
                                 <option value="4">4</option>
                                 <option value="5">5</option>
                              </select>
                              <span class="help-block">Please enter how many children you would like to RSVP for the dinner.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? endif; ?>
                  <? endif; ?>

                  


                  <? if($this->vars['activate_waitlist'] == false): ?>



                     </br></br>
                     <h3 class="form-section">4. Attendance Certification Statement</h3>
                     <div class="row-fluid">
                        <div class="span12 ">
                           <div class="control-group">
                              <label class="control-label">I acknowledge that the National College for DUI Defense does not allow attendance by jurists or prosecutors except upon special written invitation.  Accordingly, I hereby certify that I am not a full time judicial officer or full time prosecutor and that I am actively engaged in the defense of criminal cases.  Any Reference to the Summer Session, for advertising purposes, can only be used as “conducted at Harvard Law School” or “held on premises of Harvard Law School.” Registrant herein accepts and understands he/she cannot infer or use the term of graduated, nor taught at, or attended Harvard Law School. Any such use of the Harvard Law School name is acknowledged to be prohibited.
                              </br>
                              </label>
                              </br>
                              <label class="control-label">By printing your name you acknowledge the above statements.</label>
                              <div class="controls">
                                 <div class="input-prepend input-append">
                                    <span class="add-on">Printed Name </span>
                                    <input name="doc[attendanceCertificationStatement]" class="m-wrap span12 attendanceCertificationStatement" type="text" autocomplete="on" placeholder="">
                                    <span class="add-on">, on this <? $date = new \DateTime(); echo $date->format('dS');?> day of <?echo $date->format('F');?>, 20<?echo $date->format('y');?></span>
                                 </div>
                              </div>
                              
                           </div>
                        </div>
                        <!--/span-->
                     </div>


                     </br></br>
                     <h3 class="form-section">5. Registration Fees</h3>
                     <div class="row-fluid addr ">
                        <div class="span6 ">
                           <div class="control-group">
                              <label class="control-label" >Registration Fee</label>
                              <div class="controls">
                                 <div class="input-prepend input-append">
                                     <span class="add-on">$ </span>
                                        <input id="registration_fee" type="text" autocomplete="on" disabled value="<?=($signed_in) ? $this->vars['seminar']['register']['memberPrice'] :$this->vars['seminar']['register']['nonMemberPrice'] ?>" class="m-wrap span12"> 
                                        <input name="doc[registrationFee]" type="hidden" value="<?=($signed_in) ? $this->vars['seminar']['register']['memberPrice'] :$this->vars['seminar']['register']['nonMemberPrice'] ?>" class="m-wrap span12"> 
                                        <input name="doc[registrationFeeOriginal]" type="hidden" value="<?=($signed_in) ? $this->vars['seminar']['register']['memberPrice'] :$this->vars['seminar']['register']['nonMemberPrice'] ?>" class="m-wrap span12"> 
                                     <span class="add-on">.00</span>
                                 </div>
                                 <span class="help-block">**CD of materials will be included in the registration fee.**</span>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                        <? if(is_array($this->vars['seminar']['register']) && array_key_exists('hardCopyPrice',$this->vars['seminar']['register']) && !empty($this->vars['seminar']['register']['hardCopyPrice'])): ?>
                        <div class="span6 ">
                           <div class="control-group">
                              <label class="control-label" >Would you like to pre-order a hard copy of the materials?</label>
                              <div class="controls">
                                 <select name="doc[hardCopy]" class="span6 m-wrap hardcopyYesNo">
                                    <option value="NO">NO</option>
                                    <option value="YES">YES</option>
                                 </select>
                                 <span class="help-block">If yes, an additional charge of $<?=$this->vars['seminar']['register']['hardCopyPrice']?> will be added.</span>
                                 <input id="hardcopyfee" name="doc[hardCopyFee]" type="hidden" value="<?=$this->vars['seminar']['register']['hardCopyPrice']?>"> 
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                        <? endif; ?>
                     </div>
                     <? if(is_array($this->vars['seminar']['register']) && array_key_exists('deposit',$this->vars['seminar']['register']) && !empty($this->vars['seminar']['register']['deposit'])): ?>
                     <br><br>
                     <div id="deposit-group" class="row-fluid addr ">
                        <div class="span12 ">
                           <div class="control-group">
                              <label class="control-label" >Would you like to make a desposit and pay the remainder later?</label>
                              <div class="controls">
                                 <input style="margin-left:1px;" type="radio" name="doc[depositQuestion]" value="yes">&nbsp;&nbsp;Yes, I would like to make a deposit now and pay the remainder <?=(array_key_exists('depositDueDate',$this->vars['seminar']['register'])) ? 'on '.$this->vars['seminar']['register']['depositDueDate'] :'later' ?>.<br/><br/>
                                 <input style="margin-left:1px;" type="radio" name="doc[depositQuestion]" checked value="no">&nbsp;&nbsp;No thanks, I'll pay in full now.<br/><br/>

                                 <input name="doc[deposit]" id="deposit" type="hidden" value="<?=(array_key_exists('deposit',$this->vars['seminar']['register'])) ? $this->vars['seminar']['register']['deposit'] :'' ?>" class="m-wrap span12"> 
                                 <input name="doc[depositDueDate]" id="depositDueDate" type="hidden" value="<?=(array_key_exists('depositDueDate',$this->vars['seminar']['register'])) ? $this->vars['seminar']['register']['depositDueDate'] :'' ?>" class="m-wrap span12"> 
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <? endif; ?>
                     <br>
                     <div class="row-fluid addr ">
                        <div class="span12 ">
                           <div class="control-group">
                              <label class="control-label" >Total Fee</label>
                              <div class="controls">
                                 <div class="input-prepend input-append">
                                     <span class="add-on">$ </span>
                                        <input name="doc[total]" id="total" type="text" autocomplete="on" disabled value="<?=($signed_in) ? $this->vars['seminar']['register']['memberPrice'] :$this->vars['seminar']['register']['nonMemberPrice'] ?>" class="m-wrap span12"> 
                                        <input name="" id="total_orig" type="hidden" value="<?=($signed_in) ? $this->vars['seminar']['register']['memberPrice'] :$this->vars['seminar']['register']['nonMemberPrice'] ?>" class="m-wrap span12"> 
                                     <span class="add-on">.00</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     </br>
                     
                     

                     <h3 class="form-section">Payment Options</h3>
                     <div class="row-fluid">
                        <div class="span12 ">
                           <? if($this->vars['activate_waitlist'] == false): ?>
                              <button type="button" class="btn blue check">Click to Pay By Check</button>
                              <button type="button" class="btn blue credit">Click to Pay by Credit Card</button>
                              <? if(is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && is_array($this->vars['seminar']['register']) && array_key_exists('scholarship',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['scholarship'] == 'ON'): ?>
                              <button type="button" class="btn purple scholarship">Click to Apply for a Scholarship</button>
                              <? endif; ?>
                           <? endif; ?>

                        </div>
                     </div>
                     <br><br>


                     <!-- PAYMENT ELEMENT -->
                     <style>
                     .card {
                     float: left;
                     width: 39px;
                     height: 25px;
                     text-indent: -9999px;
                     background-position: 0 0;
                     background-repeat: no-repeat;
                     padding-right: 2px;
                     }
                     
                     .card.visa {
                     background-image: url('/assets/img/card-visa.gif');
                     }
                     .card.master {
                     background-image: url('/assets/img/card-mastercard.gif');
                     }
                     .card.amex {
                     background-image: url('/assets/img/card-amex.gif');
                     }
                     .card.discover {
                     background-image: url('/assets/img/card-discover.gif');
                     }
                     </style>
                     <div id="payment-form" class="hide">
                        
                        <input type="hidden" class="memberId" name="doc[payment][memberId]" value="<?=($signed_in) ? $this->vars['member']['_id']: '';?>">
                        <input type="hidden" class="description" name="doc[payment][description]" value="<?='INV-'.time();?>">
                        <input type="hidden" class="title" name="doc[payment][title]" value="<?=$this->vars['seminar']['headline'].' - '.$this->vars['seminar']['location'].' - '.$this->vars['seminar']['startDate']['monthDay'].' - '.$this->vars['seminar']['endDate']['monthDay'].', '.$this->vars['seminar']['startDate']['year']?>">
                        <input type="hidden" class="amount" name="doc[payment][amount]" value="<?=($signed_in) ? $this->vars['seminar']['register']['memberPrice'] :$this->vars['seminar']['register']['nonMemberPrice'] ?>">
                        <input type="hidden" class="cardType" name="doc[payment][cardType]" value="">
                        <input type="hidden" class="token" name="doc[payment][token]" value="">

                        <h3 class="form-section">6. Pay By Credit Card</h3>
                        <p>To pay by check, please scroll to the end of the form and click the blue button.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group">
                                 <label class="control-label" for="type">We Accept</label>
                                 <div class="controls">
                                    <span class="card visa" title="Visa">Visa</span>
                                    <span class="card master" title="Mastercard">Mastercard</span>
                                    <span class="card amex" title="American Express">American Express</span>
                                    <span class="card discover" title="Discover">Discover</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span12 "><span class="cardType"></span></div>
                        </div>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">Your name as it appears on the card</label>
                                 <div class="controls">
                                    <input id="card-name" type="text" autocomplete="on" name="doc[payment][name]" class="m-wrap span8 name" value="<?=($signed_in) ? $this->vars['member']['firstName'].$middleName.$this->vars['member']['lastName']: ''?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">Credit Card Number</label>
                                 <div class="controls">
                                    <input id="card-number" type="text" autocomplete="on" name="doc[payment][number]" class="m-wrap span8 number">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">CVC Code</label>
                                 <div class="controls">
                                    <input id="card-cvc" type="text" autocomplete="on" name="doc[payment][cvc]" class="m-wrap span8 cvc">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">Expiration Date</label>
                                 <div class="controls">
                                    <select id="card-expMonth" class="span4 expMonth" name="doc[payment][expMonth]"></select>
                                    <select id="card-expYear" class="span4 expYear" name="doc[payment][expYear]"></select>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        <h3 class="form-section">Billing Address</h3>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">Address Line 1</label>
                                 <div class="controls">
                                    <input id="card-addressLine1" type="text" autocomplete="on" name="doc[payment][addressLine1]" class="m-wrap span8 addressLine1" value="<?=($signed_in) ? $this->vars['location']['addressLine1']: ''?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">Address Line 2</label>
                                 <div class="controls">
                                    <input id="card-addressLine2" type="text" autocomplete="on" name="doc[payment][addressLine2]" class="m-wrap span8 addressLine2" value="<?=($signed_in) ? $this->vars['location']['addressLine2']: ''?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">City</label>
                                 <div class="controls">
                                    <input id="card-city" type="text" autocomplete="on" name="doc[payment][city]" class="m-wrap span8 city" value="<?=($signed_in) ? $this->vars['location']['city']: ''?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">State/Province/Region</label>
                                 <div class="controls">
                                    <input id="card-stateProvinceRegion" type="text" autocomplete="on" name="doc[payment][stateProvinceRegion]" class="m-wrap span8 stateProvinceRegion" value="<?=($signed_in) ? $this->vars['location']['state']: ''?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">Zip/PostalCode</label>
                                 <div class="controls">
                                    <input id="card-zipPostalCode" type="text" autocomplete="on" name="doc[payment][zipPostalCode]" class="m-wrap span8 zipPostalCode" value="<?if($signed_in){if(strlen($this->vars['location']['zip']) < 5){echo str_pad($this->vars['location']['zip'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['location']['zip']) > 5 && strlen($this->vars['location']['zip']) < 9){str_pad($this->vars['location']['zip'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['location']['zip'];}}?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">Country</label>
                                 <div class="controls">
                                    <input id="card-country" type="text" autocomplete="on" name="doc[payment][country]" class="m-wrap span8 country" value="<?=($signed_in) ? $this->vars['location']['country']: ''?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section">Credit Card Contact Information</h3>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">Email</label>
                                 <div class="controls">
                                    <input id="card-email" type="text" autocomplete="on" name="doc[payment][email]" class="m-wrap span8 email" value="<?=($signed_in) ? $this->vars['member']['email']: ''?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">Phone</label>
                                 <div class="controls">
                                    <input id="card-phone" type="text" autocomplete="on" name="doc[payment][phone]" class="m-wrap span8 phone" value="<?=($signed_in) ? $this->vars['member']['primaryPhone']: ''?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>                     
                     </div>
                     <!--/ PAYMENT ELEMENT -->

                  


                  <? else: ?>
                  


                     <h3 class="form-section">4. Credit Card Information</h3>
                     <h4 class="text-info"><b>Please note, your card will only be charged if a space becomes available.</b></h4>
                     <br>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Your name as it appears on the card</label>
                              <div class="controls">
                                 <input id="card-name" type="text" autocomplete="on" name="doc[payment][name]" class="m-wrap span8 name" value="<?=($signed_in) ? $this->vars['member']['firstName'].$middleName.$this->vars['member']['lastName']: ''?>">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Credit Card Number</label>
                              <div class="controls">
                                 <input id="card-number" type="text" autocomplete="on" name="doc[payment][number]" class="m-wrap span8 number">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">CVC Code</label>
                              <div class="controls">
                                 <input id="card-cvc" type="text" autocomplete="on" name="doc[payment][cvc]" class="m-wrap span8 cvc">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Expiration Date</label>
                              <div class="controls">
                                 <select id="card-expMonth" class="span4 expMonth" name="doc[payment][expMonth]"></select>
                                 <select id="card-expYear" class="span4 expYear" name="doc[payment][expYear]"></select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>

                  <? endif; //end activate waitlist ?>



                  <!-- SUCCESSFUL SAVE MODAL -->
                  <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="save-success-label">Successful Registration</h3>
                     </div>
                     <div class="modal-body">
                        <p></p>
                     </div>
                     <div class="modal-footer">
                        <button class="btn blue continue" data-insertid="">Return to NCDD.com</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->


                  <div  id="payment-form-check" class="hide">
                     <h3 class="form-section">6. Pay By Check</h3>
                     <div class="row-fluid">
                        <div class="span12 ">
                           <h4 class="form-section">Please send a payment to the address below and make it payable to NCDD.</h4>
                           <p class=""><h4>
                              <br/>National College for DUI Defense, Inc. 
                              <br/>445 S. Decatur St. 
                              <br/>Montgomery, AL 36104
                              <br><br/>Tel: 334-264-1950 
                              <br/>Fax: 334-264-1920
                              </h4>
                           </p>
                        </div>
                        <!--/span-->
                     </div>
                  </div>
                  <div  id="payment-form-scholarship" class="hide">
                     <h3 class="form-section">6. Scholarship Registration</h3>
                     <h4 class="form-section">a.</h4>
                     <div class="row-fluid">
                        <div class="span12">
                           <div class="control-group">
                              <label class="control-label">Number of years in law practice:</label>
                              <div class="controls">
                                 <input type="text" name="doc[scholarship][yearsInLawPractice]" class="m-wrap span12 yearsInLawPractice">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <h4 class="form-section">b.</h4>
                     <div class="row-fluid">
                        <div class="span12">
                           <div class="control-group">
                              <label class="control-label">Number of years in the NCDD:</label>
                              <div class="controls">
                                 <input type="text" name="doc[scholarship][yearsInNCDD]" class="m-wrap span12 yearsInNCDD">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <h4 class="form-section">c.</h4>
                     <div class="row-fluid">
                        <div class="span12">
                           <div class="control-group">
                              <label class="control-label">Approximate number of DUI/DWI jury trials and non-jury trials you have handled:</label>
                              <div class="controls">
                                 <select class="small m-wrap numberDUITrialsHandeled" name="doc[scholarship][numberDUITrialsHandeled]">
                                    <option value="10">Fewer than 10</option>
                                    <option value="11">11 to 30</option>
                                    <option value="31">31 or more</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <h4 class="form-section">d.</h4>
                     <div class="row-fluid">
                        <div class="span6 ">
                           <div class="control-group">
                              <label class="control-label">Have you ever been arrested for any crime?</label>
                              <div class="controls">
                                 <select class="small m-wrap everBeenArrested" name="doc[scholarship][everBeenArrested]">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                        <div class="span6 ">
                           <div class="control-group">
                              <label class="control-label">If "Yes", please explain  and provide the final disposition of the case including whether or not you received a "deferred" or "diverted" disposition.</label>
                              <div class="controls">
                                 <textarea rows="5" class="span12 everBeenArrestedExplain" name="doc[scholarship][everBeenArrestedExplain]"></textarea>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <h4 class="form-section">e.</h4>
                     <div class="row-fluid">
                        <div class="span6 ">
                           <div class="control-group">
                              <label class="control-label"><b>(i)</b> Has your Bar Association or licensing authority conducted any investigation or inquiry based upon complaints?</label><br>
                              <label class="control-label"><b>(ii))</b> Have you ever been subject to disciplinary action by your bar association or licensing authority?</label><br>
                              <label class="control-label"><b>(iii)</b> Has your license to practice law ever been suspended or revoked for any period of time?</label><br>
                              <div class="controls">
                                 <select class="small m-wrap everInvestigation" name="doc[scholarship][everInvestigation]">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                        <div class="span6 ">
                           <div class="control-group">
                              <label class="control-label">If your answer is "Yes" to any portion of question 6, please explain:</label>
                              <div class="controls">
                                 <textarea rows="5" class="span12 everInvestigationExplain" name="doc[scholarship][everInvestigationExplain]"></textarea>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <h4 class="form-section">f.</h4>
                     <div class="row-fluid">
                        <div class="span6 ">
                           <div class="control-group">
                              <label class="control-label">Are you presently serving, in any capacity, either part time or full time in a law enforcement or prosecution agency (Example: reserve duty officer or municipal prosecutor)? </label>
                              <div class="controls">
                                 <select class="small m-wrap everLawEnforcement" name="doc[scholarship][everLawEnforcement]">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                        <div class="span6 ">
                           <div class="control-group">
                              <label class="control-label">If "Yes", please explain.</label>
                              <div class="controls">
                                 <textarea rows="5" class="span12 everLawEnforcementExplain" name="doc[scholarship][everLawEnforcementExplain]"></textarea>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <h4 class="form-section">g.</h4>
                     <div class="row-fluid">
                        <div class="span12 ">
                           <div class="control-group">
                              <label class="control-label">Please take a moment to explain your reasons for requesting a scholarship. </label>
                              <div class="controls">
                                 <textarea rows="5" class="span12 reasonForScholarship" name="doc[scholarship][reasonForScholarship]"></textarea>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                        
                     </div>
                  </div>

                  <!-- ERROR -->
                     <div class="alert alert-error hide">
                        <button class="close" data-dismiss="alert"></button>
                        You have some form errors. Please check below.
                     </div>
                     <!--/ ERROR -->
                  
                     <div id="submit-registration-buttons" class="form-actions text-center">
                        <? $user = $this->app['session']->get('user');
                           if(is_array($user) && (array_key_exists('accessLevel', $user) && $user['accessLevel'] == ADMIN) || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )){  
                        ?>
                        <input type="checkbox" name="suppress_emails" <?=(array_key_exists('suppress_emails',$user) && !empty($user['suppress_emails']))?'checked':'';?> value="yes">Suppress Emails.
                        <? } ?>
                        
                        <? if($this->vars['activate_waitlist'] == false): ?>
                           <button type="button" class="btn green submit-registration"><i class="icon-ok"></i> Submit Registration</button>
                        <? else: ?>
                           <button type="button" class="btn blue submit-registration"><i class="icon-ok"></i> Submit Registration for the Waiting List</button>
                        <? endif; ?>
                        
                        <button type="button" class="btn cancel-registration">Cancel and Go Back</button>
                     </div>
               
               </form>
               <!-- END FORM--> 
               
               <? endif; ?>
            <? else: ?>
            <br><h2 class="text-center">Registration for this seminar is no longer available.</h2>
            <? endif; ?>

            </div>
         </div>
         <!-- END PAGE CONTENT-->

   </div>
   <!-- END PAGE CONTAINER -->
</div>
<!-- END CONTAINER -->
<? if($this->vars['seminar']['register']['currentStatus'] < \Saw\Model\SeminarRegister::$status['OFF']):?>

<?=$this->element('js/Registration.js');?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
(function( Payment, $, undefined ) {
   
   var params = {};

   function validateCVC(cvc){
      if(Stripe.validateCVC(cvc.val())){
         cvc.parents('.control-group').removeClass('error');// remove the red highlight
         cvc.next('.help-inline').remove(); // remove the error text
         $('#saw-form .control-group').find('.help-block.error').remove(); // remove help blocks too
      }else{
         // bootstrap field to red with error message
         cvc.parents('.control-group').addClass('error');
         if(cvc.next('.help-inline').length == 0){
            cvc.after('<span class="help-inline">A valid security code is required.</span>');
         }
      }
   }
   function validateCardNumber(card){
      if(Stripe.validateCardNumber(card.val())){
            card.parents('.control-group').removeClass('error');// remove the red highlight
            card.next().remove(); // remove the error text
            $('#saw-form .control-group').find('.help-block.error').remove(); // remove help blocks too
            $('#saw-form .card').css('backgroundPosition','0 -25px');
            switch (Stripe.cardType(card.val())){
               case 'Visa':
                  $('#saw-form .card.visa').css('backgroundPosition','0 0px');
                  break;
               case 'MasterCard':
                  $('#saw-form .card.master').css('backgroundPosition','0 0px');
                  break;
               case 'American Express':
                  $('#saw-form .card.amex').css('backgroundPosition','0 0px');
                  break;
               case 'Discover':
                  $('#saw-form .card.discover').css('backgroundPosition','0 0px');
                  break;         
            }
            $('#saw-form .cardType').html(Stripe.cardType(card.val()));
         }else{
            // bootstrap field to red with error message
            card.parents('.control-group').addClass('error');
            if(card.next('.help-inline').length == 0){
               card.after('<span class="help-inline">A valid card number is required.</span>');
            }
         }
   }
   Payment.initiateRegistration = function () {
      $('.submit-registration').html('<i class="icon-time"></i> Processing your registration..');
      $('.submit-registration').attr("disabled", "disabled");
      io.saw.Registration.doRegistration();     
   }
   Payment.hold_card = '';
   Payment.init = function(){
      
      // validate card number
      $('#saw-form .number').blur(function(){
         validateCardNumber($(this));
      });
      // validate cvc check
      $('#saw-form .cvc').blur(function(){
         validateCVC($(this));
      });
         
   };
   
   
}( io.saw.Payment = io.saw.Payment || {}, io.saw.jQuery || jQuery ));
</script>
<script>
jQuery(document).ready(function() {    
   io.saw.Registration.init();

   // init the credit card fields
   io.saw.Payment.init()
   // prepare the month dropdown
   var select = $("#card-expMonth"),
   month = new Date().getMonth() + 1;
   for (var i = 1; i <= 12; i++) {
      select.append($("<option value='"+i+"' "+(month === i ? "selected" : "")+">"+i+"</option>"))
   }

   // prepare the year dropdown
   var select = $("#card-expYear"),
   year = new Date().getFullYear();

   for (var i = 0; i < 12; i++) {
      select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
   }
   // end - init the credit card fields
   
   // prepare the hard copy change handler to update the total
   $('#saw-form .hardcopyYesNo').change(function(e){
      var hard_copy_fee = <?=($this->vars['seminar']['register']['hardCopyPrice'] > 0) ? $this->vars['seminar']['register']['hardCopyPrice'] : 0?>;
      if($(this).val() == 'YES'){
         $('#total').val(parseInt($('#total').val())+parseInt(hard_copy_fee));
      }else{
         var val = $('#deposit-group input[type=radio]:checked').val();
         if(val=='yes'){
            $('#total').val(parseInt($('#deposit').val()));   
         }else{
            $('#total').val(parseInt($('#total_orig').val()));
         }
         
      }
      $('#saw-form .amount').val($('#total').val());
   });

   // prepare the deposit change handler to update the total
   $('#deposit-group input[type=radio]').change(function(e){
      var val = $('#deposit-group input[type=radio]:checked').val();
      var hard_copy_fee = $('#hardcopyfee').val();
      var hard_copy_set = $('#saw-form .hardcopyYesNo').val();
      
      if(val=='yes'){
         if(hard_copy_set == 'YES'){
            $('#total').val(parseInt($('#deposit').val())+parseInt(hard_copy_fee));
         }else{
            $('#total').val(parseInt($('#deposit').val()));
         }
         
      }
      if(val=='no'){
         if(hard_copy_set == 'YES'){
            $('#total').val(parseInt($('#total_orig').val())+parseInt(hard_copy_fee));  
         }else{
            $('#total').val(parseInt($('#total_orig').val()));  
         }
         
      }
      $('#saw-form .amount').val($('#total').val());
   });

   io.saw.Payment.findPos = function(obj) {
       var curtop = 0;
       if (obj.offsetParent) {
          do {
               curtop += obj.offsetTop;
          } while (obj = obj.offsetParent);

          return [curtop];
      }
   }
   // pay by check button clicked
   $('.btn.check').click(function(e){
      $('#currentPaymentType').val(<?=\Saw\Model\Registration::$paymentType['CHECK']?>);
      $('#payment-form-scholarship').hide("slow");
      $('#payment-form-check').show("slow");
      $('#payment-form').hide("slow");     
      var targetElement = document.getElementById('payment-form-check');
      window.setTimeout(function() {
        window.scroll(0, io.saw.Payment.findPos(targetElement));
      }, 1000);
   });
   // pay by credit card button clicked
   $('.btn.credit').click(function(e){
      $('#currentPaymentType').val(<?=\Saw\Model\Registration::$paymentType['CREDIT']?>);
      $('#payment-form-scholarship').hide("slow");
      $('#payment-form').show("show");
      $('#payment-form-check').hide("slow");      
      var targetElement = document.getElementById('payment-form');
      window.setTimeout(function() {
        window.scroll(0, io.saw.Payment.findPos(targetElement));
      }, 1000);
   });
   // pay by scholarship button clicked
   $('.btn.scholarship').click(function(e){
      $('#currentPaymentType').val(<?=\Saw\Model\Registration::$paymentType['SCHOLARSHIP']?>);
      $('#payment-form-scholarship').show("slow");
      $('#payment-form-check').hide("slow");
      $('#payment-form').hide("slow");      
      var targetElement = document.getElementById('payment-form-scholarship');
      window.setTimeout(function() {
        window.scroll(0, io.saw.Payment.findPos(targetElement));
      }, 1000);
   });
   
});      
</script>
<? endif; ?>