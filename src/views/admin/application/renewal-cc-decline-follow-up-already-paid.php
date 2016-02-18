<!-- BEGIN CONTAINER -->   
<div class="page-container row-fluid">
   <!-- BEGIN PAGE CONTAINER-->
   <div class="container-fluid">
      <!-- BEGIN PAGE HEADER-->
         <div class="row-fluid">
            <div class="span12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title text-center">
                  <a href="//<?=SAW_CONSUMER_WEBSITE?>"><img src="<?=SAW_SSL_CDN?>/assets/img/ncdd-login2-logo.png"></a>
                  <br/>Renewal Payment Verification Form
               </h3>
               <p class="text-center">
                  
                  National College for DUI Defense, Inc. 
                  <br/>445 S. Decatur St. 
                  <br/>Montgomery, AL 36104
                  <br/>Tel: 334-264-1950
                  <br/>Fax: 334-264-1920
               </p>
               <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
         </div>
         
         <!-- END PAGE HEADER-->
         <!-- BEGIN PAGE CONTENT-->
         <div class="row-fluid">
            <div class="span12">
               


            <!-- BEGIN FORM-->
               <form id="saw-form" class="horizontal-form portlet">
                  

                     <h3 class="form-section"><?=(array_key_exists('name',$this->vars['ar_res']['record']['payment'])) ? $this->vars['ar_res']['record']['payment']['name']: '';?> </h3>
                     <br>
                     <h3>Your Renewal is paid.  Thank you!  </h3>
                     <br>
                     <h3>To finish your Renewal you must still submit your renewal form.  Please go to the NCDD.com member portal here: <a href="https://<?=SAW_ADMIN_WEBSITE?>">https://<?=SAW_ADMIN_WEBSITE?></a> and click the green button on your dashboard.</h3>
                     
               </form>
               <!-- END FORM--> 







            </div>
         </div>
         <!-- END PAGE CONTENT-->

   </div>
   <!-- END PAGE CONTAINER -->
</div>
<!-- END CONTAINER -->



