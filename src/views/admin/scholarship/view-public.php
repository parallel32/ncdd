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
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">For</label>
                           <div class="controls">
                              <input type="text" name="doc[for]" class="m-wrap span12 for" value="<?=$this->vars['scholarship']['for']?>" readonly>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Name</label>
                           <div class="controls">
                              <input type="text" name="doc[name]" class="m-wrap span12 name" value="<?=$this->vars['scholarship']['name']?>" readonly>
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
                              <input id="phone" type="text" name="doc[phone]" class="m-wrap span12 phone" value="<?=$this->vars['scholarship']['phone']?>" readonly>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Facsimile</label>
                           <div class="controls">
                              <input id="fax" type="text" name="doc[fax]" class="m-wrap span12 fax" value="<?=$this->vars['scholarship']['fax']?>" readonly>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6">
                        <div class="control-group">
                           <label class="control-label">Bar Number / State</label>
                           <div class="controls">
                              <input type="text" name="doc[barNumber]" class="m-wrap span12 barNumber" value="<?=$this->vars['scholarship']['barNumber']?>" readonly>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Email</label>
                           <div class="controls">
                              <input type="text" name="doc[email]" class="m-wrap span12 email" value="<?=$this->vars['scholarship']['email']?>" readonly>
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
                              <input type="text" id="address1" name="doc[address1]" class="m-wrap span12 address1" value="<?=$this->vars['scholarship']['address1']?>" readonly>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 2</label>
                           <div class="controls">
                              <input type="text" id="address2" name="doc[address2]" class="m-wrap span12 address2" value="<?=$this->vars['scholarship']['address2']?>" readonly>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >City</label>
                           <div class="controls">
                              <input type="text" id="city" name="doc[city]" class="m-wrap span12 city" value="<?=$this->vars['scholarship']['city']?>" readonly> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >State / Province</label>
                           <div class="controls">
                              <input type="text" id="state" name="doc[state]" class="m-wrap span12 state" value="<?=$this->vars['scholarship']['state']?>" readonly> 
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
                              <input type="text" id="zip" name="doc[postalCode]" class="m-wrap span12 postalCode" value="<?if(strlen($this->vars['scholarship']['postalCode']) < 5){echo str_pad($this->vars['scholarship']['postalCode'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['scholarship']['postalCode']) > 5 && strlen($this->vars['scholarship']['postalCode']) < 9){str_pad($this->vars['scholarship']['postalCode'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['scholarship']['postalCode'];}?>" readonly> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Country</label>
                           <div class="controls">
                              <input type="text" id="country" name="doc[country]" class="m-wrap span12 country" value="<?=$this->vars['scholarship']['country']?>" readonly> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  
                  <h3 class="form-section">2.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Number of years in law practice:</label>
                           <div class="controls">
                              <input type="text" name="doc[yearsInLawPractice]" class="m-wrap span12 yearsInLawPractice" value="<?=$this->vars['scholarship']['yearsInLawPractice']?>" readonly>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">3.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Number of years in the NCDD:</label>
                           <div class="controls">
                              <input type="text" name="doc[yearsInNCDD]" class="m-wrap span12 yearsInNCDD" value="<?=$this->vars['scholarship']['yearsInNCDD']?>" readonly>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">4.</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">Approximate number of DUI/DWI jury trials and non-jury trials you have handled:</label>
                           <div class="controls">
                              <select class="small m-wrap numberDUITrialsHandeled" name="doc[numberDUITrialsHandeled]" value="<?=$this->vars['scholarship']['numberDUITrialsHandeled']?>" readonly>
                                 <option value="10">Fewer than 10</option>
                                 <option value="11">11 to 30</option>
                                 <option value="31">31 or more</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">5.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Have you ever been arrested for any crime?</label>
                           <div class="controls">
                              <select class="small m-wrap everBeenArrested" name="doc[everBeenArrested]" value="<?=$this->vars['scholarship']['everBeenArrested']?>" readonly>
                                 <option value="no">No</option>
                                 <option value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If "Yes", please explain  and provide the final disposition of the case including whether or not you received a "deferred" or "diverted" disposition.</label>
                           <div class="controls">
                              <textarea rows="5" class="span12 everBeenArrestedExplain" name="doc[everBeenArrestedExplain]" readonly><?=$this->vars['scholarship']['everBeenArrestedExplain']?></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">6.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><b>a)</b> Has your Bar Association or licensing authority conducted any investigation or inquiry based upon complaints?</label><br>
                           <label class="control-label"><b>b)</b> Have you ever been subject to disciplinary action by your bar association or licensing authority?</label><br>
                           <label class="control-label"><b>c)</b> Has your license to practice law ever been suspended or revoked for any period of time?</label><br>
                           <div class="controls">
                              <select class="small m-wrap everInvestigation" name="doc[everInvestigation]" value="<?=$this->vars['scholarship']['everInvestigation']?>" readonly>
                                 <option value="no">No</option>
                                 <option value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">If your answer is "Yes" to any portion of question 6, please explain:</label>
                           <div class="controls">
                              <textarea rows="5" class="span12 everInvestigationExplain" name="doc[everInvestigationExplain]" readonly><?=$this->vars['scholarship']['everInvestigationExplain']?></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">7.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Are you presently serving, in any capacity, either part time or full time in a law enforcement or prosecution agency (Example: reserve duty officer or municipal prosecutor)? </label>
                           <div class="controls">
                              <select class="small m-wrap everLawEnforcement" name="doc[everLawEnforcement]" value="<?=$this->vars['scholarship']['everLawEnforcement']?>" readonly>
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
                              <textarea rows="5" class="span12 everLawEnforcementExplain" name="doc[everLawEnforcementExplain]" readonly><?=$this->vars['scholarship']['everLawEnforcementExplain']?></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">8.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Please take a moment to explain your reasons for requesting a scholarship. </label>
                           <div class="controls">
                              <?=$this->vars['scholarship']['reasonForScholarship']?>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     
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