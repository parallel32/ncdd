
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

               <? foreach($this->vars['areas'] as $country =>$states): ?>
                  <!-- REVIEW BLOG POSTS -->
                  <div id="recent-review" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue">
                           <div class="portlet-title" id="draft">
                              <div class="caption"><i class="icon-flag"></i><?=strtoupper($country)?></div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="reviews" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">State</th>
                                       <th class="">Member(s)</th>
                                       <th class="">Status</th>
                                       <th class="hidden-480">Last Edited</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? foreach($states as $state): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$state['name']?></td>
                                       <td class=" "><?=$state['members']?></td>
                                       <?
                                          switch ($state['currentStatus']) {
                                             case \Saw\Model\Delegate::$status['PUBLISH']:
                                                $currentStatus = '<span class="label label-success">'.\Saw\Model\Delegate::$statusReversed[$state['currentStatus']].'</span>';
                                                break;
                                             case \Saw\Model\Delegate::$status['DRAFT']:
                                                $currentStatus = '<span class="label label-inverse">'.\Saw\Model\Delegate::$statusReversed[$state['currentStatus']].'</span>';
                                                break;
                                             default:
                                                $currentStatus = '<span class="label label-inverse">DRAFT</span>';
                                                break;
                                          }
                                       ?>
                                       
                                       <td class=" "><?=$currentStatus?></td>
                                       <td class="hidden-480 "><?=$state['lastEditDate']?></td>
                                       <?if($state['add'] == 'yes'): ?>
                                       <td class=" "><a href="/delegate/add/<?=$country?>/<?=strtolower($state['abbr'])?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
                                       <? else: ?>
                                       <td class=" "><a href="/delegate/edit/<?=$state['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
                                       <? endif; ?>
                                    </tr>
                                    <? endforeach;?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>
                  <br><br>
                  <!--/ REVIEW BLOG POSTS -->
               <? endforeach; ?>                 
               </div>
            </div>
            
            <!-- END PAGE CONTENT-->

         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
      <script>
         jQuery(document).ready(function() {    
            
         });
      </script>