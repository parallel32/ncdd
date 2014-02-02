
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
                        <a id="add-category" class="btn green add-category"><i class=" icon-plus"></i> Add New </a>
                        <br>
                        <br>
                     </div>
                  </div>
                  
                  <!-- CATEGORIES -->
                  <div class="row-fluid">
                     <div id="blog" class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue">
                           <div class="portlet-title" id="draft">
                              <div class="caption"><i class="icon-edit"></i>DUI Blog Tags</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="reviews" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Tag</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['tags'])): foreach($this->vars['tags'] as $category): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$category['name']?></td>
                                       <td class=" "><a data-id="<?=$category['_id']?>" data-member-id="" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No tags.</td>
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
                              <div class="caption"><i class="icon-edit"></i>NCDD Store Categories</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="reviews" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Category</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['categories'])): foreach($this->vars['categories'] as $category): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$category['name']?></td>
                                       <td class=" "><a data-id="<?=$category['_id']?>" data-member-id="" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No categories.</td>
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
            $('#add-category').click(function(e){
               document.location.href='/category/edit';  
            });
            $('.edit').click(function(e){
               document.location.href='/category/edit/'+$(this).attr('data-id');
            });
            
         });
      </script>