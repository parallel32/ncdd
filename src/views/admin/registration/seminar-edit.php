<? if(!empty($this->vars['member'])): 
   $signed_in = true;
else: 
   $signed_in = false;
endif; ?>
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
                  <input type="hidden" name="doc[_id]" value="<?=$this->vars['registration']['_id']?>">
                  <input type="hidden" name="doc[class]" value="<?=$this->vars['registration']['class']?>">
                  
                  <h3 class="form-section">1. Your Information</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Name</label>
                           <div class="controls">
                              <input type="text" name="doc[name]" value="<?=$this->vars['registration']['name']?>" class="m-wrap span12 name">
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
                              <input id="phone" type="text" name="doc[phone]" value="<?=$this->vars['registration']['phone']?>" class="m-wrap span12 phone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Facsimile</label>
                           <div class="controls">
                              <input id="fax" type="text" name="doc[fax]" value="<?=$this->vars['registration']['fax']?>" class="m-wrap span12 fax">
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
                              <input type="text" name="doc[barNumber]" value="<?=$this->vars['registration']['barNumber']?>" class="m-wrap span12 barNumber">
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
                              <input type="text" name="doc[email]" value="<?=$this->vars['registration']['email']?>" class="m-wrap span12 email">
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
                              <input type="text" id="address1" name="doc[address1]" value="<?=$this->vars['registration']['address1']?>" class="m-wrap span12 address1">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 2</label>
                           <div class="controls">
                              <input type="text" id="address2" name="doc[address2]" value="<?=$this->vars['registration']['address2']?>" class="m-wrap span12 address2">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >City</label>
                           <div class="controls">
                              <input type="text" id="city" name="doc[city]" value="<?=$this->vars['registration']['city']?>" class="m-wrap span12 city"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >State / Province</label>
                           <div class="controls">
                              <input type="text" id="state" name="doc[state]" value="<?=$this->vars['registration']['state']?>" class="m-wrap span12 state"> 
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
                              <input type="text" id="zip" name="doc[postalCode]" value="<?if(strlen($this->vars['registration']['postalCode']) < 5){echo str_pad($this->vars['registration']['postalCode'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['registration']['postalCode']) > 5 && strlen($this->vars['registration']['postalCode']) < 9){str_pad($this->vars['registration']['postalCode'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['registration']['postalCode'];}?>" class="m-wrap span12 postalCode"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Country</label>
                           <div class="controls">
                              <input type="text" id="country" name="doc[country]" value="<?=$this->vars['registration']['country']?>" class="m-wrap span12 country"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!-- END ADDRESS -->
                  <h3 class="form-section">3. Registration Details</h3>
                  <? if((array_key_exists('register',$this->vars['seminar']) && array_key_exists('attendanceQuestion',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['attendanceQuestion'] == 'ON') || (array_key_exists('register',$this->vars['seminar']) && !array_key_exists('attendanceQuestion',$this->vars['seminar']['register'])) ): ?>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >How many times have you previously attended this Seminar?</label>
                           <div class="controls">
                              <input type="text" name="doc[previouslyAttended]" value="<?=$this->vars['registration']['previouslyAttended']?>" class="m-wrap span12 previouslyAttended"> 
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
                              <input type="text" name="doc[nameTag]" value="<?=$this->vars['registration']['nameTag']?>" class="m-wrap span12 nameTag"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? if((array_key_exists('register',$this->vars['seminar']) && array_key_exists('rsvpQuestion',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['rsvpQuestion'] == 'ON') || (array_key_exists('register',$this->vars['seminar']) && !array_key_exists('rsvpQuestion',$this->vars['seminar']['register'])) ): ?>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Attendees Dinner RSVP</label>
                           <div class="controls">
                              <select name="doc[rsvp]" class="span6 m-wrap rsvp">
                                 <option <?=($this->vars['registration']['rsvp'] == 1) ? 'selected': ''?> value="1">1</option>
                                 <option <?=($this->vars['registration']['rsvp'] == 2) ? 'selected': ''?> value="2">2</option>
                              </select>
                              <span class="help-block">Please enter how many people you would like to RSVP for the dinner (2 maximum).</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? if((array_key_exists('register',$this->vars['seminar']) && array_key_exists('rsvpKidsQuestion',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['rsvpKidsQuestion'] == 'ON') || (array_key_exists('register',$this->vars['seminar']) && !array_key_exists('rsvpKidsQuestion',$this->vars['seminar']['register'])) ): ?>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Children Attendees Dinner RSVP</label>
                           <div class="controls">
                              <select name="doc[rsvpkids]" class="span6 m-wrap rsvpkids">
                                 <option <?=(array_key_exists('rsvpkids',$this->vars['registration']) && $this->vars['registration']['rsvpkids'] == 0) ? 'selected': ''?> value="0">0</option>
                                 <option <?=(array_key_exists('rsvpkids',$this->vars['registration']) && $this->vars['registration']['rsvpkids'] == 1) ? 'selected': ''?> value="1">1</option>
                                 <option <?=(array_key_exists('rsvpkids',$this->vars['registration']) && $this->vars['registration']['rsvpkids'] == 2) ? 'selected': ''?> value="2">2</option>
                                 <option <?=(array_key_exists('rsvpkids',$this->vars['registration']) && $this->vars['registration']['rsvpkids'] == 3) ? 'selected': ''?> value="3">3</option>
                                 <option <?=(array_key_exists('rsvpkids',$this->vars['registration']) && $this->vars['registration']['rsvpkids'] == 4) ? 'selected': ''?> value="4">4</option>
                                 <option <?=(array_key_exists('rsvpkids',$this->vars['registration']) && $this->vars['registration']['rsvpkids'] == 5) ? 'selected': ''?> value="5">5</option>
                              </select>
                              <span class="help-block">Please enter how many children you would like to RSVP for the dinner.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? endif; ?>
                  <? endif; ?>
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
                              <input name="doc[attendanceCertificationStatement]" value="<?=$this->vars['registration']['attendanceCertificationStatement']?>" class="m-wrap span12 attendanceCertificationStatement" type="text" placeholder="">
                           </div>
                           
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  </br></br>
                  <h3 class="form-section">5. Payment</h3>
                  <? if(array_key_exists('register',$this->vars['seminar']) && array_key_exists('scholarship',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['scholarship'] == 'ON'): ?>
                  <h4>Scholarship</h4>
                  <div id="scholarship-group" class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >If you've applied for a scholarship, please enter your scholarship's registration number below:</label>
                           <div class="controls">
                              <input name="doc[registrationNumber]" id="registrationNumber" type="text" disabled value="<?=$this->vars['registration']['registrationNumber']?>" class="m-wrap span4">
                              <span class="help-block">Cannot edit this field because it was already validated to be correct on the seminar registration form.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? endif; ?>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Registration Fee</label>
                           <div class="controls">
                              <div class="input-prepend input-append">
                                  <span class="add-on">$ </span>
                                     <input id="registration_fee" name="doc[registrationFee]" value="<?=$this->vars['registration']['registrationFee']?>" type="text" class="m-wrap span12"> 
                                  <span class="add-on">.00</span>
                              </div>
                              <span class="help-block">**CD of materials will be included in the registration fee.**</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <? if(array_key_exists('hardCopyPrice',$this->vars['seminar']['register']) && !empty($this->vars['seminar']['register']['hardCopyPrice'])): ?>
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Would you like to pre-order a hard copy of the materials?</label>
                           <div class="controls">
                              <select name="doc[hardCopy]" class="span6 m-wrap hardcopyYesNo">
                                 <option value="NO" <?=($this->vars['registration']['hardCopy'] == 'NO') ?'selected' :'' ;?>>NO</option>
                                 <option value="YES" <?=($this->vars['registration']['hardCopy'] == 'YES') ?'selected' :'' ;?>>YES</option>
                              </select>
                              <input id="hardcopyfee" name="doc[hardCopyFee]" type="hidden" value="<?=$this->vars['seminar']['register']['hardCopyPrice']?>"> 
                              <span class="help-block">If yes, an additional charge of $<?=$this->vars['seminar']['register']['hardCopyPrice']?> will be added.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <? endif; ?>
                  </div>
                  <? if(array_key_exists('deposit',$this->vars['seminar']['register']) && !empty($this->vars['seminar']['register']['deposit'])): ?>
                  <br><br>
                  <div id="deposit-group" class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Would you like to make a desposit and pay the remainder later?</label>
                           <div class="controls">
                              <input style="margin-left:1px;" type="radio" name="doc[depositQuestion]" <?=($this->vars['registration']['depositQuestion'] == 'yes') ?'checked' :'' ;?> value="yes">&nbsp;&nbsp;Yes, I would like to make a deposit now and pay the remainder <?=(array_key_exists('depositDueDate',$this->vars['seminar']['register'])) ? 'on '.$this->vars['seminar']['register']['depositDueDate'] :'later' ?>.<br/><br/>
                              <input style="margin-left:1px;" type="radio" name="doc[depositQuestion]" <?=($this->vars['registration']['depositQuestion'] == 'no') ?'checked' :'' ;?> value="no">&nbsp;&nbsp;No thanks, I'll pay in full now.<br/><br/>

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
                                     <input name="doc[total]" id="total" type="text" value="<?=$this->vars['registration']['total']?>" class="m-wrap span12"> 
                                     <input name="" id="total_orig" type="hidden" value="<?=($signed_in) ? $this->vars['seminar']['register']['memberPrice'] :$this->vars['seminar']['register']['nonMemberPrice'] ?>" class="m-wrap span12"> 
                                  <span class="add-on">.00</span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="alert alert-error hide">
                        <button class="close" data-dismiss="alert"></button>
                        You have some form errors. Please check below.
                     </div>
                     
                     <div class="form-actions text-center">
                        <button type="button" data-id="<?=$this->vars['registration']['_id']?>" class="btn green save"><i class="icon-pencil"></i> Save Changes</button>
                        <button type="button" data-id="<?=$this->vars['registration']['_id']?>" class="btn edit cancel">Cancel and Go Back</button>
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
                        <button class="btn blue continue">Edit Again</button>
                        <button class="btn continue finished" data-seminar-id="<?=$this->vars['seminar']['_id']?>">Back To Registrations</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->

            </div>
         </div>
         <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
      <?=$this->element('js/Registration.js');?>
      <script>
      jQuery(document).ready(function() {
         io.saw.Registration.manageInit();
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
         });

      });
      </script>