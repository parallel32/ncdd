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
            
            <div class="alert alert-info">
               <strong>New Member App -</strong> <a href="https://<?=SAW_ADMIN_WEBSITE?>/application/new-member">https://<?=SAW_ADMIN_WEBSITE?>/application/new-member</a>
            </div>
            <div class="alert alert-info">
               <strong>New Sustaining Member App -</strong> <a href="https://<?=SAW_ADMIN_WEBSITE?>/application/new-sustaining-member">https://<?=SAW_ADMIN_WEBSITE?>/application/new-sustaining-member</a>
            </div>
            
            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat yellow">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['approved'])) ? count($this->vars['approved']): 0;?></i>
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
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <a name="approve"></a>
                  <div class="dashboard-stat green">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['paid'])) ? count($this->vars['paid']): 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Paid YTD</font></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#paid90"><font><font>
                     Click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               
            </div>
            
            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat purple">
                     <div class="visual">
                        <i class="icon-hide-me"><span class="number"><?=count($this->vars['trial']);?></span></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>Trial Mode</font></div>
                        <div class="desc"><font><font></font></font></div>
                     </div>
                     <a class="more" href="#trial"><font><font>
                     Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat purple">
                     <div class="visual">
                        <i class="icon-hide-me"><span class="number"><?=(!empty($this->vars['allentrapptrialpromocode'])) ? count($this->vars['allentrapptrialpromocode']) : 0;?></span></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>Allen Trapp</font></div>
                        <div class="desc"><font><font></font></font></div>
                     </div>
                     <a class="more" href="#trial"><font><font>
                     Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
            </div>

            <div class="row-fluid">
            
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat blue">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['eagle2016promocode'])) ? count($this->vars['eagle2016promocode']): 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>EAGLE2016 Promo</font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#eagle2016"><font><font>
                     Click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>               

            </div>
            

            <? 
               if(array_key_exists('promos', $this->vars) && is_array($this->vars['promos']) && !empty($this->vars['promos'])):
                  $i=0;
                  foreach($this->vars['promos'] as $code => $promo):
                     if ($i & 1) {
            ?>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat red">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['promos'][$code])) ? count($this->vars['promos'][$code]): 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font><?=$code?></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#<?=$code?>"><font><font>
                     Click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>               
            <?
                     } else {
            ?>
            <?
               if(count($this->vars['promos']) < 2 && $i==0){
                  echo '<div class="row-fluid">';
               }
            ?>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat red">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['promos'][$code])) ? count($this->vars['promos'][$code]): 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font><?=$code?></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#<?=$code?>"><font><font>
                     Click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>               
            </div>
            <? 
                  }
                  $i++;
                  endforeach;
               endif;
            ?>
            
            


            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box purple">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications in Trial Mode</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Status</th>
                                 <th class="hidden-480">Starts</th>
                                 <th class="hidden-480">Ends</th>
                                 <th class="hidden-480">Promo</th>
                                 <th class="hidden-480">Application Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['trial'])): foreach($this->vars['trial'] as $application): ?>
                              <tr class="gradeX odd <?=(array_key_exists('currentStatus',$application['trial'])) ? ( \Saw\Model\Trial::$status['ACTIVE'] == $application['trial']['currentStatus']) ? 'success' :'error' : 'warning';?>">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <? $declineCount = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('declineCount',$application['member']['payment']) && $application['member']['payment']['declineCount'] > 0) ? '('.$application['member']['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('renewalREUSE',$application['member']['payment']) && $application['member']['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && !empty($application['member']['payment']['number']) && !empty($application['member']['payment']['cvc'])) ? '<a data-id="'.$application['member']['_id'].'" class="btn '.$renewalREUSE.' mini card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>

                                 <td class="hidden-phone"><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=(array_key_exists('currentStatus',$application['trial'])) ? \Saw\Model\Trial::$statusReversed[$application['trial']['currentStatus']]: 'no status set';?></td>

                                 <?
                                    // humanize dates
                                    $start = \Carbon\Carbon::createFromTimeStamp(strtotime($application['trial']['startDate']['fullDateTime']), $application['trial']['timeZone']);
                                    $end = \Carbon\Carbon::createFromTimeStamp(strtotime($application['trial']['endDate']['fullMonth']), $application['trial']['timeZone']);
                                 ?>

                                 <td class="hidden-480 "><b><?=$start->diffForHumans()?></b><br>(<?=$application['trial']['startDate']['fullMonth']?>)</td>
                                 <td class="hidden-480 "><b><?=$end->diffForHumans()?></b><br>(<?=$application['trial']['endDate']['fullMonth']?>)</td>
                                 <td class="center hidden-480 "><?=(array_key_exists('promocode', $application)) ? $application['promocode']:'' ?></td>
                                 <td class="center hidden-480 "><?=$application['type']?></td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$application['memberId']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
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
                                 <th class=""></th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Approved</th>
                                 <th class="hidden-480">Application Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['approved'])): foreach($this->vars['approved'] as $application): 
                              if(!empty($application['email'])){
                              ?>
                              <tr class="gradeX odd">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <? $declineCount = ( is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('declineCount',$application['member']['payment']) && $application['member']['payment']['declineCount'] > 0) ? '('.$application['member']['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('renewalREUSE',$application['member']['payment']) && $application['member']['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <?
                                    try {
                                       
                                 ?>
                                 <td class=" "><?=(is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && !empty($application['member']['payment']['number']) && !empty($application['member']['payment']['cvc'])) ? '<a data-id="'.$application['member']['_id'].'" class="btn '.$renewalREUSE.' mini card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <?
                                 } catch (Exception $e) {
                                       error_log(__FILE__.' '.__LINE__.' for variable: application  ==>'.print_r($application,true));  
                                    }
                                 ?>
                                 <td class="hidden-phone"><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($application['approvedDate']['fullDateTime']), $application['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$application['approvedDate']['monthDay'].' '.$application['approvedDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=$application['type']?></td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <?if(!empty($application['memberId'])):?>
                                    <a data-id="<?=(!empty($application['memberId'])) ? (string)$application['memberId'] : ''?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                    <? endif; ?>
                                 </td>
                              </tr>
                              <? } else{
                                 error_log(__FILE__.' '.__LINE__.' for variable: else application  ==>'.print_r($application,true));
                              }
                                 endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div><a name="eagle2016"></a>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
         </div>

            <div class="row-fluid">
               <div class="span12">
                  
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>EAGLE2016 Promo</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Paid</th>
                                 <th class="hidden-480">References</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['eagle2016promocode'])): foreach($this->vars['eagle2016promocode'] as $application): ?>
                              <tr class="gradeX odd">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <? $declineCount = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('declineCount',$application['member']['payment']) && $application['member']['payment']['declineCount'] > 0) ? '('.$application['member']['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('renewalREUSE',$application['member']['payment']) && $application['member']['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && !empty($application['member']['payment']['number']) && !empty($application['member']['payment']['cvc'])) ? '<a data-id="'.$application['member']['_id'].'" class="btn '.$renewalREUSE.' mini card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <td class="hidden-phone "><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <td class="hidden-480 "><?=$application['paidDate']['monthDay'].' '.$application['paidDate']['shortTime']?></td>
                                 <td class="hidden-phone">
                                    <? if($application['new_references']['total'] >= $application['new_references']['max']): ?>
                                    <span class="label label-success"><?=$application['new_references']['total'].' of '.$application['new_references']['max']?></span>
                                    <? else: ?>
                                    <span class="label label-important"><?=$application['new_references']['total'].' of '.$application['new_references']['max']?></span>
                                    <? endif; ?>
                                    <a href="https://<?=SAW_ADMIN_WEBSITE?>/reference/<?=$application['_id']?>/<?=$application['firstName'].'-'.$application['lastName']?>" target="_blank">Reference form</a>
                                 </td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$application['paymentId']?>" class="btn blue mini payment"><i class=" "></i> Payment</a>
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
               </div>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
         </div>












            


            <? 
               if(array_key_exists('promos', $this->vars) && is_array($this->vars['promos']) && !empty($this->vars['promos'])):
                  $i=0;
                  foreach($this->vars['promos'] as $code => $promo):
            ?>   
            
            <a name="<?=$code?>"></a>
            <div class="row-fluid">
               <div class="span12">
                  
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box red">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i><?=$code?></div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Paid</th>
                                 <th class="hidden-480">References</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($promo)): foreach($promo as $application): ?>
                              <tr class="gradeX odd">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <? $declineCount = (is_array($application) && array_key_exists('member',$application) && is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('declineCount',$application['member']['payment']) && $application['member']['payment']['declineCount'] > 0) ? '('.$application['member']['payment']['declineCount'].')': ''; ?>
                                 <? 
                                    $renewalREUSE = (array_key_exists('promotion', $application) && !empty($application['promotion']) && $application['promotion']['optInOnOff'] == 'on' && $application['promotion']['optIn'] == 'yes') ? 'purple' : 'red';
                                 ?>
                                 <td class=" "><?=(is_array($application) && array_key_exists('member',$application) && is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && !empty($application['member']['payment']['number']) && !empty($application['member']['payment']['cvc'])) ? '<a data-url="/card/promotion/'.\Saw\Model\Promotion::$status['NEWMEMBER'].'/'.$application['_id'].'" data-id="'.$application['_id'].'" class="btn '.$renewalREUSE.' mini card">cc'.$declineCount.'</a>':'' ?></td>
                                 <td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <td class="hidden-phone "><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <td class="hidden-480 "><?=$application['paidDate']['monthDay'].' '.$application['paidDate']['shortTime']?></td>
                                 <td class="hidden-phone">
                                    <? if($application['new_references']['total'] >= $application['new_references']['max']): ?>
                                    <span class="label label-success"><?=$application['new_references']['total'].' of '.$application['new_references']['max']?></span>
                                    <? else: ?>
                                    <span class="label label-important"><?=$application['new_references']['total'].' of '.$application['new_references']['max']?></span>
                                    <? endif; ?>
                                    <a href="https://<?=SAW_ADMIN_WEBSITE?>/reference/<?=$application['_id']?>/<?=$application['firstName'].'-'.$application['lastName']?>" target="_blank">Reference form</a>
                                 </td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$application['paymentId']?>" class="btn blue mini payment"><i class=" "></i> Payment</a>
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
               </div>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
         </div>




            <?      
                  $i++;
                  endforeach;
               endif;
            ?>



            <a name="paid90"></a>
            <div class="row-fluid">
               <div class="span12">
                  
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box green">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Paid Year to Date (YTD)</div>
                        <div class="actions">
                           <a class="btn yellow" href="/applications/all"><i class=" icon-eye-open"></i> View All</a>
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Paid</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['paid'])): foreach($this->vars['paid'] as $application): ?>
                              <tr class="gradeX odd">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <td class="hidden-phone "><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <td class="hidden-480 "><?=$application['paidDate']['monthDay'].' '.$application['paidDate']['shortTime']?></td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$application['paymentId']?>" class="btn blue mini payment"><i class=" "></i> Payment</a>
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
               </div>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
         </div>
            




         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<?=$this->element('js/Application.js');?>
