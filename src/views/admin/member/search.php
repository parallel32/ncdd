<?
$accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app); 
?>      
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
               <div class="row-fluid search-forms search-default">
                  <form id="saw-form" class="form-search">
                     <div class="chat-form">
                        <div class="input-cont">   
                           <input type="text" name="doc[search]" placeholder="Search key words can be: email address OR name OR partial name OR state (Alabama, New York, Washington, etc.)" class="m-wrap" value="<?=$this->vars['query'];?>">
                        </div>
                        <button type="button" class="btn green">Search &nbsp; <i class="m-icon-swapright m-icon-white"></i></button>
                     </div>
                  </form>
               </div>
               <div class="alert alert-info">
                  Search key words can be: <strong>email address</strong> OR <strong>name</strong> OR <strong>partial name</strong> OR <strong>state (Alabama, New York, Washington, etc.)</strong>
               </div>
               <span id="result-message" class="help-block"></span>
               <div id="results" class="portlet-body">
                  <table class="table table-striped table-hover">
                     <thead class="hide">
                        <tr>
                           <th>Photo</th>
                           <th>Name</th>
                           <? if($accessLevel >= EDITOR): ?>
                           <th class="hidden-phone">#</th>
                           <? endif; ?>
                           <th class="hidden-phone">Order</th>
                           <th class="hidden-phone">Membership</th>
                           <th class="hidden-phone hidden-tablet">Executive</th>
                           <th class="hidden-phone hidden-tablet">Board Certified</th>
                           <th class="hidden-phone hidden-tablet">Listed</th>
                           <th>Profile</th>
                           <? if($accessLevel >= EDITOR): ?>
                           <th></th>
                           <? endif; ?>
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
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<script>
jQuery(document).ready(function() {  
   window.saw_stateOrderNum = '';
   window.saw_search = function(){
      io.saw.FormPost.activate({postUrl:'/member/search'
         ,serializeSelector:':input'
         ,formName:'#saw-form'
         ,blockUIParams:{elementToBlock:'#results'}
         ,postOnComplete:function(responseObj,responseStatus){}
         ,postOnSuccess:function(responseObj){
               
               // set the state global variable
               window.saw_stateOrderNum = responseObj.state;
               //clear all records
               $('#results tbody').html('');
               $('#result-message').html(responseObj.message);

               $.each(responseObj.results,function(key,member){
                  if(window.saw_stateOrderNum == 'yes' && member.hasOwnProperty('orderNumState')){
                     //console.log(member.displayName+' A '+ member.orderNumState.toString());
                     orderNum = member.orderNumState.toString();
                  }else{
                     //console.log('B'+ member.orderNum.toString());
                     orderNum = member.orderNum.toString();
                  }
                  if(member.hasOwnProperty('boardCertifiedSr')){
                     var boardCertified = (member.boardCertified == 'Yes' || member.boardCertifiedSr == 'Yes') ? 'Yes' : 'No';
                  }else{
                     var boardCertified = member.boardCertified;
                  }
                  html = '<tr>'+
                        '   <td><img width="159" src="'+member.image+'" alt=""></td>'+
                        '   <td class="">'+member.displayName+'</td>'+
                        <? if($accessLevel >= EDITOR): ?>
                        '   <td class=" hidden-phone" id="'+member._id.$id+'"><input type="text" class="m-wrap" style="width:32px;" value="'+orderNum+'"><a data-member-id="'+member._id.$id+'" href="#" class="btn green icn-only order-update"><i class="icon-check icon-white"></i></a></td>'+
                        <? endif; ?>
                        '   <td class=" hidden-phone"><span class="label">'+member.currentOrder+'</span></td>'+
                        '   <td class=" hidden-phone"><span class="label">'+member.currentMembership+'</span></td>'+
                        '   <td class=" hidden-phone hidden-tablet"><span class="label">'+member.currentFacultyPosition+'</span></td>'+
                        '   <td class=" hidden-phone hidden-tablet"><span class="label">'+boardCertified+'</span></td>'+
                        '   <td class=" hidden-phone hidden-tablet"><span class="label">'+member.listed+'</span></td>'+
                        '   <td><a target="_blank" class="btn mini green-stripe" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/'+member._id.$id+'/'+member.slug+'">View</a></td>'+
                        <? if($accessLevel >= EDITOR): ?>
                        '   <td><a class="btn mini blue-stripe edit" data-id="'+member._id.$id+'">Edit</a></td>'+
                        '   <td><a class="btn mini yellow-stripe user-login" data-id="'+member._id.$id+'">LogIn</a></td>'+
                        <? endif; ?>
                        '</tr>';
                  $('#results tbody').append(html);
                  $('#results thead').removeClass('hide');
               });
               
               // bind click events to the records....
               $('#results td .edit').click(function(e){
                  document.location.href='/member/'+$(this).attr('data-id')+'/edit';
               });   
               <? if($accessLevel >= EDITOR): ?>
               $('#results td .user-login').click(function(e){
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
               <? endif; ?>

               $('#results tbody .order-update').click(function(e){
                  e.preventDefault();
                  io.saw.FormGet.activate({postUrl:'/member/order/'+$(this).attr('data-member-id')+'/'+($(this).prev().val() || '*')+'/'+window.saw_stateOrderNum
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