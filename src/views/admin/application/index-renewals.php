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
            
            <h1>1. Renewals</h1>
            <div class="row-fluid">
                  <div class="responsive span6" data-tablet="span6" data-desktop="span3">
                     <div class="dashboard-stat red">
                        <div class="visual">
                           <i class="icon-hideme"><?=(is_array($this->vars['renewals']['unsubmitted'])) ? count($this->vars['renewals']['unsubmitted']) : 0;?></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font>
                              Unsubmitted
                           </font></font></div>
                           <div class="desc"><font><font>                           
                              
                           </font></font></div>
                        </div>
                        <a class="more" href="#unsubmitted"><font><font>
                        Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="responsive span6" data-tablet="span6" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hide-me"><span class="number"><?=(is_array($this->vars['renewals']['submitted'])) ? count($this->vars['renewals']['submitted']) : 0;?></span></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font></font>Submitted</font></div>
                           <div class="desc"><font><font></font></font></div>
                        </div>
                        <a class="more" href="#submitted"><font><font>
                        Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="responsive span6 fix-offset" data-tablet="span6  fix-offset" data-desktop="span3">
                     <div class="dashboard-stat yellow">
                        <div class="visual">
                           <i class="icon-hideme"><?=(is_array($this->vars['renewals']['approved'])) ? count($this->vars['renewals']['approved']) : 0;?></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font></font>Unpaid</font></div>
                           <div class="desc"><font><font>
                              
                           </font></font></div>
                        </div>
                        <a class="more" href="#unpaid"><font><font>
                        Click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="responsive span6" data-tablet="span6" data-desktop="span3">
                     <a name="submitted"></a>
                     <div class="dashboard-stat green">
                        <div class="visual">
                           <i class="icon-hideme"><?=(is_array($this->vars['renewals']['paid'])) ? count($this->vars['renewals']['paid']) : 0;?></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font>Paid</font></font></div>
                           <div class="desc"><font><font>
                              
                           </font></font></div>
                        </div>
                        <a class="more" href="#paid"><font><font>
                        click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div><a name="submitted"></a>
                  </div>
                  
               </div>
            
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications Submitted</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['renewals']['submitted'])): foreach($this->vars['renewals']['submitted'] as $member): ?>
                              <tr class="gradeX odd ">
                                 <td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['submittedDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['submittedDate']['monthDay'].' '.$member['renewal']['submittedDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="unpaid"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box yellow">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications Approved and Unpaid</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-phone">Pay By</th>
                                 <th class="hidden-480">Date Approved</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['renewals']['approved'])): foreach($this->vars['renewals']['approved'] as $member): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <td class="hidden-phone"><?=($member['renewal']['payByCheck'] == 'yes') ? 'Chk': 'CC' ?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['approvedDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['approvedDate']['monthDay'].' '.$member['renewal']['approvedDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="paid"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid" id="paid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box green">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications Paid</div>
                        <div class="actions">
                           <a class="btn yellow view"><i class=" icon-eye-open"></i> View All</a>
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date Paid</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['renewals']['paid'])): foreach($this->vars['renewals']['paid'] as $member): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['paidDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['paidDate']['monthDay'].' '.$member['renewal']['paidDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['paymentId']?>" class="btn blue mini view payment"><i class=" "></i> Payment</a>
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="unsubmitted"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box red">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications Unsubmitted</div>
                     </div>
                     <div id="applications-to-approve" class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['renewals']['unsubmitted'])): foreach($this->vars['renewals']['unsubmitted'] as $member): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <td class=" "><!--<a data-id="<?=$member['_id']?>" class="btn blue mini view"><i class=" "></i> View</a>--></td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">Nothing to approve.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>




























            
            <h1 id="2updates">2. Updates</h1>
            <div class="row-fluid">
                  <div class="responsive span6" data-tablet="span6" data-desktop="span3">
                     <div class="dashboard-stat red">
                        <div class="visual">
                           <i class="icon-hideme"><?=(is_array($this->vars['updates']['unsubmitted'])) ? count($this->vars['updates']['unsubmitted']) : 0;?></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font>
                              Unsubmitted
                           </font></font></div>
                           <div class="desc"><font><font>                           
                              
                           </font></font></div>
                        </div>
                        <a class="more" href="#updates-unsubmitted"><font><font>
                        Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="responsive span6" data-tablet="span6" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hide-me"><span class="number"><?=(is_array($this->vars['updates']['submitted'])) ? count($this->vars['updates']['submitted']) : 0;?></span></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font></font>Submitted</font></div>
                           <div class="desc"><font><font></font></font></div>
                        </div>
                        <a class="more" href="#updates-submitted"><font><font>
                        Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="responsive span6 fix-offset" data-tablet="span6  fix-offset" data-desktop="span3">
                     <div class="dashboard-stat yellow">
                        <div class="visual">
                           <i class="icon-hideme"><?=(is_array($this->vars['updates']['approved'])) ? count($this->vars['updates']['approved']) : 0;?></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font></font>Approved</font></div>
                           <div class="desc"><font><font>
                              
                           </font></font></div>
                        </div>
                        <a class="more" href="#updates-approved"><font><font>
                        Click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div><a name="updates-submitted"></a>
               </div>
            

            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications Submitted</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['updates']['submitted'])): foreach($this->vars['updates']['submitted'] as $member): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['submittedDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['submittedDate']['monthDay'].' '.$member['renewal']['submittedDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="updates-approved"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box yellow">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications Approved</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date Approved</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['updates']['approved'])): foreach($this->vars['updates']['approved'] as $member): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['approvedDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['approvedDate']['monthDay'].' '.$member['renewal']['approvedDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="updates-unsubmitted"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box red">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications Unsubmitted</div>
                     </div>
                     <div id="applications-to-approve" class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['updates']['unsubmitted'])): foreach($this->vars['updates']['unsubmitted'] as $member): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <td class=" "><!--<a data-id="<?=$member['_id']?>" class="btn blue mini view"><i class=" "></i> View</a>--></td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">Nothing to show.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>
            

            <a name="3donations"></a>
            <h1>3. Donations</h1>
            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span3">
                     <a name="approve"></a>
                     <div class="dashboard-stat green">
                        <div class="visual">
                           <i class="icon-hideme"><?=(is_array($this->vars['donations'])) ? count($this->vars['donations']) : 0;?></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font>Donations</font></font></div>
                           <div class="desc"><font><font>
                              
                           </font></font></div>
                        </div>
                        <a class="more" href="#donations"><font><font>
                        click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
            </div><a name="submitted"></a>
            
            <div class="row-fluid" id="paid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box green">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications with Donations</div>
                        <div class="actions">
                           <a class="btn yellow view"><i class=" icon-eye-open"></i> View All</a>
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date </th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['donations'])): foreach($this->vars['donations'] as $member): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['submittedDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['submittedDate']['monthDay'].' '.$member['renewal']['submittedDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['contributionPaymentId']?>" class="btn blue mini view payment"><i class=" "></i> Payment</a>
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            </br>            
            <div class="row-fluid">
               <h1>4. Manage Renewal Activation</h1>
               <a id="activate-renewals" class="btn green "><i class=" "></i> Activate Renewals</a>
               <a id="clear-renewals" class="btn yellow "><i class=" "></i> Clear Renewals</a>
            </div>
            <div class="row-fluid">
               <div class="span12 alert alert-info">
                  <p>Note: Use these buttons to batch activate or clear all active members.</p>
                  <p>You should only use the Activate Renewals button in November.</p>
                  <p>You should only use the Clear Renewals button just before November to clear this screen for the new renewals.</p>
               </div>
            </div>
            <!-- MODAL -->
            <div id="activate-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="activate-modal-label" aria-hidden="true">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h3 id="activate-modal-label">Activate Renewals?</h3>
               </div>
               <div class="modal-body">
                  <p>Are you sure you want to activate renewals for all General, Sustaining, and Founding Members, who are active?</p>
               </div>
               <div class="modal-footer">
                  <button class="btn green continue">Yes, Activate Renewals</button>
                  <button class="btn cancel">Cancel</button>
               </div>
            </div>
            <!--/ MODAL -->
            <!-- MODAL -->
            <div id="clear-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="clear-modal-label" aria-hidden="true">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h3 id="clear-modal-label">Clear Renewals?</h3>
               </div>
               <div class="modal-body">
                  <p>Are you sure you want to clear renewals and prepare for another year?</p>
               </div>
               <div class="modal-footer">
                  <button class="btn yellow continue">Yes, Clear Renewals</button>
                  <button class="btn cancel">Cancel</button>
               </div>
            </div>
            <!--/ MODAL -->
            <!-- MODAL -->
            <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h3 id="save-success-label"></h3>
               </div>
               <div class="modal-body">
                  <p></p>
               </div>
               <div class="modal-footer">
                  <button class="btn blue continue">Continue</button>
               </div>
            </div>
            <!--/ MODAL -->
            <script>
            jQuery(document).ready(function() {    
               io.saw.Application.init();

               $('#save-success .continue').click(function(e){
                  e.preventDefault();
                  document.location.href = '/renewals';
               });
               $('#activate-renewals').click(function(e){
                  e.preventDefault();
                  $('#activate-modal').modal({keyboard: false});
               });
               $('#activate-modal .cancel').click(function(e){
                  e.preventDefault();
                  $('#activate-modal').modal('hide');
               });
               $('#activate-modal .continue').click(function(e){
                  e.preventDefault();
                  io.saw.FormGet.activate({postUrl:'/applications/activate/renewals/yes'
                     ,postOnComplete:function(responseObj,responseStatus){
                        $('#activate-modal').modal('hide');
                     }
                     ,postOnSuccess:function(responseObj){
                        $('#save-success .modal-body p').html(responseObj.message);
                        $('#save-success-label').html(responseObj.label);
                        $('#save-success').modal({keyboard: false});       
                     }
                     ,postOnErrors:function(responseObj){
                        var responseObj = $.parseJSON(responseObj.responseText);
                        $('#save-success .modal-body p').html(responseObj.message);
                        $('#save-success').modal({keyboard: false});       
                     }
                  });   
               });
               

               $('#clear-renewals').click(function(e){
                  e.preventDefault();
                  $('#clear-modal').modal({keyboard: false});
               });
               $('#clear-modal .cancel').click(function(e){
                  e.preventDefault();
                  $('#clear-modal').modal('hide');
               });
               $('#clear-modal .continue').click(function(e){
                  e.preventDefault();
                  io.saw.FormGet.activate({postUrl:'/applications/activate/renewals/clear'
                     ,postOnComplete:function(responseObj,responseStatus){
                        $('#clear-modal').modal('hide');
                     }
                     ,postOnSuccess:function(responseObj){
                        $('#save-success .modal-body p').html(responseObj.message);
                        $('#save-success-label').html(responseObj.label);
                        $('#save-success').modal({keyboard: false});       
                     }
                     ,postOnErrors:function(responseObj){
                        var responseObj = $.parseJSON(responseObj.responseText);
                        $('#save-success .modal-body p').html(responseObj.message);
                        $('#save-success').modal({keyboard: false});       
                     }
                  });   
               });
            
            });      
            </script>









         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<?=$this->element('js/Application.js');?>
<script>
jQuery(document).ready(function() {    
   io.saw.Application.init();

   $('#paid .yellow.view').click(function(e){
      e.preventDefault();
      document.location.href='/applications/all';
   });

});      
</script>