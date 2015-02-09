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
            <!-- BEGIN PAGE HEADER-->
         <div class="row-fluid">
            <div class="span12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title text-center">
                  <img src="/assets/img/ncdd-login2-logo.png">
                  <br/>Member Renewal Form
               </h3>
               <p class="text-center">
                  
                  <br/>National College for DUI Defense, Inc. 
                  <br/>445 S. Decatur St. 
                  <br/>Montgomery, AL 36104
                  <br/>Tel: 334-264-1950 
                  <br/>Fax: 334-264-1920
               </p>
               <!-- END PAGE TITLE & BREADCRUMB-->
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
                  <h3 class="form-section">1.  If your information below has changed please update it otherwise, skip to step 2.</h3>
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
                              <?if(strlen($this->vars['location']['zip']) < 5){echo str_pad($this->vars['location']['zip'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['location']['zip']) > 5 && strlen($this->vars['location']['zip']) < 9){str_pad($this->vars['location']['zip'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['location']['zip'];}?>
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
                              <input type="text" name="doc[firstName]" value="" class="m-wrap span12 firstName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">Middle Name</label>
                           <div class="controls">
                              <input type="text" name="doc[middleName]" value="" class="m-wrap span12 middleName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">Last Name</label>
                           <div class="controls">
                              <input type="text" name="doc[lastName]" value="" class="m-wrap span12 lastName">
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
                              <input type="text" name="doc[firmName]" value="" class="m-wrap span12 firmName">
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
                              <input type="text" name="doc[address1]" value="" class="m-wrap span12 address1">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Address 2</label>
                           <div class="controls">
                              <input type="text" name="doc[address2]" value="" class="m-wrap span12 address2">
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
                              <input type="text" name="doc[city]" value="" class="m-wrap span12 city">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">State / Province</label>
                           <div class="controls">
                              <input type="text" name="doc[state]" value="" class="m-wrap span12 state">
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
                              <input type="text" name="doc[postalCode]" value="" class="m-wrap span12 postalCode">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Country</label>
                           <div class="controls">
                              <input type="text" name="doc[country]" value="" class="m-wrap span12 country">
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
                              <input type="text" name="doc[phone]" value="" class="m-wrap span12 phone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Fax</label>
                           <div class="controls">
                              <input type="text" name="doc[fax]" value="" class="m-wrap span12 fax">
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
                              <input type="text" name="doc[email]" value="" class="m-wrap span12 email">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Bar Number / State</label>
                           <div class="controls">
                              <input type="text" name="doc[barNumber]" value="" class="m-wrap span12 barNumber">
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
                           <label class="control-label">Listserv Email (if different than your username)</label>
                           <div class="controls">
                              <input type="text" name="doc[listServEmail]" value="" class="m-wrap span12 listServEmail">
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
                  <h3 class="form-section">3.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Since your last application, have you had a complaint/charge made against you by your State Bar Association or licensing authority arising from drug/substance/alcohol use or abuse?</label>
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
                  <h3 class="form-section">4.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Since your last application, have you been convicted or received a ‘deferred’ or ‘diverted’ disposition of any crime involving moral turpitude?</label>
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
                  <h3 class="form-section">5.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Since your last application, has your Bar Association or licensing authority conducted any investigation or inquiry based upon complaints, have you been subject to disciplinary action by your bar association, or has your license been suspended for any period of time?</label>
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
                  <h3 class="form-section">6.</h3>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Are you presently serving in any capacity (either part time or full time) in a law enforcement or prosecution agency (Example: reserve duty or municipal prosecutor)?</label>
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
                  <h3 class="form-section">7.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">I understand that any future service in any branch of law enforcement or as a prosecutor of state, county, district or municipal ordinances or statutes requires my immediate disclosure to NCDD and termination of my membership.</label>
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
                  <h3 class="form-section">8.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">
                           I have substantial current involvement in the practice area of DUI/DWI defense and I understand that as a condition of continued membership I must continue to have substantial involvement, including attendance at one (or more) seminars every two (2) years either sponsored by NCDD or at a State/local seminar approved by NCDD.
                           <br><span class="control-group"><span class="controls"><input type="checkbox" name="doc[twoSeminarsAcknowledgement]" class="twoSeminarsAcknowledgement" value="yes"><b>Yes, I acknowledge this.</b></span></span>
                           </label>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">
                              I have read the general membership rules, and I understand and agree to be bound by them. I declare under penalty of perjury that the foregoing application are true and correct to the best of my knowledge.
                           </br>
                           </label>
                           <div class="input-append">
                              <span class="add-on">Executed At </span>
                              <input name="doc[executed]" class="m-wrap span12 executed" type="text" placeholder="City and State / Province">
                              <span class="add-on">, on this <? $date = new \DateTime(); echo $date->format('dS');?> day of <?echo $date->format('F');?>, 20<?echo $date->format('y');?></span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"></label>
                           <div class="input-prepend">
                              <span class="add-on">Printed Name </span>
                              <input name="doc[executedPrintedName]" class="m-wrap span12 executedPrintedName" type="text" placeholder="">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>

                  
                  <h3 class="form-section">Check which applies to your membership:</h3>
                  <!-- EARLY BIRD DISCOUNT FOR 2014 -->
                  <p class="alert alert-info"><b>As an added incentive to pay your dues early and sign up for automatic renewal, complete your Membership Renewal by February 15, 2015 and you will receive an automatic $50 off your 2015 Annual dues.</b></p>

                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"></label>
                           <div class="controls">
                              <select class=" m-wrap span12 membershipDues" name="doc[membershipDues]">
                                 <option value="225">6 or more years in law practice ($225 annual dues)</option>
                                 <option value="175">1-5 years in law practice ($175 annual dues) </option>
                                 <option value="50"> Public Defender ($50 annual dues)</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">Please confirm if you intend to pay by check:</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"></label>
                           <div class="controls">
                              <input style="margin-left:1px;" type="radio" name="doc[payByCheck]" value="yes">&nbsp;&nbsp;Yes, I intend to pay by check.<br/><br/>
                              <input style="margin-left:1px;" type="radio" name="doc[payByCheck]" value="no" checked>&nbsp;&nbsp;No, I intend to pay my membership dues online with my credit card.<br/><br/>
                              <!--<input style="margin-left:1px;" type="radio" name="doc[payByCheck]" checked value="no-store">&nbsp;&nbsp;I intend to pay my membership dues online with my credit card.  Please also store my credit card for future convenience.<br/><br/>-->
                              <!--Upon submission of this form and subsequent approval of your renewal, you will receive an email with instructions on how to pay your dues.-->
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span10 ">
                        <p class="alert alert-info">
                        <b>I authorize the NCDD to store my credit card for future Annual Dues payments.</b>
                        <span class="control-group"><span class="controls"><input type="checkbox" name="doc[termsAcknowledgement]" class="termsAcknowledgement" value="yes">Yes, I agree.</span></span>
                     </p>
                     </div>
                     
                  </div>






























                  <h3 class="form-section">If you intend to pay by credit card please provide your card details:</h3>
                  <? if(array_key_exists('payment',$this->vars['member']) && !empty($this->vars['member']['payment']) && is_array($this->vars['member']['payment'])): 
                        $this->vars['payment'] = $this->vars['member']['payment'];
                     else:
                        $this->vars['payment'] = array();
                     endif;
                  ?>
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
                                 <input type="text" name="doc[paymentlite][name]" class="m-wrap span8 paymentlite-name" value="<?=(array_key_exists('name',$this->vars['payment'])) ? $this->vars['payment']['name']: '';?>">
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
                                 <input type="text" name="doc[paymentlite][number]" class="m-wrap span8 paymentlite-number" value="<?=(array_key_exists('number',$this->vars['payment'])) ? $this->vars['payment']['number']: '';?>">
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
                                 <input type="text" name="doc[paymentlite][cvc]" class="m-wrap span8 paymentlite-cvc" value="<?=(array_key_exists('cvc',$this->vars['payment'])) ? $this->vars['payment']['cvc']: '';?>">
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
                                 <select id="ccard-expMonth" class="span4 paymentlite-expMonth" name="doc[paymentlite][expMonth]"></select>
                                 <select id="ccard-expYear" class="span4 paymentlite-expYear" name="doc[paymentlite][expYear]"></select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <h3 class="form-section">Credit Card Billing Address</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Address Line 1</label>
                              <div class="controls">
                                 <input type="text" name="doc[paymentlite][addressLine1]" class="m-wrap span8 paymentlite-addressLine1" value="<?=(array_key_exists('addressLine1',$this->vars['payment'])) ? $this->vars['payment']['addressLine1']: '';?>">
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
                                 <input type="text" name="doc[paymentlite][addressLine2]" class="m-wrap span8 paymentlite-addressLine2" value="<?=(array_key_exists('addressLine2',$this->vars['payment'])) ? $this->vars['payment']['addressLine2']: '';?>">
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
                                 <input type="text" name="doc[paymentlite][city]" class="m-wrap span8 paymentlite-city" value="<?=(array_key_exists('city',$this->vars['payment'])) ? $this->vars['payment']['city']: '';?>">
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
                                 <input type="text" name="doc[paymentlite][stateProvinceRegion]" class="m-wrap span8 paymentlite-stateProvinceRegion" value="<?=(array_key_exists('stateProvinceRegion',$this->vars['payment'])) ? $this->vars['payment']['stateProvinceRegion']: '';?>">
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
                                 <input type="text" name="doc[paymentlite][zipPostalCode]" class="m-wrap span8 paymentlite-zipPostalCode" value="<?if(array_key_exists('zipPostalCode',$this->vars['payment'])){if(strlen($this->vars['payment']['zipPostalCode']) < 5){echo str_pad($this->vars['payment']['zipPostalCode'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['payment']['zipPostalCode']) > 5 && strlen($this->vars['payment']['zipPostalCode']) < 9){str_pad($this->vars['payment']['zipPostalCode'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['payment']['zipPostalCode'];}}?>">
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
                                 <input type="text" name="doc[paymentlite][country]" class="m-wrap span8 paymentlite-country" value="<?=(array_key_exists('country',$this->vars['payment'])) ? $this->vars['payment']['country']: '';?>">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>























                  <h3 class="form-section">9. Voluntary Contribution to the NCDD Foundation.</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <input id="contributionPaymentId" name="doc[contributionPaymentId]" type="hidden" value="" class="m-wrap span12 contributionPaymentId"> 
                        <button type="button" id="yes-contribution" data-value="no" class="btn green yes-contribution">Click here to make a charitable contribution.</button>
                        <button type="button" id="cancel-contribution" class="btn cancel-contribution hide">Click here to cancel contribution</button>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid charity-div hide">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Please charge the following amount as my voluntary contribution to the NCDD Foundation.</label>
                           <div class="input-prepend input-append">
                               <span class="add-on">$ </span>
                                  <input id="contributionAmount" name="doc[contributionAmount]" type="text" value="" class="m-wrap span12 amount"> 
                                  <input id="contributionCheck" name="doc[contributionCheck]" type="hidden" value="no" class="m-wrap span12 contributionCheck"> 
                               <span class="add-on">.00</span>
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
                  <div id="payment-form" class="charity-div hide">
                     
                     <input type="hidden" class="memberId" name="doc[payment][memberId]" value="<?=$this->vars['member']['_id'];?>">
                     <input type="hidden" class="description" name="doc[payment][description]" value="<?='INV-'.time();?>">
                     <input type="hidden" class="title" name="doc[payment][title]" value="Charitable contribution to the NCDD Foundation on behalf of <?=$this->vars['member']['displayName'];?>">
                     <input type="hidden" class="amount" name="doc[payment][amount]" value="">
                     <input type="hidden" class="cardType" name="doc[payment][cardType]" value="">
                     <input type="hidden" class="token" name="doc[payment][token]" value="">
                     <h3 class="form-section">Credit Card</h3>
                     <p>To pay by check, please scroll to the end of the form and click the blue button.</p>
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
                                 <input id="card-name" type="text" name="doc[payment][name]" class="m-wrap span8 payment-name" value="<?=$this->vars['member']['displayName']?>">
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
                                 <input id="card-number" type="text" name="doc[payment][number]" class="m-wrap span8 payment-number">
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
                                 <input id="card-cvc" type="text" name="doc[payment][cvc]" class="m-wrap span8 payment-cvc">
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
                                 <select id="card-expMonth" class="span4 payment-expMonth" name="doc[payment][expMonth]"></select>
                                 <select id="card-expYear" class="span4 payment-expYear" name="doc[payment][expYear]"></select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     
                     <h3 class="form-section">Billing Address</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Address Line 1</label>
                              <div class="controls">
                                 <input id="card-addressLine1" type="text" name="doc[payment][addressLine1]" class="m-wrap span8 payment-addressLine1" value="<?=$this->vars['location']['addressLine1']?>">
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
                                 <input id="card-addressLine2" type="text" name="doc[payment][addressLine2]" class="m-wrap span8 payment-addressLine2" value="<?=$this->vars['location']['addressLine2']?>">
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
                                 <input id="card-city" type="text" name="doc[payment][city]" class="m-wrap span8 payment-city" value="<?=$this->vars['location']['city']?>">
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
                                 <input id="card-stateProvinceRegion" type="text" name="doc[payment][stateProvinceRegion]" class="m-wrap span8 payment-stateProvinceRegion" value="<?=$this->vars['location']['state']?>">
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
                                 <input id="card-zipPostalCode" type="text" name="doc[payment][zipPostalCode]" class="m-wrap span8 payment-zipPostalCode" value="<?if(strlen($this->vars['location']['zip']) < 5){echo str_pad($this->vars['location']['zip'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['location']['zip']) > 5 && strlen($this->vars['location']['zip']) < 9){str_pad($this->vars['location']['zip'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['location']['zip'];}?>">
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
                                 <input id="card-country" type="text" name="doc[payment][country]" class="m-wrap span8 payment-country" value="<?=$this->vars['location']['country']?>">
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
                                 <input id="card-email" type="text" name="doc[payment][email]" class="m-wrap span8 payment-email" value="<?=$this->vars['member']['email']?>">
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
                                 <input id="card-phone" type="text" name="doc[payment][phone]" class="m-wrap span8 payment-phone" value="<?=$this->vars['member']['primaryPhone']?>">
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
                     
                  </div>
                  <!--/ PAYMENT ELEMENT -->

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
                        <button class="btn finished">Finished, Go Back to the Dashboard.</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  
                  <div class="form-actions text-center">
                     <? $user = $this->app['session']->get('user');
                        if($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )){  
                     ?>
                     <input type="checkbox" name="suppress_emails" <?=(array_key_exists('suppress_emails',$user) && !empty($user['suppress_emails']))?'checked':'';?> value="yes">Suppress Emails.
                     <? } ?>
                     <button type="button" class="btn green"><i class="icon-check"></i> Submit</button>
                     <button type="button" class="btn cancel-go-back">Cancel and Go Back</button>
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
      <?=$this->element('js/Application.js');?>
      <script>
      jQuery(document).ready(function() {    
         io.saw.Application.updateMemberInit();


         // charity on
         $('#yes-contribution').click(function(e){
            $('#cancel-contribution').show();
            $('.charity-div').show();
            $(this).attr('data-value','yes');
            $('#contributionCheck').val('yes');
         });
         // charity off
         $('#cancel-contribution').click(function(e){
            $('#cancel-contribution').hide();
            $('.charity-div').hide();
            $('#yes-contribution').attr('data-value','no');
            $('#contributionCheck').val('no');
         });
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
         Payment.createStripeToken = function (){
            $('#saw-form .form-actions .btn.green').html('<i class="icon-time"></i> Processing Your Registration..');
            $('#saw-form .form-actions .btn.green').attr("disabled", "disabled");
            submitApp();
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



         // prepare the month dropdown
            var select = $("#ccard-expMonth"),
            month = new Date().getMonth() + 1;
            for (var i = 1; i <= 12; i++) {
               select.append($("<option value='"+i+"' "+(month === i ? "selected" : "")+">"+i+"</option>"))
            }

            // prepare the year dropdown
            var select = $("#ccard-expYear"),
            year = new Date().getFullYear();

            for (var i = 0; i < 12; i++) {
               select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
            }
            
         <? if(array_key_exists('payment',$this->vars['member']) && !empty($this->vars['member']['payment']) && is_array($this->vars['member']['payment'])): ?>
            // STORE CARD STUFF
            var smonth = '<?=(array_key_exists('expMonth',$this->vars['payment'])) ? $this->vars['payment']['expMonth']: '';?>';
            var syear = '<?=(array_key_exists('expYear',$this->vars['payment'])) ? $this->vars['payment']['expYear']: '';?>';
            $('#ccard-expMonth option[value='+smonth+']').attr('selected', 'selected');
            $('#ccard-expYear option[value=20'+syear+']').attr('selected', true);
         <? endif; ?>


         submitApp = function(){
            io.saw.FormPost.activate({postUrl:'/application/update-member/<?=$this->vars["member"]["_id"]?>'
               ,serializeSelector:':input'
               ,invalidFieldsString:'no'
               ,postOnComplete:function(responseObj,responseStatus){
                     if(responseStatus == 'success'){
                  
                  }else{
                        var responseObj = $.parseJSON(responseObj.responseText);
                     }
               }
               ,postOnSuccess:function(responseObj){
                     $('#save-success .modal-body p').html(responseObj.message);
                     $('#save-success-label').html(responseObj.label);
                     $('#save-success').modal({keyboard: false});       
                     //$('#saw-form .form-actions .btn.green').prop("disabled",true);
                     $('#saw-form .form-actions .btn.green').html('<i class="icon-ok"></i> Submission Successful');
               }
               ,postOnErrors:function(responseObj){
                     $('#payment-form .number').val(io.saw.Payment.hold_card);
                     $('#saw-form .form-actions .btn.green').removeAttr("disabled");
                  $('#saw-form .form-actions .btn.green').html('<i class="icon-ok"></i> Oops, Submission Failed - try again');
               }
            });         
         };
         initiateSubmit = function(){

            if($('#yes-contribution').attr('data-value') == 'no'){
               submitApp();
            }

            if($('#yes-contribution').attr('data-value') == 'yes'){
               $('#payment-form .amount').val($('#contributionAmount').val());
               io.saw.Payment.createStripeToken();
            }
            
         };
      });
      </script>