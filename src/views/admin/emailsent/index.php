      <link href="/assets/css/pages/search.css" rel="stylesheet" type="text/css"/>
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
            <!-- SEARCH -->
            <div id="tab_1_5" class="tab-pane active">
               <div class="row-fluid search-forms search-default">
                  <form id="saw-form" class="form-search">
                     <div class="chat-form">
                        <div class="input-cont">   
                           <input type="text" name="doc[search]" placeholder="" class="m-wrap" value="">
                        </div>
                        <button type="button" class="btn green">Search &nbsp; <i class="m-icon-swapright m-icon-white"></i></button>
                     </div>
                  </form>
               </div>
               <div class="alert alert-info">
                  Search key words can be anything in the <strong>To</strong>, <strong>Subject</strong>, and <strong>Body</strong> fields of the email.
               </div>
               <span id="result-message" class="help-block"></span>
               <div id="results" class="portlet-body">
                  <table class="table table-striped table-hover">
                     <thead class="hide">
                        <tr>
                           <th>To</th>
                           <th>Subject</th>
                           <th class="hidden-phone">DateSent</th>
                           <th></th>
                        </tr>
                     </thead>
                     <tbody>
                        
                     </tbody>
                  </table>
               </div>
               <div class="space5"></div>
               <div class="pagination pagination-right hide">
                  <ul>
                     <li><a href="#">Prev</a></li>
                     <li><a href="#">1</a></li>
                     <li><a href="#">2</a></li>
                     <li class="active"><a href="#">3</a></li>
                     <li><a href="#">4</a></li>
                     <li><a href="#">5</a></li>
                     <li><a href="#">Next</a></li>
                  </ul>
               </div>
            </div>
            <!--/ SEARCH -->

            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat yellow">
                     <div class="visual">
                        <i class="icon-hideme"><?=$this->vars['emailqcnt']?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           In Queue
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#inq"><font><font>
                     Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <a name="inq"></a>
                  <div class="dashboard-stat green">
                     <div class="visual">
                        <i class="icon-hideme"><?=$this->vars['emailcnt'];?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Total Sent</font></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#paid90"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>  
            </div>
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box yellow">
                     <div class="portlet-title" id="scholarship">
                        <div class="caption"><i class="icon-envelope"></i>Emails in queue to be sent</div>
                     </div>
                     <div id="scholarships-to-approve" class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="scholarships" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">To</th>
                                 <th class="">Subject</th>
                                 <th class="hidden-480">Date Sent</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['emailsq'])): foreach($this->vars['emailsq'] as $email): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$email['to']?></td>
                                 <td class=" "><?=$email['subject']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($email['sentDate']['fullDateTime']), $email['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$email['sentDate']['monthDay'].' '.$email['sentDate']['shortTime']?></td>
                                 <td class=" "><a data-id="" class="btn blue mini view" href="/emailsent/<?=$email['_id']?>/view"><i class=" "></i> View</a></td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">Nothing in the Queue.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="trial"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>
            <div class="row-fluid" id="paid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box green">
                     <div class="portlet-title" id="scholarship">
                        <div class="caption"><i class="icon-envelope"></i>Emails Sent</div>
                        <div class="actions">
                           <!--<a class="btn yellow view"><i class=" icon-eye-open"></i> View All</a>-->
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="scholarships" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">To</th>
                                 <th class="">Subject</th>
                                 <th class="hidden-480">Date Sent</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['emails'])): foreach($this->vars['emails'] as $email):?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$email['to']?></td>
                                 <td class=" "><?=$email['subject']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($email['sentDate']['fullDateTime']), $email['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$email['sentDate']['monthDay'].' '.$email['sentDate']['shortTime']?></td>
                                 <td class=" "><a data-id="<?=$email['_id']?>" class="btn blue mini view" href="/emailsent/<?=$email['_id']?>/view"><i class=" "></i> View</a></td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">Nothing recorded as sent.</td>
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
            <button class="btn blue continue close">Close</button>
         </div>
      </div>
      <!--/ SUCCESSFUL SAVE MODAL -->

<script>
jQuery(document).ready(function() {  
   window.saw_stateOrderNum = '';
   window.saw_search = function(){
      io.saw.FormPost.activate({postUrl:'/emailsent/search'
         ,serializeSelector:':input'
         ,formName:'#saw-form'
         ,blockUIParams:{elementToBlock:'#results'}
         ,postOnComplete:function(responseObj,responseStatus){}
         ,postOnSuccess:function(responseObj){
               //clear all records
               $('#results tbody').html('');
               $('#result-message').html(responseObj.message);

               $.each(responseObj.results,function(key,email){
                  html = '<tr>'+
                        '   <td class="">'+email.to+'</td>'+
                        '   <td class=" hidden-phone">'+email.subject+'</td>'+
                        '   <td class=" hidden-phone">'+email.sentDate.fullDateTime+'</td>'+
                        '   <td><a class="btn mini green-stripe" href="/emailsent/'+email._id.$id+'/view">View</a></td>'+
                        '   <!--<td><a class="btn mini blue-stripe edit" data-id="'+email._id.$id+'">Re-Send</a></td>-->'+
                        '</tr>';
                  $('#results tbody').append(html);
                  $('#results thead').removeClass('hide');
               });
               
               $('#results td .edit').click(function(e){
                  e.preventDefault();
                  io.saw.FormGet.activate({postUrl:'/emailsent/'+$(this).attr('data-id')+'/resend'
                     ,postOnComplete:function(responseObj,responseStatus){}
                     ,postOnSuccess:function(responseObj){}
                     ,blockUI:'yes'
                     ,blockUIParams:{elementToBlock:'#'+$(this).parents('td').attr('id')}
                  });
               });
         }
      });
   };
   $('#saw-form input').keypress(function(e) {
      if (e.which == 13) {
         e.preventDefault();
         window.saw_search();
      }
   });  
   $('#saw-form .btn.green').click(function(e){
      e.preventDefault();
      window.saw_search();
   });
   <? if(!empty($this->vars['query'])){ ?>
      window.saw_search();
   <? } ?>
   
});      
</script>