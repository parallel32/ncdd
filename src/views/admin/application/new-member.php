<!-- BEGIN CONTAINER -->   
<div class="page-container row-fluid">
   <!-- BEGIN PAGE CONTAINER-->
   <div class="container-fluid">
      <!-- BEGIN PAGE HEADER-->
         <div class="row-fluid">
            <div class="span12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title text-center">
                  <a href="//<?=SAW_CONSUMER_WEBSITE?>"><img src="<?=SAW_SSL_CDN?>/assets/img/ncdd-login2-logo.png"></a>
                  <br/>General Member Application Form
               </h3>
               <p class="text-center">
                  
                  National College for DUI Defense, Inc. 
                  <br/>445 S. Decatur St. 
                  <br/>Montgomery, AL 36104
                  <br/>Tel: 334-264-1950
                  <br/>Fax: 334-264-1920
               </p>
               <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
         </div>
         <div class="row-fluid">
            <div class="span12">
               <h4 class="page-title text-center">Please Review Our <a href="//<?=SAW_CONSUMER_WEBSITE?>/become-a-member">Membership Eligibility Rules</a></h4>
            </div>
         </div>
         
         <div class="row-fluid">
            <div class="span12">
            <h4 class="page-title">Our Annual Membership Dues</h4>
            <? if( $this->vars['dues'][1]['amount'] == $this->vars['dues'][1]['prorated']['a']): ?>
               <p><h4>Attorneys in practice for less than 6 years: $<?=$this->vars['dues'][1]['amount']?></h4></p>
            <? else: ?>
               <p><h4>Attorneys in practice for less than 6 years: $<?=$this->vars['dues'][1]['amount']?>, currently pro-rated at $<?=$this->vars['dues'][1]['prorated']['a']?> to the end of the calendar year.</h4></p>
            <? endif; ?>
            
            <? if( $this->vars['dues'][6]['amount'] == $this->vars['dues'][6]['prorated']['a']): ?>
               <p><h4>Attorneys in practice for 6 years or more: $<?=$this->vars['dues'][6]['amount']?></h4></p>
            <? else: ?>
               <p><h4>Attorneys in practice for 6 years or more: $<?=$this->vars['dues'][6]['amount']?>, currently pro-rated at $<?=$this->vars['dues'][6]['prorated']['a']?> to the end of the calendar year.</h4></p>
            <? endif; ?>
            
            <? if( $this->vars['dues']['publicDefender']['amount'] == $this->vars['dues']['publicDefender']['prorated']['a']): ?>
               <p><h4>Attorneys in practice as Public Defenders: $<?=$this->vars['dues']['publicDefender']['amount']?></h4></p>
            <? else: ?>
               <p><h4>Attorneys in practice as Public Defenders: $<?=$this->vars['dues']['publicDefender']['amount']?>, currently pro-rated at $<?=$this->vars['dues']['publicDefender']['prorated']['a']?> to the end of the calendar year.</h4></p>
            <? endif; ?>
            
            
            </div>
         </div>
         
         <!-- END PAGE HEADER-->
         <!-- BEGIN PAGE CONTENT-->
         <div class="row-fluid">
            <div class="span12">
               <!-- BEGIN FORM-->
               <form id="saw-form" class="horizontal-form portlet">
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>                  
                  <h3 class="form-section">1.</h3>
                  <div class="row-fluid">
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">First Name</label>
                           <div class="controls">
                              <input type="text" name="doc[firstName]" class="m-wrap span12 firstName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">Middle Initial</label>
                           <div class="controls">
                              <input type="text" name="doc[middleName]" class="m-wrap span12 middleName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group ">
                           <label class="control-label">Last Name</label>
                           <div class="controls">
                              <input type="text" name="doc[lastName]" class="m-wrap span12 lastName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Telephone</label>
                           <div class="controls">
                              <input id="phone" type="text" name="doc[phone]" class="m-wrap span12 phone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Facsimile</label>
                           <div class="controls">
                              <input id="fax" type="text" name="doc[fax]" class="m-wrap span12 fax">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  

                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Cell Phone</label>
                           <div class="controls">
                              <input type="text" name="doc[cellphone]" class="m-wrap span12 cellphone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Would you like to receive text alerts?</label>
                           <div class="controls">
                              <select class="small m-wrap textAlertsOpt" name="doc[textAlertsOpt]">
                                 <option value=""></option>
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              </select>
                              <span class="help-block">Highly recommended.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <input type="hidden" name="doc[textAlertsOpt]" class="m-wrap span12 textAlertsOpt" value="yes">
                     
                  </div>
                  

                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Bar Number / State</label>
                           <div class="controls">
                              <input type="text" name="doc[barNumber]" class="m-wrap span12 barNumber">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Email</label>
                           <div class="controls">
                              <input type="text" name="doc[email]" class="m-wrap span12 email">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Website</label>
                           <div class="controls">
                              <input type="text" name="doc[website]" class="m-wrap span12 website">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Would you like to be added to the NCDD List Server?</label>
                           <div class="controls">
                              <select class="small m-wrap addToListServ" name="doc[addToListServ]">
                                 <option value=""></option>
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              </select>
                              <span class="help-block">Highly recommended.</span>
                           </div>
                        </div>
                     </div>
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Listserv Email (if different from above)</label>
                           <div class="controls">
                              <input type="text" name="doc[listServEmail]" class="m-wrap span12 listServEmail">
                           </div>
                        </div>
                     </div>
                  </div>
                  <input type="hidden" name="doc[addToListServ]" class="m-wrap span12 addToListServ" value="yes">
                  <!-- BEGIN ADDRESS -->
                  <h3 class="form-section">Business Address</h3>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 1</label>
                           <div class="controls">
                              <input type="text" id="address1" name="doc[address1]" class="m-wrap span12 address1">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 2</label>
                           <div class="controls">
                              <input type="text" id="address2" name="doc[address2]" class="m-wrap span12 address2">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
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
                  <div class="row-fluid addr ">
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
                  <h3 class="form-section text-info"><strong>Geocode Your Address</strong></h3>
                  <p>We attempt to determine the Latitude and Longitude of your address for future searches based on a client's nearby location</p>
                  <div class="row-fluid validateAddress">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Type in your full address and then click Submit for Geocoding:</label>
                           <div class="controls">
                              <input type="text" id="geocodeaddress" class="m-wrap span12 geocodeaddress" >
                              <button type="button" class="btn blue geocodeaddress">Submit for Geocoding <i class="icon-globe"></i></button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <input type="hidden" name="doc[formattedAddress]" id="raw">
                  <input type="hidden" name="doc[lat]" id="lat">
                  <input type="hidden" name="doc[lon]" id="lon">
                  <!-- BEGIN ADDRESS MODAL -->

