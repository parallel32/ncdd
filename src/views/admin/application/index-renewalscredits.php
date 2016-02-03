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

            <h1>1. Renewals with a credit on file</h1>
            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat red">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['renewals'])) ? count($this->vars['renewals']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           Total
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                  </div>
               </div>
            </div>


            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption"></div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th><th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Credit Amt</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['renewals'])): foreach($this->vars['renewals'] as $member): ?>
                              <tr class="gradeX odd ">
                                 <? $declineCount = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('declineCount',$member['payment']) && $member['payment']['declineCount'] > 0) ? '('.$member['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('renewalREUSE',$member['payment']) && $member['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && !empty($member['payment']['number']) && !empty($member['payment']['cvc'])) ? '<a data-id="'.$member['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <td class="hidden-480 "><b><?=(array_key_exists('payment', $member) && array_key_exists('renewalCredit', $member['payment']) && !empty($member['payment']['renewalCredit'])) ? '$'.$member['payment']['renewalCredit'] : ''?></b></td>
                                 <td class=" ">
                                    <? if(!empty($member['renewal']['applicationId'])){?>
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <? } ?>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                    <a data-id="<?=$member['_id']?>" class="btn mini yellow-stripe user-login">LogIn</a>
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
            

            
            <script>
            jQuery(document).ready(function() {    
               io.saw.Application.init();

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

   $('#paid-renewals .yellow.view').click(function(e){
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
                   </div>
                 </div>
           </div>
       </div>
      <!--/ EMAIL VIEW MODAL -->


<script>
jQuery(document).ready(function() {

   $('.btn.card').live('click', function() {
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
      console.log('here')
      console.log($(this).attr('data-id'))
      $('#view-modal iframe').attr('src','/application/'+$(this).attr('data-id')+'/view');
      $('#view-modal').modal({keyboard: false});   
   });
   
   $('.btn.view.member').live('click', function() {
      $('#view-modal iframe').attr('src','/member/'+$(this).attr('data-id')+'/edit');
      $('#view-modal').modal({keyboard: false});   
   });
   
      

});      
</script>