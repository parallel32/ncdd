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
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Cell Phone</label>
                           <div class="controls">
                              <input type="text" name="doc[cellphone]" value="<?=(array_key_exists('cellphone', $this->vars['application'])) ? $this->vars['application']['cellphone'] : ''?>" class="m-wrap span12 cellphone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Would you like to receive text alerts?</label>
                           <div class="controls">
                              <select class="small m-wrap textAlertsOpt" name="doc[textAlertsOpt]">
                                 <option<?=(array_key_exists('textAlertsOpt', $this->vars['application']) && $this->vars['application']['textAlertsOpt'] == "no") ? ' selected' :'';?> value="no">No</option>
                                 <option<?=(array_key_exists('textAlertsOpt', $this->vars['application']) && $this->vars['application']['textAlertsOpt'] == "yes") ? ' selected' :'';?> value="yes">Yes</option>
                              </select>
                              <span class="help-block">Highly recommended.</span>
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
                              <input type="text" id="zip" name="doc[postalCode]" value="<?if(!empty($this->vars['application']['postalCode']) && strlen($this->vars['application']['postalCode']) < 5){echo str_pad($this->vars['application']['postalCode'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['application']['postalCode']) > 5 && strlen($this->vars['application']['postalCode']) < 9){str_pad($this->vars['application']['postalCode'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['application']['postalCode'];}?>" class="m-wrap span12 postalCode"> 
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
                  <p>We attempt to determine the Latitude and Longitude of your address for future searches based on a client's nearby location</p>
                  <div class="row-fluid validateAddress">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Type in your full address and then click Submit for Geocoding:</label>
                           <div class="controls">
                              <input type="text" id="geocodeaddress" value="<?=$this->vars['application']['formattedAddress']?>" class="m-wrap span12 geocodeaddress" >
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
                  
                  <h3 class="form-section">2.(old value)</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">How did you hear about the NCDD?</label>
                           <div class="controls">
                              <input type="text" value="<?=$this->vars['application']['hearAboutNCDD']?>" class="m-wrap span12 hearAboutNCDD">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">2.(new)</h3>
                  <div class="row-fluid">
                     <div class="span6">
                        <div class="control-group">
                           <label class="control-label">How did you hear about the NCDD?</label>
                           <div class="controls">
                              <select name="doc[hearAboutNCDD]" class="m-wrap span6 hearAboutNCDD">
                              <option value="">Please select</option>
                              <option <?=($this->vars['application']['hearAboutNCDD'] == "Google") ? "selected":"" ?> value="Google">Google</option>
                              <option <?=($this->vars['application']['hearAboutNCDD'] == "Yahoo") ? "selected":"" ?> value="Yahoo">Yahoo</option>
                              <option <?=($this->vars['application']['hearAboutNCDD'] == "Bing") ? "selected":"" ?> value="Bing">Bing</option>
                              <option <?=($this->vars['application']['hearAboutNCDD'] == "Other Search Engine") ? "selected":"" ?> value="Other Search Engine">Other Search Engine</option>
                              <option <?=($this->vars['application']['hearAboutNCDD'] == "Friend/Collegue") ? "selected":"" ?> value="Friend/Collegue">Friend/Collegue</option>
                              <option <?=($this->vars['application']['hearAboutNCDD'] == "Existing Member") ? "selected":"" ?> value="Existing Member">Existing Member</option>
                              <option <?=($this->vars['application']['hearAboutNCDD'] == "Seminar") ? "selected":"" ?> value="Seminar">Seminar</option>
                              <option <?=($this->vars['application']['hearAboutNCDD'] == "NCDD Promotion") ? "selected":"" ?> value="NCDD Promotion">NCDD Promotion</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">3.(old value)</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Year of admission to practice:</label>
                           <div class="controls">
                              <input type="text" name="doc[yearsInLawPractice]" value="<?=$this->vars['application']['yearsInLawPractice']?>" class="m-wrap span12 yearsInLawPractice">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>

                  <h3 class="form-section">3.(new)</h3>
                  <div class="row-fluid">
                     <div class="span6">
                        <div class="control-group">
                           <label class="control-label">Year of admission to practice:</label>
                           <div class="controls">
                              <select name="doc[yearsInLawPractice]" class="m-wrap span6 yearsInLawPractice">
                              <option value="">Please select</option>
                              <? for($i=(int)date('Y'); $i >= (int)date('Y')-20; $i--){ ?>
                              <option <?=($this->vars['application']['yearsInLawPractice'] == $i) ? "selected":"" ?> value="<?=$i?>"><?=$i?></option>
                              <? } ?>
                              <option <?=($this->vars['application']['yearsInLawPractice'] == 1995) ? "selected":"" ?> value="1995">More than 20 years ago</option>
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
                           <label class="control-label">Are you a Public Defender?</label>
                           <div class="controls">
                              <select class="small m-wrap publicDefender" name="doc[publicDefender]">
                                 <option <?=(array_key_exists('publicDefender',$this->vars['application']) && $this->vars['application']['publicDefender'] == 'no') ?'selected':'';?> value="no">No</option>
                                 <option <?=(array_key_exists('publicDefender',$this->vars['application']) && $this->vars['application']['publicDefender'] == 'yes') ?'selected':'';?> value="yes">Yes</option>
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
                                    <option<?=(array_key_exists('licensedInUSAAustraliaCanada', $this->vars['application']) && $this->vars['application']['licensedInUSAAustraliaCanada'] == "no") ? ' selected' :'';?> value="no">No</option>
                                    <option<?=(array_key_exists('licensedInUSAAustraliaCanada', $this->vars['application']) && $this->vars['application']['licensedInUSAAustraliaCanada'] == "yes") ? ' selected' :'';?> value="yes">Yes</option>
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
                              <textarea class="span12 licensedInUSAAustraliaCanadaExplain" name="doc[licensedInUSAAustraliaCanadaExplain]"><?=(array_key_exists('licensedInUSAAustraliaCanadaExplain', $this->vars['application'])) ? $this->vars['application']['licensedInUSAAustraliaCanadaExplain'] : ''?></textarea>
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
                                    <option<?=($this->vars['application']['everInvestigation'] == "no") ? ' selected' :'';?> value="no">No</option>
                                    <option<?=($this->vars['application']['everInvestigation'] == "yes") ? ' selected' :'';?> value="yes">Yes</option>
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
                              <textarea class="span12 everInvestigationExplain" name="doc[everInvestigationExplain]"><?=$this->vars['application']['everInvestigationExplain']?></textarea>
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
                                    <option<?=($this->vars['application']['everLawEnforcement'] == "no") ? ' selected' :'';?> value="no">No</option>
                                    <option<?=($this->vars['application']['everLawEnforcement'] == "yes") ? ' selected' :'';?> value="yes">Yes</option>
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
                              <textarea class="span12 everLawEnforcementExplain" name="doc[everLawEnforcementExplain]"><?=$this->vars['application']['everLawEnforcementExplain']?></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>

            <? if (!empty($this->vars['application']['percentDUIDefense'])): ?>
                  <h2>START - OLD APP FIELDS</h2>
                  <hr>
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
                  <hr>
                  <h2>END - OLD APP FIELDS</h2>
            <? endif; ?>
                  <h3 class="form-section">6.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">
                           I have substantial current involvement in the practice area of DUI/DWI defense and I understand that as a condition of continued membership I am expected to have substantial involvement, including attendance at one (or more) seminars every two (2) years either sponsored by NCDD or at a State/local seminar approved by NCDD. 
                           <br><span class="control-group"><span class="controls"><input <?=(array_key_exists('twoSeminarsAcknowledgement',$this->vars['application']) && $this->vars['application']['twoSeminarsAcknowledgement'] == 'yes') ? 'checked' : '' ?> type="checkbox" name="doc[twoSeminarsAcknowledgement]" class="twoSeminarsAcknowledgement" value="yes"><b>Yes, I acknowledge this.</b></span></span>
                           </br></br>
                           I have read the general membership rules, and I understand and agree to be bound by them as they are presently published and as they may be amended from time to time during my membership. 
                           </br></br>
                           I declare under penalty of perjury that the foregoing statements are true and correct to the best of my knowledge.
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
                           <label class="control-label"></label>
                           <div class="input-prepend input-append">
                              <span class="add-on">Printed Name: </span>
                              <input name="doc[executedPrintedName]" value="<?=$this->vars['application']['executedPrintedName']?>" class="m-wrap span12 executedPrintedName" type="text" placeholder="">
                              <span class="add-on"> <?=(array_key_exists('executedPrintedNameDate', $this->vars['application'])) ? $this->vars['application']['executedPrintedNameDate'] : ''?></span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>

                  

                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">By printing your name you acknowledge this Authorization and Release.</label>
                           <div class="controls">
                              <div class="input-prepend input-append">
                                 <span class="add-on">Printed Name: </span>
                                 <input name="doc[authorizationReleasePrintedName]" value="<?=$this->vars['application']['authorizationReleasePrintedName']?>" class="m-wrap span12 authorizationReleasePrintedName" type="text" placeholder="">
                                 <span class="add-on"> <?=(array_key_exists('authorizationReleasePrintedNameDate', $this->vars['application'])) ? $this->vars['application']['authorizationReleasePrintedNameDate'] : ''?></span>
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
                     <!--/span--
                  </div>
               -->
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

                  <h3 class="form-section">Promotional Code</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
