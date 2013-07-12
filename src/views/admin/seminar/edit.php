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
                                       <span class="help-block" id="headline-slug"></span>
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
                           <h3 class="form-section">Description</h3>
                           <div class="row-fluid">
                              <div class="span12 ">
                                 <div class="control-group">
                                    <span class="help-block description"><?=$seminar['description']?></span>
                                    <input id="description" type="hidden" name="doc[description]" value="">
                                 </div>
                              </div>
                           </div>


                           <div class="form-actions">
                              <button type="button" class="btn green">Save</button>
                              <button type="button" class="btn cancel">Cancel</button>
                              <button type="button" class="btn blue manage">Manage Agendas</button>
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
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
      <?=$this->element('js/Seminar.js');?>
      <?=$this->element('js/FormDatePickerClass.js');?>
      <script>
      jQuery(document).ready(function() {    
         io.saw.FormDatePicker.init('range');
         io.saw.Seminar.init('edit');
         io.saw.Seminar.sluggify('headline','headline');         

         Aloha.ready( function() {
            Aloha.jQuery('.description').aloha();
         });
      });
      
      </script>
