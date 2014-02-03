         <link rel="stylesheet" type="text/css" href="/assets/plugins/jquery-multi-select/css/multi-select-metro.css" />
         <script type="text/javascript" src="/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>   

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
                        <input id="add" type="hidden" name="doc[add]" value="<?=$this->vars['add']?>">
                        <input id="_id" type="hidden" name="doc[_id]" value="<?=(array_key_exists('category',$this->vars)) ? $this->vars['category']['_id'] : '' ?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h2>Create new categories or edit existing ones here.</h2>
                        
                        <h3 class="form-section text-info"><strong>Category</strong></h3>
                        <p>Select where this category belongs.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <select name="doc[currentType]" class="span10 m-wrap forum" data-placeholder="Choose a Category" tabindex="1">
                                       <? foreach(\Saw\Model\Category::$typeReversed as $key=>$value):
                                       $selected = (!empty($this->vars['category']) && $this->vars['category']['currentType'] == $key)? 'selected' : '';
                                       ?>
                                       <option <?=$selected?> value="<?=$key?>"><?=$value?></option>
                                       <? endforeach; ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        <h3 class="form-section text-info"><strong>Name</strong></h3>
                        <p>Name your category or tag.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[name]" value="<?=(!empty($this->vars['category']) && array_key_exists('name',$this->vars['category'])) ? $this->vars['category']['name']: ''?>" class="m-wrap span10 name">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Url</strong></h3>
                        <p>The product name will automatically produce a clean SEO friendly URL.  But, you can always change it here after you finish typing the Name.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[slug]" value="<?=(!empty($this->vars['category']) && array_key_exists('slug',$this->vars['category'])) ? $this->vars['category']['slug']: ''?>" class="m-wrap span10 slug">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        <h3 class="form-section text-info"><strong>Picture (optional)</strong></h3>
                        <p>You can upload a picture to make your category more appealing.  From an SEO perspective, categorys with a picture are much better received by search engines.</p>
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

                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <div class="form-actions text-center">
                           <? 
                              
                              $buttons = "<button type='button' class='btn green save'><i class='icon-pencil'></i> Save.</button>
                                          <button type='button' class='btn cancel'>Cancel</button>";
                              if(!empty($this->vars['category']) && array_key_exists('_id',$this->vars['category'])){
                                 $buttons.=" <button type='button' class='btn red delete'>Delete</button>";
                              }
                              
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
                           <button class="btn blue all-categories">Go to All Categories</button>
                           <button class="btn blue dashboard">Go to Dashboard</button>
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
                           <p>Are you sure you want to delete this category?  Deleting will purge the entire category including all photos and comments.  This operation cannot be undone.</p>
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
         <?=$this->element('js/Category.js');?>
         <script>
         jQuery(document).ready(function() {    
            io.saw.Category.init();
         });
            
         </script>

