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
                        <input type="hidden" name="doc[currentType]" value="<?=$this->vars['currentType']?>">
                        <input type="hidden" name="doc[slug]" value="<?=$this->vars['slug']?>">
                        <input type="hidden" name="doc[add]" value="<?=$this->vars['add']?>">
                        <? if(!empty($this->vars['page']) && array_key_exists('_id',$this->vars['page'])): ?>
                           <input type="hidden" name="doc[_id]" value="<?=$this->vars['page']['_id']?>">
                        <? endif; ?>
                        <? if($this->vars['currentType'] == $this->vars['type']['MANAGED']): ?>
                           <input type="hidden" name="doc[currentStatus]" value="<?=$this->vars['status']['PUBLISHED']?>">
                        <? endif; ?>
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <? if($this->vars['currentType'] == $this->vars['type']['DYNAMIC']): ?>
                        <h3 class="form-section text-info"><strong>Status</strong></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <select class="large m-wrap currentStatus" name="doc[currentStatus]">
                                       <? foreach($this->vars['statusReversed'] as $key=>$val): ?>
                                       <option value="<?=$key?>" <?=(!empty($this->vars['page']) && $this->vars['page']['currentStatus'] == $key) ?'selected':'';?>><?=$val?></option>
                                       <? endforeach; ?>
                                    </select>
                                    <span class="help-block">If you set a status of PUBLISHED then this page will be available on the public website</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <? endif; ?>
                        <h3 class="form-section text-info"><strong>Section</strong></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <select class="large m-wrap section" name="doc[section]">
                                       <? $sections = \Saw\Model\Page::$sections;
                                          foreach($sections as $key=>$val): ?>
                                       <option value="<?=$val?>" <?=(!empty($this->vars['page']) && array_key_exists('section',$this->vars['page']) && $this->vars['page']['section'] == $val) ?'selected':'';?>><?=$val?></option>
                                       <? endforeach; ?>
                                    </select>
                                    <span class="help-block">This setting will determine which navigation item this page will be linked from.</span>
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
                                    <input type="text" name="doc[headline]" value="<?=(!empty($this->vars['page']) && array_key_exists('headline',$this->vars['page'])) ? $this->vars['page']['headline']: $this->vars['headline']?>" class="m-wrap span10 headline">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Page Url</strong></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[slug]" value="<?=(!empty($this->vars['page']) && array_key_exists('slug',$this->vars['page'])) ? $this->vars['page']['slug']: $this->vars['slug']?>" class="m-wrap span10 slug">
                                    <span class="help-block">NOTE: The Page Url is auto-generated, which is created when you type in the Headline.  It can be overwritten here after you type in the Headline.</span>
                                    <span class="help-block">NOTE: changing this on "Managed" pages will cause the link to break on the public website.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>

                        <h3 class="form-section text-info"><strong>Body</strong>&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.activeEditor.focus();">Click to Edit</a></h3>
                        <div class="row-fluid">
                           <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 50px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                           <div id="body" class="span12 editable">
                              <?=(!empty($this->vars['page']) && array_key_exists('body',$this->vars['page'])) ? $this->vars['page']['body'] : '<br><br><br>'?>
                           </div>
                           <input id="input-body" type="hidden" name="doc[body]" value="">
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

                     
                  </div>
               </div>
               <!-- END PAGE CONTENT-->
            </div>
            <!-- END PAGE CONTAINER-->    
         </div>
         <!-- END PAGE -->
         <?=$this->element('js/Page.js');?>
         <script>
         jQuery(document).ready(function() {    
            io.saw.Page.init();
         });
         </script>
         <? $id = (array_key_exists('page',$this->vars)) ? $this->vars['page']['_id'] : '' ?>
         <?=$this->element('editor',array('_id'=>$id,'client_id'=>$this->vars['client_id'],'access_token'=>$this->vars['access_token']));?>
         