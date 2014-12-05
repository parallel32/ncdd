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
                              <input disabled type="text" name="doc[firstName]" value="<?=$this->vars['application']['firstName']?>" class="m-wrap span12 firstName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">Middle Initial</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[middleName]" value="<?=(array_key_exists('middleName',$this->vars['application'])) ? $this->vars['application']['middleName']: '';?>" class="m-wrap span12 middleName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group ">
                           <label class="control-label">Last Name</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[lastName]" value="<?=$this->vars['application']['lastName']?>" class="m-wrap span12 lastName">
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
                              <input disabled id="phone" type="text" value="<?=$this->vars['application']['phone']?>" class="m-wrap span12 phone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Facsimile</label>
                           <div class="controls">
                              <input disabled id="fax" type="text" value="<?=$this->vars['application']['fax']?>" class="m-wrap span12 fax">
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
                              <input disabled type="text" value="<?=$this->vars['application']['barNumber']?>" class="m-wrap span12 barNumber">
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
                              <input disabled type="text" value="<?=$this->vars['application']['email']?>" class="m-wrap span12 email">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Website</label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['website']?>" class="m-wrap span12 website">
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
                              <input disabled type="text" value="<?=$this->vars['application']['addToListServ']?>" class="m-wrap span12 website">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Listserv Email</label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['listServEmail']?>" class="m-wrap span12 listServEmail">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!-- BEGIN ADDRESS -->
                  <h3 class="form-section">Address</h3>
                  <div class="row-fluid validateAddress">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Business Address</label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['formattedAddress']?>" id="geocodeaddress" class="m-wrap span12 formattedAddress" >
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 1</label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['address1']?>" id="address1" class="m-wrap span12 address1">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 2</label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['address2']?>" id="address2" class="m-wrap span12 address2">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >City</label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['city']?>" id="city" class="m-wrap span12 city"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >State / Province</label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['state']?>" id="state" class="m-wrap span12 state"> 
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
                              <input disabled type="text" value="<?=$this->vars['application']['postalCode']?>" id="zip" class="m-wrap span12 postalCode"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Country</label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['country']?>" id="country" class="m-wrap span12 country"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  
                  <!-- END ADDRESS -->
                  <h3 class="form-section">2.</h3>
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
                  <h3 class="form-section">3.</h3>
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
                           I have substantial current involvement in the practice area of DUI/DWI defense and I understand that as a condition of continued membership I must continue to have substantial involvement, including attendance at one (or more) seminars every two (2) years either sponsored by NCDD or at a State/local seminar approved by NCDD.
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
                              <input disabled type="text" name="doc[referredBy]" value="<?=(array_key_exists('trial',$this->vars['application'])) ? (array_key_exists('referredBy',$this->vars['application']['trial'])) ? $this->vars['application']['trial']['referredBy'] : (array_key_exists('referredBy',$this->vars['application'])) ? $this->vars['application']['referredBy'] : '' : (array_key_exists('referredBy',$this->vars['application'])) ? $this->vars['application']['referredBy'] : '';?>" class="m-wrap span12 referredBy">
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
                              <input disabled type="text" name="doc[promocode]" class="m-wrap span12 promocode" value="<?=(array_key_exists('promocode', $this->vars['application'])) ? $this->vars['application']['promocode'] : ''?>">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>


                  <br>
                  <div class="row-fluid">
                     <div class="span10 ">
                        <p class="alert alert-info">
                        <b>Additionally, you authorize us to retain the information that you have given us for our records, including member's address, licensing, contact information, and credit card information that we may use for the limited purposes described above, such as renewal payments of your membership dues and to communicate with you and to send announcements pertinent to your membership.</b>
                        <input <?=(array_key_exists('termsAcknowledgement',$this->vars['application']) && $this->vars['application']['termsAcknowledgement'] == 'yes') ? 'checked' : '' ?> type="checkbox" name="doc[termsAcknowledgement]" class="termsAcknowledgement" value="yes">Yes, I agree.
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
                  
               </form>
               <!-- END FORM--> 

               

            </div>
         </div>
         <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->