<script>
jQuery(document).ready(function() {    
   io.saw.Application.init();


   $('#applications-to-approve tbody .ref-update').click(function(e){
      e.preventDefault();
      io.saw.FormPost.activate({postUrl:'/application/references'
         ,serialized:'id='+$(this).attr('data-id')+'&value='+($(this).prev().val() || '*')
         ,postOnComplete:function(responseObj,responseStatus){}
         ,postOnSuccess:function(responseObj){}
         ,blockUI:'yes'
         ,blockUIParams:{elementToBlock:'#'+$(this).parents('td').attr('id')}
      });
      
   });

   $('#paid .yellow.view').click(function(e){
      e.preventDefault();
      document.location.href='/applications/all';
   });

});      
</script>


      <!-- EMAIL VIEW MODAL -->
      <div class="modal container fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title" id="view-label"></h4>
                   </div>
                   <div class="modal-body">
                       <iframe src="" style="zoom:0.60" width="99.6%" height="1000" frameborder="0"></iframe>
                   </div>
                   <div class="modal-footer">
                       <button class="btn default no">Close</button>
                       <a class="btn green popout" href="" target="_blank">Pop Out</a>
                   </div>
                 </div>
           </div>
       </div>
      <!--/ EMAIL VIEW MODAL -->


<script>
jQuery(document).ready(function() {

   $('.btn.card').live('click', function() {
      if($(this).attr('data-url').length > 0){
         $('#view-modal iframe').attr('src',$(this).attr('data-url'));
         $('#view-modal .popout').attr('href',$(this).attr('data-url'));
         $('#view-modal').modal({keyboard: false});   
      }else{
         $('#view-modal iframe').attr('src','/card/'+$(this).attr('data-id'));
         $('#view-modal .popout').attr('href','/card/'+$(this).attr('data-id'));
         $('#view-modal').modal({keyboard: false});      
      }
      
   });
   $('.btn.payment').live('click', function() {
      $('#view-modal iframe').attr('src','/payment/'+$(this).attr('data-id')+'/view');
      $('#view-modal .popout').attr('href','/payment/'+$(this).attr('data-id')+'/view');
      $('#view-modal').modal({keyboard: false});   
   });
   $('#view-modal .btn.no').click(function(e){
      $('#view-modal').modal('hide');
   });
   $('.btn.view').live('click', function() {
      $('#view-modal iframe').attr('src','/application/'+$(this).attr('data-id')+'/view');
      $('#view-modal .popout').attr('href','/application/'+$(this).attr('data-id')+'/view');
      $('#view-modal').modal({keyboard: false});   
   });
   
   $('.btn.view.member').live('click', function() {
      $('#view-modal iframe').attr('src','/member/'+$(this).attr('data-id')+'/edit');
      $('#view-modal .popout').attr('href','/member/'+$(this).attr('data-id')+'/edit');
      $('#view-modal').modal({keyboard: false});   
   });
   
      

});      
</script>