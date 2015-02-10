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
                  <div id="dashboard">

               <!-- BEGIN DASHBOARD STATS -->
               <div class="row-fluid">
                  <div class="span12 responsive" data-tablet="span12" data-desktop="span6">
                     <div class="dashboard-stat red">
                        <div class="visual">
                           <i class="icon-page"></i>
                        </div>
                        <div class="details">
                           <div class="number"><?=$this->vars['count']?></div>
                           <div class="desc">Total Changes</div>
                        </div>
                        </a>                 
                     </div>
                  </div>
               </div>
               <!-- END DASHBOARD STATS -->

               <!-- CHANGES (RECENT) -->
               <div class="row-fluid">
                  <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE PORTLET-->
                     <div class="portlet box blue">
                        <div class="portlet-title" id="page">
                           <div class="caption"><i class="icon-copy"></i>Changes (all time)</div>
                           <div class="actions">
                           </div>
                        </div>
                        <div class="portlet-body">
                           <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                           <table class="table table-striped table-bordered table-hover dataTable" id="changes" aria-describedby="sample_1_info">
                              <thead>
                                 <tr role="row">
                                    <th class="">Who</th>
                                    <th class="">What</th>
                                    <th class="">When</th>
                                 </tr>
                              </thead>
                              <tbody role="alert" aria-live="polite" aria-relevant="all">
                                 <? if(!empty($this->vars['changes'])): foreach($this->vars['changes'] as $change): ?>
                                 <tr class="gradeX odd">
                                    <td class=" "><?=$change['label']?></td>
                                    <td class=" ">


                                       <table class="table table-striped table-bordered" id="" aria-describedby="sample_1_info">
                                          <thead>
                                             <tr role="row">
                                                <th class=""></th>
                                                <th class=""></th>
                                             </tr>
                                          </thead>
                                          <tbody role="alert" aria-live="polite" aria-relevant="all">
                                          <?foreach ($change['values'] as $key => $value) {?>
                                             <tr class="">
                                                <td class=" "><?=$key?></td>
                                                <td class=" "><?=$value?></td>
                                             </tr>
                                          <?}?>
                                          </tbody>
                                       </table>
                                    </td>
                                    <td class=" "><b><?=$change['timeAgo']?></b><br><?=$change['date']['fullDateTime']?></td>
                                 </tr>
                                 <? endforeach;?>
                                 <? else: ?>
                                    <td colspan="5">No pages at the moment.</td>
                                 <? endif;?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!-- END EXAMPLE TABLE PORTLET-->
                  </div>
               </div>
               <div class="clearfix"></div>
               <!--/ CHANGES (RECENT) -->


            </div>
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->

