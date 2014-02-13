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
                        <input id="currentStatus" type="hidden" name="doc[currentStatus]" value="">
                        <input id="_id" type="hidden" name="doc[_id]" value="<?=(array_key_exists('product',$this->vars)) ? $this->vars['product']['_id'] : '' ?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h2>Draft a product here.  Save it for later editing or publish it right away.</h2>
                        <h3 class="form-section text-info"><strong>Name</strong></h3>
                        <p>Name your product.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[name]" value="<?=(!empty($this->vars['product']) && array_key_exists('name',$this->vars['product'])) ? $this->vars['product']['name']: ''?>" class="m-wrap span10 name">
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
                                    <input type="text" name="doc[slug]" value="<?=(!empty($this->vars['product']) && array_key_exists('slug',$this->vars['product'])) ? $this->vars['product']['slug']: ''?>" class="m-wrap span10 slug">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Price</strong></h3>
                        <p>The price of the product for the general public.</p>
                        <p>Add a price like this: 10.50.  You don't need to put in the $ (dollar) sign</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[price]" value="<?=(!empty($this->vars['product']) && array_key_exists('price',$this->vars['product'])) ? number_format($this->vars['product']['price'],2): ''?>" class="m-wrap span10 price">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Member Price</strong></h3>
                        <p>The price of the product for members only.</p>
                        <p>Add a price like this: 10.50.  You don't need to put in the $ (dollar) sign</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[memberPrice]" value="<?=(!empty($this->vars['product']) && array_key_exists('memberPrice',$this->vars['product'])) ? number_format($this->vars['product']['memberPrice'],2): ''?>" class="m-wrap span10 memberPrice">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Shipping Price</strong></h3>
                        <p>The cost to ship this product.</p>
                        <p>Add a price like this: 10.50.  You don't need to put in the $ (dollar) sign</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[shippingPrice]" value="<?=(!empty($this->vars['product']) && array_key_exists('shippingPrice',$this->vars['product'])) ? number_format($this->vars['product']['shippingPrice'],2): ''?>" class="m-wrap span10 shippingPrice">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Purchase Instructions</strong></h3>
                        <p>Enter the purchase instructions here.  <br><br><strong>For example:</strong><br> "We have Small, Medium, and Large sizes.  We also have Red, Blue, Black and Pink colors.  Please tell us what you'd like.  If you select a quantity of more than one, please note what you would like for each item."</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group">
                              <label class="control-label">Purchase Instructions (if none, leave blank)</label>
                              <div class="controls">
                                 <textarea rows="4" class="span6 purchaseInstructions" id="purchaseInstructions" name="doc[purchaseInstructions]"><?=(!empty($this->vars['product']['purchaseInstructions']) && array_key_exists('purchaseInstructions',$this->vars['product'])) ? $this->vars['product']['purchaseInstructions'] :'' ?></textarea>
                              </div>
                           </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Category</strong></h3>
                        <p>Categorize your product appropriately by selecting a category below.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group">
                              <label class="control-label">Available Categories</label>
                              <div class="controls">
                                 <select class="span6 category" id="category" name="doc[category]" style="">
                                    <? 
                                       foreach($this->vars['availableCategories'] as $k=>$v): 
                                          $selected = false;
                                          if(!empty($this->vars['product']) && array_key_exists('category',$this->vars['product'])){
                                             if(is_array($this->vars['product']['category'])) {
                                                if(strpos($this->vars['product']['category']['name'],$v) !== false){
                                                   $selected = true;   
                                                }
                                             }elseif (is_string($this->vars['product']['category'])){
                                                if(strpos($this->vars['product']['category'],$v) !== false){
                                                   $selected = true;
                                                }
                                             }
                                          }
                                    ?>
                                    <option <?=($selected) ? ' selected' :'' ?> value="<?=$k?>"><?=$v?></option>
                                    <? endforeach; ?>
                                 </select>
                              </div>
                           </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Picture (optional)</strong></h3>
                        <p>You can upload a picture to make your product more appealing.</p>
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
                        <h3 class="form-section text-info"><strong>Description</strong></h3>&nbsp;<button type="button" class="btn blue show-editor">Click To Edit</button><br><br>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <span id="description" class="description"><?=(!empty($this->vars['product']) && array_key_exists('description',$this->vars['product'])) ? $this->vars['product']['description'] : ''?></span>
                                    <input id="input-description" type="hidden" name="doc[description]" value="" class="description">
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
                           <button type='button' class='btn green save-publish'><i class='icon-ok'></i>Save and Publish.</button>
                           <button type='button' class='btn yellow save'><i class='icon-pencil'></i>Save and don't Publish.</button>
                           <button type='button' class='btn red delete'>Delete</button>
                           <button type='button' class='btn cancel'>Cancel</button>
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
                              <button class="btn blue all-posts">Go back to Products</button>
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
                           <p>Are you sure you want to delete this product?  Deleting will purge the entire product post including all photos.  This operation cannot be undone.</p>
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
         <?=$this->element('js/Product.js');?>
         <?=$this->element('js/ClearField.js');?>
         <script>
         jQuery(document).ready(function() {    
            io.saw.Product.init();
            io.saw.ClearField.init({formArr:['#saw-form']});

            window.editor = new SnapEditor.InPlace("description", {
               path: "/assets/snapeditor",
               toolbar: {
                  items: [
                     "styleBlock", "|",
                     "bold", "italic", "underline", "|",
                     "alignLeft", "alignCentre", "alignRight", "alignJustify", "|",
                     "orderedList", "unorderedList", "indent", "outdent", "|",
                     "link", "table", "horizontalRule", "|"
                   ],
                            }
                  ,snap: false
                  /*
                  ,onSave: function (e) {
                     var isSuccess = true;
                     html = e.html;
                     io.saw.Product.save();
                     return isSuccess || "Error";
                  }
                  ,onUnsavedChanges: function (e) {
                     e.api.execAction("save");
                 }*/
            });
            $('.show-editor').click(function(e){
               window.editor.api.activate();
            })
       
           
         });
            
         </script>

