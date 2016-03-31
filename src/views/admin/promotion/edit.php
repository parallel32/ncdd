         <link rel="stylesheet" type="text/css" href="<?=SAW_SSL_CDN?>/assets/plugins/jquery-multi-select/css/multi-select-metro.css" />
         <script type="text/javascript" src="<?=SAW_SSL_CDN?>/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>   

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
                        <input id="_id" type="hidden" name="doc[_id]" value="<?=(array_key_exists('promotion',$this->vars)) ? $this->vars['promotion']['_id'] : '' ?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h2>Create new promotions or edit existing ones here.</h2>
                        
                        <h3 class="form-section text-info"><strong>Code</strong></h3>
                        <p>This is the promotion code that you'll give out.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[code]" value="<?=(!empty($this->vars['promotion']) && array_key_exists('code',$this->vars['promotion'])) ? $this->vars['promotion']['code']: ''?>" class="m-wrap span10 code">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Start Date</strong></h3>
                        <p>Simply type in a new date for the start date. E.g.: March 15, 2016.  Meaning it will start at midnight on this date.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[startDate]" value="<?=(!empty($this->vars['promotion']) && array_key_exists('startDate',$this->vars['promotion'])) ? $this->vars['promotion']['startDate']['fullMonth']: ''?>" class="m-wrap span10 startDate">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>End Date</strong></h3>
                        <p>Simply type in a new date for the end date. E.g.: Feb 15, 2017.  Meaning it will end at 11:59pm on this date.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[endDate]" value="<?=(!empty($this->vars['promotion']) && array_key_exists('endDate',$this->vars['promotion'])) ? $this->vars['promotion']['endDate']['fullMonth']: ''?>" class="m-wrap span10 endDate">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        <h3 class="form-section text-info"><strong>Discount Type</strong></h3>
                        <p>Select the type of discount.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <select name="doc[currentType]" class="span10 m-wrap forum" data-placeholder="Discount Type" tabindex="1">
                                       <? foreach(\Saw\Model\Promotion::$typeReversed as $key=>$value):
                                       $selected = (!empty($this->vars['promotion']) && $this->vars['promotion']['currentType'] == $key)? 'selected' : '';
                                       ?>
                                       <option <?=$selected?> value="<?=$key?>"><?=$value?></option>
                                       <? endforeach; ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Discount Amount</strong></h3>
                        <p>Enter the percentage as just a whole number or the dollar amount as a whole number.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[discountAmt]" value="<?=(!empty($this->vars['promotion']) && array_key_exists('discountAmt',$this->vars['promotion'])) ? $this->vars['promotion']['discountAmt']: ''?>" class="m-wrap span10 discountAmt">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Opt-In On/Off</strong></h3>
                        <p>Turn the opt-in on/off meaning show it or not.  Opt-in is whether to keep the payment method on file for future automated transactions.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <select name="doc[optInOnOff]" class="span10 m-wrap forum" data-placeholder="" tabindex="1">
                                       <option <?=(!empty($this->vars['promotion']) && $this->vars['promotion']['optInOnOff'] == 'on')? 'selected' : ''?> value="on">On</option>
                                       <option <?=(!empty($this->vars['promotion']) && $this->vars['promotion']['optInOnOff'] == 'off')? 'selected' : ''?> value="off">Off</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Opt-in Disclosure</strong></h3>
                        <p>This is the opt-in disclosure terms and conditions of the promotion.  Currently this only referrs to saving the payment details for future use.  Later it can be opt-ins for other things (as we define them). </p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <textarea name="doc[optInDisclosure]" class="m-wrap span10 optInDisclosure"><?=(!empty($this->vars['promotion']) && array_key_exists('optInDisclosure',$this->vars['promotion'])) ? $this->vars['promotion']['optInDisclosure']: ''?></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Gift yes/no</strong></h3>
                        <p>Is there a gift associated with the promotion?  If so, set this to yes and fill in the gift name, dollar value of the gift and optionally a photo of the gift.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <select name="doc[gift]" class="span10 m-wrap forum" data-placeholder="" tabindex="1">
                                       <option <?=(!empty($this->vars['promotion']) && $this->vars['promotion']['gift'] == 'yes')? 'selected' : ''?> value="yes">Yes</option>
                                       <option <?=(!empty($this->vars['promotion']) && $this->vars['promotion']['gift'] == 'no')? 'selected' : ''?> value="no">No</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Gift Name</strong></h3>
                        <p></p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[giftName]" value="<?=(!empty($this->vars['promotion']) && array_key_exists('giftName',$this->vars['promotion'])) ? $this->vars['promotion']['giftName']: ''?>" class="m-wrap span10 giftName">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Gift Description</strong></h3>
                        <p>If you add something here it will appear otherwise, it will not.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <textarea name="doc[giftDesc]" class="m-wrap span10 giftDesc"><?=(!empty($this->vars['promotion']) && array_key_exists('giftDesc',$this->vars['promotion'])) ? $this->vars['promotion']['giftDesc']: ''?></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Gift Dollar Value</strong></h3>
                        <p>Enter the value of the give as just a whole number or the dollar amount as a whole number.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[giftDollarValue]" value="<?=(!empty($this->vars['promotion']) && array_key_exists('giftDollarValue',$this->vars['promotion'])) ? $this->vars['promotion']['giftDollarValue']: ''?>" class="m-wrap span10 giftDollarValue">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        <h3 class="form-section text-info"><strong>Gift Picture (optional)</strong></h3>
                        <p>You can upload a picture to make show the gift that's being offered.</p>
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
                              if(!empty($this->vars['promotion']) && array_key_exists('_id',$this->vars['promotion'])){
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
                           <button class="btn blue all-promotions">Go to All Promotions</button>
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
                           <p>Are you sure you want to delete this promotion?  Deleting will purge the entire promotion including all photos and comments.  This operation cannot be undone.</p>
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
         <?=$this->element('js/Promotion.js');?>
         <?=$this->element('js/ClearField.js');?>
         <script>
         jQuery(document).ready(function() {    
            io.saw.Promotion.init();
            io.saw.ClearField.init({formArr:['#saw-form']}); 
         });
            
         </script>

