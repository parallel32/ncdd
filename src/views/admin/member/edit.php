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
                                    <select class="large m-wrap boardCertified" name="doc[boardCertified]">
                                       <option value="no">No</option>
                                       <option value="yes" <?=($this->vars['member']['boardCertified'] == 1) ?'selected':'';?>>Yes - Board Certified</option>
                                       <option value="yes2" <?=(array_key_exists('boardCertifiedSr', $this->vars['member']) && $this->vars['member']['boardCertifiedSr'] == 1) ?'selected':'';?>>Yes - Board Certified Sr.</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group ">
                                 <label class="control-label">Faculty?</label>
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





                        <table class="table table-hover">
                        <thead>
                           <tr>
                              <th colspan="3"><h3>How-To Videos</h3></th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><!-- VIDEO MODAL -->
                              <?$modal='video-a';?>
                              <?$modal_title='Edit Profile Picture';?>
                              <?$modal_src='https://www.youtube.com/embed/fT9z4yegOuA?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                              <td><!-- VIDEO MODAL -->
                              <?$modal='video-b';?>
                              <?$modal_title='Crop Profile Picture';?>
                              <?$modal_src='https://www.youtube.com/embed/9XojAlmeywY?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                              <td><!-- VIDEO MODAL -->
                              <?$modal='video-c';?>
                              <?$modal_title='Update Profile Information';?>
                              <?$modal_src='https://www.youtube.com/embed/O2jOxTwfTvs?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                           </tr>
                           <tr>
                              <td><!-- VIDEO MODAL -->
                              <?$modal='video-d';?>
                              <?$modal_title='Update Office Address and Practice States';?>
                              <?$modal_src='https://www.youtube.com/embed/cxZ-hcQ-oNo?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                              <td colspan="2"><!-- VIDEO MODAL -->
                              <?$modal='video-e';?>
                              <?$modal_title='Update Lanuguages and Practice Areas';?>
                              <?$modal_src='https://www.youtube.com/embed/XVTBE2pQnpk?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                              
                           </tr>
                        </tbody>
                        </table>
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
                        <?if($this->vars['trial_member'] == 'no'): ?>
                        <h3 class="form-section text-info"><strong>Membership Information</strong></h3>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Member Status</label>
                                 <div class="controls">
                                    <img width="152" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$this->vars['member']['_id']?>/member">
                                    <? if($this->vars['member']['boardCertified']): ?>
                                       &nbsp;&nbsp;<img width="200" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$this->vars['member']['_id']?>/boardcertified">
                                    <? endif; ?>
                                    <? if(array_key_exists('boardCertifiedSr', $this->vars['member']) && $this->vars['member']['boardCertifiedSr']): ?>
                                       &nbsp;&nbsp;<img width="200" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$this->vars['member']['_id']?>/boardcertified">
                                    <? endif; ?>
                                    <? if(array_key_exists('staff',$this->vars['member']) && $this->vars['member']['staff']): ?>
                                       &nbsp;&nbsp;<img width="152" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$this->vars['member']['_id']?>/staff">
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
                                    <? if($this->vars['member']['currentFacultyPosition'] == \Saw\Model\Member::$facultyPosition['DELEGATE']):?>
                                    <img width="152" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$this->vars['member']['_id']?>/delegate">
                                    <? else: ?>
                                    <img src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$this->vars['member']['_id']?>/exec">
                                    <? endif; ?>
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
                                    <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="152" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$this->vars['member']['_id']?>/member" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
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
                                    <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="200" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$this->vars['member']['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <? endif; ?>
                        <? if(array_key_exists('boardCertifiedSr', $this->vars['member']) && $this->vars['member']['boardCertifiedSr']): ?>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Board Certified Sr Badge for your website:</label>
                                 <div class="controls">
                                    <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="200" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$this->vars['member']['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
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
                                    <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="152" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$this->vars['member']['_id']?>/staff" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <? endif; ?>
                        <? if($this->vars['member']['currentFacultyPosition'] == \Saw\Model\Member::$facultyPosition['DELEGATE']):?>
                        <div class="row-fluid">
                           <div class="span6 ">
                              <div class="control-group ">
                                 <label class="control-label">Delegate Badge for your website:</label>
                                 <div class="controls">
                                    <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="152" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$this->vars['member']['_id']?>/delegate" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <? endif; ?>
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
                                 <label class="control-label">Focus On:</label>
                                 <div class="controls">
                                    <input type="text" name="doc[specializeIn]" value="<?=$this->vars['member']['specializeIn']?>" class="m-wrap span11 specializeIn">
                                    <span class="help-block">Example:  DWI / DUI Defense</span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>

                        <h3 class="form-section text-info"><strong>About Me</strong>&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.activeEditor.focus();">Click Here To Change or Add Your Bio</a>
                        <!-- VIDEO MODAL -->
                           <?$modal='video-bio';?>
                           <?$modal_title='Editor How-To\'s';?>
                           <?$modal_src='https://www.youtube.com/embed/_eZZkPhkIME?rel=0';?>
                           <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                           <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                           <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                           <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                              <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                 <h3 id="save-modal-label"><?=$modal_title?></h3>
                              </div>
                              <div class="modal-body">
                                 <script>
                                    jQuery(document).ready(function() {    
                                       $('#embed-video').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/_eZZkPhkIME?rel=0');
                                       });
                                       $('#embed-video-link').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/f_rt_YnNjGs?rel=0');
                                       });
                                       $('#embed-website-link').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/-ZOlUA4hOlw?rel=0');
                                       });
                                       $('#embed-photo').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/NpBs85diwS4?rel=0');
                                       });
                                       $('#embed-file').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/0jIi7jF-4aM?rel=0');
                                       });
                                       $('#embed-vfl').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/bjfYaF4Dt-Q?rel=0');
                                       });

                                    });      
                                 </script>
                                 <table class="table table-hover">
                                 <tbody>
                                    <tr>
                                       <td><a id="embed-video" class="btn purple"><i class="icon-youtube-play"></i> Embed Video</a></td>
                                       <td><a id="embed-video-link" class="btn purple"><i class="icon-youtube-play"></i> Embed Video Link</a></td>
                                       <td><a id="embed-website-link" class="btn purple"><i class="icon-youtube-play"></i> Embed Website Link</a></td>
                                    </tr>
                                    <tr>
                                       <td><a id="embed-photo" class="btn purple"><i class="icon-youtube-play"></i> Embed Photo</a></td>
                                       <td><a id="embed-file" class="btn purple"><i class="icon-youtube-play"></i> Embed File</a></td>
                                       <td><a id="embed-vfl" class="btn purple"><i class="icon-youtube-play"></i> Embed Virtual Library Link</a></td>
                                    </tr>
                                 </tbody>
                                 </table>
                                 <iframe id="howto-frame" width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                              </div>
                           </div>
                           <!--/ VIDEO MODAL -->
                           </h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                           <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 50px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                           <div id="body" class="span12 editable" style="margin-left:0px;">
                              <?=(empty($this->vars['member']['aboutMe'])) ? "<br><br><br><br>" : $this->vars['member']['aboutMe'];?>
                           </div>
                           <input id="input-body" type="hidden" name="doc[aboutMe]" value="">
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

















                     <!-- PRACTICESTATES -->
                     <div class="row-fluid">
                        <div class="span12">
                           <div id="practicestate-grid" class="portlet box blue">
                              <div class="portlet-title">
                                 <div class="caption">Practice States - states you're able to practice law in</div>
                                 <div class="actions">
                                    <a class="btn green add"><i class=" icon-plus"></i> Add</a>
                                 </div>
                              </div>
                              <div class="portlet-body">
                                 <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                 <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                                    <thead>
                                       <tr role="row">
                                          <th class="">State</th>
                                          <th class=""></th>
                                       </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                       <? if(!empty($this->vars['member']['practiceStates'])): foreach($this->vars['member']['practiceStates'] as $practicestate): ?>
                                       <tr class="gradeX odd">
                                          <td id="<?=$practicestate['_id']?>" class=" "><?=$practicestate['raw']?></td>
                                          <td class=" "><a data-name="<?=$practicestate['state']?>" data-id="<?=$practicestate['_id']?>" class="btn red mini delete"></i> Delete</a></td>
                                       </tr>
                                       <? endforeach;?>
                                       <? else: ?>
                                          <td id="practicestate-norecords" colspan="5">No records.</td>
                                       <? endif;?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>


                     <!-- ADD PRACTICESTATES MODAL -->
                     <div id="add-practicestate-modal" class="modal container hide fade" tabindex="-1" role="dialog" aria-labelledby="add-practicestate-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="add-practicestate-modal-label">Add Practice State</h3>
                        </div>
                        <div class="modal-body">



                           <form id="practicestate-form" class="horizontal-form">
                              <!-- ERROR -->
                              <div class="alert alert-error hide">
                                 <button class="close" data-dismiss="alert"></button>
                                 You have some form errors. Please check below.
                              </div>
                              <!--/ ERROR -->
                              
                              <!-- BEGIN ADDRESS -->
                              <h3 class="form-section text-info"><strong>Enter the state in which you're able to practice law.</strong></h3>
                              <div class="row-fluid addr ">
                                 <div class="span6 ">
                                    <div class="control-group">
                                       <label class="control-label" >State / Province</label>
                                       <div class="controls">
                                          <input type="text" id="ps-state" name="doc[state]" class="m-wrap span12 state"> 
                                       </div>
                                    </div>
                                 </div>
                                 <!--/span-->
                              </div>
                              <!--/row-->           
                              <div class="row-fluid addr ">
                                 <div class="span6 ">
                                    <div class="control-group">
                                       <label class="control-label" >Country</label>
                                       <div class="controls">
                                          <input type="text" id="ps-country" name="doc[country]" class="m-wrap span12 country"> 
                                       </div>
                                    </div>
                                 </div>
                                 <!--/span-->
                              </div>
                              <h3 class="form-section text-info"><strong>Geocode Your State</strong></h3>
                              <p>We attempt to determine the Latitude and Longitude of your state for furture searches based on nearby a client's location</p>
                              <div class="row-fluid validateAddressPS">
                                 <div class="span12 ">
                                    <div class="control-group">
                                       <label class="control-label" >Type in the state name and then click Submit for Geocoding:</label>
                                       <div class="controls">
                                          <input type="text" id="ps-geocodeaddress" class="m-wrap span12 geocode" >
                                          <button type="button" class="btn blue geocodeaddress">Submit for Geocoding <i class="icon-globe"></i></button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <input type="hidden" id="ps-mode">
                              <input type="hidden" id="ps-_id">
                              <input type="hidden" name="doc[raw]" id="ps-raw">
                              <input type="hidden" name="doc[lat]" id="ps-lat">
                              <input type="hidden" name="doc[lon]" id="ps-lon">
                              <!-- BEGIN ADDRESS MODAL -->
                              <div id="ps-address_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="address-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="ps-address-modal-label">Select the State</h3>
                                    <p>Select the state which you intend to use.</p>
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
                                                            <th> State</th>
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
                     <!--/ ADD PRACTICESTATES MODAL -->   
                     <!--/ PRACTICESTATES -->
















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
         <?=$this->element('js/AddressPS.js');?>
         <?=$this->element('js/ClearField.js');?>

         <script>
         jQuery(document).ready(function() {    
            io.saw.Member.init();
            io.saw.Address.init('#location-form');
            io.saw.AddressPS.init('#practicestate-form');
            io.saw.ClearField.init({formArr:['#practicestate-form','#location-form','#saw-form','#website-form','#language-form','#pa-form']});
            $.extend($.inputmask.defaults, {
                'autounmask': true
            });
            $(".phone").inputmask("mask", {"mask": "(999) 999-9999"}); 
            $(".fax").inputmask("mask", {"mask": "(999) 999-9999"}); 
            $(".primaryPhone").inputmask("mask", {"mask": "(999) 999-9999"}); 
            $(".primaryFax").inputmask("mask", {"mask": "(999) 999-9999"}); 
            $(".tollFree").inputmask("mask", {"mask": "(999) 999-9999"}); 
         });      
         </script>
         <? $id = (array_key_exists('member',$this->vars)) ? $this->vars['member']['_id'] : '' ?>
         <?=$this->element('editor',array('_id'=>$id,'client_id'=>null,'access_token'=>null));?>

