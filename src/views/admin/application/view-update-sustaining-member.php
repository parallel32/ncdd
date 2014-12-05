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

                  <h3 class="form-section">1.  If your information below has changed please update it, otherwise, skip to step 2.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>Name</b></label>
                           <div class="controls">
                              <?=$this->vars['member']['displayName']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>Firm Name</b></label>
                           <div class="controls">
                              <?=$this->vars['location']['name']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>Address 1</b></label>
                           <div class="controls">
                              <?=$this->vars['location']['addressLine1']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>Address 2</b></label>
                           <div class="controls">
                              <?=$this->vars['location']['addressLine2']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>City</b></label>
                           <div class="controls">
                              <?=$this->vars['location']['city']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>State / Province</b></label>
                           <div class="controls">
                              <?=$this->vars['location']['state']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>Zip</b></label>
                           <div class="controls">
                              <?=$this->vars['location']['zip']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>Country</b></label>
                           <div class="controls">
                              <?=$this->vars['location']['country']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>Phone</b></label>
                           <div class="controls">
                              <?=$this->vars['location']['phone']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>Fax</b></label>
                           <div class="controls">
                              <?=$this->vars['location']['fax']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  
                  <div class="row-fluid">
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>Email Address</b></label>
                           <div class="controls">
                              <?=$this->vars['member']['email']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>Bar Number / State</b></label>
                           <div class="controls">
                              <?=$this->vars['member']['barNumber']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>


                  </br><hr></br>


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
                           <label class="control-label">Middle Name</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[middleName]" value="<?=$this->vars['application']['middleName']?>" class="m-wrap span12 middleName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">Last Name</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[lastName]" value="<?=$this->vars['application']['lastName']?>" class="m-wrap span12 lastName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Law Firm Name / Name of your practice</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[firmName]" value="<?=(array_key_exists('firmName',$this->vars['application'])) ? $this->vars['application']['firmName']: '';?>" class="m-wrap span12 firmName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Address 1</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[address1]" value="<?=$this->vars['application']['address1']?>" class="m-wrap span12 address1">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Address 2</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[address2]" value="<?=$this->vars['application']['address2']?>" class="m-wrap span12 address2">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">City</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[city]" value="<?=$this->vars['application']['city']?>" class="m-wrap span12 city">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">State / Province</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[state]" value="<?=$this->vars['application']['state']?>" class="m-wrap span12 state">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Zip</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[postalCode]" value="<?=$this->vars['application']['postalCode']?>" class="m-wrap span12 postalCode">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Country</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[country]" value="<?=$this->vars['application']['country']?>" class="m-wrap span12 country">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Phone</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[phone]" value="<?=$this->vars['application']['phone']?>" class="m-wrap span12 phone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Fax</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[fax]" value="<?=$this->vars['application']['fax']?>" class="m-wrap span12 fax">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  
                  <div class="row-fluid">
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Email Address</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[email]" value="<?=$this->vars['application']['email']?>" class="m-wrap span12 email">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Bar Number / State</label>
                           <div class="controls">
                              <input disabled type="text" name="doc[barNumber]" value="<?=$this->vars['application']['barNumber']?>" class="m-wrap span12 barNumber">
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
                  
                  <h3 class="form-section">2.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Since your last application, have you been arrested, prosecuted, convicted or received a ‘deferred’ or ‘diverted’ disposition on any charge involving drug/substance/alcohol use or abuse?</label>
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
                  <h3 class="form-section">3.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Since your last application, have you had a complaint/charge made against you by your State Bar Association or licensing authority arising from drug/substance/alcohol use or abuse?</label>
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
                  <h3 class="form-section">4.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Since your last application, have you been convicted or received a ‘deferred’ or ‘diverted’ disposition of any crime involving moral turpitude?</label>
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
                  <h3 class="form-section">5.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Since your last application, has your Bar Association or licensing authority conducted any investigation or inquiry based upon complaints, have you been subject to disciplinary action by your bar association, or has your license been suspended for any period of time?</label>
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
                  <h3 class="form-section">6.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Are you presently serving in any capacity (either part time or full time) in a law enforcement or prosecution agency (Example: reserve duty or municipal prosecutor)?</label>
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
                  <h3 class="form-section">7.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">I understand that any future service in any branch of law enforcement or as a prosecutor of state, county, district or municipal ordinances or statutes requires my immediate disclosure to NCDD and termination of my membership.</label>
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
                  
                  <h3 class="form-section">8.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">
                           I have substantial current involvement in the practice area of DUI/DWI defense and I understand that as a condition of continued membership I must continue to have substantial involvement, including attendance at one (or more) seminars every two (2) years either sponsored by NCDD or at a State/local seminar approved by NCDD.
                           <br><span class="control-group"><span class="controls"><input <?=(array_key_exists('twoSeminarsAcknowledgement',$this->vars['application']) && $this->vars['application']['twoSeminarsAcknowledgement'] == 'yes') ? 'checked' : '' ?> type="checkbox" name="doc[twoSeminarsAcknowledgement]" class="twoSeminarsAcknowledgement" value="yes"><b>Yes, I acknowledge this.</b></span></span>
                           </label>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  
                  
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">I have read the general membership rules, and I understand and agree to be bound by them. I declare under penalty of perjury that the foregoing application are true and correct to the best of my knowledge.
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

                  <div class="row-fluid">
                     <div class="span10 ">
                        <p class="alert alert-info">
                        <b>Additionally, you authorize us to retain the information that you have given us for our records, including member's address, licensing, contact information, and credit card information that we may use for the limited purposes described above, such as renewal payments of your membership dues and to communicate with you and to send announcements pertinent to your membership.</b>
                        <input <?=(array_key_exists('termsAcknowledgement',$this->vars['application']) && $this->vars['application']['termsAcknowledgement'] == 'yes') ? 'checked' : '' ?> type="checkbox" name="doc[termsAcknowledgement]" class="termsAcknowledgement" value="yes">Yes, I agree.
                        </p>
                     </div>
                     
                  </div>

                  
                  <h3 class="form-section">9. Voluntary Contribution to the NCDD Foundation.</h3>
                  <div class="row-fluid charity-div ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">The following amount is my voluntary contribution to the NCDD Foundation.</label>
                           <div class="input-prepend input-append">
                               <span class="add-on">$ </span>
                                  <input disabled id="contributionAmount" value="<?=(array_key_exists('contributionAmount',$this->vars['application'])) ? $this->vars['application']['contributionAmount']: ''?>" type="text" class="m-wrap span12 amount"> 
                               <span class="add-on">.00</span>
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
                     <button type="button" data-id="<?=$this->vars['application']['_id']?>" class="btn blue edit"><i class="icon-pencil"></i> Edit Application</button>
                     <? if($this->vars['application']['currentStatus'] < \Saw\Model\Apply::$status['APPROVED']): ?>
                     <? $user = $this->app['session']->get('user');
                        if($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )){  
                     ?>
                     <input type="checkbox" name="suppress_emails" <?=(array_key_exists('suppress_emails',$user) && !empty($user['suppress_emails']))?'checked':'';?> value="yes">Suppress Emails.
                     <? } ?>
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