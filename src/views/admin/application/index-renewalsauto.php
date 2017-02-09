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
            <h3>Everyone who opted in to Auto Pay</h3>
            <div class="row-fluid">
               <div class="responsive span12" data-tablet="span12" data-desktop="span12">
                  <div class="dashboard-stat purple">
                     <div class="visual">
                        <i class="icon-hideme"><?=$this->vars['grand_total'];?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           Grand Total
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                  </div>
               </div>
            </div>


            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat blue">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['valid'])) ? count($this->vars['valid']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           valid
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#valid"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat yellow">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['expired'])) ? count($this->vars['expired']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           expired
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#expired"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
            </div>


            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat red">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['declined'])) ? count($this->vars['declined']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           declined
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#declined"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat green">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['paid'])) ? count($this->vars['paid']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           paid
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#paid"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
            </div>


            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box red">
                     <div class="portlet-title" id="application">
                        <div class="caption">Declined</div><a name="declined"></a>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Card</th>
                                 <th class="hidden-phone">ExpDate</th>
                                 <th class="hidden-phone">Number</th>
                                 <th class="hidden-480">Member</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['declined'])): foreach($this->vars['declined'] as $item): ?>
                              <tr class="gradeX odd ">
                              <?if (true): ?>
                                 <td class=" "><a data-id="<?=$item['record']['_id']?>" class="btn mini card">cc</a></td>
                                 <td class="hidden-phone"><?=$item['record']['payment']['expMonth']?> / <?=$item['record']['payment']['expYear']?></td>
                                 <td class="hidden-phone"><?='...'.substr(str_replace('.x', '', $item['record']['payment']['number']), -4);?></td>
                                 <td class="hidden-phone"><?=$item['record']['name']?></td>
                                 <td class="hidden-phone declinemessage">
                                 <?
                                    // process decline message
                                    $decoded_message = '';
                                    if(strpos($item['declinedMessage'], 'Declined') !== false){
                                       $tmp = explode('Declined', $item['declinedMessage']);
                                       if(is_array($tmp) && !empty($tmp)){
                                          $code = substr($tmp[1], 0,4);
                                          //error_log('$code: '.print_r($code,true));
                                          $last['M'] = 'Card code matches.';
                                          $last['N'] = 'Card code does not match.';
                                          $last['P'] = 'Not processed';
                                          $last['S'] = 'Merchant has indicated that the card code is not present on the card.';
                                          $last['U'] = 'Issuer is not certified and/or has not provided encryption keys.';
                                          $last['X'] = 'No response from the credit card association was received.';

                                          if(strlen($code) == 4){
                                             $firstthree['YYY'] = 'Address and zip code match.';
                                             $firstthree['YYA'] = 'Address and zip code match.';
                                             $firstthree['NYZ'] = 'Only the zip code matches';
                                             $firstthree['YNA'] = 'Only the address matches.';
                                             $firstthree['YNY'] = 'Only the address matches.';
                                             $firstthree['NNN'] = 'Neither the address nor the zip code match.';
                                             $firstthree['XXW'] = 'Card number not on file';
                                             $firstthree['XXU'] = 'Address information not verified for domestic transaction.';
                                             $firstthree['XXR'] = 'Retry - system unavailable.';
                                             $firstthree['XXS'] = 'Service not supported.';
                                             $firstthree['XXE'] = 'AVS not allowed for card type.';
                                             $firstthree['XXG'] = 'Global non-AVS participant. Normally an international transaction.';
                                             $firstthree['YNB'] = 'Street address matchesfor international transaction; Postal code not verified.';
                                             $firstthree['NNC'] = 'Street address and Postal code not verified for international transaction.';
                                             $firstthree['YYD'] = 'Street address and Postal code match for international transaction.';
                                             $firstthree['YYF'] = 'Street address and Postal code match for international transaction. (UK Only)';
                                             $firstthree['NNI'] = 'Address information not verified for international transaction.';
                                             $firstthree['YYM'] = 'Street address and Postal code match for international transaction.';
                                             $firstthree['NYP'] = 'Postal codes match for international transaction; Street address not verified.';
                                             
                                             if(array_key_exists(substr($code, 0,3), $firstthree)){
                                                $decoded_message = $firstthree[substr($code, 0,3)];   
                                             }
                                             if(array_key_exists(substr($code, -1,1), $last)){
                                                $decoded_message = $decoded_message.' '.$last[substr($code, -1,1)];
                                             }
                                                
                                          }
                                          if(strlen($code) < 4){
                                             $firstthree['XX'] = 'Address verification has been requested, but not received.';

                                             if(array_key_exists(substr($code, 0,2), $firstthree)){
                                                $decoded_message = $firstthree[substr($code, 0,2)];   
                                             }
                                             if(array_key_exists(substr($code, -1,1), $last)){
                                                $decoded_message = $decoded_message.' '.$last[substr($code, -1,1)];
                                             }
                                          }
                                          
                                          
                                       }
                                    }
                                 ?>
                                 <?=$item['declinedMessage'].'<br> <strong>'.$decoded_message.'</strong>'?>

                                 </td>
                              <? endif; 
                              ?>
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
         </div>
         <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption">Valid</div><a name="valid"></a>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Card</th>
                                 <th class="hidden-phone">ExpDate</th>
                                 <th class="hidden-phone">Number</th>
                                 <th class="hidden-480">Member</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['valid'])): foreach($this->vars['valid'] as $item): ?>
                              <tr class="gradeX odd ">
                              <?if (true): ?>
                                 <td class=" "><a data-id="<?=$item['record']['_id']?>" class="btn mini card">cc</a></td>
                                 <td class="hidden-phone"><?=$item['record']['payment']['expMonth']?> / <?=$item['record']['payment']['expYear']?></td>
                                 <td class="hidden-phone"><?='...'.substr(str_replace('.x', '', $item['record']['payment']['number']), -4);?></td>
                                 <td class="hidden-phone"><?=$item['record']['name']?></td>
                                 <td class="hidden-phone"><?=$item['declinedMessage']?></td>                                 
                              <? endif; ?>
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
         </div>
         <div class="row-fluid" id="paid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box green">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications Paid</div>
                        <div class="actions">
                           <!-- <a class="btn yellow view"><i class=" icon-eye-open"></i> View All</a> -->
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th>
                                 <th class=""></th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date Paid</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['paid'])): foreach($this->vars['paid'] as $member): ?>
                              <tr class="gradeX odd">
                                 <? $declineCount = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('declineCount',$member['payment']) && $member['payment']['declineCount'] > 0) ? '('.$member['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('renewalREUSE',$member['payment']) && $member['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && !empty($member['payment']['number']) && !empty($member['payment']['cvc'])) ? '<a data-id="'.$member['_id'].'" class="btn '.$renewalREUSE.' mini cardpaid">cc'.$declineCount.'</a>':'' ?></td>
                                 <td class=" "><?
                                 if(!empty($member['renewalpromocode'])){
                                    if(strtolower($member['renewalpromocode']) == 'renew2016'){
                                       echo '<a class="btn mini blue renewalpromocode">'.$member['renewalpromocode'].'</a>';
                                    }else{
                                       echo '<a class="btn mini blue promocode">'.$member['renewalpromocode'].'</a>';
                                    }
                                    
                                 }else{
                                       echo '';
                                 }?></td>
                                 <td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['paidDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['paidDate']['monthDay'].' '.$member['renewal']['paidDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['paymentId']?>" class="btn blue mini payment"><i class=" "></i> Payment</a>
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                    <a data-id="<?=$member['_id']?>" class="btn mini yellow-stripe user-login">LogIn</a>
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
                  <div class="portlet box yellow">
                     <div class="portlet-title" id="application">
                        <div class="caption">Expired</div><a name="expired"></a>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Card</th>
                                 <th class="hidden-phone">ExpDate</th>
                                 <th class="hidden-phone">Number</th>
                                 <th class="hidden-480">Member</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['expired'])): foreach($this->vars['expired'] as $item): ?>
                              <tr class="gradeX odd ">
                              <?if (true): ?>
                                 <td class=" "><a data-id="<?=$item['record']['_id']?>" class="btn mini card">cc</a></td>
                                 <td class="hidden-phone"><?=$item['record']['payment']['expMonth']?> / <?=$item['record']['payment']['expYear']?></td>
                                 <td class="hidden-phone"><?='...'.substr(str_replace('.x', '', $item['record']['payment']['number']), -4);?></td>
                                 <td class="hidden-phone"><?=$item['record']['name']?></td>
                                 <td class="hidden-phone"><?=$item['declinedMessage']?></td>                                 
                              <? endif; ?>
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
         </div>



         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->


      <!-- EMAIL VIEW MODAL -->
      <div class="modal container fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title" id="view-label"></h4>
                   </div>
                   <div class="modal-body">
                       <iframe src="" style="zoom:0.60" width="99.6%" height="800" frameborder="0"></iframe>
                   </div>
                   <div class="modal-footer">
                       <button class="btn default no">Close</button>
                   </div>
                 </div>
           </div>
       </div>
      <!--/ EMAIL VIEW MODAL -->


