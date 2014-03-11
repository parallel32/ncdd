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
                        <h4><i class="icon-facetime-video"></i> Add a new Seminar</h4>
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form id="saw-form" class="form-horizontal" novalidate="novalidate">
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                                 <div class="alert alert-error hide">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Headline<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[headline]" data-required="1" class="span6 m-wrap headline">
                                       <span class="help-block" id="headline-slug"></span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Location<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[location]" data-required="1" class="span6 m-wrap location">
                                       <span class="help-block">Enter the place where the seminar will be held.</span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Start Date<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[startDate]" data-required="1" class="span6 m-wrap startDate" value="">
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">End Date<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[endDate]" data-required="1" class="span6 m-wrap endDate">
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Time Zone<span class="required">*</span></label>
                                    <div class="controls">
                                       <select name="doc[timeZone]" class="span6 m-wrap timeZone" data-placeholder="Choose a Category" tabindex="1">
                                          <option value="America/New_York">Eastern</option>
                                          <option value="America/Chicago">Central</option>
                                          <option value="America/Denver">Mountain</option>
                                          <option value="America/Los_Angeles">Pacific</option>
                                          <option value="America/Anchorage">Alaska</option>
                                          <option value="America/Adak">Hawaii</option>
                                       </select>
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                                 
                              </div>
                           </div>
                           
                           <h3 class="form-section text-info"><strong>Description</strong>&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.activeEditor.focus();">Click to Add a Description</a></h3>
                           <div class="row-fluid">
                              <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 5px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                              <div id="body" class="span12 editable">
                                 <?=$seminar['description']?>
                              </div>
                              <input id="input-body" type="hidden" name="doc[description]" value="">
                              <!--/span-->
                           </div>

                           <div class="form-actions">
                              <button type="button" class="btn green">Save & Continue</button>
                              <button type="button" class="btn cancel">Cancel</button>
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
                              <button class="btn yellow continue" data-insertid="">Add an Image</button>
                              <button class="btn blue continue" data-insertid="">Continue To Agenda</button>
                           </div>
                        </div>

                     </div>
                  </div>
                  <!-- END VALIDATION STATES-->
               </div>
            </div>
            <!-- END PAGE CONTENT-->

            

         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
      <?=$this->element('js/Seminar.js');?>
      <?=$this->element('js/FormDatePickerClass.js');?>
      <script>
      jQuery(document).ready(function() {    
         io.saw.FormDatePicker.init('range');
         io.saw.Seminar.init('add');
         io.saw.Seminar.sluggify('headline','headline');
      });      
      </script>
      <?=$this->element('editor',array('_id'=>null));?>
