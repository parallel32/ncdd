      <!-- BEGIN PAGE -->
      <div class="page-content" style="margin-left: 3px;">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
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
                  
                  
                  <h3 class="form-section">1. New Member Application</h3>
                  <div class="row-fluid">
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">First Name: <b><?=$this->vars['application']['firstName']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">Middle Initial: <b><?=(array_key_exists('middleName',$this->vars['application'])) ? $this->vars['application']['middleName']: '';?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group ">
                           <label class="control-label">Last Name: <b><?=$this->vars['application']['lastName']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Telephone: <b><?=$this->vars['application']['phone']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Facsimile: <b><?=$this->vars['application']['fax']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Cell Phone: <b><?=(array_key_exists('cellphone', $this->vars['application'])) ? $this->vars['application']['cellphone'] : ''?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Would you like to receive text alerts?  <b><?=(array_key_exists('textAlertsOpt', $this->vars['application'])) ? $this->vars['application']['textAlertsOpt'] : ''?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                     
                  </div>
                  

                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Bar Number / State: <b><?=$this->vars['application']['barNumber']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Email: <b><?=$this->vars['application']['email']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Website: <b><?=$this->vars['application']['website']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Would you like to be added to the NCDD List Server?  <b><?=$this->vars['application']['addToListServ']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Listserv Email: <b><?=$this->vars['application']['listServEmail']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!-- BEGIN ADDRESS -->
                  <h3 class="form-section">Address</h3>
                  <div class="row-fluid validateAddress">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Business Address: <b><?=$this->vars['application']['formattedAddress']?></b></label>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 1: <b><?=$this->vars['application']['address1']?></b></label>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 2: <b><?=$this->vars['application']['address2']?></b></label>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >City: <b><?=$this->vars['application']['city']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >State / Province: <b><?=$this->vars['application']['state']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!--/row-->           
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Postal Code: <b><?if(!empty($this->vars['application']['postalCode']) && strlen($this->vars['application']['postalCode']) < 5){echo str_pad($this->vars['application']['postalCode'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['application']['postalCode']) > 5 && strlen($this->vars['application']['postalCode']) < 9){str_pad($this->vars['application']['postalCode'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['application']['postalCode'];}?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Country: <b><?=$this->vars['application']['country']?></b></label>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  
                  <!-- END ADDRESS -->
                  <h3 class="form-section">2.(old value)</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">How did you hear about the NCDD?</label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['hearAboutNCDD']?>" class="m-wrap span12 hearAboutNCDD">
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
                              <select disabled name="doc[hearAboutNCDD]" class="m-wrap span6 hearAboutNCDD">
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
                              <input disabled type="text" name="doc[yearsInLawPractice]" value="<?=$this->vars['application']['yearsInLawPractice']?>" class="m-wrap span12 yearsInLawPractice">
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
                              <select disabled name="doc[yearsInLawPractice]" class="m-wrap span6 yearsInLawPractice">
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
                                 <input disabled type="text" value="<?=(array_key_exists('licensedInUSAAustraliaCanada', $this->vars['application'])) ? $this->vars['application']['licensedInUSAAustraliaCanada'] : ''?>" class="m-wrap span12 licensedInUSAAustraliaCanada">
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If you selected "No", please explain.</label>
                           <div class="controls">
                              <textarea disabled class="span12 licensedInUSAAustraliaCanadaExplain" name="doc[licensedInUSAAustraliaCanadaExplain]"><?=(array_key_exists('licensedInUSAAustraliaCanadaExplain', $this->vars['application'])) ? $this->vars['application']['licensedInUSAAustraliaCanadaExplain'] : ''?></textarea>
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
                                 <input disabled type="text" value="<?=$this->vars['application']['everInvestigation']?>" class="m-wrap span12 everInvestigation">
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If you selected "No", please explain.</label>
                           <div class="controls">
                              <textarea disabled class="span12 everInvestigationExplain" name="doc[everInvestigationExplain]"><?=$this->vars['application']['everInvestigationExplain']?></textarea>
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
                                 <input disabled type="text" value="<?=$this->vars['application']['everLawEnforcement']?>" class="m-wrap span12 everLawEnforcement">
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If you selected "No", please explain.</label>
                           <div class="controls">
                              <textarea disabled class="span12 everLawEnforcementExplain" name="doc[everLawEnforcementExplain]"><?=$this->vars['application']['everLawEnforcementExplain']?></textarea>
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
                              <input disabled type="text" value="<?=$this->vars['application']['percentDUIDefense']?>" class="m-wrap span12 percentDUIDefense">
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
                              <input disabled type="text" value="<?=$this->vars['application']['juryTrialsAvailableInYourState']?>" class="m-wrap span12 juryTrialsAvailableInYourState">
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
                              <input disabled type="text" value="<?=$this->vars['application']['numberDUITrialsHandeled']?>" class="m-wrap span12 numberDUITrialsHandeled">
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
                              <input disabled type="text" value="<?=$this->vars['application']['numberNonDUITrialsHandeled']?>" class="m-wrap span12 numberNonDUITrialsHandeled">
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
                              <input disabled type="text" value="<?=$this->vars['application']['everBeenArrested']?>" class="m-wrap span12 everBeenArrested">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea disabled class="span12 everBeenArrestedExplain" ><?=$this->vars['application']['everBeenArrestedExplain']?></textarea>
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
                              <input disabled type="text" value="<?=$this->vars['application']['everChargedByBar']?>" class="m-wrap span12 everChargedByBar">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea disabled class="span12 everChargedByBarExplain" ><?=$this->vars['application']['everChargedByBarExplain']?></textarea>
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
                              <input disabled type="text" value="<?=$this->vars['application']['everConvictedCrime']?>" class="m-wrap span12 everConvictedCrime">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea disabled class="span12 everConvictedCrimeExplain" ><?=$this->vars['application']['everConvictedCrimeExplain']?></textarea>
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
                              <input disabled type="text" value="<?=$this->vars['application']['everInvestigation']?>" class="m-wrap span12 everInvestigation">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea disabled class="span12 everInvestigationExplain" ><?=$this->vars['application']['everInvestigationExplain']?></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">12.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Are you presently serving, in any capacity, (either part time or full time in law enforcement or prosecution agencies (Example, reserve duty or municipal prosecutor)? </label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['everLawEnforcement']?>" class="m-wrap span12 everLawEnforcement">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea disabled class="span12 everLawEnforcementExplain" ><?=$this->vars['application']['everLawEnforcementExplain']?></textarea>
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
                              <input disabled type="text" value="<?=$this->vars['application']['futureLawEnforcement']?>" class="m-wrap span12 futureLawEnforcement">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <!-- commented out by request from Rhea.
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea disabled class="span12 futureLawEnforcementExplain" ><?=$this->vars['application']['futureLawEnforcementExplain']?></textarea>
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
                              <div class="">
                                 <input disabled class="m-wrap span12 executed" type="text" value="<?=$this->vars['application']['executed']?>" placeholder="city, state/province">
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
                              <span class="add-on">Printed Name: </span>
                              <input disabled name="doc[executedPrintedName]" value="<?=$this->vars['application']['executedPrintedName']?>" class="m-wrap span12 executedPrintedName" type="text" placeholder="">
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
                                 <input disabled class="m-wrap span12 authorizationReleasePrintedName" type="text" value="<?=$this->vars['application']['authorizationReleasePrintedName']?>" placeholder="">
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
                              <input disabled type="text" value="<?=$this->vars['application']['referenceFormDownload']?>" class="m-wrap span12 referenceFormDownload">
                              <span class="help-block">Please submit this reference form to the address at the top of this application.</span>
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
                              <input disabled type="text" name="doc[referredBy]" value="<?=(array_key_exists('trial',$this->vars['application']) && !empty($this->vars['application']['trial'])) ? (array_key_exists('referredBy',$this->vars['application']['trial'])) ? $this->vars['application']['trial']['referredBy'] : (array_key_exists('referredBy',$this->vars['application'])) ? $this->vars['application']['referredBy'] : '' : (array_key_exists('referredBy',$this->vars['application'])) ? $this->vars['application']['referredBy'] : '';?>" class="m-wrap span12 referredBy">
                              <span class="help-block">If someone referred you, who is already a member, please type in their name here.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>


































                  
               </form>
               <!-- END FORM--> 

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
               <!-- DELETE MODAL -->
               <div id="delete-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h3 id="delete-modal-label">Are you sure you want to delete this?</h3>
                  </div>
                  <div class="modal-body">
                     <p>This delete action cannot be undone.</p>
                  </div>
                  <div class="modal-footer">
                     <button class="btn red continue" data-id="<?=$this->vars['application']['_id']?>">Yes, Delete it.</button>
                     <button class="btn cancel">Cancel</button>
                  </div>
               </div>
               <!--/ DELETE MODAL -->
               <!-- TRIAL MODAL -->
               <div id="trial-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="trial-modal-label" aria-hidden="true">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h3 id="trial-modal-label">Set the length of the trial.</h3>
                  </div>
                  <div class="modal-body">
                     <form id="trial-form" class="horizontal-form portlet">
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>                  
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group">
                                 <label class="control-label">Referred By</label>
                                 <div class="controls">
                                    <input type="text" name="doc[referredBy]" value="<?=(array_key_exists('trial',$this->vars['application']) && !empty($this->vars['application']['trial'])) ? (array_key_exists('referredBy',$this->vars['application']['trial'])) ? $this->vars['application']['trial']['referredBy'] : (array_key_exists('referredBy',$this->vars['application'])) ? $this->vars['application']['referredBy'] : '' : (array_key_exists('referredBy',$this->vars['application'])) ? $this->vars['application']['referredBy'] : '';?>" class="m-wrap span12 referredBy">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group">
                                 <label class="control-label">Trial Length</label>
                                 <div class="controls">
                                    <select class=" m-wrap endDate" name="doc[endDate]">
                                       <?
                                          $ts = strtotime('now');
                                          $option_a_ts = strtotime('June 30 '.date('Y'));
                                          $option_b_ts = strtotime('December 30 '.date('Y'));
                                          if($option_a_ts > $ts){
                                             $year_a = date('Y');
                                          }
                                          if($option_a_ts < $ts){
                                             $year_a = date('Y') + 1;
                                          }
                                          if($option_b_ts > $ts){
                                             $year_b = date('Y');
                                          }
                                          if($option_b_ts < $ts){
                                             $year_b = date('Y') + 1;
                                          }
                                       ?>
                                       <option value="June 30 <?=$year_a?>">June 30 <?=$year_a?></option>
                                       <option value="December 30 <?=$year_b?>">December 30 <?=$year_b?></option>
                                       <option value="1 Month">1 Month</option>
                                       <option value="2 Months">2 Months</option>
                                       <option value="3 Months">3 Months</option>
                                       <option value="4 Months">4 Months</option>
                                       <option value="5 Months">5 Months</option>
                                       <option value="6 Months">6 Months</option>
                                       <option value="7 Months">7 Months</option>
                                       <option value="8 Months">8 Months</option>
                                       <option value="9 Months">9 Months</option>
                                       <option value="10 Months">10 Months</option>
                                       <option value="11 Months">11 Months</option>
                                       <option value="12 Months">12 Months</option>
                                    </select>
                                    <span class="help-block">An email will be sent to the applicant and admin when the trial period expires.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="alert alert-warning">
                           Note: the system will email the applicant with their access credentials when confirm is clicked.
                        </div> 
                     </form>
                  </div>
                  <div class="modal-footer">
                     <button class="btn green continue" data-id="<?=$this->vars['application']['_id']?>">Confirm and Begin Trial.</button>
                     <button class="btn cancel">Cancel</button>
                  </div>
               </div>
               <!--/ TRIAL MODAL -->
            </div>
         </div>
         <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
      <?=$this->element('js/Application.js');?>
      <script>
      jQuery(document).ready(function() {    
         io.saw.Application.approveInit();
      });      
      </script>