<script>
jQuery(document).ready(function() {
   var geocoding_started = false;
   $('#country').keyup(function(e){
      if(!geocoding_started){
         $('#saw-form .btn.geocodeaddress').trigger('click');
         geocoding_started = true;
      }
   });
   $('#country').change(function(e){
      if(!geocoding_started){
         $('#saw-form .btn.geocodeaddress').trigger('click');
         geocoding_started = true;
      }
   });
   $('#geocodeaddress').focus(function(e){
      if(!geocoding_started){
         $('#saw-form .btn.geocodeaddress').trigger('click');
         geocoding_started = true;
      }
   });    
});      
</script>
                  <div id="address_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="address-modal-label" aria-hidden="true">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="address-modal-label">GEOCODE Your Address</h3>
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
                                                   Loading Address...
                                                </td>
                                                <td><a class="btn mini purple hide" 
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
                        <button class="btn address-cancel" aria-hidden="true">Cancel</button>
                     </div>
                  </div>
                  <!-- END ADDRESS MODAL -->
                  <!-- END ADDRESS -->
                  <h3 class="form-section">2.</h3>
                  <div class="row-fluid">
                     <div class="span6">
                        <div class="control-group">
                           <label class="control-label">How did you hear about the NCDD?</label>
                           <div class="controls">
                              <select name="doc[hearAboutNCDD]" class="m-wrap span6 hearAboutNCDD">
                              <option value="">Please select</option>
                              <option value="Google">Google</option>
                              <option value="Yahoo">Yahoo</option>
                              <option value="Bing">Bing</option>
                              <option value="Other Search Engine">Other Search Engine</option>
                              <option value="Friend/Collegue">Friend/Collegue</option>
                              <option value="Existing Member">Existing Member</option>
                              <option value="Seminar">Seminar</option>
                              <option value="NCDD Promotion">NCDD Promotion</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">3.</h3>
                  <div class="row-fluid">
                     <div class="span6">
                        <div class="control-group">
                           <label class="control-label">Year of admission to practice:</label>
                           <div class="controls">
                              <select name="doc[yearsInLawPractice]" class="m-wrap span6 yearsInLawPractice">
                              <option value="">Please select</option>
                              <? for($i=(int)date('Y'); $i >= (int)date('Y')-20; $i--){ ?>
                              <option value="<?=$i?>"><?=$i?></option>
                              <? } ?>
                              <option value="1995">More than 20 years ago</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">4.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Are you a full time Public Defender?</label>
                           <div class="controls">
                              <select class="small m-wrap publicDefender" name="doc[publicDefender]">
                                 <option value="no">No</option>
                                 <option value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">5. Check all that apply.  Please supply an explanation for those which do not apply.</h3>
                  <div class="row-fluid">
                     <div class="span6">
                        <div class="control-group">
                           <label class="control-label">I am an attorney presently admitted and licensed and currently eligible to practice law.</label>
                           <div class="controls">
                              <div class="success-toggle-button">
                                 <select class="small m-wrap licensedInUSAAustraliaCanada" name="doc[licensedInUSAAustraliaCanada]">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If you selected "No", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 licensedInUSAAustraliaCanadaExplain" name="doc[licensedInUSAAustraliaCanadaExplain]"></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6">
                        <div class="control-group">
                           <label class="control-label">I have not been the subject of a professional inquiry and have not had discipline imposed upon me by any jurisdiction in which I am licensed or permitted to practice. I also agree that I shall immediately report to the College any such inquiry or discipline as a condition of my continued membership in the College.</label>
                           <div class="controls">
                              <div class="success-toggle-button">
                                 <select class="small m-wrap everInvestigation" name="doc[everInvestigation]">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If you selected "No", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everInvestigationExplain" name="doc[everInvestigationExplain]"></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6">
                        <div class="control-group">
                           <label class="control-label">I am not presently serving, in any capacity, either part time or full time, in law enforcement or prosecution agencies and understand that any future service requires my immediate disclosure to the NCDD and termination of my membership.</label>
                           <div class="controls">
                              <div class="success-toggle-button">
                                 <select class="small m-wrap everLawEnforcement" name="doc[everLawEnforcement]">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If you selected "No", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everLawEnforcementExplain" name="doc[everLawEnforcementExplain]"></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>



            <? if(false): ?>
                  <h3 class="form-section">4.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">% of business in DUI defense:</label>
                           <div class="controls">
                              <input type="text" name="doc[percentDUIDefense]" class="m-wrap span12 percentDUIDefense">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">5.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Are jury trials available in your state?</label>
                           <div class="controls">
                              <select class="small m-wrap juryTrialsAvailableInYourState" name="doc[juryTrialsAvailableInYourState]">
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">6.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Approximate number of DUI/DWI jury trials you have handled:</label>
                           <div class="controls">
                              <select class="small m-wrap numberDUITrialsHandeled" name="doc[numberDUITrialsHandeled]">
                                 <option value="10">Fewer than 10</option>
                                 <option value="11">11 to 30</option>
                                 <option value="31">31 or more</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">7.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Approximate number of DUI/DWI non-jury trials you have handled: </label>
                           <div class="controls">
                              <select class="small m-wrap numberNonDUITrialsHandeled" name="doc[numberNonDUITrialsHandeled]">
                                 <option value="10">Fewer than 10</option>
                                 <option value="11">11 to 30</option>
                                 <option value="31">31 or more</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">8.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Have you ever been arrested, prosecuted, convicted or received a “deferred” or “diverted” disposition on any criminal offense other than a minor traffic offense?</label>
                           <div class="controls">
                              <select class="small m-wrap everBeenArrested" name="doc[everBeenArrested]">
                                 <option value="no">No</option>
                                 <option value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everBeenArrestedExplain" name="doc[everBeenArrestedExplain]"></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">9.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Have you ever had a complaint/charge made against you by your State Bar Association or licensing authority arising from drug/substance/alcohol use or abuse?</label>
                           <div class="controls">
                              <select class="small m-wrap everChargedByBar" name="doc[everChargedByBar]">
                                 <option value="no">No</option>
                                 <option value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everChargedByBarExplain" name="doc[everChargedByBarExplain]"></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">10.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Have you ever been convicted or received a “deferred” or “diverted” disposition of any crime involving moral turpitude?</label>
                           <div class="controls">
                              <select class="small m-wrap everConvictedCrime" name="doc[everConvictedCrime]">
                                 <option value="no">No</option>
                                 <option value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everConvictedCrimeExplain" name="doc[everConvictedCrimeExplain]"></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">11.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">I have not been the subject of a professional inquiry and have not had discipline imposed upon me by any jurisdiction in which I am licensed or permitted to practice. I also agree that I shall immediately report to the College any such inquiry or discipline as a condition of my continued membership in the College.</label>
                           <div class="controls">
                              <select class="small m-wrap everInvestigation" name="doc[everInvestigation]">
                                 <option value="no">No</option>
                                 <option value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everInvestigationExplain" name="doc[everInvestigationExplain]"></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">12.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">I am not presently serving, in any capacity, either part time or full time, in law enforcement or prosecution agencies and understand that any future service requires my immediate disclosure to NCDD and termination of my membership.</label>
                           <div class="controls">
                              <select class="small m-wrap everLawEnforcement" name="doc[everLawEnforcement]">
                                 <option value="no">No</option>
                                 <option value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everLawEnforcementExplain" name="doc[everLawEnforcementExplain]"></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">13. a)</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">I understand that any future service in any branch of law enforcement or prosecution of state, province, county district or municipal ordinances/statutes requires my immediate disclosure to NCDD and termination of my membership. </label>
                           <div class="controls">
                              <select class="small m-wrap futureLawEnforcement" name="doc[futureLawEnforcement]">
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <!-- commented out by request from Rhea.
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 futureLawEnforcementExplain" name="doc[futureLawEnforcementExplain]"></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">13. b)</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">I am an attorney presently admitted and licensed and currently eligible to practice law in a state or province of the United States, Canada or Australia. </label>
                           <div class="controls">
                              <select class="small m-wrap licensedInUSAAustraliaCanada" name="doc[licensedInUSAAustraliaCanada]">
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
            <? endif;?>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">
                           I have substantial current involvement in the practice area of DUI/DWI defense and I understand that as a condition of continued membership I am expected to have substantial involvement, including attendance at one (or more) seminars every two (2) years either sponsored by NCDD or at a State/local seminar approved by NCDD.
                           <br><span class="control-group"><span class="controls"><input type="checkbox" name="doc[twoSeminarsAcknowledgement]" class="twoSeminarsAcknowledgement" value="yes"><b>Yes, I acknowledge this.</b></span></span>
                           </br></br>
                           I have read the general membership rules, and I understand and agree to be bound by them as they are presently published and as they may be amended from time to time during my membership.
                           </br></br>
                           I declare under penalty of perjury that the foregoing statements are true and correct to the best of my knowledge.
                           </label>
                           <div class="controls">
                              </br>
                              <div class="input-prepend input-append">
                                 <span class="add-on">Executed at </span>
                                 <input name="doc[executed]" class="m-wrap span12 executed" type="text" placeholder="city, state/province">
                                 <span class="add-on">, this <? $date = new \DateTime(); echo $date->format('dS');?> day of <?echo $date->format('F');?>, 20<?echo $date->format('y');?></span>
                              </div>
                           </div>
                           
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"></label>
                           <div class="input-prepend input-append">
                              <span class="add-on">Printed Name </span>
                              <input name="doc[executedPrintedName]" class="m-wrap span12 executedPrintedName" type="text" placeholder="">
                              <? $date = new \DateTime(); $datee = $date->format('dS').' of '.$date->format('F').', 20'.$date->format('y'); ?>
                              <input name="doc[executedPrintedNameDate]" class="m-wrap span12 executedPrintedNameDate" type="hidden" value="<?=$datee?>">
                              <span class="add-on"> <?=$datee?></span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <input name="doc[authorizationReleasePrintedName]" class="m-wrap span12 authorizationReleasePrintedName" type="hidden" value="">
                  <input name="doc[authorizationReleasePrintedNameDate]" class="m-wrap span12 authorizationReleasePrintedNameDate" type="hidden" value="">
                  
                  
                  <!--
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Please download this zip file containing the reference form along with the authorization and release form and confirm you did so by selecting "Yes": <br>
                              <a target="_blank" href="https://<?=SAW_ADMIN_WEBSITE?>/application/downloads/ncdd-general-membership-reference-form-auhtorization-release.zip">New Member Application Reference Form & Authoriztion and Release Form - click to download the ZIP file.</a>
                           </label>
                           <div class="controls">
                              <select class="large m-wrap referenceFormDownload" name="doc[referenceFormDownload]">
                                 <option value="no">No, I have not downloaded the reference form.</option>
                                 <option value="yes">Yes, I have downloaded the reference form.</option>
                              </select>
                              <span class="help-block"></span>
                              <h4><strong>Please make sure your 2 references send their forms ASAP to the address at the top of the reference form via fax, email, or U.S. mail.</strong></h4>
                           </div>
                        </div>
                     </div>
                     <!--/span--
                  </div>
                  -->
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Referred By:</label>
                           <div class="controls">
                              <input type="text" name="doc[referredBy]" class="m-wrap span12 referredBy">
                              <span class="help-block">If someone referred you, who is already a member, please type their name here.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">Promotional Code</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
