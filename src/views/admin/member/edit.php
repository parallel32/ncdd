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
                     <form id="saw-form" class="horizontal-form portlet">
                        <input type="hidden" name="doc[_id]" value="<?=$this->vars['member']['_id']?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <? $accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app); 
                        if($accessLevel == ADMIN): ?>

                        <h3 class="form-section text-info"><strong>Administration Section (ADMIN ONLY)</strong></h3>
                        <p>This section is not accessible to members.</p>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Bar Association Number</label>
                                 <div class="controls">
                                    <input type="text" name="doc[barNumber]" value="<?=$this->vars['member']['barNumber']?>" class="m-wrap span10 barNumber">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">List Serv Email</label>
                                 <div class="controls">
                                    <input type="text" name="doc[listServEmail]" value="<?=$this->vars['member']['listServEmail']?>" class="m-wrap span10 listServEmail">
                                    <span class="help-block">This does not interact with the Yahoo Groups.  This is just a record of the email they wish to use.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Active?</label>
                                 <div class="controls">
                                    <select class="small m-wrap status" name="doc[status]">
                                       <option value="no">No</option>
                                       <option value="yes" <?=($this->vars['member']['status'] == USER_STATUS_ACTIVE) ?'selected':'';?>>Yes</option>
                                    </select>
                                    <span class="help-block">Setting this to "No" will revoke login privileges to the Member Portal</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Listed?</label>
                                 <div class="controls">
                                    <select class="small m-wrap listed" name="doc[listed]">
                                       <option value="no">No</option>
                                       <option value="yes" <?=($this->vars['member']['listed'] == 1) ?'selected':'';?>>Yes</option>
                                    </select>
                                    <span class="help-block">Setting this to "No" will hide this member from the public list of members including all search results</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Executive Position</label>
                                 <div class="controls">
                                    <select class="large m-wrap currentFacultyPosition" name="doc[currentFacultyPosition]">
                                       <option value="0">No Position</option>
                                       <? foreach($this->vars['member']['facultyPositionReversed'] as $key=>$val): ?>
                                       <option value="<?=$key?>" <?=($this->vars['member']['currentFacultyPosition'] == $key) ?'selected':'';?>><?=$val?></option>
                                       <? endforeach; ?>
                                    </select>
                                    <span class="help-block">If this member does not hold a position then leave this field selected to "No Position"</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Membership Status</label>
                                 <div class="controls">
                                    <select class="large m-wrap currentMembership" name="doc[currentMembership]">
                                       <? foreach($this->vars['member']['membershipReversed'] as $key=>$val): ?>
                                       <option value="<?=$key?>" <?=($this->vars['member']['currentMembership'] == $key) ?'selected':'';?>><?=$val?></option>
                                       <? endforeach; ?>
                                    </select>
                                    <span class="help-block">If this member does not hold a position then leave this field selected to "No Position"</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Board Certified?</label>
                                 <div class="controls">
                                    <select class="small m-wrap boardCertified" name="doc[boardCertified]">
                                       <option value="no">No</option>
                                       <option value="yes" <?=($this->vars['member']['boardCertified'] == 1) ?'selected':'';?>>Yes</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group ">
                                 <label class="control-label">Faculty/Staff?</label>
                                 <div class="controls">
                                    <select class="small m-wrap staff" name="doc[staff]">
                                       <option value="no">No</option>
                                       <option value="yes" <?=(array_key_exists('staff',$this->vars['member'])) ? ($this->vars['member']['staff'] == 1) ?'selected':'': '';?>>Yes</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Listing Order</label>
                                 <div class="controls">
                                    <select class="large m-wrap" readonly="">
                                       <? foreach($this->vars['member']['orderReversed'] as $key=>$val): ?>
                                       <option value="<?=$key?>" <?=($this->vars['member']['currentOrder'] == $key) ?'selected':'';?>><?=$val?></option>
                                       <? endforeach; ?>
                                    </select>
                                    <span class="help-block">This is the current position in which this member appears in the "Find an Attorney" search results</span>
                                    <span class="help-block">This field is driven by Executive Position and Membership Status and cannot be changed on its own.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Join Date</label>
                                 <div class="controls">
                                    <input type="text" name="doc[joinDate]" value="<?=$this->vars['member']['joinDate']['detail']?>" class="m-wrap span10 joinDate">
                                    <span class="help-block">This date affects the listing order.  Members are ordered by the date they joined within each level of ordering.  For example: all members grouped as founding members will then be ordered by the date they joined.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Change Access Level To</label>
                                 <div class="controls">
                                    <select class="large m-wrap status" name="doc[changeAccessLevelTo]">
                                       <option value="<?=MEMBER?>" <?=(array_key_exists('changeAccessLevelTo',$this->vars['member'])) ? ($this->vars['member']['changeAccessLevelTo'] == MEMBER) ?'selected':'': '';?>>MEMBER</option>
                                       <option value="<?=UNPAIDMEMBER?>" <?=(array_key_exists('changeAccessLevelTo',$this->vars['member'])) ? ($this->vars['member']['changeAccessLevelTo'] == UNPAIDMEMBER) ?'selected':'': '';?>>UNPAID MEMBER</option>                                       
                                    </select>
                                    <span class="help-block">The purpose of this field is to change the access level of a member.  For example, if you want to reduce their access privileges because of non-payment you can change their Access Level to UNPAID MEMBER.  Then, after payment is received, you can change it back to MEMBER.</span>
                                    <div class="alert">
                                       <strong>Notice!</strong> the current accessLevel is: <strong><?=$this->app['humanizeAccessLevels']($this->vars['member']['accessLevel'])?></strong>.  Their accessLevel will not change to the above value until the next time they log in.
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Renewal Process</label>
                                 <div class="controls">
                                    <? 
                                    if(array_key_exists('renewal',$this->vars['member']) && !empty($this->vars['member']['renewal'])){ 
                                       $active = true;
                                    }else{
                                       $active = false;
                                    }
                                    ?>
                                    <select class="large m-wrap status" name="doc[renewalStatus]">
                                       <option value="<?=($active) ? 'ACTIVE' : 'ACTIVATE'?>" <?=($active) ? 'selected' :'' ?>><?=($active) ? 'ACTIVE' : 'ACTIVATE RENEWAL' ?></option>
                                       <option value="<?=(!$active) ? 'INACTIVE' : 'DEACTIVATE'?>" <?=(!$active) ? 'selected':'' ?>><?=(!$active) ? 'INACTIVE' : 'DEACTIVATE RENEWAL' ?></option>
                                    </select>
                                    <span class="help-block">The purpose of this field is to manually activate / deactivate this member's renewal application workflow.</span>
                                    <div class="alert">
                                       <strong>Notice!</strong> 
                                       <br>The renewal process is: <strong><?=($active) ?'ACTIVE' : 'INACTIVE';?></strong>.  
                                       <br>The current status is: <strong><?=($active) ? \Saw\Model\Renewal::$statusReversed[$this->vars['member']['renewal']['currentStatus']] : 'INACTIVE';?></strong>.  
                                       <br>The current renewal year: <strong><?=($active) ? $this->vars['member']['renewal']['year'] : '';?></strong>.  
                                    </div>
                                    <? 
                                       if($active){ 
                                          switch ($this->vars['member']['currentMembership']) {
                                             case \Saw\Model\Member::$membership['GENERAL MEMBER']:
                                                $apptype = 'update-member';
                                                break;
                                             case \Saw\Model\Member::$membership['SUSTAINING MEMBER']:
                                                $apptype = 'update-sustaining-member';
                                                break;
                                             case \Saw\Model\Member::$membership['FOUNDING MEMBER']:
                                                $apptype = 'update-founding-member';
                                                break;                        
                                             default:
                                                $apptype = 'update-member';
                                                break;
                                          }

                                    ?>

                                    <div>
                                       <a href="/application/<?=$apptype?>/<?=$this->vars['member']['_id']?>" class="btn yellow"> GoTo Application</a>
                                    </div>
                                    <? } ?>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="form-actions text-center">
                           <button type="button" class="btn green save"><i class="icon-ok"></i> Save</button>
                           <button type="button" class="btn cancel">Cancel</button>
                        </div>
                        <? endif; ?>

                        <h3 class="form-section text-info"><strong>Profile Photo</strong></h3>
                        <div class="row-fluid">
                           <div class="span4 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <img id="image" src="<?=$this->vars['image']?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <button type="button" data-id="<?=$this->vars['member']['_id']?>" class="btn blue edit-photo">Edit My Photo</button>
                                    <a target="_blank" class="btn green" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>">View My Profile</a>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>

                        <h3 class="form-section text-info"><strong>Authentication Information</strong></h3>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Email</label>
                                 <div class="controls">
                                    <input type="text" name="doc[email]" value="<?=$this->vars['member']['email']?>" class="m-wrap span10 email">
                                    <span class="help-block">Changing this also changes your Username for logging in.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Password</label>
                                 <div class="controls">
                                    <input type="text" name="doc[password]" class="m-wrap span10 password">
                                    <span class="help-block">To reset your password simply add a new one here. The old one will be overwritten.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>

                        <h3 class="form-section text-info"><strong>Membership Information</strong></h3>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Member Status</label>
                                 <div class="controls">
                                    <img width="152" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/member">
                                    <? if($this->vars['member']['boardCertified']): ?>
                                       &nbsp;&nbsp;<img width="200" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/boardcertified">
                                    <? endif; ?>
                                    <? if(array_key_exists('staff',$this->vars['member']) && $this->vars['member']['staff']): ?>
                                       &nbsp;&nbsp;<img width="152" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/staff">
                                    <? endif; ?>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <? if($this->vars['member']['currentFacultyPosition'] > 0): ?>
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Executive Status</label>
                                 <div class="controls">
                                    <img src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/exec">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <? endif; ?>
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Membership Badge for your website:</label>
                                 <div class="controls">
                                    <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="152" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/member" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <? if($this->vars['member']['boardCertified']): ?>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Board Certified Badge for your website:</label>
                                 <div class="controls">
                                    <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="200" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <? endif; ?>
                        <? if(array_key_exists('staff',$this->vars['member']) && $this->vars['member']['staff']): ?>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Faculty Badge for your website:</label>
                                 <div class="controls">
                                    <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="152" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/staff" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <? endif; ?>
                        
                        <h3 class="form-section text-info"><strong>General Information</strong></h3>
                        <div class="row-fluid">
                           <div class="span4 ">
                              <div class="control-group ">
                                 <label class="control-label">First Name</label>
                                 <div class="controls">
                                    <input type="text" name="doc[firstName]" value="<?=$this->vars['member']['firstName']?>" class="m-wrap span10 firstName">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span4 ">
                              <div class="control-group ">
                                 <label class="control-label">Middle Initial</label>
                                 <div class="controls">
                                    <input type="text" name="doc[middleName]" value="<?=(array_key_exists('middleName',$this->vars['member'])) ? $this->vars['member']['middleName']: '';?>" class="m-wrap span10 middleName">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span4 ">
                              <div class="control-group ">
                                 <label class="control-label">Last Name</label>
                                 <div class="controls">
                                    <input type="text" name="doc[lastName]" value="<?=$this->vars['member']['lastName']?>" class="m-wrap span10 lastName">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Primary Phone</label>
                                 <div class="controls">
                                    <input type="text" name="doc[primaryPhone]" value="<?=$this->vars['member']['primaryPhone']?>" class="m-wrap span10 primaryPhone">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Primary Fax</label>
                                 <div class="controls">
                                    <input type="text" name="doc[primaryFax]" value="<?=$this->vars['member']['primaryFax']?>" class="m-wrap span10 primaryFax">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label">Specialize In:</label>
                                 <div class="controls">
                                    <input type="text" name="doc[specializeIn]" value="<?=$this->vars['member']['specializeIn']?>" class="m-wrap span11 specializeIn">
                                    <span class="help-block">Example:  DWI / DUI Defense</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>About Me</strong></h3>&nbsp;<button type="button" class="btn blue show-editor">Click Here To Change or Add Your Bio</button><br><br>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <div class="controls">
                                    <span id="aboutMe" class="help-block "><?=(empty($this->vars['member']['aboutMe'])) ? "<br><br><br><br>" : $this->vars['member']['aboutMe'];?></span>
                                    <input id="input-aboutMe" type="hidden" name="doc[aboutMe]" value="">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        <h3 class="form-section text-info"><strong>Financial Information</strong></h3>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Fees</label>
                                 <div class="controls">
                                    <input type="text" name="doc[financialFees]" value="<?=$this->vars['member']['financialFees']?>" class="m-wrap span10 financialFees">
                                    <span class="help-block">Example: Free Consultation</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Payments Accepted</label>
                                 <div class="controls">
                                    <input type="text" name="doc[financialPayment]" value="<?=$this->vars['member']['financialPayment']?>" class="m-wrap span10 financialPayment">
                                    <span class="help-block">Example: Cash, Check, All major credit cards, and we offer a payment schedule.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info "><strong>Social Network Links</strong></h3>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Facebook</label>
                                 <div class="controls">
                                    <input type="text" name="doc[facebookUrl]" value="<?=$this->vars['member']['facebookUrl']?>" class="m-wrap span10 facebookUrl">
                                    <span class="help-block">Will not appear if left blank</span>
                                    <span class="help-block">Use the full url: e.g. https://domain.com/name/uniqueid .. etc.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Twitter</label>
                                 <div class="controls">
                                    <input type="text" name="doc[twitterUrl]" value="<?=$this->vars['member']['twitterUrl']?>" class="m-wrap span10 twitterUrl">
                                    <span class="help-block">Will not appear if left blank</span>
                                    <span class="help-block">Use the full url: e.g. https://domain.com/name/uniqueid .. etc.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Google Plus</label>
                                 <div class="controls">
                                    <input type="text" name="doc[googlePlusUrl]" value="<?=$this->vars['member']['googlePlusUrl']?>" class="m-wrap span10 googlePlusUrl">
                                    <span class="help-block">Will not appear if left blank</span>
                                    <span class="help-block">Use the full url: e.g. https://domain.com/name/uniqueid .. etc.</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">LinkedIn</label>
                                 <div class="controls">
                                    <input type="text" name="doc[linkedInUrl]" value="<?=$this->vars['member']['linkedInUrl']?>" class="m-wrap span10 linkedInUrl">
                                    <span class="help-block">Will not appear if left blank</span>
                                    <span class="help-block">Use the full url: e.g. https://domain.com/name/uniqueid .. etc.</span>
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
                        <div class="form-actions text-center">
                           <button type="button" class="btn green save"><i class="icon-ok"></i> Save</button>
                           <button type="button" class="btn cancel">Cancel</button>
                        </div>
                     </form>
                     <!-- SUCCESSFUL SAVE MODAL -->
                     <div id="save-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="save-modal-label">Successful Operation.</h3>
                        </div>
                        <div class="modal-body">
                           <p></p>
                        </div>
                        <div class="modal-footer">
                           <button class="btn blue continue edit">Continue Editing</button>
                           <button class="btn continue dashboard">Go To Dashboard</button>
                        </div>
                     </div>
                     <!--/ SUCCESSFUL SAVE MODAL -->

                     <h3 class="form-section text-info"><strong>Additional Information</strong></h3>
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
                                          <th class=""></th>
                                       </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                       <? if(!empty($this->vars['member']['locations'])): foreach($this->vars['member']['locations'] as $location): ?>
                                       <tr class="gradeX odd">
                                          <td id="<?=$location['_id']?>" class=" "><?=$location['raw']?></td>
                                          <td class=" "><a id="edit-<?=$location['_id']?>" 
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
                                             data-zip="<?=$location['zip']?>" 
                                             data-country="<?=$location['country']?>" 
                                             data-raw="<?=$location['raw']?>"
                                             data-mode="save" 
                                             class="btn blue mini edit"></i> Edit</a> <a data-id="<?=$location['_id']?>" class="btn red mini delete"></i> Delete</a></td>
                                       </tr>
                                       <? endforeach;?>
                                       <? else: ?>
                                          <td id="location-norecords" colspan="5">No records.</td>
                                       <? endif;?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>


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
                                          <input type="text" id="geocodeaddress" class="m-wrap span12" >
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
                           <button type="button" class="btn cancel">Cancel</button>
                        </div>
                     </div>
                     <!--/ ADD LOCATION MODAL -->   
                     <!--/ LOCATION -->











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
                           <button type="button" class="btn cancel">Cancel</button>
                        </div>
                     </div>
                     <!--/ ADD WEBSITE MODAL -->   
                     <!--/ WEBSITE -->




                     <!-- LANGUAGE -->
                     <div class="row-fluid">
                        <div class="span12">
                           <div id="language-grid" class="portlet box blue">
                              <div class="portlet-title">
                                 <div class="caption">Languages</div>
                                 <div class="actions">
                                    <a class="btn green add"><i class=" icon-plus"></i> Add</a>
                                 </div>
                              </div>
                              <div class="portlet-body">
                                 <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                 <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                                    <thead>
                                       <tr role="row">
                                          <th class="">Language</th>
                                          <th class=""></th>
                                       </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                       <? if(!empty($this->vars['member']['languages'])): foreach($this->vars['member']['languages'] as $language): ?>
                                       <tr class="gradeX odd">
                                          <td class=" "><?=$language['language']?></td>
                                          <td class=" "><a data-name="<?=$language['language']?>" data-id="<?=$this->vars['member']['_id']?>" class="btn red mini delete"></i> Delete</a></td>
                                       </tr>
                                       <? endforeach;?>
                                       <? else: ?>
                                          <td id="language-norecords" colspan="5">No records.</td>
                                       <? endif;?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>


                     <!-- ADD LANGUAGE MODAL -->
                     <div id="add-language-modal" class="modal container hide fade" tabindex="-1" role="dialog" aria-labelledby="add-language-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="add-language-modal-label">Add Language</h3>
                        </div>
                        <div class="modal-body">



                           <form id="language-form" class="horizontal-form">
                              <!-- ERROR -->
                              <div class="alert alert-error hide">
                                 <button class="close" data-dismiss="alert"></button>
                                 You have some form errors. Please check below.
                              </div>
                              <!--/ ERROR -->
                              
                              <!-- BEGIN LANGUAGE -->
                              <div class="row-fluid">
                                 <div class="span12 ">
                                    <div class="control-group">
                                       <label class="control-label" >Language</label>
                                       <div class="controls">
                                          <input type="text" name="doc[language]" class="m-wrap span12 language">
                                          <span class="help-block">Example: Spanish</span>
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
                           <button type="button" class="btn cancel">Cancel</button>
                        </div>
                     </div>
                     <!--/ ADD LANGUAGE MODAL -->   
                     <!--/ LANGUAGE -->





                     <!-- PRACTICE AREA -->
                     <div class="row-fluid">
                        <div class="span12">
                           <div id="pa-grid" class="portlet box blue">
                              <div class="portlet-title">
                                 <div class="caption">Practice Areas</div>
                                 <div class="actions">
                                    <a class="btn green add"><i class=" icon-plus"></i> Add</a>
                                 </div>
                              </div>
                              <div class="portlet-body">
                                 <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                 <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                                    <thead>
                                       <tr role="row">
                                          <th class="">Practice Area</th>
                                          <th class="">Percentage</th>
                                          <th class=""></th>
                                       </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                       <? if(!empty($this->vars['member']['practiceAreas'])): foreach($this->vars['member']['practiceAreas'] as $pa): ?>
                                       <tr class="gradeX odd">
                                          <td class=" "><?=$pa['pa']?></td>
                                          <td class=" "><?=$pa['percent']?></td>
                                          <td class=" "><a data-name="<?=$pa['pa']?>" data-id="<?=$this->vars['member']['_id']?>" class="btn red mini delete"></i> Delete</a></td>
                                       </tr>
                                       <? endforeach;?>
                                       <? else: ?>
                                          <td id="pa-norecords" colspan="5">No records.</td>
                                       <? endif;?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>


                     <!-- ADD PRACTICE AREA MODAL -->
                     <div id="add-pa-modal" class="modal container hide fade" tabindex="-1" role="dialog" aria-labelledby="add-pa-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="add-pa-modal-label">Add Practice Area</h3>
                        </div>
                        <div class="modal-body">



                           <form id="pa-form" class="horizontal-form">
                              <!-- ERROR -->
                              <div class="alert alert-error hide">
                                 <button class="close" data-dismiss="alert"></button>
                                 You have some form errors. Please check below.
                              </div>
                              <!--/ ERROR -->
                              
                              <!-- BEGIN PRACTICE AREA -->
                              <div class="row-fluid">
                                 <div class="span12 ">
                                    <div class="control-group">
                                       <label class="control-label" >Practice Area</label>
                                       <div class="controls">
                                          <input type="text" name="doc[pa]" class="m-wrap span12 pa">
                                          <span class="help-block">Example: DUI</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>                              
                              <div class="row-fluid">
                                 <div class="span12 ">
                                    <div class="control-group">
                                       <label class="control-label" >Percent</label>
                                       <div class="controls">
                                          <input type="text" name="doc[percent]" class="m-wrap span12 percent">
                                          <span class="help-block">Example: 80</span>
                                          <span class="help-block">Please only add a number and no % sign.</span>
                                          <span class="help-block">All your practice areas should total to 100.  Otherwise the pie chart on your profile will be hidden.</span>
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
                           <button type="button" class="btn cancel">Cancel</button>
                        </div>
                     </div>
                     <!--/ ADD PRACTICE AREA MODAL -->   
                     <!--/ PRACTICE AREA -->
                     <? if($accessLevel == ADMIN): ?>
                     <!-- DELETE MODAL -->
                     <div id="delete-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="delete-modal-label">Are you sure you want to delete this member?</h3>
                        </div>
                        <div class="modal-body">
                           <p>This action cannot be undone.  You will delete all records in the database related to this member.</p>
                        </div>
                        <div class="modal-footer">
                           <button class="btn red continue delete">Yes, I'm sure.  Delete.</button>
                           <button class="btn cancel">Cancel</button>
                        </div>
                     </div>
                     <!--/ DELETE MODAL -->

                     <div class="row-fluid">
                        <div class="span12">
                           <button id="verify-delete" class="btn red big btn-block"><i class="icon-remove icon-white"></i>&nbsp;&nbsp;Delete This Member&nbsp;&nbsp;<i class="icon-remove icon-white"></i></button>
                        </div>
                     </div>
                     <? endif; ?>
                     
                  </div>
               </div>
               <!-- END PAGE CONTENT-->
            </div>
            <!-- END PAGE CONTAINER-->    
         </div>
         <!-- END PAGE -->
         <?=$this->element('js/Member.js',array('accessLevel'=>$accessLevel));?>
         <?=$this->element('js/Address.js');?>
         <?=$this->element('js/ClearField.js');?>

         <script>
         jQuery(document).ready(function() {    
            io.saw.Member.init();
            io.saw.Address.init('#location-form');
            io.saw.ClearField.init({formArr:['#location-form','#saw-form','#website-form','#language-form','#pa-form']});

            window.editor = new SnapEditor.InPlace("aboutMe", {
                path: "/assets/snapeditor",
                toolbar: {
                  items: [
                   "styleBlock", "|",
                   "bold", "italic", "underline", "|",
                   "alignLeft", "alignCentre", "alignRight", "alignJustify", "|",
                   "orderedList", "unorderedList", "indent", "outdent", "|",
                   "link", "table", "horizontalRule", "|"
                 ],
                }
                ,snap: false
                /*
                ,onSave: function (e) {
                   var isSuccess = true;
                   html = e.html;
                   io.saw.Member.save();
                   return isSuccess || "Error";
                }
                ,onUnsavedChanges: function (e) {
                     e.api.execAction("save");
                 }
                 */
             });
            
            $('.show-editor').click(function(e){
               window.editor.api.activate();
            })
         });      
         </script>

