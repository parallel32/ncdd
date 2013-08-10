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
            <? foreach($this->vars['agendas'] as $agenda): ?>
			<h3 class="page-title">
               <?=$agenda['name']?> - <?=$agenda['date']['fullMonth']?><small></small>
               <? $accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app);
	                if($accessLevel >= EDITOR){
	             ?>
               <a class="btn green add-time-slot" data-date="<?=$agenda['date']['fullMonth']?>" data-id="<?=$agenda['_id']?>">
                 Add Time Slot <i class="icon-plus"></i>
               </a>
               <? } ?>
            </h3>
            <div class="row-fluid">
               <div class="span12">
                  <ul class="timeline">
                     <? foreach($agenda['timeSlots'] as $timeSlot): ?>
                     <li class="timeline-<?=$timeSlot['color']?>">
                        <div class="timeline-time">
                           <span id="<?=$agenda['_id']?>-<?=$timeSlot['date']['date']->sec?>-date" class="date"><?=$timeSlot['date']['monthDay']?></span>
                           <span id="<?=$agenda['_id']?>-<?=$timeSlot['date']['date']->sec?>-time" class="time"><?=$timeSlot['date']['shortTimeSlim']?></span>
                        </div>
                        <div class="timeline-icon"><i class="icon-time"></i></div>
                        <div id="<?=$agenda['_id']?>-<?=$timeSlot['date']['date']->sec?>-title" class="hide"><?=$timeSlot['title']?></div>
                        <div id="<?=$agenda['_id']?>-<?=$timeSlot['date']['date']->sec?>-color" class="hide"><?=$timeSlot['color']?></div>
                        <div class="timeline-body">
                           <h2><?=$timeSlot['title']?>

                           	<? $accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app);
		                        if($accessLevel >= EDITOR){
		                     ?>
		                        &nbsp; <a class="pull-right btn green edit-time-slot" data-date="<?=$timeSlot['date']['fullMonth']?>" data-id="<?=$agenda['_id']?>-<?=$timeSlot['date']['date']->sec?>">
				                 Edit <i class="icon-pencil"></i>
				               </a>
				               

				               &nbsp; <a class="pull-right btn red delete-time-slot" data-date="<?=$timeSlot['date']['fullMonth']?>" data-id="<?=$agenda['_id']?>-<?=$timeSlot['date']['date']->sec?>">
				                 Remove</i>
				               </a>   
		                     <?}?>
                           	</h2>
                           <div id="<?=$agenda['_id']?>-<?=$timeSlot['date']['date']->sec?>-description" class="timeline-content">
                           	<?=$timeSlot['description']?>
                           </div>
                        </div>
                     </li>
                     <? endforeach; ?>                     
                  </ul>
               </div>
            </div>
        	<? endforeach; ?>
            <!-- END PAGE CONTENT-->
            <div id="timeslot-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h3 id="save-success-label">Enter A Time Slot</h3>
               </div>
               <div class="modal-body">
                  <!-- BEGIN FORM-->
                        <form id="edit-form" class="form-horizontal" novalidate="novalidate">
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                                 <div class="alert alert-error hide">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Time<span class="required">*</span></label>
                                    <div class="controls">
                                       <div class="input-append">
											<input type="text" name="doc[date]" value="" data-format="hh:mm a" class="span6 m-wrap small clockface date">
											<input type="hidden" name="doc[dateTime]" value="" class="dateTime">
											<button class="btn" type="button" id="clockface_toggle">
											<i class="icon-time"></i>
											</button>
										</div>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Title<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[title]" data-required="1" class="span6 m-wrap title" value="">
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Color<span class="required">*</span></label>
                                    <div class="controls">
                                       <select name="doc[color]" class="span6 m-wrap color" data-placeholder="Choose a Color" tabindex="1">
                                          <option value="yellow">yellow</option>
                                          <option value="green">green</option>
                                          <option value="blue">blue</option>
                                          <option value="purple">purple</option>
                                          <option value="red">red</option>
                                          <option value="grey">grey</option>
                                       </select>
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                                 
                              </div>
                           </div>
                           <h3 class="form-section">Description</h3>
                           <div class="row-fluid">
                              <div class="span12 ">
                                 <div class="control-group">
                                    <span id="description" class="help-block">Click here to add a description...</span>
                                    <input id="input-description" type="hidden" name="doc[description]" value="">
                                 </div>
                              </div>
                           </div>
                           <input type="hidden" id="edit-id" name="doc[_id]" value="">
						</form>
                        
                        <!-- END FORM-->
               </div>
               <div class="modal-footer">
           		  <button type="button" class="btn green">Save & Continue</button>
                  <button type="button" class="btn cancel">Cancel</button>
               </div>
            </div>






            <div id="timeslot-delete-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h3 id="save-success-label">Delete Time Slot</h3>
               </div>
               <div class="modal-body">
                  <!-- BEGIN FORM-->
                        <form id="delete-form" class="form-horizontal" novalidate="novalidate">
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                                 <div class="alert alert-error hide">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Time</label>
                                    <div class="controls">
                                       <div class="input-append">
											<input type="text" name="doc[date]" value="" data-format="hh:mm a" class="span6 m-wrap small clockface date" readonly="">
											<input type="hidden" name="doc[dateTime]" value="" class="dateTime">
											<button class="btn" type="button" id="clockface_toggle">
											<i class="icon-time"></i>
											</button>
										</div>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Title</label>
                                    <div class="controls">
                                       <input type="text" name="doc[title]" data-required="1" class="span6 m-wrap title" value="" readonly="">
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                           </div>
                           <input type="hidden" id="delete-id" name="doc[_id]" value="">
						</form>
                        
                        <!-- END FORM-->
               </div>
               <div class="modal-footer">
           		  <button type="button" class="btn green">Confirm Delete</button>
                  <button type="button" class="btn cancel">Cancel</button>
               </div>
            </div>
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->

      <?=$this->element('js/Agenda.js');?>
      <?=$this->element('js/FormClockFacePickerClass.js');?>
      <script>
      jQuery(document).ready(function() {    
         io.saw.FormClockFacePicker.init();
         io.saw.Agenda.init();
         /*
         Aloha.ready( function() {
              Aloha.jQuery('.description').aloha();
         });
         //*/

         var editor = new SnapEditor.InPlace("description", {
               toolbar: {
                 items: [
                   "styleBlock", "|",
                   "p", "|",
                   "bold", "italic", "underline", "|",
                   "alignment", "|",
                   "alignLeft", "alignCentre", "alignRight", "alignJustify", "|",
                   "orderedList", "unorderedList", "indent", "outdent", "|",
                   "link", "table", "horizontalRule" 
                 ]
               }
               ,snap: false
               ,onSave: function (e) {
                  var isSuccess = true;
                  html = e.html;
                  io.saw.Agenda.save();
                  return isSuccess || "Error";
               }
            });
         editor.on("snapeditor.ready", function (e) {
            window.setTimeout(function(){
               $('.snapeditor_toolbar_floating').css('z-index',12000);   
               $('.snapeditor_toolbar_menu').css('z-index',12001);   
               $('.snapeditor_dialog').css('z-index',12010);   
            },200);
            
         });
         /*
         $('#description').click(function(e){
            console.log('here.....');
            window.setTimeout(function(){
               
               
            },2000);
         });
         //*/
      });
      
      </script>