<!--                            <label class="control-label">Enter   the   promo code  BONUS2015 and pay   your  2016  dues  in full in order to obtain   
the   remainder of 2015 for free.  Offer expires December 31, 2015. </label> -->
                           <div class="controls">
                              <input type="text" name="doc[promocode]" class="m-wrap span12 promocode" value="">
                              <input type="hidden" id="promocodetype" value="">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div id="promocodeverification" class="row-fluid hide">
                     
                  <?
                  if(array_key_exists('promos',$this->vars) 
                           && is_array($this->vars['promos']) 
                           && !empty($this->vars['promos']) ):
                     foreach ($this->vars['promos'] as $promo):
                     ?>
                     <input type="hidden" class="freeMembershipPmtAmt <?=strtolower($promo['code'])?>x" value="<?=(array_key_exists('freeMembershipPmtAmt', $promo)) ? $promo['freeMembershipPmtAmt']:''?>">
                     <div class="row-fluid">
                        <div class="span6 promocodeblocks <?=strtoupper($promo['code'])?>">
                        <? if($promo['discountAmt'] > 0): ?>
                           <p class="promo-discount">
                              Discount: <b><?=($promo['currentType'] == \Saw\Model\Promotion::$type['MONEY']) ? "$": '';?><?=$promo['discountAmt']?><?=($promo['currentType'] == \Saw\Model\Promotion::$type['PERCENT']) ? "%": '';?></b>
                           </p>
                           <br>
                        <? endif; ?>
                           <? if($promo['optInOnOff'] == 'on'){?>
                           <p class="alert alert-info">
                              <b><?=$promo['optInDisclosure']?></b>
                              <br><span class="control-group"><span class="controls"><input type="checkbox" name="doc[optIn]" class="optIn" value="yes">Yes, I agree.</span></span>
                           </p>
                           <? } ?>
                        </div>                     
                     </div>
                     <div class="row-fluid">
                        <div class="span6 promocodeblocks <?=strtoupper($promo['code'])?>">
                           <? if($promo['gift'] == 'yes'){?>
                           <p class="">
                              <b><?=$promo['giftName']?></b>&nbsp;-&nbsp;A $<?=$promo['giftDollarValue']?> value.
                              <br>
                              <?=$promo['giftDesc']?>
                              <br>
                              <img src="<?=$this->app['getImageURL']($promo['image'],'small')?>" width="200">
                           </p>
                           <? } ?>
                        </div>
                     </div>
                     <? endforeach; ?>
                  <? endif; ?>
                  </div>
                  
                  
                  
                  <!-- PAYMENT ELEMENT -->
                  <style>
                  .card {
                  float: left;
                  width: 39px;
                  height: 25px;
                  text-indent: -9999px;
                  background-position: 0 0;
                  background-repeat: no-repeat;
                  padding-right: 2px;
                  }
                  
                  .card.visa {
                  background-image: url('/assets/img/card-visa.gif');
                  }
                  .card.master {
                  background-image: url('/assets/img/card-mastercard.gif');
                  }
                  .card.amex {
                  background-image: url('/assets/img/card-amex.gif');
                  }
                  .card.discover {
                  background-image: url('/assets/img/card-discover.gif');
                  }
                  </style>
                  <script>
                  // less than six years
                  var lsix_amount = <?=$this->vars['dues'][1]['amount']?>;
                  var lsix_prorated = <?=$this->vars['dues'][1]['prorated']['a']?>;
                  var lsix_message = 'Attorneys in practice for less than 6 years';
                  // greater than or equal to six years
                  var gsix_amount = <?=$this->vars['dues'][6]['amount']?>;
                  var gsix_prorated = <?=$this->vars['dues'][6]['prorated']['a']?>;
                  var gsix_message = 'Attorneys in practice for 6 or more years';
                  // public defenders
                  var pd_amount = <?=$this->vars['dues']['publicDefender']['amount']?>;
                  var pd_prorated = <?=$this->vars['dues']['publicDefender']['prorated']['a']?>;
                  var pd_message = 'Public Defender';
                  jQuery(document).ready(function() {  
 
                     $('#pay-by-cc').click(function(e){
                        e.preventDefault();
                        $('#payment-form .currentPaymentType').val('<?=\Saw\Model\Payment::$paymentType['CREDIT']?>');
                        $('#payment-information-billing').removeClass('hide');
                        $('#payment-information-cc').removeClass('hide');
                        $('#payment-information-check').addClass('hide');
                     });
                     <? if(false):?>
                     $('#pay-by-check').click(function(e){
                        e.preventDefault();
                        $('#payment-form .currentPaymentType').val('<?=\Saw\Model\Payment::$paymentType['CHECK']?>');
                        $('#payment-information-cc').addClass('hide');
                        $('#payment-information-check').removeClass('hide');
                        $('#payment-information-billing').removeClass('hide');
                     });
                     <? endif; ?>
                  });      

                  </script>
                  <div id="payment-form">
                     
                     <input type="hidden" class="payment memberId" name="doc[payment][memberId]" value="">
                     <input type="hidden" class="payment description" name="doc[payment][description]" value="<?='INV-'.time();?>">
                     <input type="hidden" class="payment title" name="doc[payment][title]" value="New Member Application">
                     <input type="hidden" class="payment amount" name="doc[payment][amount]" value="">
                     <input type="hidden" class="payment cardType" name="doc[payment][cardType]" value="">
                     <input type="hidden" class="payment currentPaymentType" name="doc[payment][currentPaymentType]" value="">
                     <input type="hidden" class="payment token" name="doc[payment][token]" value="">
                     <h3 class="form-section">Payment Amount</h3>
                     <div class="row-fluid">
                        <h4>$<i class="payment amount"></i></h4>                        
                     </div>
                     <br><br>
                  <div id="payment-information" class="">
                     <h3 class="form-section">Payment Information</h3>
                     <div class="row-fluid">
                        <? if(false):?>
                        <h4>Please select a payment method:</h4>
                        <? endif; ?>
                        <button id="pay-by-cc" type="button" class="btn blue pay-by-cc">Pay by Credit Card</button>
                        <? if(false): ?>
                        <button id="pay-by-check" type="button" class="btn blue pay-by-check">Pay by Check</button>
                        <? endif; ?>
                     </div>
                     <br><br>

                     










                     <? if (false): ?>
                     <?
                     //////////////////
                     // PAY BY CHECK //
                     //////////////////
                     ?>
                     <div id="payment-information-check" class="hide">
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Check Number</label>
                              <div class="controls">
                                 <input id="check-number" type="text" name="doc[payment][checkNumber]" class="m-wrap span8 payment checkNumber">
                                 <span class="help-block">This refers to the number, which is usually located on the top right corner of checks.</span>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Checking Account Type</label>
                              <div class="controls">
                                 <select id="check-account-type" class="span4 payment accountType" name="doc[payment][accountType]">
                                    <option value="pc">Primary checking</option>
                                    <option value="ps">Primary savings</option>
                                    <option value="bc">Backup checking</option>
                                    <option value="bs">Backup savings</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Checking Account Number</label>
                              <div class="controls">
                                 <input id="check-account-number" type="text" name="doc[payment][accountNumber]" class="m-wrap span8 payment accountNumber">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Checking Routing Number</label>
                              <div class="controls">
                                 <input id="check-routing-number" type="text" name="doc[payment][routingNumber]" class="m-wrap span8 payment routingNumber">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Your Driver's License Number</label>
                              <div class="controls">
                                 <input id="check-driving-license-number" type="text" name="doc[payment][drivingLicenseNumber]" class="m-wrap span8 payment drivingLicenseNumber">
                                 <span class="help-block">This should be the driver's license number of the owner of the checking account.</span>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Your Driver's License State</label>
                              <div class="controls">
                                 <input id="check-driving-license-state" type="text" name="doc[payment][drivingLicenseState]" class="m-wrap span8 payment drivingLicenseState">
                                 <span class="help-block">This should be the state in which the driver's license was issued.</span>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     </div>
                     <? endif; ?>








                     <?
                     ///////////////////
                     // PAY BY CREDIT //
                     ///////////////////
                     ?>
                     <div id="payment-information-cc" class="hide">
                     <div class="row-fluid">
                        <div class="span12 ">
                           <div class="control-group">
                              <label class="control-label" for="type">We Accept</label>
                              <div class="controls">
                                 <span class="card visa" title="Visa">Visa</span>
                                 <span class="card master" title="Mastercard">Mastercard</span>
                                 <span class="card amex" title="American Express">American Express</span>
                                 <span class="card discover" title="Discover">Discover</span>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span12 "><span class="cardType"></span></div>
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Your name as it appears on the card</label>
                              <div class="controls">
                                 <input id="card-name" type="text" name="doc[payment][name]" class="m-wrap span8 payment name" value="">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Credit Card Number</label>
                              <div class="controls">
                                 <input id="card-number" type="text" name="doc[payment][number]" class="m-wrap span8 payment number">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">CVC Code</label>
                              <div class="controls">
                                 <input id="card-cvc" type="text" name="doc[payment][cvc]" class="m-wrap span8 payment cvc">
                                 <span class="help-block">This is the 3 or 4 digit security code on your card. </span>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Expiration Date</label>
                              <div class="controls">
                                 <select id="card-expMonth" class="span4 payment expMonth" name="doc[payment][expMonth]"></select>
                                 <select id="card-expYear" class="span4 payment expYear" name="doc[payment][expYear]"></select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     </div>

                     <div id="payment-information-billing" class="hide">
                     <h3 class="form-section">Billing Address</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Address Line 1</label>
                              <div class="controls">
                                 <input id="card-addressLine1" type="text" name="doc[payment][addressLine1]" class="m-wrap span8 payment addressLine1" value="">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Address Line 2</label>
                              <div class="controls">
                                 <input id="card-addressLine2" type="text" name="doc[payment][addressLine2]" class="m-wrap span8 payment addressLine2" value="">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">City</label>
                              <div class="controls">
                                 <input id="card-city" type="text" name="doc[payment][city]" class="m-wrap span8 payment city billingcity" value="">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">State/Province/Region</label>
                              <div class="controls">
                                 <select id="card-stateProvinceRegion" name="doc[payment][stateProvinceRegion]" class="m-wrap span8 payment stateProvinceRegion billingstate"></select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Zip/PostalCode</label>
                              <div class="controls">
                                 <input id="card-zipPostalCode" type="text" name="doc[payment][zipPostalCode]" class="m-wrap span8 payment zipPostalCode" value="">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Country</label>
                              <div class="controls">
                                 <select id="card-country" name="doc[payment][country]" class="m-wrap span8 payment country billingcountry">
                                 <option value="US">USA</option>
                                 <option value="CA">CANADA</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <h3 class="form-section">Credit Card Contact Information</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Email</label>
                              <div class="controls">
                                 <input id="card-email" type="text" name="doc[payment][email]" class="m-wrap span8 payment email" value="">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Phone</label>
                              <div class="controls">
                                 <input id="card-phone" type="text" name="doc[payment][phone]" class="m-wrap span8 payment phone" value="">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     </div>
                  </div>
                  </div>
                  <!--/ PAYMENT ELEMENT -->


                  <br>                  
                  <div class="row-fluid">
                     <div class="span10 ">
                        <p class="alert">
                        <b>As is the policy of the NCDD, the application process shall not directly or indirectly discriminate against any applicant for reason of race, color, gender, age, religion, disability, national origin, ancestry, marital status, sexual orientation, parental status, military discharge status, or income status.</b>
                        </p>
                        
                     </div>
                  </div>
                  

                  <!-- SUCCESSFUL SAVE MODAL -->
                  <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="save-success-label">Successful Operation</h3>
                     </div>
                     <div class="modal-body">
                        <p></p>
                     </div>
                     <div class="modal-footer">
                        <button class="btn blue continue" data-insertid="">Return to NCDD.com</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  
                  <div class="form-actions text-center">
                     <? $user = $this->app['session']->get('user');
                           if(is_array($user) && array_key_exists('accessLevel', $user)){
                           if($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )){  
                        ?>
                        <input type="checkbox" name="suppress_emails" <?=(array_key_exists('suppress_emails',$user) && !empty($user['suppress_emails']))?'checked':'';?> value="yes">Suppress Emails.
                        <? }} ?>
                     <button type="button" class="btn green"><i class="icon-ok"></i> Submit Application</button>
                     <button type="button" class="btn cancel-go-back">Cancel and Go Back</button>
                  </div>
               </form>
               <!-- END FORM--> 
            </div>
         </div>
         <!-- END PAGE CONTENT-->

   </div>
   <!-- END PAGE CONTAINER -->
