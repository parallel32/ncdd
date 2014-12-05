<!-- BEGIN CONTAINER -->   
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
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              </select>
                              <span class="help-block">Highly recommended.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Listserv Email (if different from above)</label>
                           <div class="controls">
                              <input type="text" name="doc[listServEmail]" class="m-wrap span12 listServEmail">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!-- BEGIN ADDRESS -->
                  <h3 class="form-section">Address</h3>
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
                                                   Loading Address...
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
                        <button class="btn address-cancel" aria-hidden="true">Cancel</button>
                     </div>
                  </div>
                  <!-- END ADDRESS MODAL -->
                  <!-- END ADDRESS -->
                  <h3 class="form-section">2.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">How did you hear about the NCDD?</label>
                           <div class="controls">
                              <input type="text" name="doc[hearAboutNCDD]" class="m-wrap span12 hearAboutNCDD">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">3.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Year of admission to practice:</label>
                           <div class="controls">
                              <input type="text" name="doc[yearsInLawPractice]" class="m-wrap span12 yearsInLawPractice">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">4.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Are you a Public Defender?</label>
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
                  <h3 class="form-section">6.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">
                           I have substantial current involvement in the practice area of DUI/DWI defense and I understand that as a condition of continued membership I must continue to have substantial involvement, including attendance at one (or more) seminars every two (2) years either sponsored by NCDD or at a State/local seminar approved by NCDD.
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

                  <h3 class="form-section">7. AUTHORIZATION AND RELEASE</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <h3 class="text-center"><u>PARTIES</u></h3>
                        <p>
                           <u>APPLICANT</u> - person applying for initial membership status or a present member applying for renewal of his or her membership status. </br><u>NCDD</u> - The National College for DUI Defense, Inc.
                        </p>
                        <h3 class="text-center"><u>ACKNOWLEDGEMENT</u></h3>
                        <p>
                           I understand and agree that as a condition of present and continuing membership in NCDD I shall immediately report all facts or circumstances relating thereto to the Executive Director of NCDD:
                        </p>
                        <p>
a.&nbsp;&nbsp;if any license or privilege to practice law that I hold or possess is suspended, terminated, revoked, or restricted, or if I am otherwise disciplined or censured by a licensing authority for the practice of law before any court or jurisdiction;
<br>b.&nbsp;&nbsp;if I obtain employment with any prosecuting authority either by contract, or if part time or full time or;
<br>c.&nbsp;&nbsp;if I am no longer in substantial current involvement in the practice area of DUI/DWI defense;
<br>d.&nbsp;&nbsp;if I fail to attend one (or more) seminars every two (2) years either sponsored by NCDD or at a State/local seminar approved by NCDD; or
<br>e.&nbsp;&nbsp;if I am no longer eligible for membership in NCDD under the bylaws as amended. 
                        </p>
                        <p>
                           I hereby authorize NCDD to charge the debit or credit card that I may have on file for any and all membership dues for membership or other fees at the level and rate then in effect until such time as I notify the Executive Director of NCDD to cancel such authorization. All membership dues will be charged on the due date as set out in the rules governing membership. Cancellation of use of this method of payment is prospective only. Notice of cancellation must be delivered to the Executive Director in writing or by email at least 14 days prior to the due date of membership dues or fees.
                        </p>
                        <h3 class="text-center"><u>AUTHORIZE AND RELEASE</u></h3>
                        <p>
                           Applicant does by this document give consent for the NCDD to conduct an investigation into my character and fitness to be a member, and to make inquiries and request such information from third parties as, in the sole discretion of NCDD, may be necessary for such investigation. I further authorize the use of any and all such information in the course of the NCDD’s investigation and evaluation of my application for general membership and annual renewal.
                        </p>
                        <h3 class="text-center"><u>INITIAL MEMBERSHIP AND/OR RENEWAL</u></h3>
                        <p>
                           I authorize and request every person or entity, governmental or private, having opinions or knowledge about me, or control of any documents, information, or data pertaining to me, to furnish to the NCDD or its representative such opinions, knowledge, documents or data. Without limiting the previously described authority, I specifically authorize the release of records pertaining to my criminal history, files of any state or professional association regarding disciplinary proceedings and complaints against me, and records of educational institutions concerning me.
                           </br></br>
                           I hereby authorize all persons set out above to answer any inquiries from the NCDD concerning me, and I waive absolutely any privileges or privacy rights I may have which are applicable to any documents or information referred to above and sought pursuant to this authorization and release.
                           </br></br>
                           Notwithstanding any statement herein to the contrary, this Authorization and Release shall not operate to release any medical or mental health records relating to alcohol, drug or chemical dependency.
                           </br></br>
                           I hereby release, discharge and hold harmless the NCDD, its agents or representatives, and any person or entity and its agents or representatives, from any and all liability arising out of the furnishing or use of the opinions, knowledge, documents, records or other data released pursuant to this Authorization and Release.
                           </br></br>
                           A photocopy of this authorization shall be accepted with the same validity as the original.
                           </br></br>
                        </p>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">By printing your name you acknowledge this Authorization and Release.</label>
                           <div class="controls">
                              <div class="input-prepend input-append">
                                 <span class="add-on">Printed Name </span>
                                 <input name="doc[authorizationReleasePrintedName]" class="m-wrap span12 authorizationReleasePrintedName" type="text" placeholder="">
                                 <? $date = new \DateTime(); $datee = $date->format('dS').' of '.$date->format('F').', 20'.$date->format('y'); ?>
                                 <input name="doc[authorizationReleasePrintedNameDate]" class="m-wrap span12 authorizationReleasePrintedNameDate" type="hidden" value="<?=$datee?>">
                                 <span class="add-on"> <?=$datee?></span>
                              </div>
                           </div>
                           
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  
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
                  <h3 class="form-section">8. Promotional Code</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If you have a promo code please enter it here:</label>
                           <div class="controls">
                              <input type="text" name="doc[promocode]" class="m-wrap span12 promocode">
                              <input type="hidden" id="promocodetype" value="discount">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
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
                     <h3 class="form-section">9. Payment Amount</h3>
                     <div class="row-fluid">
                        <h4>$<i class="payment amount"></i></h4>                        
                     </div>
                     <br><br>
                  <br>
                  <div class="row-fluid">
                     <div class="span10 ">
                        <p class="alert alert-info">
                        <b>Additionally, you authorize us to retain the information that you have given us for our records, including member's address, licensing, contact information, and credit card information that we may use for the limited purposes described above, such as renewal payments of your membership dues and to communicate with you and to send announcements pertinent to your membership.</b>
                        <span class="control-group"><span class="controls"><input type="checkbox" name="doc[termsAcknowledgement]" class="termsAcknowledgement" value="yes">Yes, I agree.</span></span>
                        </p>
                     </div>
                     
                  </div>
                  
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
                        <a href="/applications" class="btn blue " data-insertid="">Back to Applications</a>
                        <a href="/applications/new-member-admin" class="btn blue " data-insertid="">Add Another</a>
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
                     <a href="/applications" class="btn">Cancel and Go Back</a>
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
<script>
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