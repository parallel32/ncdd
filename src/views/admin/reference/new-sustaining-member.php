<!-- BEGIN CONTAINER -->   
<div class="page-container row-fluid">
   <!-- BEGIN PAGE CONTAINER-->
   <div class="container-fluid">
      <!-- BEGIN PAGE HEADER-->
         <div class="row-fluid">
            <div class="span12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title text-center">
                  <a href="//<?=SAW_CONSUMER_WEBSITE?>"><img src="/assets/img/ncdd-login2-logo.png"></a>
                  <br/>Sustaining Membership Reference Form
                  <br/>for
                  <br/><b><? $middleName = (!empty($this->vars['application']['middleName'])) ? ' '.$this->vars['application']['middleName'] : '' ?>
                              <?=$this->vars['application']['firstName'].$middleName.' '.$this->vars['application']['lastName']?></b>
               </h3>
               <p class="text-center">
                  
                  National College for DUI Defense, Inc. 
                  <br/>445 S. Decatur St. 
                  <br/>Montgomery, AL 36104
                  <br/>Tel: 334-264-1950 
                  <br/>Fax: 334-264-1920
               </p>
               <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
         </div>
         <!-- END PAGE HEADER-->
         <? if($this->vars['max-submissions-reached']): ?>
         <div class="row-fluid">
            <div class="span12">
               <h3 class="form-section text-center">This reference form is now disable because all the necessary references have been submitted.</h3>
            </div>
         </div>

         <? else: ?>
         
         <!-- BEGIN PAGE CONTENT-->
         <div class="row-fluid">
            <div class="span12">
               <!-- BEGIN FORM-->
               <form id="saw-form" class="horizontal-form portlet">
                    <input name="doc[applicationId]" type="hidden" id="applicationId" value="<?=$this->vars['application']['_id']?>">
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  <h3 class="form-section">1. Dear Reference</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Please complete the below and submit this form within ten (10) days of receipt. The below named
individual has applied for a <b>SUSTAINING MEMBERSHIP</b> with the National College for DUI Defense, Inc. and listed you 
as a reference. The applicant has authorized an investigation into his/her background and has required that all sources having 
control of records pertaining to him/her cooperate with the National College in making such information available and has 
released any privilege pertaining to the furnishing of such information to the National College. A copy of applicants 
Authorization and Release form is at the bottom of this form. Infomation furnished will be held confidential as provided in the Rules 
Governing, <b>SUSTAINING MEMBERSHIP</b> as adopted and approved by the National College for DUI Defense, Inc.
                           </label>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">3. Reference Information</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"><strong>Name</strong></label>
                           <div class="controls">
                              <input type="text" name="doc[name]" class="m-wrap span12 name">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><strong>Email</strong></label>
                           <div class="controls">
                              <input type="text" name="doc[email]" class="m-wrap span12 email">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label"><strong>Telephone</strong></label>
                           <div class="controls">
                              <input id="phone" type="text" name="doc[phone]" class="m-wrap span12 phone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!-- BEGIN ADDRESS -->
                  <h3 class="form-section">Business Address</h3>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"><strong>Address 1</strong></label>
                           <div class="controls">
                              <input type="text" id="address1" name="doc[address1]" class="m-wrap span12 address1">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" ><strong>Address 2</strong></label>
                           <div class="controls">
                              <input type="text" id="address2" name="doc[address2]" class="m-wrap span12 address2">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" ><strong>City</strong></label>
                           <div class="controls">
                              <input type="text" id="city" name="doc[city]" class="m-wrap span12 city"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" ><strong>State / Province</strong></label>
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
                           <label class="control-label" ><strong>Postal Code</strong></label>
                           <div class="controls">
                              <input type="text" id="zip" name="doc[postalCode]" class="m-wrap span12 postalCode"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" ><strong>Country</strong></label>
                           <div class="controls">
                              <input type="text" id="country" name="doc[country]" class="m-wrap span12 country"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!-- END ADDRESS -->
                  <h3 class="form-section">5. Please select all that apply</h3>
                  <h3 class="form-section">a)</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">I am a currently-sitting judge. I am familiar with the applicant and l hereby attest to the applicant’s good character and competency in the area of DUI/DWI defense.</strong></label>
                           <div class="controls">
                              <br>
                              <select class="small m-wrap sittingJudge" name="doc[sittingJudge]">
                                  <option value="">Please Select</option>
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">b)</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">I am a licensed attorney with at least 5 years of practice with a practice devoted to at least 50% DUI/DWI defense. I am familiar with the applicant and I hereby attest to the applicant’s good character and competency in the area of DUI defense.</strong></label>
                           <div class="controls">
                              <br>
                              <select class="small m-wrap licensedAttorney" name="doc[licensedAttorney]">
                                 <option value="">Please Select</option>
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">c)</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">To the best of my knowledge, the applicant has substantial involvement in the area of DUI/DWI defense.</strong></label>
                           <div class="controls">
                              <br>
                              <select class="small m-wrap substantialInvolvement" name="doc[substantialInvolvement]">
                                 <option value="">Please Select</option>
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">d)</h3>
                  <div class="row-fluid">
                     <div class="span12">
                        <div class="control-group">
                           <label class="control-label">To the best of my knowledge, the applicant has not been the subject of any professional inquiry or discipline.</strong></label>
                           <div class="controls">
                              <br>
                              <select class="small m-wrap noProfessionalInquiry" name="doc[noProfessionalInquiry]">
                                 <option value="">Please Select</option>
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">6.  Personal Comments</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"></label>
                           <div class="controls">
                              <textarea rows="6" class="span12 personalComments" name="doc[personalComments]"></textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">7. Your Signature</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"><strong></strong></label>
                           <div class="controls">
                              <div class="input-prepend input-append">
                                 <span class="add-on">Printed Name </span>
                                 <input name="doc[executed]" class="m-wrap span12 executed" type="text" placeholder="">
                                    <? $date = new \DateTime(); $datee = $date->format('dS').' of '.$date->format('F').', 20'.$date->format('y'); ?>
                                 <input name="doc[executedDate]" class="m-wrap span12 executedDate" type="hidden" value="<?=$datee?>">
                                 <span class="add-on"> <?=$datee?></span>
                              </div>
                           </div>
                           
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  


                  <h3 class="form-section">8. Proof of Authorization and Release for <b><?=$this->vars['application']['firstName'].$middleName.' '.$this->vars['application']['lastName']?></b></h3>
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
                           Applicant does by this document give consent for the NCDD to conduct an investigation into my character and fitness to be a member, and to make inquiries and request such information from third parties as, in the sole discretion of NCDD, may be necessary for such investigation. I further authorize the use of any and all such information in the course of the NCDD’s investigation and evaluation of my application for sustaining membership and annual renewal.
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
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  
                  <div class="form-actions text-center">
                     <button type="button" class="btn green"><i class="icon-ok"></i> Submit Reference</button>
                     <button type="button" class="btn cancel-go-back">Cancel and Go Back</button>
                  </div>
               </form>
               <!-- END FORM--> 
            </div>
         </div>
         <!-- END PAGE CONTENT-->
         <? endif; ?>

   </div>
   <!-- END PAGE CONTAINER -->
</div>
<!-- END CONTAINER -->
<?=$this->element('js/Reference.js');?>
<script>
jQuery(document).ready(function() {    
   io.saw.Reference.init();
});      
</script>