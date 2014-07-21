<? $accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app); ?>

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
                        <input id="currentStatus" type="hidden" name="doc[currentStatus]" value="<?=(array_key_exists('delegate',$this->vars)) ? $this->vars['delegate']['currentStatus'] : ''?>">
                        <input id="_id" type="hidden" name="doc[_id]" value="<?=(array_key_exists('delegate',$this->vars)) ? $this->vars['delegate']['_id'] : '' ?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h2><?=(!empty($this->vars['delegate']) && array_key_exists('state',$this->vars['delegate'])) ? $this->vars['delegate']['state']: ''?> Delegate Page.</h2>
                        <? if($accessLevel == ADMIN): ?>
                        <!-- MEMBER -->
                        <div class="row-fluid">
                           <div class="span12">
                              <div id="member-grid" class="portlet box blue">
                                 <div class="portlet-title">
                                    <div class="caption">Delegate(s)</div>
                                    <div class="actions">
                                       <a class="btn green add"><i class=" icon-plus"></i> Add</a>
                                    </div>
                                 </div>
                                 <div class="portlet-body">
                                    <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                                       <thead>
                                          <tr role="row">
                                             <th class="">Member</th>
                                             <th class="">Email</th>
                                             <th class=""></th>
                                          </tr>
                                       </thead>
                                       <tbody role="alert" aria-live="polite" aria-relevant="all">
                                          <? if(!empty($this->vars['delegate']['members'])): foreach($this->vars['delegate']['members'] as $member): ?>
                                          <tr class="gradeX odd">
                                             <td class=" "><?=$member['displayName']?></td>
                                             <td class=" "><?=$member['email']?></td>
                                             <td class=" "><a data-member-id="<?=$member['_id']?>" data-id="<?=$this->vars['delegate']['_id']?>" class="btn red mini delete"></i> Remove</a></td>
                                          </tr>
                                          <? endforeach;?>
                                          <? else: ?>
                                             <td id="member-norecords" colspan="5">No records.</td>
                                          <? endif;?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--/ MEMBER -->
                        <? endif; ?>




                        <!-- EVENT -->
                        <div class="row-fluid">
                           <div class="span12">
                              <div id="event-grid" class="portlet box blue">
                                 <div class="portlet-title">
                                    <div class="caption">Events</div>
                                    <div class="actions">
                                       <a class="btn green add"><i class=" icon-plus"></i> Add</a>
                                    </div>
                                 </div>
                                 <div class="portlet-body">
                                    <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                                       <thead>
                                          <tr role="row">
                                             <th class="">Event</th>
                                             <th class="">Date</th>
                                             <th class=""></th>
                                          </tr>
                                       </thead>
                                       <tbody role="alert" aria-live="polite" aria-relevant="all">
                                          <? if(!empty($this->vars['delegate']['events'])): 
                                          foreach($this->vars['delegate']['events'] as $event): ?>
                                          <tr class="gradeX odd">
                                             <td class=" "><?=$event['name']?></td>
                                             <td class=" "><?=$event['date']['fullMonth']?></td>
                                             <td class=" "><a data-event-id="<?=$event['_id']?>" data-id="<?=$this->vars['delegate']['_id']?>" class="btn red mini delete"></i> Delete</a></td>
                                          </tr>
                                          <? endforeach;?>
                                          <? else: ?>
                                             <td id="event-norecords" colspan="5">No records.</td>
                                          <? endif;?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>


                           
                        <!--/ EVENT -->
                        <h2>Pictures</h2>
                        <p>Please maintain 3 pictures on the page for consistency with all the other Delegate pages.</p>
                        <h3 class="form-section text-info"><strong>Picture 1</strong></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <a id="image" href="#" class="btn blue manage-picture">Click here to manage the picture</a><br><br>
                                    <img id="image" src="<?=$this->vars['image']?>" width="329">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Picture 2</strong></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <a id="image2" href="#" class="btn blue manage-picture">Click here to manage the picture</a><br><br>
                                    <img id="image" src="<?=$this->vars['image2']?>" width="329">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Picture 3</strong></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <a id="image3" href="#" class="btn blue manage-picture">Click here to manage the picture</a><br><br>
                                    <img id="image" src="<?=$this->vars['image3']?>" width="329">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Content</strong>&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.activeEditor.focus();">Click to Edit</a></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                           <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 50px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                           <div id="body" class="span12 editable" style="margin-left:0px;">
                              <?=(!empty($this->vars['delegate']) && array_key_exists('body',$this->vars['delegate'])) ? $this->vars['delegate']['body'] : ''?>
                           </div>
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
                           <? 
                              if(!empty($this->vars['delegate']) && array_key_exists('currentStatus',$this->vars['delegate'])): 
                                 $status = \Saw\Model\Delegate::$statusReversed[$this->vars['delegate']['currentStatus']];
                                 switch ($status) {
                                    case 'DRAFT':
                                          $buttons = "<button type='button' class='btn green save'><i class='icon-pencil'></i> Save.</button>&nbsp;";
                                          if($accessLevel == ADMIN){
                                          $buttons.= "<button type='button' class='btn green publish'><i class='icon-ok'></i> Publish now.</button>&nbsp;";   
                                          }                                          
                                          $buttons.= "<button type='button' class='btn cancel-edit'>Cancel</button>";
                                       break;
                                    case 'PUBLISH':
                                          $buttons = "<button type='button' class='btn green save'><i class='icon-pencil'></i> Save.</button>&nbsp;";
                                          if($accessLevel == ADMIN){
                                          $buttons.= "<button type='button' class='btn yellow unpublish'><i class='icon-ok'></i> Save and un-publish.</button>&nbsp;";
                                          }
                                          $buttons.= "<button type='button' class='btn cancel-edit'>Cancel</button>";
                                       break;
                                 }
                              endif;
                              echo $buttons;
                           ?>
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
                           <button class="btn green continue edit">Continue Editing</button>
                           <button class="btn blue dashboard">Done</button>
                        </div>
                     </div>
                     <!--/ SUCCESSFUL SAVE MODAL -->

                     <!-- DELETE MODAL -->
                     <div id="delete-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="delete-modal-label">Delete Operation.</h3>
                        </div>
                        <div class="modal-body">
                           <p>Are you sure you want to delete this delegate post?  Deleting will purge the entire delegate post including all photos and comments.  This operation cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                           <button class="btn red yes">Yes, I'm sure. Delete.</button>
                           <button class="btn no">Cancel Delete</button>
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


         <!-- ADD MEMBER MODAL -->
                        <div id="add-member-modal" class="modal container hide fade" tabindex="-1" role="dialog" aria-labelledby="add-member-modal-label" aria-hidden="true">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h3 id="add-member-modal-label">Below are all the members, who hold the State Delegate staff position.</h3>
                           </div>
                           <div class="modal-body">

                              <h3><?=count($this->vars['state_delegates'])?> Total Members</h3>

                              <form id="member-form" class="horizontal-form">
                                 <!-- ERROR -->
                                 <div class="alert alert-error hide">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                 </div>
                                 <!--/ ERROR -->
                                 
                                 <!-- BEGIN MEMBER -->
                                 <? foreach($this->vars['state_delegates'] as $member): ?>
                                 <div class="row-fluid">
                                    <div class="span4 ">
                                       <?=$member['displayName']?>
                                    </div>
                                    <div class="span4 ">
                                       <button type="button" data-id="<?=$this->vars['delegate']['_id']?>" data-member-id="<?=$member['_id']?>" class="btn green select-member"><i class="icon-ok"></i> Select</button>
                                    </div>
                                 </div><br>
                                 <? endforeach; ?>
                                 <!-- ERROR -->
                                 <div class="alert alert-error hide">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                 </div>
                                 <!--/ ERROR -->
                                 
                              </form>     

                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn cancel">Cancel</button>
                           </div>
                        </div>
                        <!--/ ADD MEMBER MODAL -->
                        <!-- ADD EVENT MODAL -->
                        <div id="add-event-modal" class="modal container hide fade" tabindex="-1" role="dialog" aria-labelledby="add-event-modal-label" aria-hidden="true">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h3 id="add-event-modal-label">Add Event</h3>
                           </div>
                           <div class="modal-body">



                              <form id="event-form" class="horizontal-form">
                                 <input type="hidden" name="doc[state]" value="<?=strtoupper($this->vars['delegate']['abbr'])?>">
                                 <input type="hidden" name="doc[currentType]" value="10">
                                 <input type="hidden" name="doc[add]" value="yes">
                                 
                                 <!-- BEGIN EVENT -->
                                 <div class="row-fluid">
                                    <div class="span12 ">
                                       <div class="control-group">
                                          <label class="control-label" >Seminar Name</label>
                                          <div class="controls">
                                             <input type="text" name="doc[name]" class="m-wrap span12 name">
                                             <span class="help-block">Provide the name of the seminar</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>                              
                                 <div class="row-fluid">
                                    <div class="span12 ">
                                       <div class="control-group">
                                          <label class="control-label" >Sponsor</label>
                                          <div class="controls">
                                             <input type="text" name="doc[sponsor]" class="m-wrap span12 sponsor">
                                             <span class="help-block">Provide the name of the seminar sponsor.</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>                              
                                 <div class="row-fluid">
                                    <div class="span12 ">
                                       <div class="control-group">
                                          <label class="control-label" >Co-Sponsor</label>
                                          <div class="controls">
                                             <input type="text" name="doc[cosponsor]" class="m-wrap span12 cosponsor">
                                             <span class="help-block">Provide the name of the seminar co-sponsor if there is one.</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>                              
                                 <div class="row-fluid">
                                    <div class="span12 ">
                                       <div class="control-group">
                                          <label class="control-label" >Date</label>
                                          <div class="controls">
                                             <input type="text" name="doc[date]" class="m-wrap span12 date">
                                             <span class="help-block">Enter the date of the seminar. Simply type a date casually. For example: July 14, 2014</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>                              
                                 <!-- ERROR -->
                                 <div class="alert alert-error hide">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                 </div>
                                 <!--/ ERROR -->
                                 
                              </form>     

                           </div>
                           <div class="modal-footer">
                              <button type="button" data-id="<?=$this->vars['delegate']['_id']?>" class="btn green save-event"><i class="icon-ok"></i> Save</button>
                              <button type="button" class="btn cancel">Cancel</button>
                           </div>
                        </div>
                        <!--/ ADD EVENT MODAL -->
         <?=$this->element('js/Delegate.js');?>
         <?=$this->element('js/ClearField.js');?>

         <script>
         jQuery(document).ready(function() {    
            io.saw.Delegate.init();
            io.saw.ClearField.init({formArr:['#saw-form']});
         });
         </script>
         <? $id = (array_key_exists('delegate',$this->vars)) ? $this->vars['delegate']['_id'] : '' ?>
         <?=$this->element('editor',array('_id'=>$id,'client_id'=>'','access_token'=>''));?>         