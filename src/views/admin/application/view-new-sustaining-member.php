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
                  
                  <h3 class="form-section">Private URL for sharing this application.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <div class="controls">
                              <input type="text" value="https://<?=SAW_ADMIN_WEBSITE?>/application/<?=$this->vars['application']['_id']?>/view-public" class="m-wrap span12">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
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
                           <label class="control-label">Number of years in law practice:</label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['yearsInLawPractice']?>" class="m-wrap span12 yearsInLawPractice">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">3.</h3>
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
                  <h3 class="form-section">4.</h3>
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
                  <h3 class="form-section">5.</h3>
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
                  <h3 class="form-section">6.</h3>
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
                  <h3 class="form-section">7.</h3>
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
                  <h3 class="form-section">8.</h3>
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
                  <h3 class="form-section">9.</h3>
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
                  <h3 class="form-section">10.</h3>
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
                  <h3 class="form-section">11.</h3>
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
                  <h3 class="form-section">12.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">I understand that any future service in any branch of law enforcement or prosecution of state, province, county district or municipal ordinances/statutes requires my immediate disclosure to NCDD and termination of my membership. </label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['futureLawEnforcement']?>" class="m-wrap span12 futureLawEnforcement">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
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
                  <h3 class="form-section">13.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">I understand that as a condition of continued membership I must attend at least one seminar every two (2) years sponsored/co-sponsored by NCDD or a State seminar listed on the NCDD website.</label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['attendSeminar']?>" class="m-wrap span12 attendSeminar">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain.</label>
                           <div class="controls">
                              <textarea disabled class="span12 attendSeminarExplain" ><?=$this->vars['application']['attendSeminarExplain']?></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">14.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">
                           </br></br>
                           I have read the general membership rules, and I understand and agree to be bound by them. I declare under penalty of perjury that the foregoing two (2) pages are true and correct to the best of my knowledge.
                           </br>
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
                           <label class="control-label">Printed Name</label>
                           <div class="controls">
                                 <input disabled class="m-wrap span12 executedPrintedName" type="text" value="<?=$this->vars['application']['executedPrintedName']?>">
                           </div>
                           
                        </div>
                     </div>
                     <!--/span-->
                  </div>

                  <h3 class="form-section">Annual Membership dues in the amount of $3500 are payable upon application approval.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"></label>
                           <div class="controls">
                              <input disabled class="m-wrap span12 executedPrintedName" name="doc[membershipDues]" value="<?=$this->vars['application']['membershipDues']?>" class="membershipDues" type="text">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>

                  <h3 class="form-section text-center">THE NATIONAL COLLEGE FOR DUI DEFENSE, INC.</br> AUTHORIZATION AND RELEASE</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <p>
                           I, <input disabled class="m-wrap span3 authorizationReleasePrintedName" type="text" value="<?=$this->vars['application']['authorizationReleasePrintedName']?>" placeholder=""> 
                           having filed an application for a <strong>SUSTAINING MEMBERSHIP</strong> hereby authorize and give my consent to The National College for DUI Defense, Inc., hereby including its Membership Committee, (hereinafter collectively referred to as the “National College”), to conduct an investigation as to my moral character and fitness and to make inquiries and request such information from third parties as, in the sole discretion of the National College is necessary to such investigation. I further authorize the use of any such information in the course of the National College’s, investigation and evaluation of my application for <strong>SUSTAINING MEMBERSHIP</strong>. I authorize and request every person, firm, company, corporation, school, employer (past or present), governmental agency, court, association, institution, or other third party having opinions about me or knowledge or control of any information, documents, records (including, but not limited to, criminal history, and record information), or data pertaining to me, to reveal, furnish and release to the National College, or any of its agents or representatives, and such opinions, knowledge, information, documents, records or other data. Without limiting the previously described authority, I specifically authorize the release of files of any professional association regarding all undergraduate, graduate or professional school records relating to my admission to, and conduct during my enrollment in such schools. I hereby authorized all such persons as set out above to answer any inquiries, questions, or interrogatories concerning me, which may be submitted to them by or on my behalf of the National College. I further waive absolutely any privileges I may have which re applicable to any documents or information sought from you pursuant to this authorization and release. Notwithstanding any statement herein to the contrary, this Authorization and Release shall not operate to release any medical or mental health records relating to alcohol, drug or chemical dependency. I hereby release, discharge and hold harmless the National College, its agents or representatives and any person, firm, company, corporation, school, employer (past or present), governmental agency, court, association, institution, or other third party, and their agents, from any and all liability of every nature and kind arising out of the furnishing, inspection, and the use of such options, knowledge, documents, records or other data. A photocopy of this authorization shall be accepted with the same validity as the original.
                        </p>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">By printing your name you acknowledge this Authorization and Release.</label>
                           <div class="controls">
                              <input disabled class="m-wrap span12 authorizationRelease" type="text" value="<?=$this->vars['application']['authorizationRelease']?>" placeholder="">
                           </div>
                           
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Please download this reference form and confirm you did so by selecting "Yes": <br>
                              <a target="_blank" href="https://<?=SAW_ADMIN_WEBSITE?>/application/downloads/ncdd-sustaining-membership-reference-form.pdf">Sustaining Member Application Reference Form - click to download the PDF document.</a>
                           </label>
                           <div class="controls">
                              <input disabled type="text" value="<?=$this->vars['application']['referenceFormDownload']?>" class="m-wrap span12 referenceFormDownload">
                              <span class="help-block"></span>
                              <h4><strong>Please make sure your 4 references send their forms ASAP to the address at the top of the reference form via fax, email, or U.S. mail.</strong></h4>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>

                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Your Sponsor:</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[sponsor]" value="<?=(array_key_exists('sponsor',$this->vars['application'])) ? $this->vars['application']['sponsor']: '';?>" class="m-wrap span12 sponsor">
                              <span class="help-block">Please type in the name of the Fellow or Regent who is sponsoring your application.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  
                  <div class="form-actions text-center">
                     <? if($this->vars['application']['currentStatus'] >= \Saw\Model\Apply::$status['APPROVED'] && $this->vars['application']['currentStatus'] < \Saw\Model\Apply::$status['PAID']): ?>
                     <button type="button" data-id="<?=$this->vars['application']['_id']?>" class="btn green pay"><i class="icon-money"></i> Pay Application</button>
                     <? endif; ?>                     
                     <button type="button" data-id="<?=$this->vars['application']['_id']?>" class="btn blue edit"><i class="icon-pencil"></i> Edit Application</button>
                     <? if($this->vars['application']['currentStatus'] < \Saw\Model\Apply::$status['APPROVED']): ?>
                     <button type="button" data-id="<?=$this->vars['application']['_id']?>" data-type="<?=$this->vars['application']['class']?>" class="btn green approve"><i class="icon-ok"></i> Approve Application</button>
                     <? endif; ?>
                     <button type="button" class="btn cancel">Cancel and Go Back</button>
                     <button type="button" data-id="<?=$this->vars['application']['_id']?>" class="btn red delete">Delete Application</button>
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