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
                  <img src="<?=SAW_SSL_CDN?>/assets/img/ncdd-login2-logo.png">
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
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">First Name</label>
                           <div class="controls">
                              <input type="text" name="doc[firstName]" value="<?=$this->vars['member']['firstName']?>" class="m-wrap span12 firstName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">Middle Name</label>
                           <div class="controls">
                              <input type="text" name="doc[middleName]" value="<?=(array_key_exists('middleName', $this->vars['member'])) ? $this->vars['member']['middleName'] : ''?>" class="m-wrap span12 middleName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">Last Name</label>
                           <div class="controls">
                              <input type="text" name="doc[lastName]" value="<?=$this->vars['member']['lastName']?>" class="m-wrap span12 lastName">
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
                              <input type="text" name="doc[email]" value="<?=$this->vars['member']['email']?>" class="m-wrap span12 email">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     
                  </div>


















                  <!-- LOCATION -->
                     <div class="row-fluid">
                        <div class="span12">
                           <div id="location-grid" class="portlet box blue">
                              <div class="portlet-title">
                                 <div class="caption">Office Locations</div>
                                 <div class="actions">
                                    <a class="btn green add"><i class=" icon-plus"></i> Add</a>
                                 </div>
                              </div>
                              <div class="portlet-body">
                                 <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                 <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                                    <thead>
                                       <tr role="row">
                                          <th class="">Address</th>
                                          <th class="">Primary</th>
                                          <th class=""></th>
                                       </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                       <? if(!empty($this->vars['member']['locations'])): foreach($this->vars['member']['locations'] as $location): 
                                             if(!empty($location['addressLine1']) && !empty($location['city'])):
                                       ?>
                                       <tr class="gradeX odd">
                                          <td id="<?=$location['_id']?>" class=" "><?=$location['raw']?></td>
                                          <td id="<?=$location['_id']?>" class=" primarycell"><?=(array_key_exists('primary', $location) && $location['primary'] == 11) ? '<i class="icon-check"></i>' : '';?></td>
                                          <td class=" ">
                                              <a data-id="<?=$location['_id']?>" class="btn yellow mini setprimary"></i> Set as Primary</a>
                                             <a id="edit-<?=$location['_id']?>" 
                                             data-id="<?=$location['_id']?>" 
                                             data-name="<?=$location['name']?>" 
                                             data-hours="<?=$location['hours']?>" 
                                             data-phone="<?=$location['phone']?>" 
                                             data-fax="<?=$location['fax']?>" 
                                             data-tollFree="<?=$location['tollFree']?>" 
                                             data-addressLineOne="<?=$location['addressLine1']?>" 
                                             data-addressLineTwo="<?=$location['addressLine2']?>" 
                                             data-city="<?=$location['city']?>" 
                                             data-state="<?=$location['state']?>" 
                                             data-zip="<?if(strlen($location['zip']) < 5){echo str_pad($location['zip'],5,'0',STR_PAD_LEFT);}else if(strlen($location['zip']) > 5 && strlen($location['zip']) < 9){str_pad($location['zip'],9,'0',STR_PAD_LEFT);}else{echo $location['zip'];}?>" 
                                             data-country="<?=$location['country']?>" 
                                             data-raw="<?=$location['raw']?>"
                                             data-mode="save" 
                                             class="btn blue mini edit"></i> Edit</a> <a data-id="<?=$location['_id']?>" class="btn red mini delete"></i> Delete</a></td>
                                       </tr>
                                       <? 
                                          endif;
                                       endforeach;?>
                                       <? else: ?>
                                          <td id="location-norecords" colspan="5">No records.</td>
                                       <? endif;?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>


                     











                     <!-- WEBSITE -->
                     <div class="row-fluid">
                        <div class="span12">
                           <div id="website-grid" class="portlet box blue">
                              <div class="portlet-title">
                                 <div class="caption">Websites</div>
                                 <div class="actions">
                                    <a class="btn green add"><i class=" icon-plus"></i> Add</a>
                                 </div>
                              </div>
                              <div class="portlet-body">
                                 <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                 <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                                    <thead>
                                       <tr role="row">
                                          <th class="">Web Site</th>
                                          <th class="">Description</th>
                                          <th class=""></th>
                                       </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                       <? if(!empty($this->vars['member']['websites'])): foreach($this->vars['member']['websites'] as $website): ?>
                                       <tr class="gradeX odd">
                                          <td class=" "><?=$website['website']?></td>
                                          <td class=" "><?=$website['websiteDesc']?></td>
                                          <td class=" "><a data-name="<?=$website['website']?>" data-id="<?=$this->vars['member']['_id']?>" class="btn red mini delete"></i> Delete</a></td>
                                       </tr>
                                       <? endforeach;?>
                                       <? else: ?>
                                          <td id="website-norecords" colspan="5">No records.</td>
                                       <? endif;?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>


                     
                     <!--/ WEBSITE -->


































































                  </br><hr></br>




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

                  <? if(array_key_exists('is_autopay', $this->vars) && $this->vars['is_autopay']): ?>
                     
                  <? else: ?>

                  
                     <h3 class="form-section">Select which membership applies to you:</h3>
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
                     
                     
                     <h3 class="form-section">Promo Code</h3>
                     <div class="row-fluid">
                        <div class="span6">
                           <div class="control-group ">
                              <!-- <label class="control-label">Enter the promo code RENEW2016, pay your dues in full and sign up for future membership dues auto-pay (if you haven't already) and receive the NCDD Membership Desktop Trophy.  Offer expires January 4th, 2016. </label> -->
                              <div class="controls">
                                 <input type="text" name="doc[renewalpromocode]" class="m-wrap span12 renewalpromocode" value="">
                                 <input type="hidden" id="promocodetype" value="">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     
                     <h3 class="form-section">Please confirm if you intend to pay by check:</h3>
                     <div id="paybycheck" class="row-fluid">
                        <div class="span12 alert alert-warning">
                           <div class="control-group error">
                              <label class="control-label"></label>
                              <div class="controls">
                                 <input style="margin-left:1px;" type="radio" name="doc[payByCheck]" value="yes">&nbsp;&nbsp;Yes, I intend to pay by check.<br/><br/>
                                 <input style="margin-left:1px;" type="radio" name="doc[payByCheck]" value="no" checked>&nbsp;&nbsp;No, I intend to pay my membership dues online with my credit card.<br/><br/>
                                 <!--<input style="margin-left:1px;" type="radio" name="doc[payByCheck]" checked value="no-store">&nbsp;&nbsp;I intend to pay my membership dues online with my credit card.  Please also store my credit card for future convenience.<br/><br/>-->
                                 <!--Upon submission of this form and subsequent approval of your renewal, you will receive an email with instructions on how to pay your dues.-->
                                 <p id="paybycheck-instructions" class="hide">Because you are using the promocode, you must pay by credit card.  If you need to pay by check, clear out the promo code and select to pay by check.</p>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     
                     <div id="promocodeverification" class="row-fluid ">
                        <div class="span10 ">
                           <p class="alert alert-info">
                           <b>I authorize the NCDD to store my credit card for future Annual Dues payments.</b>
                           <span class="control-group"><span class="controls"><input type="checkbox" name="doc[termsAcknowledgement]" class="termsAcknowledgement" value="yes">Yes, I agree.</span></span>
                        </p>
                        </div>
                     </div>





                     <h3 class="form-section">If you intend to pay by credit card please provide your card details:</h3>
                     <? if(is_array($this->vars['member']) && array_key_exists('payment',$this->vars['member']) && !empty($this->vars['member']['payment']) && is_array($this->vars['member']['payment'])): 
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

                  <? endif; // is_autopay ?>





















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


      <!-- ADD LOCATION MODAL -->
      <div id="add-location-modal" class="modal container hide fade" tabindex="-1" role="dialog" aria-labelledby="add-location-modal-label" aria-hidden="true">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3 id="add-location-modal-label">Add Location</h3>
         </div>
         <div class="modal-body">



            <form id="location-form" class="horizontal-form">
               <!-- ERROR -->
               <div class="alert alert-error hide">
                  <button class="close" data-dismiss="alert"></button>
                  You have some form errors. Please check below.
               </div>
               <!--/ ERROR -->
               
               <!-- BEGIN ADDRESS -->
               <h3 class="form-section text-info"><strong>General Info</strong> (optional, but useful for clients)</h3>
               <div class="row-fluid">
                  <div class="span12 ">
                     <div class="control-group">
                        <label class="control-label" >Location Name</label>
                        <div class="controls">
                           <input type="text" id="location-name" name="doc[name]" class="m-wrap span12 name">
                           <span class="help-block">Example: The law office of .. OR .. Name and Name Firm, LLP</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row-fluid">
                  <div class="span6 ">
                     <div class="control-group">
                        <label class="control-label" >Hours of operation</label>
                        <div class="controls">
                           <input type="text" id="location-hours" name="doc[hours]" class="m-wrap span12 hours">
                           <span class="help-block">Example: M-F 9am to 5pm</span>
                        </div>
                     </div>
                  </div>
                  <div class="span6 ">
                     <div class="control-group">
                        <label class="control-label" >Office Phone</label>
                        <div class="controls">
                           <input type="text" id="location-phone" name="doc[phone]" class="m-wrap span12 phone">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row-fluid">
                  <div class="span6 ">
                     <div class="control-group">
                        <label class="control-label" >Office Fax</label>
                        <div class="controls">
                           <input type="text" id="location-fax" name="doc[fax]" class="m-wrap span12 fax">
                           <span class="help-block">Example: M-F 9am to 5pm</span>
                        </div>
                     </div>
                  </div>
                  <div class="span6 ">
                     <div class="control-group">
                        <label class="control-label" >Toll Free</label>
                        <div class="controls">
                           <input type="text" id="location-tollFree" name="doc[tollFree]" class="m-wrap span12 tollFree">
                        </div>
                     </div>
                  </div>
               </div>
               <h3 class="form-section text-info"><strong>Address</strong></h3>
               <div class="row-fluid addr ">
                  <div class="span12 ">
                     <div class="control-group">
                        <label class="control-label" >Address 1</label>
                        <div class="controls">
                           <input type="text" id="address1" name="doc[addressLine1]" class="m-wrap span12 addressLine1">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row-fluid addr ">
                  <div class="span12 ">
                     <div class="control-group">
                        <label class="control-label" >Address 2</label>
                        <div class="controls">
                           <input type="text" id="address2" name="doc[addressLine2]" class="m-wrap span12 addressLine2">
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
                           <input type="text" id="zip" name="doc[zip]" class="m-wrap span12 zip"> 
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
               <p>We attempt to determine the Latitude and Longitude of your address for furture searches based on nearby a client's location</p>
               <div class="row-fluid validateAddress">
                  <div class="span12 ">
                     <div class="control-group">
                        <label class="control-label" >Type in your full address and then click Submit for Geocoding:</label>
                        <div class="controls">
                           <input type="text" id="geocodeaddress" class="m-wrap span12 geocode" >
                           <button type="button" class="btn blue geocodeaddress">Submit for Geocoding <i class="icon-globe"></i></button>
                        </div>
                     </div>
                  </div>
               </div>
               <input type="hidden" id="mode">
               <input type="hidden" id="_id">
               <input type="hidden" name="doc[raw]" id="raw">
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
                                                Loading...
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
               <!-- ERROR -->
               <div class="alert alert-error hide">
                  <button class="close" data-dismiss="alert"></button>
                  You have some form errors. Please check below.
               </div>
               <!--/ ERROR -->
               
            </form>     

         </div>
         <div class="modal-footer">
            <button type="button" data-member-id="<?=$this->vars['member']['_id']?>" class="btn green save"><i class="icon-ok"></i> Save</button>
            <button type="button" class="btn cancell">Cancel</button>
         </div>
      </div>
      <!--/ ADD LOCATION MODAL -->   
      
      <!-- ADD WEBSITE MODAL -->
      <div id="add-website-modal" class="modal container hide fade" tabindex="-1" role="dialog" aria-labelledby="add-website-modal-label" aria-hidden="true">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3 id="add-website-modal-label">Add Website</h3>
         </div>
         <div class="modal-body">



            <form id="website-form" class="horizontal-form">
               <!-- ERROR -->
               <div class="alert alert-error hide">
                  <button class="close" data-dismiss="alert"></button>
                  You have some form errors. Please check below.
               </div>
               <!--/ ERROR -->
               
               <!-- BEGIN WEBSITE -->
               <div class="row-fluid">
                  <div class="span12 ">
                     <div class="control-group">
                        <label class="control-label" >Website Address</label>
                        <div class="controls">
                           <input type="text" id="modal-doc-website" name="doc[website]" class="m-wrap span12 website">
                           <span class="help-block">Example: domain.com</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row-fluid">
                  <div class="span12 ">
                     <div class="control-group">
                        <label class="control-label" >Website Description</label>
                        <div class="controls">
                           <input type="text" name="doc[websiteDesc]" class="m-wrap span12 websiteDesc">
                           <span class="help-block">Provide a short description.  This will not be visible, but very good for search engines</span>
                        </div>
                     </div>
                  </div>
               </div>
               
               <!-- ERROR -->
               <div class="alert alert-error hide">
                  <button class="close" data-dismiss="alert"></button>
                  You have some form errors. Please check below.
               </div>
               <!--/ ERROR -->
               
            </form>     

         </div>
         <div class="modal-footer">
            <button type="button" data-member-id="<?=$this->vars['member']['_id']?>" class="btn green save"><i class="icon-ok"></i> Save</button>
            <button type="button" class="btn cancell">Cancel</button>
         </div>
      </div>
      <!--/ ADD WEBSITE MODAL -->   




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
            
         <? if(is_array($this->vars['member']) && array_key_exists('payment',$this->vars['member']) && !empty($this->vars['member']['payment']) && is_array($this->vars['member']['payment'])): ?>
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
      <?=$this->element('js/Address.js');?>
      <?=$this->element('js/ClearField.js');?>

      <script>
      jQuery(document).ready(function() {    
         //////////////
         // LOCATION //
         //////////////
         // location grid buttons
         $('#location-grid .add').click(function(e){
            $('#add-location-modal :input').val('');//clear the modal
            $('#add-location-modal').modal({keyboard: false});
         });
         $('#location-grid .delete').click(function(e){
            var the_this = $(this);
            io.saw.FormGet.activate({postUrl:'/member/location/'+$(this).attr('data-id')+'/delete'
               ,postOnComplete:function(responseObj,responseStatus){}
               ,postOnSuccess:function(responseObj){
                  // remove the record from the grid
                  $(the_this).parents('tr').remove();
               }
            });
            
         });      
         $('#location-grid .setprimary').click(function(e){
            var the_this = $(this);
            io.saw.FormGet.activate({postUrl:'/member/location/'+$(this).attr('data-id')+'/primary'
               ,postOnComplete:function(responseObj,responseStatus){}
               ,postOnSuccess:function(responseObj){
                  // remove the record from the grid
                  $(the_this).parents('tbody').find('.primarycell').html(''); 
                  $(the_this).parents('tr').find('.primarycell').html('<i class="icon-check"></i>');
               }
            });
            
         });      
         $('#location-grid .edit').click(function(e){
            var the_this = $(this);
            $('#add-location-modal-label').html('Save Location');
            // clear the modal first
            $('#add-location-modal :input').val('');
            // set fields
            $('#_id').val($(this).attr('data-id'));
            $('#location-name').val($(this).attr('data-name'));
            $('#location-hours').val($(this).attr('data-hours'));
            $('#location-phone').val($(this).attr('data-phone'));
            $('#location-fax').val($(this).attr('data-fax'));
            $('#location-tollFree').val($(this).attr('data-tollFree'));
            $('#address1').val($(this).attr('data-addressLineOne'));
            $('#address2').val($(this).attr('data-addressLineTwo'));
            $('#city').val($(this).attr('data-city'));
            $('#state').val($(this).attr('data-state'));
            $('#zip').val($(this).attr('data-zip'));
            $('#country').val($(this).attr('data-country'));
            $('#raw').val($(this).attr('data-raw'));
            $('#geocodeaddress').val($(this).attr('data-raw'));
            $('#mode').val($(this).attr('data-mode'));

            $('#add-location-modal').modal({keyboard: false});
         });      
         

         // add location modal buttons    
         $('#add-location-modal .save').click(function(e){
         console.log('here'+$('#mode').val())
            var full_address = $('#location-name').val()+' '+$('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val();
            $('#raw').val(full_address);
            
            if($('#mode').val() == 'save'){
               io.saw.FormPost.activate({postUrl:'/location/'+$('#_id').val()+'/edit'
                  ,serializeSelector:':input'
                  ,formName:'#location-form'
                  ,postOnComplete:function(responseObj,responseStatus){}
                  ,postOnSuccess:function(responseObj){
                        $('#'+$('#_id').val()).html($('#raw').val());
                        $('#add-location-modal').modal('hide');         
                        $('#location-norecords').remove();

                        // reset the data attributes with the current values from the form
                        $('#edit-'+$('#_id').val()).attr('data-name',$('#location-name').val());
                        $('#edit-'+$('#_id').val()).attr('data-hours',$('#location-hours').val());
                        $('#edit-'+$('#_id').val()).attr('data-phone',$('#location-phone').val());
                        $('#edit-'+$('#_id').val()).attr('data-fax',$('#location-fax').val());
                        $('#edit-'+$('#_id').val()).attr('data-tollFree',$('#location-tollFree').val());
                        $('#edit-'+$('#_id').val()).attr('data-addressLineOne',$('#address1').val());
                        $('#edit-'+$('#_id').val()).attr('data-addressLineTwo',$('#address2').val());
                        $('#edit-'+$('#_id').val()).attr('data-city',$('#city').val());
                        $('#edit-'+$('#_id').val()).attr('data-state',$('#state').val());
                        $('#edit-'+$('#_id').val()).attr('data-zip',$('#zip').val());
                        $('#edit-'+$('#_id').val()).attr('data-country',$('#country').val());
                        $('#edit-'+$('#_id').val()).attr('data-raw',$('#raw').val());
                        $('#edit-'+$('#_id').val()).attr('data-mode',$('#mode').val());
                  }
               });
            }else{ //add
               io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-member-id')+'/location/add'
                  ,serializeSelector:':input'
                  ,formName:'#location-form'
                  ,postOnComplete:function(responseObj,responseStatus){}
                  ,postOnSuccess:function(responseObj){
                        $('#add-location-modal').modal('hide');         
                        $('#location-norecords').remove();
                        // add the record to the grid.
                        html = '<tr class="gradeX odd">'+
                          '  <td id="'+responseObj.id.$id+'" class=" ">'+full_address+ '</td>'+
                          '  <td id="'+responseObj.id.$id+'" class=" primarycell"></td>'+
                          '  <td class=" ">'+
                          '<a data-id="'+responseObj.id.$id+'" class="btn yellow mini setprimary"></i> Set as Primary</a>'+
                          '<a id="edit-'+responseObj.id.$id+'" '+
                          ' data-id="'+responseObj.id.$id+'" '+
                          ' data-name="'+$('#location-name').val()+'" '+
                          ' data-hours="'+$('#location-hours').val()+'" '+
                          ' data-phone="'+$('#location-phone').val()+'" '+
                          ' data-fax="'+$('#location-fax').val()+'" '+
                          ' data-tollFree="'+$('#location-tollFree').val()+'" '+
                          ' data-addressLineOne="'+$('#address1').val()+'" '+
                          ' data-addressLineTwo="'+$('#address2').val()+'" '+
                          ' data-city="'+$('#city').val()+'" '+
                          ' data-state="'+$('#state').val()+'" '+
                          ' data-zip="'+$('#zip').val()+'" '+
                          ' data-country="'+$('#country').val()+'" '+
                          ' data-raw="'+$('#raw').val()+'" '+
                          ' data-mode="save" '+

                          'class="btn blue mini edit"></i> Edit</a> '+
                          ' <a data-id="'+responseObj.id.$id+'" class="btn red mini delete"></i> Delete</a></td>'+
                           '</tr>';
                           $('#location-grid tbody').append(html);

                           // rebind click event to the records....
                           $('#location-grid .delete').click(function(e){
                              var the_this = $(this);
                        io.saw.FormGet.activate({postUrl:'/member/location/'+$(this).attr('data-id')+'/delete'
                           ,postOnComplete:function(responseObj,responseStatus){}
                           ,postOnSuccess:function(responseObj){
                              // remove the record from the grid
                              $(the_this).parents('tr').remove();
                           }
                        });
                        
                     });   
                     $('#location-grid .setprimary').click(function(e){
                        var the_this = $(this);
                        io.saw.FormGet.activate({postUrl:'/member/location/'+$(this).attr('data-id')+'/primary'
                           ,postOnComplete:function(responseObj,responseStatus){}
                           ,postOnSuccess:function(responseObj){
                              // remove the record from the grid
                              $(the_this).parents('tbody').find('.primarycell').html(''); 
                              $(the_this).parents('tr').find('.primarycell').html('<i class="icon-check"></i>');
                           }
                        });
                        
                     });
                     $('#location-grid .edit').click(function(e){
                        var the_this = $(this);
                        $('#add-location-modal-label').html('Save Location');
                        // clear the modal first
                        $('#add-location-modal :input').val('');
                        // set fields
                        $('#_id').val($(this).attr('data-id'));
                        $('#location-name').val($(this).attr('data-name'));
                        $('#location-hours').val($(this).attr('data-hours'));
                        $('#location-phone').val($(this).attr('data-phone'));
                        $('#location-fax').val($(this).attr('data-fax'));
                        $('#location-tollFree').val($(this).attr('data-tollFree'));
                        $('#address1').val($(this).attr('data-addressLineOne'));
                        $('#address2').val($(this).attr('data-addressLineTwo'));
                        $('#city').val($(this).attr('data-city'));
                        $('#state').val($(this).attr('data-state'));
                        $('#zip').val($(this).attr('data-zip'));
                        $('#country').val($(this).attr('data-country'));
                        $('#raw').val($(this).attr('data-raw'));
                        $('#geocodeaddress').val($(this).attr('data-raw'));
                        $('#mode').val($(this).attr('data-mode'));

                        $('#add-location-modal').modal({keyboard: false});
                     });      
                  }
               });
            }
            
         });      
         $('#add-location-modal .cancel').click(function(e){
            $('#add-location-modal').modal('hide');
         });      
         
         // auto fill the geocde address field
         $('#geocodeaddress').focus(function(e){
            $('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
         });
         $('#address1').blur(function(e){
            $('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
         });
         $('#address2').blur(function(e){
            $('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
         });
         $('#city').blur(function(e){
            $('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
         });
         $('#state').blur(function(e){
            $('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
         });
         $('#zip').blur(function(e){
            $('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
         });
         $('#country').blur(function(e){
            $('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
         });
         

         /////////////
         // WEBSITE //
         /////////////
         // website grid buttons
         $('#website-grid .add').click(function(e){
            $('#add-website-modal :input').val('');//clear the modal
            $('#add-website-modal').modal({keyboard: false});
            setTimeout(function(){$('#modal-doc-website').focus()}, 1500);
         });
         $('#website-grid .delete').click(function(e){
            var the_this = $(this);
            io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-id')+'/website/delete'
               ,serialized:'website='+$(this).attr('data-name')
               ,postOnComplete:function(responseObj,responseStatus){}
               ,postOnSuccess:function(responseObj){
                  // remove the record from the grid
                  $(the_this).parents('tr').remove();
               }
            });
            
         });      
         

         // add website modal buttons     
         $('#add-website-modal .save').click(function(e){
            io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-member-id')+'/website/add'
               ,serializeSelector:':input'
               ,formName:'#website-form'
               ,postOnComplete:function(responseObj,responseStatus){}
               ,postOnSuccess:function(responseObj){
                     $('#add-website-modal').modal('hide');       
                     $('#website-norecords').remove();
                     // add the record to the grid.
                     html = '<tr class="gradeX odd">'+
                       '  <td class=" ">'+$('#add-website-modal .website').val()+'</td>'+
                       '  <td class=" ">'+$('#add-website-modal .websiteDesc').val()+'</td>'+
                       '  <td class=" "><a data-name="'+responseObj.name+'" data-id="'+responseObj.id+'" class="btn red mini delete"></i> Delete</a></td>'+
                        '</tr>';
                        $('#website-grid tbody').append(html);

                        // rebind click event to the records....
                        $('#website-grid .delete').click(function(e){
                     var the_this = $(this);
                     io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-id')+'/website/delete'
                        ,serialized:'website='+$(this).attr('data-name')
                        ,postOnComplete:function(responseObj,responseStatus){}
                        ,postOnSuccess:function(responseObj){
                           // remove the record from the grid
                           $(the_this).parents('tr').remove();
                        }
                     });
                     
                  });   
               }
            });
         });      
         $('#add-website-modal .cancel').click(function(e){
            $('#add-website-modal').modal('hide');
         });

         io.saw.Address.init('#location-form');
         io.saw.ClearField.init({formArr:['#location-form','#website-form']});
         $.extend($.inputmask.defaults, {
             'autounmask': true
         });
         $(".phone").inputmask("mask", {"mask": "(999) 999-9999"}); 
         $(".fax").inputmask("mask", {"mask": "(999) 999-9999"}); 
         $(".primaryPhone").inputmask("mask", {"mask": "(999) 999-9999"}); 
         $(".primaryFax").inputmask("mask", {"mask": "(999) 999-9999"}); 
         $(".tollFree").inputmask("mask", {"mask": "(999) 999-9999"}); 
         

         $('#add-website-modal .cancell').click(function(e){
            e.preventDefault();
            $('#add-website-modal').modal('hide');            
         });
         $('#add-location-modal .cancell').click(function(e){
            e.preventDefault();
            $('#add-location-modal').modal('hide');            
         });
      });      
      </script>
      