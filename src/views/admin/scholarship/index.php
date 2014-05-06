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
            

            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat red">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['submitted'])) ? count($this->vars['submitted']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           To Approve
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#approve"><font><font>
                     Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <a name="approve"></a>
                  <div class="dashboard-stat green">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['approved'])) ? count($this->vars['approved']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Approved</font></font></div>
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
                  <div class="portlet box red">
                     <div class="portlet-title" id="scholarship">
                        <div class="caption"><i class="icon-user"></i>Scholarships To Approve</div>
                     </div>
                     <div id="scholarships-to-approve" class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="scholarships" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">For</th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Submitted</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['submitted'])): foreach($this->vars['submitted'] as $scholarship): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$scholarship['for']?></td>
                                 <td class=" "><?=$scholarship['name']?></td>
                                 <td class="hidden-phone"><?=$scholarship['email']?></td>
                                 <td class="hidden-480 "><?=$scholarship['city'].', '.$scholarship['state']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($scholarship['submittedDate']['fullDateTime']), $scholarship['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$scholarship['submittedDate']['monthDay'].' '.$scholarship['submittedDate']['shortTime']?></td>
                                 <td class=" "><a data-id="<?=$scholarship['_id']?>" class="btn blue mini view"><i class=" "></i> View</a></td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">Nothing to approve.</td>
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
                        <div class="caption"><i class="icon-user"></i>Scholarships Approved</div>
                        <div class="actions">
                           <!--<a class="btn yellow view"><i class=" icon-eye-open"></i> View All</a>-->
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="scholarships" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">For</th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Approved</th>
                                 <th class="hidden-480">Reg. Number</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['approved'])): foreach($this->vars['approved'] as $scholarship): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$scholarship['for']?></td>
                                 <td class=" "><?=$scholarship['name']?></td>
                                 <td class="hidden-phone "><?=$scholarship['email']?></td>
                                 <td class="hidden-480 "><?=$scholarship['city'].', '.$scholarship['state']?></td>
                                 <td class="hidden-480 "><?=$scholarship['approvedDate']['monthDay'].' '.$scholarship['approvedDate']['shortTime']?></td>
                                 <td class="hidden-480 "><?=$scholarship['registrationNumber']?></td>
                                 <td class=" ">
                                    <a data-id="<?=$scholarship['_id']?>" class="btn blue mini view"><i class=" "></i> View</a>
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


         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<?=$this->element('js/Scholarship.js');?>
<script>
jQuery(document).ready(function() {    
   io.saw.Scholarship.init();
});      
</script>