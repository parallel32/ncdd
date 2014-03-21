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
               <!-- BEGIN FORM-->
               <form id="saw-form" class="horizontal-form portlet">
                  <input type="hidden" name="doc[_id]" class="_id" value="<?=$this->vars['application']['_id']?>">
                  <input type="hidden" name="doc[class]" class="type" value="<?=$this->vars['application']['class']?>">
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
                              <input type="text" name="doc[firstName]" value="<?=$this->vars['application']['firstName']?>" class="m-wrap span12 firstName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">Middle Initial</label>
                           <div class="controls">
                              <input type="text" name="doc[middleName]" value="<?=(array_key_exists('middleName',$this->vars['application'])) ? $this->vars['application']['middleName']: '';?>" class="m-wrap span12 middleName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group ">
                           <label class="control-label">Last Name</label>
                           <div class="controls">
                              <input type="text" name="doc[lastName]" value="<?=$this->vars['application']['lastName']?>" class="m-wrap span12 lastName">
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
                              <input id="phone" type="text" name="doc[phone]" value="<?=$this->vars['application']['phone']?>" class="m-wrap span12 phone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Facsimile</label>
                           <div class="controls">
                              <input id="fax" type="text" name="doc[fax]" value="<?=$this->vars['application']['fax']?>" class="m-wrap span12 fax">
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
                              <input type="text" name="doc[barNumber]" value="<?=$this->vars['application']['barNumber']?>" class="m-wrap span12 barNumber">
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
                              <input type="text" name="doc[email]" value="<?=$this->vars['application']['email']?>" class="m-wrap span12 email">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Website</label>
                           <div class="controls">
                              <input type="text" name="doc[website]" value="<?=$this->vars['application']['website']?>" class="m-wrap span12 website">
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
                                 <option<?=($this->vars['application']['addToListServ'] == "no") ? ' selected' :'';?> value="no">No</option>
                                 <option<?=($this->vars['application']['addToListServ'] == "yes") ? ' selected' :'';?> value="yes">Yes</option>
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
                              <input type="text" name="doc[listServEmail]" value="<?=$this->vars['application']['listServEmail']?>" class="m-wrap span12 listServEmail">
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
                              <input type="text" id="address1" name="doc[address1]" value="<?=$this->vars['application']['address1']?>" class="m-wrap span12 address1">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 2</label>
                           <div class="controls">
                              <input type="text" id="address2" name="doc[address2]" value="<?=$this->vars['application']['address2']?>" class="m-wrap span12 address2">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >City</label>
                           <div class="controls">
                              <input type="text" id="city" name="doc[city]" value="<?=$this->vars['application']['city']?>" class="m-wrap span12 city"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >State / Province</label>
                           <div class="controls">
                              <input type="text" id="state" name="doc[state]" value="<?=$this->vars['application']['state']?>" class="m-wrap span12 state"> 
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
                              <input type="text" id="zip" name="doc[postalCode]" value="<?=$this->vars['application']['postalCode']?>" class="m-wrap span12 postalCode"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Country</label>
                           <div class="controls">
                              <input type="text" id="country" name="doc[country]" value="<?=$this->vars['application']['country']?>" class="m-wrap span12 country"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section text-info"><strong>Geocode Your Address</strong></h3>
                  <p>We attempt to determine the Latitude and Longitude of your address for furture searches based on nearby a client's location</p>
                  <div class="row-fluid validateAddress">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Type in your full address and then click Submit for Geocoding:</label>
                           <div class="controls">
                              <input type="text" id="geocodeaddress" value="<?=$this->vars['application']['formattedAddress']?>" class="m-wrap span12" >
                              <button type="button" class="btn blue geocodeaddress">Submit for Geocoding <i class="icon-globe"></i></button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <input type="hidden" name="doc[formattedAddress]" value="<?=$this->vars['application']['formattedAddress']?>" id="raw">
                  <input type="hidden" name="doc[lat]" value="<?=$this->vars['application']['lat']?>" id="lat">
                  <input type="hidden" name="doc[lon]" value="<?=$this->vars['application']['lon']?>" id="lon">
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
                              <input type="text" name="doc[hearAboutNCDD]" value="<?=$this->vars['application']['hearAboutNCDD']?>" class="m-wrap span12 hearAboutNCDD">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">3.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Number of years in law practice:</label>
                           <div class="controls">
                              <input type="text" name="doc[yearsInLawPractice]" value="<?=$this->vars['application']['yearsInLawPractice']?>" class="m-wrap span12 yearsInLawPractice">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">4.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">% of business in DUI defense:</label>
                           <div class="controls">
                              <input type="text" name="doc[percentDUIDefense]" value="<?=$this->vars['application']['percentDUIDefense']?>" class="m-wrap span12 percentDUIDefense">
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
                              <select class="small m-wrap juryTrialsAvailableInYourState" value="<?=$this->vars['application']['juryTrialsAvailableInYourState']?>" name="doc[juryTrialsAvailableInYourState]">
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
                                 <option<?=($this->vars['application']['numberDUITrialsHandeled'] == "10") ? ' selected' :'';?> value="10">Fewer than 10</option>
                                 <option<?=($this->vars['application']['numberDUITrialsHandeled'] == "11") ? ' selected' :'';?> value="11">11 to 30</option>
                                 <option<?=($this->vars['application']['numberDUITrialsHandeled'] == "31") ? ' selected' :'';?> value="31">31 or more</option>
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
                                 <option<?=($this->vars['application']['numberNonDUITrialsHandeled'] == "10") ? ' selected' :'';?> value="10">Fewer than 10</option>
                                 <option<?=($this->vars['application']['numberNonDUITrialsHandeled'] == "11") ? ' selected' :'';?> value="11">11 to 30</option>
                                 <option<?=($this->vars['application']['numberNonDUITrialsHandeled'] == "31") ? ' selected' :'';?> value="31">31 or more</option>
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
                                 <option<?=($this->vars['application']['everBeenArrested'] == "no") ? ' selected' :'';?> value="no">No</option>
                                 <option<?=($this->vars['application']['everBeenArrested'] == "yes") ? ' selected' :'';?> value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everBeenArrestedExplain" name="doc[everBeenArrestedExplain]"><?=$this->vars['application']['everBeenArrestedExplain']?></textarea>
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
                                 <option<?=($this->vars['application']['everChargedByBar'] == "no") ? ' selected' :'';?> value="no">No</option>
                                 <option<?=($this->vars['application']['everChargedByBar'] == "yes") ? ' selected' :'';?> value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everChargedByBarExplain" name="doc[everChargedByBarExplain]"><?=$this->vars['application']['everChargedByBarExplain']?></textarea>
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
                                 <option<?=($this->vars['application']['everConvictedCrime'] == "no") ? ' selected' :'';?> value="no">No</option>
                                 <option<?=($this->vars['application']['everConvictedCrime'] == "yes") ? ' selected' :'';?> value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everConvictedCrimeExplain" name="doc[everConvictedCrimeExplain]"><?=$this->vars['application']['everConvictedCrimeExplain']?></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">11.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Has your Bar Association or licensing authority conducted any investigation or inquiry based upon complaints, have you ever been subject to disciplinary action by your bar association or licensing authority; has your license to practice law ever been suspended for any period of time? </label>
                           <div class="controls">
                              <select class="small m-wrap everInvestigation" name="doc[everInvestigation]">
                                 <option<?=($this->vars['application']['everInvestigation'] == "no") ? ' selected' :'';?> value="no">No</option>
                                 <option<?=($this->vars['application']['everInvestigation'] == "yes") ? ' selected' :'';?> value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everInvestigationExplain" name="doc[everInvestigationExplain]"><?=$this->vars['application']['everInvestigationExplain']?></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">12.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Are you presently serving, in any capacity, either part time or full time in law enforcement or prosecution agencies (Example, reserve duty or municipal prosecutor)? </label>
                           <div class="controls">
                              <select class="small m-wrap everLawEnforcement" name="doc[everLawEnforcement]">
                                 <option<?=($this->vars['application']['everLawEnforcement'] == "no") ? ' selected' :'';?> value="no">No</option>
                                 <option<?=($this->vars['application']['everLawEnforcement'] == "yes") ? ' selected' :'';?> value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea class="span12 everLawEnforcementExplain" name="doc[everLawEnforcementExplain]"><?=$this->vars['application']['everLawEnforcementExplain']?></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">13.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">I understand that any future service in any branch of law enforcement or prosecution of state, province, county district or municipal ordinances/statutes requires my immediate disclosure to NCDD and termination of my membership. </label>
                           <div class="controls">
                              <select class="small m-wrap futureLawEnforcement" name="doc[futureLawEnforcement]">
                                 <option<?=($this->vars['application']['futureLawEnforcement'] == "no") ? ' selected' :'';?> value="no">No</option>
                                 <option<?=($this->vars['application']['futureLawEnforcement'] == "yes") ? ' selected' :'';?> value="yes">Yes</option>
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
                  <h3 class="form-section">14.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">I understand that as a condition of continued membership I must attend at least one seminar every two (2) years sponsored/co-sponsored by NCDD or a State seminar listed on the NCDD website.
                           </br></br>
                           I have read the general membership rules, and I understand and agree to be bound by them. I declare under penalty of perjury that the foregoing application are true and correct to the best of my knowledge.
                           </br>
                           </label>
                           <div class="controls">
                              <input name="doc[executed]" value="<?=$this->vars['application']['executed']?>" class="m-wrap span12 executed" type="text" placeholder="city, state/province">
                           </div>
                           
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Printed Name</label>
                           <div class="controls">
                                 <input name="doc[executedPrintedName]" value="<?=$this->vars['application']['executedPrintedName']?>" class="m-wrap span12 executedPrintedName" type="text">
                           </div>
                           
                        </div>
                     </div>
                     <!--/span-->
                  </div>

                  <h3 class="form-section">Check which applies to your membership:</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"></label>
                           <div class="controls">
                              <select class=" m-wrap span12 membershipDues" name="doc[membershipDues]">
                                 <option<?=($this->vars['application']['membershipDues'] == "175") ? ' selected' :'';?> value="175">1-5 years in law practice ($175 annual dues) </option>
                                 <option<?=($this->vars['application']['membershipDues'] == "225") ? ' selected' :'';?> value="225">6 or more years in law practice ($225 annual dues)</option>
                                 <option<?=($this->vars['application']['membershipDues'] == "50") ? ' selected' :'';?> value="50"> Public Defender ($50 annual dues)</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!--
                  <h3 class="form-section text-center">THE NATIONAL COLLEGE FOR DUI DEFENSE, INC.</br> AUTHORIZATION AND RELEASE</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <h3 class="text-center"><u>PARTIES</u></h3>
                        <p>
                           <u>APPLICANT</u> - person applying for initial membership status or a present member applying for renewal of his or her membership status. </br><u>NCDD</u> - The National College for DUI Defense, Inc.
                        </p>
                        <h3 class="text-center"><u>ACKNOWLEDGEMENT</u></h3>
                        <p>
                           APPLICANT herein acknowledges that initial membership or renewal of membership is not automatically bestowed with payment of membership fees; (2) that the College endeavors to maintain among its membership attorneys of high ethical and moral character; and, (3) the entire membership benefits when each member maintains standards of reasonable conduct and character within his or her community and professional associations.
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
                     <!--/span--
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">By printing your name you acknowledge this Authorization and Release.</label>
                           <div class="controls">
                              <div class="input-prepend">
                                 <span class="add-on">Printed Name: </span>
                                 <input name="doc[authorizationReleasePrintedName]" value="<?=$this->vars['application']['authorizationReleasePrintedName']?>" class="m-wrap span12 authorizationReleasePrintedName" type="text" placeholder="">
                              </div>
                           </div>
                           
                        </div>
                     </div>
                     <!--/span--
                  </div>
                  -->
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Please download this reference form and confirm you did so by selecting "Yes": <br>
                              <a target="_blank" href="https://<?=SAW_ADMIN_WEBSITE?>/application/downloads/ncdd-general-membership-reference-form.pdf">New Member Application Reference Form - click to download the PDF document.</a>
                           </label>
                           <div class="controls">
                              <select class="large m-wrap referenceFormDownload" name="doc[referenceFormDownload]">
                                 <option<?=($this->vars['application']['referenceFormDownload'] == "no") ? ' selected' :'';?> value="no">No, I have not downloaded the reference form.</option>
                                 <option<?=($this->vars['application']['referenceFormDownload'] == "yes") ? ' selected' :'';?> value="yes">Yes, I have downloaded the reference form.</option>
                              </select>
                              <span class="help-block"></span>
                              <h4><strong>Please make sure your 2 references send their forms ASAP to the address at the top of the reference form via fax, email, or U.S. mail.</strong></h4>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Referred By:</label>
                           <div class="controls">
                              <input type="text" name="doc[referredBy]" value="<?=(array_key_exists('trial',$this->vars['application'])) ? (array_key_exists('referredBy',$this->vars['application']['trial'])) ? $this->vars['application']['trial']['referredBy'] : (array_key_exists('referredBy',$this->vars['application'])) ? $this->vars['application']['referredBy'] : '' : (array_key_exists('referredBy',$this->vars['application'])) ? $this->vars['application']['referredBy'] : '';?>" class="m-wrap span12 referredBy">
                              <span class="help-block">If someone referred you, who is already a member, please type their name here.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <?if($this->vars['application']['currentStatus'] == \Saw\Model\Apply::$status['TRIAL'] && array_key_exists('trial',$this->vars['application'])):?>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Trial Started:</label>
                           <div class="controls">
                              <input id="startTrial" name="startTrial" type="text" value="<?=$this->vars['application']['trial']['startDate']['fullMonth']?>" class="m-wrap span12 startDate">
                              <?$start = \Carbon\Carbon::createFromTimeStamp(strtotime($this->vars['application']['trial']['startDate']['fullMonth']), $this->vars['application']['trial']['timeZone']);?>
                              <span class="help-block"><?=$start->diffForHumans();?></span>
                              <span class="help-block">To Change: simply type in a new date to change when the trial ends. E.g.: February 15, 2014</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Trial Ends:</label>
                           <div class="controls">
                              <input id="endTrial" name="endTrial"  type="text" value="<?=$this->vars['application']['trial']['endDate']['fullMonth']?>" class="m-wrap span12 endDate">
                              <?$end = \Carbon\Carbon::createFromTimeStamp(strtotime($this->vars['application']['trial']['endDate']['fullMonth']), $this->vars['application']['trial']['timeZone']);?>
                              <span class="help-block"><?=$end->diffForHumans();?></span>
                              <span class="help-block">To Change: simply type in a new date to change when the trial ends. E.g.: February 15, 2014</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <? endif; ?>
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
                        <button class="btn blue continue-editing">Continue Editing</button>
                        <button class="btn all-applications" data-id="<?=$this->vars['application']['_id']?>">Finished, Go Back to the Application.</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  
                  <div class="form-actions text-center">
                     <button type="button" class="btn green"><i class="icon-pencil"></i> Save Changes</button>
                     <button type="button" data-id="<?=$this->vars['application']['_id']?>" class="btn cancel-go-back">Cancel and Go Back</button>
                  </div>
               </form>
               <!-- END FORM--> 
            </div>
         </div>
         <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
      <script src="/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>   
      <?=$this->element('js/Application.js');?>
      <?=$this->element('js/Address.js');?>
      <script>
      jQuery(document).ready(function() {    
         io.saw.Application.editInit();
         io.saw.Address.init('#saw-form');
      });      
      </script>