<script>
jQuery(document).ready(function() {
   $('td .user-login').click(function(e){
                  io.saw.FormGet.activate({postUrl:'/authentication/shadologin/'+$(this).attr('data-id')
                     ,postOnComplete:function(responseObj,responseStatus){}
                     ,postOnSuccess:function(responseObj){
                        document.location.href = '/';
                     }
                     ,postOnErrors:function(responseObj){
                        alert('Something failed trying to sign in as this user...this is an unlikely error with no logs.  Please recall what you did and email Mike.');
                     }
                  });
               });
   $('.btn.card').live('click', function() {
      $('#view-modal iframe').attr('src','/card/auto-renew/'+$(this).attr('data-id'));
      $('#view-modal').modal({keyboard: false});   
   });
   $('.btn.payment').live('click', function() {
      $('#view-modal iframe').attr('src','/payment/'+$(this).attr('data-id')+'/view');
      $('#view-modal').modal({keyboard: false});   
   });
   $('#view-modal .btn.no').click(function(e){
      $('#view-modal').modal('hide');
   });
});      
</script>


<script>
jQuery(document).ready(function() {

   $('.btn.cardpaid').live('click', function() {
      $('#view-modal iframe').attr('src','/card/'+$(this).attr('data-id'));
      $('#view-modal').modal({keyboard: false});   
   });
   $('.btn.payment').live('click', function() {
      $('#view-modal iframe').attr('src','/payment/'+$(this).attr('data-id')+'/view');
      $('#view-modal').modal({keyboard: false});   
   });
   $('#view-modal .btn.no').click(function(e){
      $('#view-modal').modal('hide');
   });

   $('.btn.view').live('click', function() {
      $('#view-modal iframe').attr('src','/application/'+$(this).attr('data-id')+'/view');
      $('#view-modal').modal({keyboard: false});   
   });
   
   $('.btn.view.member').live('click', function() {
      $('#view-modal iframe').attr('src','/member/'+$(this).attr('data-id')+'/edit');
      $('#view-modal').modal({keyboard: false});   
   });
   $('.btn.updatemember').live('click', function() {
      $('#view-modal iframe').attr('src',$(this).attr('data-url')+$(this).attr('data-id'));
      $('#view-modal').modal({keyboard: false});   
   });
   
      

});      
</script>