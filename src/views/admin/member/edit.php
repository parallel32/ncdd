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
                        <input type="hidden" name="doc[_id]" value="<?=$this->vars['member']['_id']?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h3 class="form-section text-info"><strong>Membership Information</strong></h3>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Member Status</label>
                                 <div class="controls">
                                    <img src="<?=$this->vars['member']['membershipBadge']?>">
                                    <? if($this->vars['member']['boardCertified']): ?>
                                       &nbsp;&nbsp;<img src="<?=$this->vars['member']['boardCertifiedBadge']?>">
                                    <? endif; ?>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <? if($this->vars['member']['currentFacultyPosition'] > 0): ?>
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Executive Status</label>
                                 <div class="controls">
                                    <img src="<?=$this->vars['member']['facultyBadge']?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <? endif; ?>
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Membership Badge for your website:</label>
                                 <div class="controls">
                                    <textarea rows="3" class="span8"><a target="_blank" href="http://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img src="http://<?=SAW_ADMIN_WEBSITE?>/badge/member/<?=$this->vars['member']['_id']?>" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?> <?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?> <?=$this->vars['member']['lastName']?>" /></a></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <? if($this->vars['member']['boardCertified']): ?>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Board Certified Badge for your website:</label>
                                 <div class="controls">
                                    <textarea rows="3" class="span8"><a target="_blank" href="http://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img src="http://<?=SAW_ADMIN_WEBSITE?>/badge/boardcertfified/<?=$this->vars['member']['_id']?>" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?> <?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?> <?=$this->vars['member']['lastName']?>" /></a></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <? endif; ?>
                        
                        <h3 class="form-section text-info"><strong>General Information</strong></h3>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">First Name</label>
                                 <div class="controls">
                                    <input type="text" name="doc[firstName]" value="<?=$this->vars['member']['firstName']?>" class="m-wrap span10 firstName">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Last Name</label>
                                 <div class="controls">
                                    <input type="text" name="doc[lastName]" value="<?=$this->vars['member']['lastName']?>" class="m-wrap span10 lastName">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Primary Phone</label>
                                 <div class="controls">
                                    <input type="text" name="doc[primaryPhone]" value="<?=$this->vars['member']['primaryPhone']?>" class="m-wrap span10 primaryPhone">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Primary Fax</label>
                                 <div class="controls">
                                    <input type="text" name="doc[primaryFax]" value="<?=$this->vars['member']['primaryFax']?>" class="m-wrap span10 primaryFax">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label">Specialize In:</label>
                                 <div class="controls">
                                    <input type="text" name="doc[specializeIn]" value="<?=$this->vars['member']['specializeIn']?>" class="m-wrap span11 specializeIn">
                                    <span class="help-block">Example:  DWI / DUI Defense</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label">About Me:</label>
                                 <div class="controls">
                                    <textarea cols="" rows="10" name="doc[aboutMe]" class="m-wrap span11 aboutMe"><?=strip_tags($this->vars['member']['aboutMe'],'<br /><br/><br>')?></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Authentication Information</strong></h3>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Email</label>
                                 <div class="controls">
                                    <input type="text" name="doc[email]" value="<?=$this->vars['member']['email']?>" class="m-wrap span10 email">
                                    <span class="help-block">Changing this also changes your Username for logging in.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Password</label>
                                 <div class="controls">
                                    <input type="text" name="doc[password]" class="m-wrap span10 password">
                                    <span class="help-block">To reset your password simply add a new one here. The old one will be overwritten.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Financial Information</strong></h3>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Fees</label>
                                 <div class="controls">
                                    <input type="text" name="doc[financialFees]" value="<?=$this->vars['member']['financialFees']?>" class="m-wrap span10 financialFees">
                                    <span class="help-block">Example: Free Consultation</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Payments Accepted</label>
                                 <div class="controls">
                                    <input type="text" name="doc[financialPayment]" value="<?=$this->vars['member']['financialPayment']?>" class="m-wrap span10 financialPayment">
                                    <span class="help-block">Example: Cash, Check, All major credit cards, and we offer a payment schedule.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info "><strong>Social Network Links</strong></h3>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Facebook</label>
                                 <div class="controls">
                                    <input type="text" name="doc[facebookUrl]" value="<?=$this->vars['member']['facebookUrl']?>" class="m-wrap span10 facebookUrl">
                                    <span class="help-block">Will not appear if left blank</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Twitter</label>
                                 <div class="controls">
                                    <input type="text" name="doc[twitterUrl]" value="<?=$this->vars['member']['twitterUrl']?>" class="m-wrap span10 twitterUrl">
                                    <span class="help-block">Will not appear if left blank</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Google Plus</label>
                                 <div class="controls">
                                    <input type="text" name="doc[googlePlusUrl]" value="<?=$this->vars['member']['googlePlusUrl']?>" class="m-wrap span10 googlePlusUrl">
                                    <span class="help-block">Will not appear if left blank</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">LinkedIn</label>
                                 <div class="controls">
                                    <input type="text" name="doc[linkedInUrl]" value="<?=$this->vars['member']['linkedInUrl']?>" class="m-wrap span10 linkedInUrl">
                                    <span class="help-block">Will not appear if left blank</span>
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
                           <button class="btn continue dashboard">Go To Dashboard</button>
                        </div>
                     </div>
                     <!--/ SUCCESSFUL SAVE MODAL -->

                     <h3 class="form-section text-info"><strong>Profile Photo</strong></h3>
                     <div class="row-fluid">
                        <div class="span4 ">
                           <div class="control-group ">
                              <label class="control-label"></label>
                              <div class="controls">
                                 <img src="/assets/img/avatar159X165.png">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                        <div class="span6 ">
                           <div class="control-group ">
                              <label class="control-label"></label>
                              <div class="controls">
                                 <button type="button" class="btn blue edit-photo">Edit My Photo</button>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <h3 class="form-section text-info"><strong>Additional Information</strong></h3>
                     
                     <!-- BEGIN LOCATION PORTLET-->
                     <div class="row-fluid">
                        <div class="span12">
                           <div id="location" class="portlet box blue">
                              <div class="portlet-title">
                                 <div class="caption">Office Locations</div>
                                 <div class="actions">
                                    <a class="btn green add"><i class=" icon-plus"></i> Add</a>
                                 </div>
                              </div>
                              <div class="portlet-body">
                                 <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                 <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                                    <thead>
                                       <tr role="row">
                                          <th class="">Address</th>
                                          <th class=""></th>
                                       </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                       <? if(!empty($this->vars['member']['locations'])): $i=0;foreach($this->vars['member']['locations'] as $location): ?>
                                       <tr class="gradeX odd">
                                          <td class=" "><?=$location['raw']?></td>
                                          <td class=" "><a data-id="<?=$i?>" class="btn red mini delete"></i> Delete</a></td>
                                       </tr>
                                       <? $i++; endforeach;?>
                                       <? else: ?>
                                          <td colspan="5">No records.</td>
                                       <? endif;?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>


                     <form id="location-form" class="horizontal-form">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h3 class="form-section text-info"><strong>Add Location</strong></h3>
                        <!-- BEGIN ADDRESS -->
                        <h3 class="form-section">Address</h3>
                        <div class="row-fluid validateAddress">
                           <div class="span12 ">
                              <div class="control-group">
                                 <label class="control-label" >Business Address</label>
                                 <span class="help-block">Type in your full address and then click Validate Address:</span>
                                 <div class="controls">
                                    <input type="text" id="geocodeaddress" class="m-wrap span12 formattedAddress" name="doc[formattedAddress]" >
                                    <button type="button" class="btn geocodeaddress">Validate Address</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <input type="hidden" name="doc[lat]" id="lat">
                        <input type="hidden" name="doc[lon]" id="lon">
                        <div class="row-fluid addr hide">
                           <div class="span12 ">
                              <div class="control-group">
                                 <label class="control-label" >Address 1</label>
                                 <div class="controls">
                                    <input type="text" id="address1" name="doc[address1]" class="m-wrap span12 address1">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row-fluid addr hide">
                           <div class="span12 ">
                              <div class="control-group">
                                 <label class="control-label" >Address 2</label>
                                 <div class="controls">
                                    <input type="text" id="address2" name="doc[address2]" class="m-wrap span12 address2">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row-fluid addr hide">
                           <div class="span6 ">
                              <div class="control-group">
                                 <label class="control-label" >City</label>
                                 <div class="controls">
                                    <input type="text" id="city" name="doc[city]" class="m-wrap span12 city"> 
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group">
                                 <label class="control-label" >State / Province</label>
                                 <div class="controls">
                                    <input type="text" id="state" name="doc[state]" class="m-wrap span12 state"> 
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <!--/row-->           
                        <div class="row-fluid addr hide">
                           <div class="span6 ">
                              <div class="control-group">
                                 <label class="control-label" >Postal Code</label>
                                 <div class="controls">
                                    <input type="text" id="zip" name="doc[postalCode]" class="m-wrap span12 postalCode"> 
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group">
                                 <label class="control-label" >Country</label>
                                 <div class="controls">
                                    <input type="text" id="country" name="doc[country]" class="m-wrap span12 country"> 
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <!-- BEGIN ADDRESS MODAL -->
                        <div id="address_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="address-modal-label" aria-hidden="true">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h3 id="address-modal-label">Select the Address</h3>
                              <p>Select the address which you intend to use.</p>
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
                                                      <th> Address</th>
                                                      <th> </th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                      <td class="highlight">
                                                         585 WELLS STREET .. ETC.
                                                      </td>
                                                      <td><a class="btn mini purple" 
                                                         data-address=""
                                                         data-city=""
                                                         data-state=""
                                                         data-zip=""
                                                         data-country=""
                                                         data-lat=""
                                                         data-lon=""
                                                         data-formattedaddress=""
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
                              <button class="btn cancel" aria-hidden="true">Cancel</button>
                           </div>
                        </div>
                        <!-- END ADDRESS MODAL -->
                        <!-- END ADDRESS -->
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
                     <!-- END LOCATION PORTLET-->
                  </div>
               </div>
               <!-- END PAGE CONTENT-->
            </div>
            <!-- END PAGE CONTAINER-->    
         </div>
         <!-- END PAGE -->
         <?=$this->element('js/Member.js');?>
         <?=$this->element('js/Address.js');?>

         <script>
         jQuery(document).ready(function() {    
            io.saw.Member.init();
            io.saw.Address.init('#location-form');
         });      
         </script>