<!--                            <label class="control-label">Enter   the   promo code  BONUS2015 and pay   your  2016  dues  in full in order to obtain   
the   remainder of 2015 for free.  Offer expires December 31, 2015. </label> -->
                           <div class="controls">
                           <?
                           // legacy
                           if(array_key_exists('promocode', $this->vars['application'])) {
                              $promocode = $this->vars['application']['promocode'];
                           }else{
                              $promocode = '';
                           }
                           // new stuff
                           if(array_key_exists('promotion', $this->vars['application']) && is_array($this->vars['application']['promotion']) && !empty($this->vars['application']['promotion']) && is_array($this->vars['application']['promotion']) && array_key_exists('code',$this->vars['application']['promotion'])) {
                              $promocode = $this->vars['application']['promotion']['code'];
                           }else{
                              $promocode = '';
                           }

                           ?>
                              <input type="text" name="doc[promocode]" class="m-wrap span12 promocode" disabled value="<?=$promocode?>">
                              <input type="hidden" id="promocodetype" value="">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                     
                  <?
                  if(array_key_exists('promotion', $this->vars['application']) && is_array($this->vars['application']['promotion']) && !empty($this->vars['application']['promotion']) && is_array($this->vars['application']['promotion']) && array_key_exists('code',$this->vars['application']['promotion'])) {
                  ?>
                  <div class="row-fluid">
                     <div class="span6 promocodeblocks <?=strtoupper($this->vars['application']['promotion']['code'])?>">
                     <? if($this->vars['application']['promotion']['discountAmt'] > 0): ?>
                        <p class="promo-discount">
                           Discount: <b><?=($this->vars['application']['promotion']['currentType'] == \Saw\Model\Promotion::$type['MONEY']) ? "$": '';?><?=$this->vars['application']['promotion']['discountAmt']?><?=($this->vars['application']['promotion']['currentType'] == \Saw\Model\Promotion::$type['PERCENT']) ? "%": '';?></b>
                        </p>
                        <br>
                     <? endif; ?>
                        <? if($this->vars['application']['promotion']['optInOnOff'] == 'on'){?>
                        <p class="alert alert-info">
                           <b><?=$this->vars['application']['promotion']['optInDisclosure']?></b>
                           <br><span class="control-group"><span class="controls"><input <?=($this->vars['application']['promotion']['optIn'] == 'yes') ? "checked" : "";?> type="checkbox" name="doc[optIn]" class="optIn" value="yes" disabled >Yes, I agree.</span></span>
                        </p>
                        <? } ?>
                     </div>                     
                  </div>
                  <div class="row-fluid">
                     <div class="span6 promocodeblocks <?=strtoupper($this->vars['application']['promotion']['code'])?>">
                        <? if($this->vars['application']['promotion']['gift'] == 'yes'){?>
                        <p class="">
                           <b><?=$this->vars['application']['promotion']['giftName']?></b>&nbsp;-&nbsp;A $<?=$this->vars['application']['promotion']['giftDollarValue']?> value.
                           <br>
                           <?=$this->vars['application']['promotion']['giftDesc']?>
                           <br>
                           <img src="<?=$this->app['getImageURL']($this->vars['application']['promotion']['image'],'small')?>" width="200">
                        </p>
                        <? } ?>
                     </div>
                  </div>
                  <? } ?>


                  

                  <?if($this->vars['application']['currentStatus'] == \Saw\Model\Apply::$status['TRIAL'] && array_key_exists('trial',$this->vars['application'])):?>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Trial Started:</label>
                           <div class="controls">
                              <input id="startTrial" name="startTrial" type="text" value="<?=$this->vars['application']['trial']['startDate']['fullMonth']?>" class="m-wrap span12 startDate">
                              <?$start = \Carbon\Carbon::createFromTimeStamp(strtotime($this->vars['application']['trial']['startDate']['fullMonth']), $this->vars['application']['trial']['timeZone']);?>
                              <span class="help-block"><?=$start->diffForHumans();?></span>
                              <span class="help-block">To Change: simply type in a new date to change when the trial ends. E.g.: March 15, 2014</span>
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
                              <span class="help-block">To Change: simply type in a new date to change when the trial ends. E.g.: March 15, 2014</span>
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
      <script src="<?=SAW_SSL_CDN?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>   
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
         io.saw.Application.editInit();
         io.saw.Address.init('#saw-form');
         $('#saw-form .publicDefender').change(function(){
            calculatedues();
         });
         $('#saw-form .yearsInLawPractice').keyup(function(){
            calculatedues();
         })
         window.setInterval(calculatedues,1000);
      });      
      </script>