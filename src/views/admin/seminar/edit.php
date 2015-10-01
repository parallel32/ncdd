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

                           <h3 class="form-section text-info"><strong>Description</strong>&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.get('body').execCommand('mcefocus',true);">Click to Edit</a>
                           <!-- VIDEO MODAL -->
                           <?$modal='video-a';?>
                           <?$modal_title='Editor How-To\'s';?>
                           <?$modal_src='https://www.youtube.com/embed/_eZZkPhkIME?rel=0';?>
                           <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                           <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                           <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                           <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                              <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                 <h3 id="save-modal-label"><?=$modal_title?></h3>
                              </div>
                              <div class="modal-body">
                                 <script>
                                    jQuery(document).ready(function() {    
                                       $('#embed-video').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/_eZZkPhkIME?rel=0');
                                       });
                                       $('#embed-video-link').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/f_rt_YnNjGs?rel=0');
                                       });
                                       $('#embed-website-link').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/-ZOlUA4hOlw?rel=0');
                                       });
                                       $('#embed-photo').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/NpBs85diwS4?rel=0');
                                       });
                                       $('#embed-file').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/0jIi7jF-4aM?rel=0');
                                       });
                                       $('#embed-vfl').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/bjfYaF4Dt-Q?rel=0');
                                       });

                                    });      
                                 </script>
                                 <table class="table table-hover">
                                 <tbody>
                                    <tr>
                                       <td><a id="embed-video" class="btn purple"><i class="icon-youtube-play"></i> Embed Video</a></td>
                                       <td><a id="embed-video-link" class="btn purple"><i class="icon-youtube-play"></i> Embed Video Link</a></td>
                                       <td><a id="embed-website-link" class="btn purple"><i class="icon-youtube-play"></i> Embed Website Link</a></td>
                                    </tr>
                                    <tr>
                                       <td><a id="embed-photo" class="btn purple"><i class="icon-youtube-play"></i> Embed Photo</a></td>
                                       <td><a id="embed-file" class="btn purple"><i class="icon-youtube-play"></i> Embed File</a></td>
                                       <td><a id="embed-vfl" class="btn purple"><i class="icon-youtube-play"></i> Embed Virtual Library Link</a></td>
                                    </tr>
                                 </tbody>
                                 </table>
                                 <iframe id="howto-frame" width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                              </div>
                           </div>
                           <!--/ VIDEO MODAL -->
                           </h3>
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
                           <h3 class="form-section text-info"><strong>Attendance Certification Statement</strong>&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.get('body-acs').execCommand('mcefocus',true);">Click to Edit</a></h3>
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                              <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 50px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                              <div id="body-acs" class="span12 editable" style="margin-left:0px;">
                                 <?=(array_key_exists('attendanceCertStatement', $seminar)) ? $seminar['attendanceCertStatement'] : ''?>
                              </div>
                              <input id="input-body-acs" type="hidden" name="doc[attendanceCertStatement]" value="">
                                 
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
                                    <label class="control-label">Registration URL</label>
                                    <div class="controls">
                                      <input type="text" name="doc[registerUrl]" value="<?=(array_key_exists('registerUrl',$seminar)) ? $seminar['registerUrl'] : '';?>" data-required="1" class="span12 m-wrap registerUrl">
                                      <span class="help-block">If filled in, this will activate the register button and redirect the person to this URL.</span>
                                      <span class="help-block"><b>However</b>, if "Activate Registration" below is set to ON or MEMBERSONLY, the register button will be linked to our registration form.</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Registration Notice</label>
                                    <div class="controls">
                                      <input type="text" name="doc[registerNotice]" value="<?=(array_key_exists('registerNotice',$seminar) && !empty($seminar['registerNotice'])) ? $seminar['registerNotice'] : '';?>" data-required="1" class="span12 m-wrap registerNotice">
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
                                       <?=(array_key_exists('register',$seminar) && array_key_exists('currentStatus',$seminar['register']) && \Saw\Model\SeminarRegister::$status['MEMBERSONLY'] == $seminar['register']['currentStatus']) ? '<span class="help-block">bypass url: <b>https://'.SAW_ADMIN_WEBSITE.'/registration/seminar/'.$seminar['_id'].'/'.$seminar['slug'].'?nlpro='.date('Y').'</b></span>': '';?>
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
                                       <select name="doc[register][scholarship]" class="span6 m-wrap scholarship" data-placeholder="Choose a Category" tabindex="1">
                                          <option value="OFF" <?=(array_key_exists('register',$seminar) && array_key_exists('scholarship',$seminar['register'])) ? ('OFF' == $seminar['register']['scholarship']) ? "selected" : "" : '';?>>OFF</option>
                                          <option value="ON" <?=(array_key_exists('register',$seminar) && array_key_exists('scholarship',$seminar['register'])) ? ('ON' == $seminar['register']['scholarship']) ? "selected" : "" : '';?>>ON</option>
                                       </select>
                                       <span class="help-block">Turn ON / OFF; applying for scholarships and registering with scholarships</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">RSVP (dinner)</label>
                                    <div class="controls">
                                       <select name="doc[register][rsvpQuestion]" class="span6 m-wrap rsvpQuestion" data-placeholder="Choose a Category" tabindex="1">
                                          <option value="ON" <?=(array_key_exists('register',$seminar) && array_key_exists('rsvpQuestion',$seminar['register'])) ? ('ON' == $seminar['register']['rsvpQuestion']) ? "selected" : "" : '';?>>ON</option>
                                          <option value="OFF" <?=(array_key_exists('register',$seminar) && array_key_exists('rsvpQuestion',$seminar['register'])) ? ('OFF' == $seminar['register']['rsvpQuestion']) ? "selected" : "" : '';?>>OFF</option>
                                       </select>
                                       <span class="help-block">Turn ON / OFF; whether to rsvp fo the dinner</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Attendance Question</label>
                                    <div class="controls">
                                       <select name="doc[register][attendanceQuestion]" class="span6 m-wrap attendanceQuestion" data-placeholder="Choose a Category" tabindex="1">
                                          <option value="ON" <?=(array_key_exists('register',$seminar) && array_key_exists('attendanceQuestion',$seminar['register'])) ? ('ON' == $seminar['register']['attendanceQuestion']) ? "selected" : "" : '';?>>ON</option>
                                          <option value="OFF" <?=(array_key_exists('register',$seminar) && array_key_exists('attendanceQuestion',$seminar['register'])) ? ('OFF' == $seminar['register']['attendanceQuestion']) ? "selected" : "" : '';?>>OFF</option>
                                       </select>
                                       <span class="help-block">Turn ON / OFF; whether to ask the previously attended seminars question.</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">RSVP Children Question</label>
                                    <div class="controls">
                                       <select name="doc[register][rsvpKidsQuestion]" class="span6 m-wrap rsvpKidsQuestion" data-placeholder="Choose a Category" tabindex="1">
                                          <option value="ON" <?=(array_key_exists('register',$seminar) && array_key_exists('rsvpKidsQuestion',$seminar['register'])) ? ('ON' == $seminar['register']['rsvpKidsQuestion']) ? "selected" : "" : '';?>>ON</option>
                                          <option value="OFF" <?=(array_key_exists('register',$seminar) && array_key_exists('rsvpKidsQuestion',$seminar['register'])) ? ('OFF' == $seminar['register']['rsvpKidsQuestion']) ? "selected" : "" : '';?>>OFF</option>
                                       </select>
                                       <span class="help-block">Turn ON / OFF; whether to ask the previously attended seminars question.</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Max Registrations</label>
                                    <div class="controls">
                                       <input type="text" name="doc[register][maxRegistrations]" value="<?=(is_array($seminar['register']) && array_key_exists('maxRegistrations',$seminar['register']) && !empty($seminar['register']['maxRegistrations'])) ? $seminar['register']['maxRegistrations'] : '';?>" data-required="1" class="span6 m-wrap maxRegistrations">
                                       <span class="help-block">When this is set, a max registration limit will be imposed and once reached the registration form will convert to a non-payment registrstion form that will populate the waiting list.</span>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <h3 class="form-section">Registration Letter&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.get('body-confletter').execCommand('mcefocus',true);">Click to Edit</a></h3>
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
                           
                           
                           <h3 class="form-section">Deposit Letter&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.get('body-deposit-confletter').execCommand('mcefocus',true);">Click to Edit</a></h3>
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
                           

                           <h3 class="form-section">Scholarship Submitted Letter&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.get('body-scholarship-confletter').execCommand('mcefocus',true);">Click to Edit</a></h3>
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
                           

                           <h3 class="form-section">Scholarship Approved Letter&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.get('body-scholarship-approveletter').execCommand('mcefocus',true);">Click to Edit</a></h3>
                           <div class="alert alert-info"><p><b>Notice:</b>To include scholarship specific information include these variables:
                                 <br>Recipient's name: <b>#name#</b>
                                 <br>What the scholarship is for: <b>#for#</b>
                              </p>
                           </div>
                           <hr>
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                              <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 50px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                              <div id="body-scholarship-approveletter" class="span12 editable" style="margin-left:0px;">
                                 <?=(array_key_exists('register',$seminar)) ? (array_key_exists('scholarshipApprovedConfirmationLetter',$seminar['register'])) ? $seminar['register']['scholarshipApprovedConfirmationLetter'] : '' : '';?>
                              </div>
                              <input id="input-body-scholarship-approveletter" type="hidden" name="doc[register][scholarshipApprovedConfirmationLetter]" value="">
                                 
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
