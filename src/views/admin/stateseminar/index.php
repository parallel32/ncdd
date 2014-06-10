<? $accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app); ?>
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
                  <? if($accessLevel >= EDITOR){ ?>
                  <div class="row-fluid">
                     <div class="span12">
                        <a id="add-stateseminar" class="btn green add-stateseminar"><i class=" icon-plus"></i> Add New </a>
                        <br>
                        <br>
                     </div>
                  </div>
                  <? } ?>
                  <!-- CATEGORIES -->
                  <div class="row-fluid">
                     <div id="blog" class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue">
                           <div class="portlet-title" id="draft">
                              <div class="caption">NCDD Sponsored or Co-Sponsored</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="reviews" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Name</th>
                                       <th class="">State</th>
                                       <th class="">Date</th>
                                       <th class="">Sponsor</th>
                                       <th class="">Co-Sponsor</th>
                                       <th class=""></th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['sponsoredseminars'])): foreach($this->vars['sponsoredseminars'] as $sponsoredseminar): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$sponsoredseminar['name']?></td>
                                       <td class=" "><?=$sponsoredseminar['state']?></td>
                                       <td class=" "><?=$sponsoredseminar['date']['fullMonth']?></td>
                                       <td class=" "><?=$sponsoredseminar['sponsor']?></td>
                                       <td class=" "><?=$sponsoredseminar['cosponsor']?></td>
                                       <td class=" "><span class="label label-info"><?=\Saw\Model\StateSeminar::$typeReversed[$sponsoredseminar['currentType']]?></span></td>
                                       <td class=" "><? if($accessLevel >= EDITOR){ ?><a data-id="<?=$sponsoredseminar['_id']?>" data-member-id="" class="btn blue mini edit">Edit</a><? } ?></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="7">None to show.</td>
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
                  <!-- CATEGORIES -->
                  <div class="row-fluid">
                     <div id="store" class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue">
                           <div class="portlet-title" id="draft">
                              <div class="caption">All State Approved Seminars </div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="reviews" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Name</th>
                                       <th class="">State</th>
                                       <th class="">Date</th>
                                       <th class="">Sponsor</th>
                                       <th class="">Co-Sponsor</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['stateseminars'])): foreach($this->vars['stateseminars'] as $stateseminar): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$stateseminar['name']?></td>
                                       <td class=" "><?=$stateseminar['state']?></td>
                                       <td class=" "><?=$stateseminar['date']['fullMonth']?></td>
                                       <td class=" "><?=$stateseminar['sponsor']?></td>
                                       <td class=" "><?=$stateseminar['cosponsor']?></td>
                                       <td class=" "><? if($accessLevel >= EDITOR){ ?><a data-id="<?=$stateseminar['_id']?>" data-member-id="" class="btn blue mini edit">Edit</a><? } ?></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="6">None to show.</td>
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
            $('#add-stateseminar').click(function(e){
               document.location.href='/stateseminar/edit';  
            });
            $('.edit').click(function(e){
               document.location.href='/stateseminar/edit/'+$(this).attr('data-id');
            });
            
         });
      </script>