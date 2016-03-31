
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
                  <div class="row-fluid">
                     <div class="span12">
                        <a id="add-promotion" class="btn green add-promotion"><i class=" icon-plus"></i> Add New </a>
                        <br>
                        <br>
                     </div>
                  </div>
                  
                  <!-- CATEGORIES -->
                  <div class="row-fluid">
                     <div id="store" class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue">
                           <div class="portlet-title" id="draft">
                              <div class="caption"><i class="icon-edit"></i>Promotions</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="reviews" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Code</th>
                                       <th class="">Start</th>
                                       <th class="">End</th>
                                       <th class="">Amount</th>
                                       <th class="">Count</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['promotions'])): foreach($this->vars['promotions'] as $promotion): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$promotion['code']?></td>
                                       <?
                                          // humanize dates
                                          $start = \Carbon\Carbon::createFromTimeStamp(strtotime($promotion['startDate']['fullDateTime']), $promotion['startDate']['timezone']);
                                          $end = \Carbon\Carbon::createFromTimeStamp(strtotime($promotion['endDate']['fullMonth']), $promotion['endDate']['timezone']);
                                       ?>

                                       <td class="hidden-480 "><b><?=$start->diffForHumans()?></b><br>(<?=$promotion['startDate']['fullMonth']?>)</td>
                                       <td class="hidden-480 "><b><?=$end->diffForHumans()?></b><br>(<?=$promotion['endDate']['fullMonth']?>)</td>
                                       <td class=" "><?=$promotion['discountAmt']?></td>
                                       <td class=" "><?=$promotion['count']?></td>
                                       <td class=" "><a data-id="<?=$promotion['_id']?>" data-member-id="" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No promotions.</td>
                                    <? endif;?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>
                  <br><br>
                  <!--/ CATEGORIES -->
                  
                  
               </div>
            </div>
            
            <!-- END PAGE CONTENT-->

         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
      <script>
         jQuery(document).ready(function() {    
            $('#add-promotion').click(function(e){
               document.location.href='/promotion/edit';  
            });
            $('.edit').click(function(e){
               document.location.href='/promotion/edit/'+$(this).attr('data-id');
            });
            
         });
      </script>