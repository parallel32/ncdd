<? $seminar = $this->vars['seminar']; ?>
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
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box blue">
                     <div class="portlet-title">
                        <h4><i class="icon-facetime-video"></i> Edit Seminar</h4>
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form id="saw-form" class="form-horizontal" novalidate="novalidate">
                           <input type="hidden" name="doc[_id]" value="<?=$seminar['_id']?>">
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                                 <div class="alert alert-error hide">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Headline<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[headline]" value="<?=$seminar['headline']?>" data-required="1" class="span6 m-wrap headline">
                                       <span class="help-block" id="headline-slug"><?=(array_key_exists('slug',$seminar)) ? '/seminar/'.$seminar['slug']: '';?></span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Location<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[location]" value="<?=(array_key_exists('location',$seminar)) ? $seminar['location']: '';?>" data-required="1" class="span6 m-wrap location">
                                       <span class="help-block">Enter the place where the seminar will be held.</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Start Date<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[startDate]" value="<?=$seminar['startDate']['detail']?>" data-required="1" class="span6 m-wrap startDate" value="">
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">End Date<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[endDate]" value="<?=$seminar['endDate']['detail']?>" data-required="1" class="span6 m-wrap endDate">
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Time Zone<span class="required">*</span></label>
                                    <div class="controls">
                                       <? 
                                          $tz = array('America/New_York'=>'Eastern'
                                                      ,'America/Chicago'=>'Central'
                                                      ,'America/Denver'=>'Mountain'
                                                      ,'America/Los_Angeles'=>'Pacific'
                                                      ,'America/Anchorage'=>'Alaska'
                                                      ,'America/Adak'=>'Hawaii'
                                                );

                                       ?>
                                       <select name="doc[timeZone]" class="span6 m-wrap timeZone" data-placeholder="Choose a Category" tabindex="1">
                                          <? foreach($tz as $key=>$value): ?>
                                             <option value="<?=$key?>" <?=($key == $seminar['timeZone']) ? "selected" : "";?>><?=$value?></option>
                                          <? endforeach; ?>
                                       </select>
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                                 
                              </div>
                           </div>

                           <h3 class="form-section text-info"><strong>Description</strong>&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.get('body').execCommand('mcefocus',true);">Click to Edit</a></h3>
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                              <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 50px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                              <div id="body" class="span12 editable" style="margin-left:0px;">
                                 <?=$seminar['description']?>
                              </div>
                              <input id="input-body" type="hidden" name="doc[description]" value="">
                                 
                              </div>
                              <!--/span-->
                           </div>
                           
                           
                           <div class="form-actions">
                              <button type="button" class="btn green">Save</button>
                              <button type="button" class="btn cancel">Cancel</button>
                              <button type="button" class="btn blue manage">Manage Agendas</button>
                              <button type="button" class="btn red image <?=($this->vars['image'] == '/noimage') ? 'hide' :'' ?>">Delete Image</button>
                           </div>
                        </form>
                        <form id="saw-slug" class="form-horizontal" novalidate="novalidate">
                           <input type="hidden" id="slug-str" name="slug-str">
                        </form>
                        <!-- END FORM-->

                        <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h3 id="save-success-label">Successful Operation</h3>
                           </div>
                           <div class="modal-body">
                              <p></p>
                           </div>
                           <div class="modal-footer">
                              <button class="btn finished" aria-hidden="true">Finished</button>
                              <button class="btn blue continue" data-insertid="">Edit Again</button>
                           </div>
                        </div>

                     </div>
                  </div>
                  <!-- END VALIDATION STATES-->
               </div>
            </div>
            <!-- END PAGE CONTENT-->

            <!-- BEGIN REGISTRATION -->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN PORTLET -->
                  <div class="portlet box blue">
                     <div class="portlet-title">
                        <h4><i class="icon-facetime-video"></i> Edit Seminar Registration</h4>
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form id="register-form" class="form-horizontal" novalidate="novalidate">
                           <input type="hidden" name="doc[_id]" value="<?=$seminar['_id']?>">
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                                 <div class="alert alert-error hide">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Registration Notice</label>
                                    <div class="controls">
                                      <input type="text" name="doc[registerNotice]" value="<?=(array_key_exists('registerNotice',$seminar)) ? $seminar['registerNotice'] : '';?>" data-required="1" class="span12 m-wrap registerNotice">
                                      <span class="help-block">If filled in, this will place a large blue banner above the registration fields.</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Activate Registration</label>
                                    <div class="controls">
                                       <select name="doc[register][currentStatus]" class="span6 m-wrap currentStatus" data-placeholder="Choose a Category" tabindex="1">
                                          <option value="<?=\Saw\Model\SeminarRegister::$status['OFF']?>" <?=(array_key_exists('register',$seminar) && array_key_exists('currentStatus',$seminar['register'])) ? (\Saw\Model\SeminarRegister::$status['OFF'] == $seminar['register']['currentStatus']) ? "selected" : "" : '';?>><?=\Saw\Model\SeminarRegister::$statusReversed[\Saw\Model\SeminarRegister::$status['OFF']]?></option>
                                          <option value="<?=\Saw\Model\SeminarRegister::$status['MEMBERSONLY']?>" <?=(array_key_exists('register',$seminar) && array_key_exists('currentStatus',$seminar['register'])) ? (\Saw\Model\SeminarRegister::$status['MEMBERSONLY'] == $seminar['register']['currentStatus']) ? "selected" : "" : '';?>><?=\Saw\Model\SeminarRegister::$statusReversed[\Saw\Model\SeminarRegister::$status['MEMBERSONLY']]?></option>
                                          <option value="<?=\Saw\Model\SeminarRegister::$status['ON']?>" <?=(array_key_exists('register',$seminar) && array_key_exists('currentStatus',$seminar['register'])) ? (\Saw\Model\SeminarRegister::$status['ON'] == $seminar['register']['currentStatus']) ? "selected" : "" : '';?>><?=\Saw\Model\SeminarRegister::$statusReversed[\Saw\Model\SeminarRegister::$status['ON']]?></option>
                                       </select>
                                       <span class="help-block">Turn online registration ON / OFF</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Member Price</label>
                                    <div class="controls">
                                      <div class="input-prepend input-append">
                                        <span class="add-on">$ </span>
                                           <input type="text" name="doc[register][memberPrice]" value="<?=(array_key_exists('register',$seminar)&& array_key_exists('memberPrice',$seminar['register'])) ? $seminar['register']['memberPrice'] : '';?>" data-required="1" class="span6 m-wrap memberPrice">
                                        <span class="add-on">.00</span>
                                      </div>
                                      <span class="help-block">Enter the dollar amount to charge for members.</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Non-Member Price</label>
                                    <div class="controls">
                                      <div class="input-prepend input-append">
                                        <span class="add-on">$ </span>
                                           <input type="text" name="doc[register][nonMemberPrice]" value="<?=(array_key_exists('register',$seminar)&& array_key_exists('nonMemberPrice',$seminar['register'])) ? $seminar['register']['nonMemberPrice'] : '';?>" data-required="1" class="span6 m-wrap nonMemberPrice">
                                        <span class="add-on">.00</span>
                                      </div>
                                      <span class="help-block">Enter the dollar amount to charge for non-members.</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Hard Copy Price</label>
                                    <div class="controls">
                                      <div class="input-prepend input-append">
                                        <span class="add-on">$ </span>
                                           <input type="text" name="doc[register][hardCopyPrice]" value="<?=(array_key_exists('register',$seminar) && array_key_exists('hardCopyPrice',$seminar['register'])) ? $seminar['register']['hardCopyPrice'] : '';?>" data-required="1" class="span6 m-wrap hardCopyPrice">
                                        <span class="add-on">.00</span>
                                      </div>
                                      <span class="help-block">Enter the dollar amount to charge for the materials hard copy.  <br>If you leave blank then it will not show up on the registration form.</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Deposit Price</label>
                                    <div class="controls">
                                      <div class="input-prepend input-append">
                                        <span class="add-on">$ </span>
                                           <input type="text" name="doc[register][deposit]" value="<?=(array_key_exists('register',$seminar) && array_key_exists('deposit',$seminar['register'])) ? $seminar['register']['deposit'] : '';?>" data-required="1" class="span6 m-wrap deposit">
                                        <span class="add-on">.00</span>
                                      </div>
                                      <span class="help-block">Enter the dollar amount for the deposit minimum.  <br>If you leave blank then it will not show up on the registration form.</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Deposit Remainder DueDate</label>
                                    <div class="controls">
                                       <input type="text" name="doc[register][depositDueDate]" value="<?=(array_key_exists('register',$seminar) && array_key_exists('depositDueDate',$seminar['register'])) ? $seminar['register']['depositDueDate'] : '';?>" data-required="1" class="span6 m-wrap depositDueDate">
                                      <span class="help-block">Type in a date like: June 15.</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Activate Scholarships</label>
                                    <div class="controls">
                                       <select name="doc[register][scholarship]" class="span6 m-wrap currentStatus" data-placeholder="Choose a Category" tabindex="1">
                                          <option value="OFF" <?=(array_key_exists('register',$seminar) && array_key_exists('scholarship',$seminar['register'])) ? ('OFF' == $seminar['register']['scholarship']) ? "selected" : "" : '';?>>OFF</option>
                                          <option value="ON" <?=(array_key_exists('register',$seminar) && array_key_exists('scholarship',$seminar['register'])) ? ('ON' == $seminar['register']['scholarship']) ? "selected" : "" : '';?>>ON</option>
                                       </select>
                                       <span class="help-block">Turn ON / OFF; applying for scholarships and registering with scholarships</span>
                                    </div>
                                 </div>
                                 
                              </div>
                           </div>

                           <h3 class="form-section">Registration Confirmation Letter&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.get('body-confletter').execCommand('mcefocus',true);">Click to Edit</a></h3>
                           <div class="alert alert-info"><p><b>Notice:</b> To include the registration total in the confirmation letter, type <b>#total#</b> below.  Reason being, it will vary depending on the price feilds above.<br>Also,it will be formatted with the dollar sign so you don't have to include that.</p>
                           </div>
                           <hr>
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                              <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 50px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                              <div id="body-confletter" class="span12 editable" style="margin-left:0px;">
                                 <?=(array_key_exists('register',$seminar)) ? (array_key_exists('confirmationLetter',$seminar['register'])) ? $seminar['register']['confirmationLetter'] : '' : '';?>
                              </div>
                              <input id="input-body-confletter" type="hidden" name="doc[register][confirmationLetter]" value="">
                                 
                              </div>
                              <!--/span-->
                           </div>
                           
                           
                           <h3 class="form-section">Registration Confirmation Letter for Deposit&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.get('body-deposit-confletter').execCommand('mcefocus',true);">Click to Edit</a></h3>
                           <div class="alert alert-info"><p><b>Notice:</b> To include the registration total in the confirmation letter, type <b>#total#</b> below.  Reason being, it will vary depending on the price feilds above.<br>Also,it will be formatted with the dollar sign so you don't have to include that.</p>
                              <p>To include the depoosit specific information include these variables:
                                 <br>Registration balance due: <b>#balance_due#</b> (this will be formatted with the dollar sign, so you don't have to include it)
                                 <br>Registration balance due date: <b>#balance_due_date#</b>
                                 <br>Registration payment link: <b>#payment_link#</b> (this will be made into a clickable link automatically)

                              </p>
                           </div>
                           <hr>
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                              <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 50px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                              <div id="body-deposit-confletter" class="span12 editable" style="margin-left:0px;">
                                 <?=(array_key_exists('register',$seminar)) ? (array_key_exists('depositConfirmationLetter',$seminar['register'])) ? $seminar['register']['depositConfirmationLetter'] : '' : '';?>
                              </div>
                              <input id="input-body-deposit-confletter" type="hidden" name="doc[register][depositConfirmationLetter]" value="">
                                 
                              </div>
                              <!--/span-->
                           </div>
                           

                           <h3 class="form-section">Registration Confirmation Letter for Scholarship&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.get('body-scholarship-confletter').execCommand('mcefocus',true);">Click to Edit</a></h3>
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                              <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 50px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                              <div id="body-scholarship-confletter" class="span12 editable" style="margin-left:0px;">
                                 <?=(array_key_exists('register',$seminar)) ? (array_key_exists('scholarshipConfirmationLetter',$seminar['register'])) ? $seminar['register']['scholarshipConfirmationLetter'] : '' : '';?>
                              </div>
                              <input id="input-body-scholarship-confletter" type="hidden" name="doc[register][scholarshipConfirmationLetter]" value="">
                                 
                              </div>
                              <!--/span-->
                           </div>
                           

                           <div class="form-actions">
                              <button type="button" class="btn green">Save</button>
                              <button type="button" class="btn cancel">Cancel</button>
                           </div>
                        </form>
                        <!-- END FORM-->

                        <div id="register-save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h3 id="save-success-label">Successful Operation</h3>
                           </div>
                           <div class="modal-body">
                              <p></p>
                           </div>
                           <div class="modal-footer">
                              <button class="btn finished" aria-hidden="true">Finished</button>
                              <button class="btn blue continue" data-insertid="">Edit Again</button>
                           </div>
                        </div>

                     </div>
                  </div>
                  <!-- END PORTAL-->
               </div>
            </div>
            <!-- END REGISTRATION -->


            <!-- BEGIN IMAGE MANAGE-->
            <div id="manage-picture" class="row-fluid uploadView">
               <div class="span12">
                  <div class="portlet box blue">
                     <div class="portlet-title">
                        <h4><i class="icon-picture"></i> Edit Seminar Image</h4>
                     </div>
                     <div class="portlet-body form">
                       <div class="row-fluid">
                        <div class="span12 ">
                           <div class="control-group ">
                              <label class="control-label"></label>
                              <div class="controls">
                                 <a href="#" class="btn blue manage-picture">Click here to manage the picture</a><br><br>
                                 <img id="image" src="<?=$this->vars['image']?>" width="329">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                    </div>
                 </div>
              </div>
            </div>
            <!-- END IMAGE MANAGE-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->

      <?=$this->element('js/Seminar.js');?>
      <?=$this->element('js/FormDatePickerClass.js');?>
      <?=$this->element('js/ClearField.js');?>
      <script>
      jQuery(document).ready(function() {   

         io.saw.FormDatePicker.init('range');
         io.saw.Seminar.init('edit');
         io.saw.Seminar.sluggify('headline','headline');
         io.saw.ClearField.init({formArr:['#register-form']});
      });
      </script>
      <? $id = $seminar['_id'] ?>
      <?=$this->element('editor',array('_id'=>$id,'client_id'=>null,'access_token'=>null));?>
