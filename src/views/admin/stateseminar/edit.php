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
                        <input id="_id" type="hidden" name="doc[_id]" value="<?=(array_key_exists('stateseminar',$this->vars)) ? $this->vars['stateseminar']['_id'] : '' ?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h2>Create new stateseminars or edit existing ones here.</h2>
                        
                        <h3 class="form-section text-info"><strong>State Seminar</strong></h3>
                        <p>Select if it's an <b>NCDD sponsored or co-sponsored</b> seminar.  If it is neither then select "STATE".</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <select name="doc[currentType]" class="span10 m-wrap forum" data-placeholder="Choose a StateSeminar" tabindex="1">
                                       <? foreach(\Saw\Model\StateSeminar::$typeReversed as $key=>$value):
                                       $selected = (!empty($this->vars['stateseminar']) && $this->vars['stateseminar']['currentType'] == $key)? 'selected' : '';
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
                        <p>Provide the name of the state approved seminar</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[name]" value="<?=(!empty($this->vars['stateseminar']) && array_key_exists('name',$this->vars['stateseminar'])) ? $this->vars['stateseminar']['name']: ''?>" class="m-wrap span10 name">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Url</strong></h3>
                        <p>SEO friendly URL.  Can be changed after you finish typing the Name.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[slug]" value="<?=(!empty($this->vars['stateseminar']) && array_key_exists('slug',$this->vars['stateseminar'])) ? $this->vars['stateseminar']['slug']: ''?>" class="m-wrap span10 slug">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Sponsor</strong></h3>
                        <p>Provide the name of the sponsor</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[sponsor]" value="<?=(!empty($this->vars['stateseminar']) && array_key_exists('sponsor',$this->vars['stateseminar'])) ? $this->vars['stateseminar']['sponsor']: ''?>" class="m-wrap span10 sponsor">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Co-Sponsor</strong></h3>
                        <p>Provide the name of the co-sponsor</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[cosponsor]" value="<?=(!empty($this->vars['stateseminar']) && array_key_exists('cosponsor',$this->vars['stateseminar'])) ? $this->vars['stateseminar']['cosponsor']: ''?>" class="m-wrap span10 cosponsor">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Date</strong></h3>
                        <p>Enter the date of the seminar.  Simply type a date casually: July 14, 2014</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[date]" value="<?=(!empty($this->vars['stateseminar']) && array_key_exists('date',$this->vars['stateseminar'])) ? $this->vars['stateseminar']['date']['fullMonth']: ''?>" class="m-wrap span10 date">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>State</strong></h3>
                        <p>Enter the state in which this seminar takes place</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <select name="doc[state]" class="m-wrap span10 state">
                                       <? 
                                       $states = array(
                                                    "AL" => "Alabama",
                                                    "AK" => "Alaska",
                                                    "AZ" => "Arizona",
                                                    "AR" => "Arkansas",
                                                    "CA" => "California",
                                                    "CO" => "Colorado",
                                                    "CT" => "Connecticut",
                                                    "DE" => "Delaware",
                                                    "FL" => "Florida",
                                                    "GA" => "Georgia",
                                                    "HI" => "Hawaii",
                                                    "ID" => "Idaho",
                                                    "IL" => "Illinois",
                                                    "IN" => "Indiana",
                                                    "IA" => "Iowa",
                                                    "KS" => "Kansas",
                                                    "KY" => "Kentucky",
                                                    "LA" => "Louisiana",
                                                    "ME" => "Maine",
                                                    "MD" => "Maryland",
                                                    "MA" => "Massachusetts",
                                                    "MI" => "Michigan",
                                                    "MN" => "Minnesota",
                                                    "MS" => "Mississippi",
                                                    "MO" => "Missouri",
                                                    "MT" => "Montana",
                                                    "NE" => "Nebraska",
                                                    "NV" => "Nevada",
                                                    "NH" => "New Hampshire",
                                                    "NJ" => "New Jersey",
                                                    "NM" => "New Mexico",
                                                    "NY" => "New York",
                                                    "NC" => "North Carolina",
                                                    "ND" => "North Dakota",
                                                    "OH" => "Ohio",
                                                    "OK" => "Oklahoma",
                                                    "OR" => "Oregon",
                                                    "PA" => "Pennsylvania",
                                                    "RI" => "Rhode Island",
                                                    "SC" => "South Carolina",
                                                    "SD" => "South Dakota",
                                                    "TN" => "Tennessee",
                                                    "TX" => "Texas",
                                                    "UT" => "Utah",
                                                    "VT" => "Vermont",
                                                    "VA" => "Virginia",
                                                    "WA" => "Washington",
                                                    "WV" => "West Virginia",
                                                    "WI" => "Wisconsin",
                                                    "WY" => "Wyoming"
                                                    );
                                       foreach ($states as $abbr => $name):
                                       ?>
                                       <option value="<?=$abbr?>" <?=(!empty($this->vars['stateseminar']) && array_key_exists('state',$this->vars['stateseminar']) && $this->vars['stateseminar']['state'] == $abbr)?'selected':''?>><?=$name?></option>
                                    <? endforeach; ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        <h3 class="form-section text-info"><strong>Picture (optional)</strong></h3>
                        <p>You can upload a picture to make your stateseminar more appealing.  From an SEO perspective, stateseminars with a picture are much better received by search engines.</p>
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
                              if(!empty($this->vars['stateseminar']) && array_key_exists('_id',$this->vars['stateseminar'])){
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
                           <button class="btn blue all-stateseminars">Go to All StateSeminars</button>
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
                           <p>Are you sure you want to delete this stateseminar?  Deleting will purge the entire stateseminar including all photos and comments.  This operation cannot be undone.</p>
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
         <?=$this->element('js/StateSeminar.js');?>
         <?=$this->element('js/ClearField.js');?>
         <script>
         jQuery(document).ready(function() {    
            io.saw.StateSeminar.init();
            io.saw.ClearField.init({formArr:['#saw-form']}); 
         });
            
         </script>

