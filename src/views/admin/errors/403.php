   <div class="row-fluid">
      <div class="span12 page-404">
         <div class="portlet number" id="number">
         </div>
         <div class="details">
            <h2>Checking your access credentials...</h2>
            </h3>
         </div>
      </div>
   </div>
   <form id="saw-form" class="form-horizontal portlet" novalidate="novalidate">
      <input type="hidden" name="doc[message]" value="The page you're trying to access requires authentication.  Please sign-in and you will be redirected back to the page you requested.">
      <input type="hidden" name="doc[redirect]" value="<?=$_SERVER['REQUEST_URI']?>">
   </form>
<script>
   jQuery(document).ready(function() {
      // set the flash message and redirect
      io.saw.FormPost.activate({postUrl:'/flash/set'
         ,serializeSelector:':input'
         ,blockUI:'no'
         ,postOnComplete:function(responseObj,responseStatus){}
         ,postOnSuccess:function(responseObj){
            document.location.href='/login';
         }
      });
   });
</script>