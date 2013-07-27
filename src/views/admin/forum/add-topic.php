   <link href="/assets/css/pages/blog.css" rel="stylesheet" type="text/css"/>
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
                     <form id="saw-form" class="horizontal-form portlet">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h3 class="form-section text-info"><strong>Status</strong></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <select class="large m-wrap currentStatus" name="doc[currentStatus]">
                                       <option value="0">DRAFT</option>
                                       <option value="10">PRIVATE</option>
                                       <option value="20">PUBLISHED</option>
                                    </select>
                                    <span class="help-block"></span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        
                        <h3 class="form-section text-info"><strong>Headline</strong></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[headline]" value="" class="m-wrap span10 headline">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Body</strong></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <span id="body" class="help-block">Click Here to add content...</span>
                                    <input id="input-body" type="hidden" name="doc[body]" value="">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        

                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <div class="form-actions text-center">
                           <button type="button" class="btn green save"><i class="icon-ok"></i> Save</button>
                           <button type="button" class="btn cancel">Cancel</button>
                           <button class="btn blue attach" type="button"><i class="icon-plus"></i> Attach a File</button>
                        </div>
                        <div id="file-here" class="blog-twitter span10">
                              
                        </div>
                     </form>
                     <!-- SUCCESSFUL SAVE MODAL -->
                     <div id="save-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="save-modal-label">Successful Operation.</h3>
                        </div>
                        <div class="modal-body">
                           <p></p>
                        </div>
                        <div class="modal-footer">
                           <button class="btn blue continue edit">Continue Editing</button>
                           <button class="btn continue dashboard">Back to List of Pages</button>
                        </div>
                     </div>
                     <!--/ SUCCESSFUL SAVE MODAL -->


                     <!-- SUCCESSFUL SAVE MODAL -->
                     <div id="file-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="save-modal-label">Select A File To Attach.</h3>
                        </div>
                        <div class="modal-body">
                           <div class="row-fluid">
                              <div class="span12">
                                 <!-- BEGIN SAMPLE TABLE PORTLET-->
                                 <div class="portlet">
                                    <div class="portlet-body">
                                       <table class="table table-striped table-bordered table-advance table-hover">
                                          <thead>
                                             <tr>
                                                <th> </th>
                                                <th> </th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <tr>
                                                <td class="highlight">
                                                   Acute Effects of Oxazepam, Diazepam and Methylperone Alone and in Combination with Alcohol on Sedation Coordination and Mood.pdf
                                                </td>
                                                <td><a class="btn mini purple" 
                                                   data-file-id="Acute Effects of Oxazepam, Diazepam and Methylperone Alone and in Combination with Alcohol on Sedation Coordination and Mood.pdf"
                                                   >SELECT</a></td>
                                             </tr>
                                             <tr>
                                                <td class="highlight">
                                                   Alcohol Tolerance.pdf
                                                </td>
                                                <td><a class="btn mini purple" 
                                                   data-file-id="Alcohol Tolerance.pdf"
                                                   >SELECT</a></td>
                                             </tr>
                                             <tr>
                                                <td class="highlight">
                                                   Behavioral Tolerance to Alcohol in Moderate Drinkers.pdf
                                                </td>
                                                <td><a class="btn mini purple" 
                                                   data-file-id="Behavioral Tolerance to Alcohol in Moderate Drinkers.pdf"
                                                   >SELECT</a></td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                                 <!-- END SAMPLE TABLE PORTLET-->
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button class="btn blue cancel">Cancel</button>
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


         <script>
         jQuery(document).ready(function() {    
            $('.attach').click(function(e){
               $('#file-modal').modal({keyboard: false});
            })

            $('.btn.mini.purple').click(function(e){
               
               html = '<div class="blog-twitter-block">'+
                        '<a href="#"><em>'+$(this).attr('data-file-id')+'</em></a> '+
                        '<i class="icon-file blog-twiiter-icon"></i>'+
                     '</div>';
                  $('#file-here').append(html);
                  $('#file-modal').modal('hide');

            })
            $('.btn.blue.cancel').click(function(e){
               $('#file-modal').modal('hide');
            })
         });                     
         </script>


         <?=$this->element('js/Page.js');?>
         <script>
         jQuery(document).ready(function() {    
            io.saw.Page.init();
            /*
            Aloha.ready( function() {
               Aloha.jQuery('.body').aloha();
            });
            //*/
             var editor = new SnapEditor.InPlace("body", {
                 buttons: [
    "styleBlock", "|",
    "p", "|",
    "bold", "italic", "underline", "|",
    "alignment", "|",
    "alignLeft", "alignCentre", "alignRight", "alignJustify", "|",
    "orderedList", "unorderedList", "indent", "outdent", "|",
    "link", "table", "horizontalRule" 
  ]
            });

           
         });
            
         </script>