</div>
<!-- END CONTAINER -->
<?=$this->element('js/Application.js');?>
<?=$this->element('js/Address.js');?>
<?=$this->element('js/CountryState.js');?>
<script>
jQuery(document).ready(function() {    
   $('.billingcountry').change(function(e){
        var $el = $('.billingstate');
        $el.empty();
        if($(this).val() == 'US'){
            var list = usa;
        }else{
            var list = canada;
        }
        $.each(list, function(key,value) {
          $el.append($("<option></option>")
             .attr("value", value.short).text(value.name));
        });
    })
    $.each(usa, function(key,value) {
      $('.billingstate').append($("<option></option>")
         .attr("value", value.short).text(value.name));
    });
});    
calculatedues = function(){
   $('#calculate-dues').html('Please answer all the questions in order to calculate your membership dues.');
   var years = $('#saw-form .yearsInLawPractice').val();
   if($('#saw-form .publicDefender').val() == 'yes'){
      $('#calculate-dues').html('$50.00');
   } else if($('#saw-form .publicDefender').val() == 'yes'){
      calculatedues();
   } else if(years.length > 0){
      if (new Date().getFullYear() - parseInt(years) < 6){
         $('#calculate-dues').html('$175.00');
      }
      if (new Date().getFullYear() - parseInt(years)  >= 6){
         $('#calculate-dues').html('$225.00');
      }
   }
   return true;
};  
jQuery(document).ready(function() {    
   io.saw.Application.newMemberInit();
   io.saw.Address.init('#saw-form');
   $('#saw-form .publicDefender').change(function(){
      calculatedues();
   });
   $('#saw-form .yearsInLawPractice').keyup(function(){
      calculatedues();
   })
   window.setInterval(calculatedues,1000);

   $('#pay-by-cc').trigger('click');
   //$('.promocode').keyup();
});      
</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
(function( Payment, $, undefined ) {
   
   var params = {};

   function validateCVC(cvc){
      if(Stripe.validateCVC(cvc.val())){
         cvc.parents('.control-group').removeClass('error');// remove the red highlight
         cvc.next('.help-inline').remove(); // remove the error text
         $('#saw-form .control-group').find('.help-block.error').remove(); // remove help blocks too
      }else{
         // bootstrap field to red with error message
         cvc.parents('.control-group').addClass('error');
         if(cvc.next('.help-inline').length == 0){
            cvc.after('<span class="help-inline">A valid security code is required.</span>');
         }
      }
   }
   function validateCardNumber(card){
      if(Stripe.validateCardNumber(card.val())){
            card.parents('.control-group').removeClass('error');// remove the red highlight
            card.next().remove(); // remove the error text
            $('#saw-form .control-group').find('.help-block.error').remove(); // remove help blocks too
            $('#saw-form .card').css('backgroundPosition','0 -25px');
            switch (Stripe.cardType(card.val())){
               case 'Visa':
                  $('#saw-form .card.visa').css('backgroundPosition','0 0px');
                  break;
               case 'MasterCard':
                  $('#saw-form .card.master').css('backgroundPosition','0 0px');
                  break;
               case 'American Express':
                  $('#saw-form .card.amex').css('backgroundPosition','0 0px');
                  break;
               case 'Discover':
                  $('#saw-form .card.discover').css('backgroundPosition','0 0px');
                  break;         
            }
            $('#saw-form .cardType').html(Stripe.cardType(card.val()));
         }else{
            // bootstrap field to red with error message
            card.parents('.control-group').addClass('error');
            if(card.next('.help-inline').length == 0){
               card.after('<span class="help-inline">A valid card number is required.</span>');
            }
         }
   }
   Payment.initiateRegistration = function () {
      $('.submit-registration').html('<i class="icon-time"></i> Processing your registration..');
      $('.submit-registration').attr("disabled", "disabled");
      io.saw.Registration.doRegistration();
   }
   Payment.hold_card = '';
   Payment.init = function(){
      
      // validate card number
      $('#saw-form .number').blur(function(){
         validateCardNumber($(this));
      });
      // validate cvc check
      $('#saw-form .cvc').blur(function(){
         validateCVC($(this));
      });
         
   };
   
   
}( io.saw.Payment = io.saw.Payment || {}, io.saw.jQuery || jQuery ));
</script>
<script>
jQuery(document).ready(function() {    

   // init the credit card fields
   io.saw.Payment.init()
   // prepare the month dropdown
   var select = $("#card-expMonth"),
   month = new Date().getMonth() + 1;
   for (var i = 1; i <= 12; i++) {
      select.append($("<option value='"+i+"' "+(month === i ? "selected" : "")+">"+i+"</option>"))
   }

   // prepare the year dropdown
   var select = $("#card-expYear"),
   year = new Date().getFullYear();

   for (var i = 0; i < 12; i++) {
      select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
   }
   // end - init the credit card fields

});      
</script>