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
               <!-- BEGIN FORM-->
               <form id="saw-form" class="horizontal-form portlet">
                  <input type="hidden" class="registrationId" name="doc[registrationId]" value="<?=$this->vars['registration']['_id']?>">
                  
                  <div class="row-fluid">
                     <div class="span12 ">
                        <h4><?=$this->vars['seminar']['headline']?> - <?=$this->vars['registration']['name']?> - <?=$this->vars['registration']['postalCode']?></h4>
                     </div>
                     <!--/span-->
                  </div>
                  

                  <h3 class="form-section">1. Your Information</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Name</label>
                           <div class="controls">
                              <input type="text" disabled name="doc[name]" value="<?=$this->vars['registration']['name']?>" class="m-wrap span12 name">
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
                              <input id="phone" type="text" disabled name="doc[phone]" value="<?=$this->vars['registration']['phone']?>" class="m-wrap span12 phone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Facsimile</label>
                           <div class="controls">
                              <input id="fax" type="text" disabled name="doc[fax]" value="<?=$this->vars['registration']['fax']?>" class="m-wrap span12 fax">
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
                              <input type="text" disabled name="doc[barNumber]" value="<?=$this->vars['registration']['barNumber']?>" class="m-wrap span12 barNumber">
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
                              <input type="text" disabled name="doc[email]" value="<?=$this->vars['registration']['email']?>" class="m-wrap span12 email">
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
                              <input type="text" disabled id="address1" name="doc[address1]" value="<?=$this->vars['registration']['address1']?>" class="m-wrap span12 address1">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 2</label>
                           <div class="controls">
                              <input type="text" disabled id="address2" name="doc[address2]" value="<?=$this->vars['registration']['address2']?>" class="m-wrap span12 address2">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >City</label>
                           <div class="controls">
                              <input type="text" disabled id="city" name="doc[city]" value="<?=$this->vars['registration']['city']?>" class="m-wrap span12 city"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >State / Province</label>
                           <div class="controls">
                              <input type="text" disabled id="state" name="doc[state]" value="<?=$this->vars['registration']['state']?>" class="m-wrap span12 state"> 
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
                              <input type="text" disabled id="zip" name="doc[postalCode]" value="<?if(strlen($this->vars['registration']['postalCode']) < 5){echo str_pad($this->vars['registration']['postalCode'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['registration']['postalCode']) > 5 && strlen($this->vars['registration']['postalCode']) < 9){str_pad($this->vars['registration']['postalCode'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['registration']['postalCode'];}?>" class="m-wrap span12 postalCode"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Country</label>
                           <div class="controls">
                              <input type="text" disabled id="country" name="doc[country]" value="<?=$this->vars['registration']['country']?>" class="m-wrap span12 country"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!-- END ADDRESS -->
                  <h3 class="form-section">3. Registration Details</h3>
                  <? if((is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) 
                  && array_key_exists('attendanceQuestion',$this->vars['seminar']['register']) 
                  && $this->vars['seminar']['register']['attendanceQuestion'] == 'ON') 
                  || (is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) 
                  && !array_key_exists('attendanceQuestion',$this->vars['seminar']['register'])) ): ?>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >How many times have you previously attended this Seminar?</label>
                           <div class="controls">
                              <input type="text" name="doc[previouslyAttended]" value="<?=(array_key_exists('previouslyAttended',$this->vars['registration'])) ? $this->vars['registration']['previouslyAttended']: '';?>" class="m-wrap span12 previouslyAttended"> 
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
                              <input type="text" disabled name="doc[nameTag]" value="<?=$this->vars['registration']['nameTag']?>" class="m-wrap span12 nameTag"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? if((is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && array_key_exists('rsvpQuestion',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['rsvpQuestion'] == 'ON') || (is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && !array_key_exists('rsvpQuestion',$this->vars['seminar']['register'])) ): ?>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Attendees Dinner RSVP</label>
                           <div class="controls">
                              <input type="text" disabled name="doc[rsvp]" value="<?=$this->vars['registration']['rsvp']?>" class="m-wrap span12 rsvp"> 
                              <span class="help-block">Please enter how many people you would like to RSVP for the dinner (2 maximum).</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? if((is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && array_key_exists('rsvpKidsQuestion',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['rsvpKidsQuestion'] == 'ON') || (is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && !array_key_exists('rsvpKidsQuestion',$this->vars['seminar']['register'])) ): ?>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Children Attendees Dinner RSVP</label>
                           <div class="controls">
                              <input type="text" disabled name="doc[rsvpkids]" value="<?=(array_key_exists('rsvpkids',$this->vars['registration'])) ? $this->vars['registration']['rsvpkids']:'' ?>" class="m-wrap span12 rsvpkids"> 
                              <span class="help-block">Please enter how many children you would like to RSVP for the dinner.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? endif; ?>
                  <? endif; ?>

                  <? if((is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && is_array($this->vars['seminar']) && array_key_exists('electivesQuestion',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['electivesQuestion'] == 'ON') || (is_array($this->vars['seminar']) && is_array($this->vars['seminar']) && array_key_exists('register',$this->vars['seminar']) && is_array($this->vars['seminar']) && !array_key_exists('electivesQuestion',$this->vars['seminar']['register'])) ): ?>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Select your first elective:</label>
                           <div class="controls">
                              <input type="text" disabled name="doc[elective1]" value="<?=(array_key_exists('elective1',$this->vars['registration'])) ? $this->vars['registration']['elective1']:'' ?>" class="m-wrap span12 elective1"> 
                              <span class="help-block"></span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Select your second elective:</label>
                           <div class="controls">
                              <input type="text" disabled name="doc[elective2]" value="<?=(array_key_exists('elective2',$this->vars['registration'])) ? $this->vars['registration']['elective2']:'' ?>" class="m-wrap span12 elective2"> 
                              <span class="help-block"></span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? endif; ?>
                  </br></br>

                  <h3 class="form-section">4. Attendance Certification Statement</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"><?=$this->vars['seminar']['attendanceCertStatement']?>
                           </br>
                           </label>
                           </br>
                           <label class="control-label">By printing your name you acknowledge the above statements.</label>
                           <div class="controls">
                              <input disabled name="doc[attendanceCertificationStatement]" value="<?=$this->vars['registration']['attendanceCertificationStatement']?>" class="m-wrap span12 attendanceCertificationStatement" type="text" placeholder="">
                           </div>
                           
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  </br></br>
                  

               


                  <? if($this->vars['activate_waitlist'] == false): ?>

                  <h3 class="form-section">5. Payment</h3>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Registration Fee</label>
                           <div class="controls">
                              <div class="input-prepend input-append">
                                  <span class="add-on">$ </span>
                                     <input disabled id="registration_fee" value="<?=$this->vars['registration']['registrationFee']?>" type="text" disabled value="" class="m-wrap span12"> 
                                  <span class="add-on">.00</span>
                              </div>
                              <span class="help-block">**CD of materials will be included in the registration fee.**</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <? if(is_array($this->vars['seminar']) && array_key_exists('hardCopyPrice',$this->vars['seminar']['register']) && !empty($this->vars['seminar']['register']['hardCopyPrice'])): ?>
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Would you like to pre-order a hard copy of the materials?</label>
                           <div class="controls">
                              <input id="registration_fee" value="<?=$this->vars['registration']['hardCopy']?>" type="text" disabled value="" class="m-wrap span12"> 
                              <span class="help-block">If yes, an additional charge of $<?=$this->vars['seminar']['register']['hardCopyPrice']?> will be added.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <? endif; ?>
                  </div>
                  <? if(is_array($this->vars['seminar']) && array_key_exists('deposit',$this->vars['seminar']['register']) && !empty($this->vars['seminar']['register']['deposit'])): ?>
                  <br><br>
                  <div id="deposit-group" class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Would you like to make a desposit and pay the remainder later?</label>
                           <div class="controls">
                              <input disabled style="margin-left:1px;" type="radio" name="doc[depositQuestion]" <?=(array_key_exists('depositQuestion',$this->vars['registration'])) ? ($this->vars['registration']['depositQuestion'] == 'yes') ?'checked' :'': '';?> value="yes">&nbsp;&nbsp;Yes, I would like to make a deposit now and pay the remainder <?=(array_key_exists('depositDueDate',$this->vars['seminar']['register'])) ? 'on <b>'.$this->vars['seminar']['register']['depositDueDate'].'</b>' :'later' ?>.<br/><br/>
                              <input disabled style="margin-left:1px;" type="radio" name="doc[depositQuestion]" <?=(array_key_exists('depositQuestion',$this->vars['registration'])) ? ($this->vars['registration']['depositQuestion'] == 'card') ?'checked' :'': '';?> value="card">&nbsp;&nbsp;Yes, I would like to make a deposit now and pay the remainder <?=(array_key_exists('depositDueDate',$this->vars['seminar']['register'])) ? 'on <b>'.$this->vars['seminar']['register']['depositDueDate'].'</b>' :'later' ?> <u>automatically</u> using the credit card, which I will provide below.<br/><br/>
                              <input disabled style="margin-left:1px;" type="radio" name="doc[depositQuestion]" <?=(array_key_exists('depositQuestion',$this->vars['registration'])) ? ($this->vars['registration']['depositQuestion'] == 'no') ?'checked' :'': '';?> value="no">&nbsp;&nbsp;No thanks, I'll pay in full now.<br/><br/>

                              <input name="doc[deposit]" id="deposit" type="hidden" value="<?=(array_key_exists('deposit',$this->vars['seminar']['register'])) ? $this->vars['seminar']['register']['deposit'] :'' ?>" class="m-wrap span12"> 
                              <input name="doc[depositDueDate]" id="depositDueDate" type="hidden" value="<?=(array_key_exists('depositDueDate',$this->vars['seminar']['register'])) ? $this->vars['seminar']['register']['depositDueDate'] :'' ?>" class="m-wrap span12"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? endif; ?>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Total Fee</label>
                           <div class="controls">
                              <div class="input-prepend input-append">
                                  <span class="add-on">$ </span>
                                     <input name="doc[total]" id="total" type="text" disabled value="<?=$this->vars['registration']['total']?>" class="m-wrap span12"> 
                                  <span class="add-on">.00</span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>

                  <?if(array_key_exists('scholarship',$this->vars['registration'])): ?>
                     <h3 class="form-section">6. Scholarship Registration</h3>
                     <h4 class="form-section">a.</h4>
                     <div class="row-fluid">
                        <div class="span12">
                           <div class="control-group">
                              <label class="control-label">Number of years in law practice:</label>
                              <div class="controls">
                                 <input disabled type="text" name="doc[scholarship][yearsInLawPractice]" class="m-wrap span12 yearsInLawPractice" value="<?=$this->vars['registration']['scholarship']['yearsInLawPractice']?>">
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
                                 <input disabled type="text" name="doc[scholarship][yearsInNCDD]" class="m-wrap span12 yearsInNCDD" value="<?=$this->vars['registration']['scholarship']['yearsInNCDD']?>">
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
                                 <select disabled class="small m-wrap numberDUITrialsHandeled" name="doc[scholarship][numberDUITrialsHandeled]">
                                    <option value="10" <?=($this->vars['registration']['scholarship']['numberDUITrialsHandeled'] == 10) ? 'selected':''?>>Fewer than 10</option>
                                    <option value="11" <?=($this->vars['registration']['scholarship']['numberDUITrialsHandeled'] == 11) ? 'selected':''?>>11 to 30</option>
                                    <option value="31" <?=($this->vars['registration']['scholarship']['numberDUITrialsHandeled'] == 31) ? 'selected':''?>>31 or more</option>
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
                                 <select disabled class="small m-wrap everBeenArrested" name="doc[scholarship][everBeenArrested]">
                                    <option value="no" <?=($this->vars['registration']['scholarship']['everBeenArrested']=='no') ? 'selected':''?>>No</option>
                                    <option value="yes" <?=($this->vars['registration']['scholarship']['everBeenArrested']=='yes') ? 'selected':''?>>Yes</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                        <div class="span6 ">
                           <div class="control-group">
                              <label class="control-label">If "Yes", please explain  and provide the final disposition of the case including whether or not you received a "deferred" or "diverted" disposition.</label>
                              <div class="controls">
                                 <p><?=$this->vars['registration']['scholarship']['everBeenArrestedExplain']?></p>
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
                                 <select disabled class="small m-wrap everInvestigation" name="doc[scholarship][everInvestigation]">
                                    <option value="no" <?=($this->vars['registration']['scholarship']['everInvestigation']=='no') ? 'selected':''?>>No</option>
                                    <option value="yes" <?=($this->vars['registration']['scholarship']['everInvestigation']=='yes') ? 'selected':''?>>Yes</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                        <div class="span6 ">
                           <div class="control-group">
                              <label class="control-label">If your answer is "Yes" to any portion of question 6, please explain:</label>
                              <div class="controls">
                                 <p><?=$this->vars['registration']['scholarship']['everInvestigationExplain']?></p>
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
                                 <select disabled class="small m-wrap everLawEnforcement" name="doc[scholarship][everLawEnforcement]">
                                    <option value="no" <?=($this->vars['registration']['scholarship']['everLawEnforcement']=='no') ? 'selected':''?>>No</option>
                                    <option value="yes" <?=($this->vars['registration']['scholarship']['everLawEnforcement']=='yes') ? 'selected':''?>>Yes</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                        <div class="span6 ">
                           <div class="control-group">
                              <label class="control-label">If "Yes", please explain.</label>
                              <div class="controls">
                                 <p><?=$this->vars['registration']['scholarship']['everLawEnforcementExplain']?></p>
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
                                 <p><?=$this->vars['registration']['scholarship']['reasonForScholarship']?></p>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                        
                     </div>


                  <? endif; ?>

               <? else: /*waitlist else*/?>

                  <h3 class="form-section">5. Credit Card Information</h3>
                     <h4 class="text-info"><b>Please note, your card will only be charged if a space becomes available.</b></h4>
                     <br>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Your name as it appears on the card</label>
                              <div class="controls">
                                 <input id="card-name" type="text" autocomplete="on" name="doc[payment][name]" class="m-wrap span8 name" value="<?=(array_key_exists('tempPayment', $this->vars['registration']) && is_array($this->vars['registration']['tempPayment'])) ? $this->vars['registration']['tempPayment']['name']:'' ;?>">
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
                                 <input id="card-number" type="text" autocomplete="on" name="doc[payment][number]" class="m-wrap span8 number" value="<?=(array_key_exists('tempPayment', $this->vars['registration']) && is_array($this->vars['registration']['tempPayment'])) ? $this->vars['registration']['tempPayment']['number']:'' ;?>">
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
                                 <input id="card-cvc" type="text" autocomplete="on" name="doc[payment][cvc]" class="m-wrap span8 cvc" value="<?=(array_key_exists('tempPayment', $this->vars['registration']) && is_array($this->vars['registration']['tempPayment'])) ? $this->vars['registration']['tempPayment']['cvc']:'' ;?>">
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
                     <script>
                     jQuery(document).ready(function() { 

                        // prepare the month dropdown
                        var select = $("#saw-form .expMonth"),
                        month = new Date().getMonth() + 1;
                        for (var i = 1; i <= 12; i++) {
                           select.append($("<option value='"+i+"' "+(month === i ? "selected" : "")+">"+i+"</option>"))
                        }

                        // prepare the year dropdown
                        var select = $("#saw-form .expYear"),
                        year = new Date().getFullYear();

                        for (var i = 0; i < 12; i++) {
                           select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
                        }  
                        
                        <?
                        $expMonth = (array_key_exists('tempPayment', $this->vars['registration']) && is_array($this->vars['registration']['tempPayment'])) ? $this->vars['registration']['tempPayment']['expMonth']:'' ;
                        $expYear = (array_key_exists('tempPayment', $this->vars['registration']) && is_array($this->vars['registration']['tempPayment'])) ? $this->vars['registration']['tempPayment']['expYear']:'' ;
                        ?>
                        <? if(isset($expMonth) && !empty($expMonth)): ?>
                           // STORE CARD STUFF
                           var smonth = '<?=$expMonth?>';
                           var syear = '<?=$expYear?>';
                           $('#card-expMonth option[value='+smonth+']').attr('selected', 'selected');
                           $('#card-expYear option[value='+syear+']').attr('selected', true);
                        <? endif; ?>
                     });      
                     </script>
               <? endif; // activate wait list ?>




                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  
                  <div class="form-actions text-center">
                     <? $user = $this->app['session']->get('user');
                        if($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )){  
                     ?>
                     <input type="checkbox" name="suppress_emails" <?=(array_key_exists('suppress_emails',$user) && !empty($user['suppress_emails']))?'checked':'';?> value="yes">Suppress Emails.
                     <? } ?>

                     <? if($this->vars['registration']['currentStatus'] < \Saw\Model\Registration::$status['PAID'] && $this->vars['activate_waitlist'] == false): ?>
                     <? if(array_key_exists('cardOnFile', $this->vars['registration']) && !empty($this->vars['registration']['cardOnFile'])){?>
                        <a class="btn green pay" href="/registration/seminar/<?=$this->vars['registration']['_id']?>/pay"><i class="icon-money"></i> Mark Paid</a>
                     <? } else { ?>
                        <a class="btn green pay" href="/registration/seminar/<?=$this->vars['registration']['_id']?>/pay-other"><i class="icon-money"></i> Mark Paid</a>
                     <? } ?>
                     <? endif; ?>
                     <? if ($this->vars['activate_waitlist'] == true): ?>
                     <button type="button" data-id="<?=$this->vars['registration']['_id']?>" class="btn blue offwaitlist"><i class="icon-info"></i> Move Member Off Wait List</button>
                     <? endif; ?>
                     <button type="button" data-id="<?=$this->vars['registration']['_id']?>" class="btn blue edit"><i class="icon-pencil"></i> Edit</button>
                     <button type="button" data-id="<?=$this->vars['seminar']['_id']?>" class="btn view cancel">Cancel and Go Back</button>
                     <? if(array_key_exists('scholarship',$this->vars['registration']) && $this->vars['registration']['scholarship']['currentStatus'] < \Saw\Model\Scholarship::$status['APPROVED']): ?>
                     <button type="button" data-id="<?=$this->vars['registration']['scholarship']['_id']?>" data-type="" class="btn green approve"><i class="icon-ok"></i> Approve Scholarship</button>
                     <? endif; ?>
                     <? if($this->vars['registration']['currentStatus'] <= \Saw\Model\Registration::$status['SCHOLARSHIP']): ?>
                     <button type="button" data-id="<?=$this->vars['registration']['_id']?>" class="btn red delete">Delete</button>
                     <? endif; ?>
                  </div>
               </form>
                  <!-- END FORM--> 

                  <!-- SUCCESSFUL SAVE MODAL -->
                  <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="save-success-label">Successful Operation</h3>
                     </div>
                     <div class="modal-body">
                        <p></p>
                     </div>
                     <div class="modal-footer">
                        <button class="btn blue continue" data-insertid="">Continue</button>
                        <button class="btn cancel" data-insertid="">Cancel</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->
                  <!-- DELETE MODAL -->
                  <div id="delete-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="delete-modal-label">Are you sure you want to delete this?</h3>
                     </div>
                     <div class="modal-body">
                        <p>This delete action cannot be undone.</p>
                     </div>
                     <div class="modal-footer">
                        <button class="btn red delete" data-seminar-id="<?=$this->vars['seminar']['_id']?>" data-id="<?=$this->vars['registration']['_id']?>">Yes, Delete it.</button>
                        <button class="btn cancel">Cancel</button>
                     </div>
                  </div>
                  <!--/ DELETE MODAL -->   



            </div>
         </div>
         <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
      <?=$this->element('js/Registration.js');?>
      <?=$this->element('js/Scholarship.js');?>
      <script>
      jQuery(document).ready(function() {
         io.saw.Registration.manageInit();
         io.saw.Scholarship.approveInitSpecial();
      });
      </script>