      <link href="/assets/css/pages/search.css" rel="stylesheet" type="text/css"/>
      <!-- BEGIN PAGE -->
      <div class="page-content portlet">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                  <?=$this->element('page-title-and-bread-crumb');?>
               </div>
            </div>
            <!-- END PAGE HEADER-->
            
            <div id="tab_1_5" class="tab-pane active">
               <h3>Managed Pages</h3>
               <a class="btn green managed" href="/page/place-holder/MANAGED/edit/place-holder">Add New <i class="icon-plus"></i></a>
               <div id="managed-pages" class="portlet-body">
                  <p id="managed-pages-result-message"></p>
                  <table class="table table-striped table-hover">
                     <thead class="hide">
                        <tr>
                           <th>Headline</th>
                           <th>URL Path</th>
                           <th>Section</th>
                           <th></th>
                        </tr>
                     </thead>
                     <tbody>
                        
                     </tbody>
                  </table>
               </div>
               <h3>Dynamic Pages</h3>
               <a class="btn green dynamic" href="/page/place-holder/DYNAMIC/edit/place-holder">Add New <i class="icon-plus"></i></a>
               <div id="dynamic-pages" class="portlet-body">
                  <p id="dynamic-pages-result-message"></p>
                  <table class="table table-striped table-hover">
                     <thead class="hide">
                        <tr>
                           <th>Headline</th>
                           <th>URL Path</th>
                           <th class="hidden-phone">Section</th>
                           <th class="hidden-phone">Status</th>
                           <th></th>
                        </tr>
                     </thead>
                     <tbody>
                        
                     </tbody>
                  </table>
               </div>
               
                     <!-- SUCCESSFUL SAVE MODAL -->
                     <div id="save-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="save-modal-label">Are you sure you want to delete this page?</h3>
                        </div>
                        <div class="modal-body">
                           <p></p>
                        </div>
                        <div class="modal-footer">
                           <button class="btn blue yes">Yes, Delete it</button>
                           <button class="btn cancel">Cancel</button>
                        </div>
                     </div>
                     <!--/ SUCCESSFUL SAVE MODAL -->
                     

               
            </div>
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<script>
jQuery(document).ready(function() {  
   io.saw.FormGet.activate({postUrl:'/page/dynamic'
      ,postOnComplete:function(responseObj,responseStatus){}
      ,postOnSuccess:function(responseObj){
            
            //clear all records
            $('#dynamic-pages tbody').html('');
            $('#dynamic-pages-result-message').html(responseObj.message);

            $.each(responseObj.results,function(key,page){
               html = '<tr>'+
                     '   <td class="">'+page.headline+'</td>'+
                     '   <td class="">'+page.slug+'</td>'+
                     '   <td class="">'+page.section+'</td>'+
                     '   <td class=" hidden-phone">'+page.currentStatus+'</td>'+
                     '   <td><a class="btn large green-stripe dynamic" data-headline="'+page.headline+'" data-slug="'+page.slug+'" data-type="DYNAMIC">Edit</a> <a class="btn large red-stripe delete" data-slug="'+page.slug+'">Delete</a></td>'+
                     '</tr>';
               $('#dynamic-pages tbody').append(html);
               $('#dynamic-pages thead').removeClass('hide');
            });
            
               // bind click events to the records....
            $('#dynamic-pages td .dynamic').click(function(e){
               document.location.href='/page/'+$(this).attr('data-slug')+'/'+$(this).attr('data-type')+'/edit/'+$(this).attr('data-headline');
            });   
            $('#dynamic-pages td .delete').click(function(e){
               $('#save-modal').modal({keyboard: false});
               window.the_this = $(this);
               
            });   
            $('#save-modal .yes').click(function(e){
               io.saw.FormGet.activate({postUrl:'/page/'+$(the_this).attr('data-slug')+'/delete'
                  ,postOnComplete:function(responseObj,responseStatus){}
                  ,postOnSuccess:function(responseObj){
                     $(the_this).parents('tr').remove();
                     $('#save-modal').modal('hide');
                  }
               });
            });   
            $('#save-modal .cancel').click(function(e){
               $('#save-modal').modal('hide');
            });   
            

      }
   });   
//*
   window.setTimeout(function(){

      io.saw.FormGet.activate({postUrl:'/page/managed'
         ,postOnComplete:function(responseObj,responseStatus){}
         ,postOnSuccess:function(responseObj){
               
               //clear all records
               $('#managed-pages tbody').html('');
               $('#managed-pages-result-message').html(responseObj.message);

               $.each(responseObj.results,function(key,page){
                  html = '<tr>'+
                        '   <td class="">'+page.headline+'</td>'+
                        '   <td class="">'+page.slug+'</td>'+
                        '   <td class="">'+page.section+'</td>'+
                        '   <td><a class="btn large green-stripe managed" data-headline="'+page.headline+'" data-slug="'+page.slug+'" data-type="MANAGED">Edit</a></td>'+
                        '</tr>';
                  $('#managed-pages tbody').append(html);
                  $('#managed-pages thead').removeClass('hide');
               });
               
                  // bind click events to the records....
               $('#managed-pages td .managed').click(function(e){
                  document.location.href='/page/'+$(this).attr('data-slug')+'/'+$(this).attr('data-type')+'/edit/'+$(this).attr('data-headline');
               });   

         }
      });
      
   }, 3000);
   
//*/
   
});      
</script>