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
                     
                        <h3 class="form-section text-info"><strong><?=$this->vars['page']['headline']?></strong></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <?=$this->vars['page']['body']?>
                           </div>
                           <!--/span-->
                        </div>
                        
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

