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





<script type="text/javascript">

    // Use the Google API Loader script to load the google.picker script.
    function loadPicker() {
      gapi.load('picker', {'callback': createPicker});
    }


    // Create and render a Picker object for searching images.
    function createPicker() {
      var view = new google.picker.View(google.picker.ViewId.DOCS);
      //view.setMimeTypes("image/png,image/jpeg,image/jpg");
      var picker = new google.picker.PickerBuilder()
          .enableFeature(google.picker.Feature.NAV_HIDDEN)
          .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
          .setAppId('<?=$this->vars['client_id']?>')
          .setOAuthToken('<?=$this->vars['access_token']?>')
          .addView(view)
          .addView(new google.picker.DocsUploadView())
          .setCallback(pickerCallback)
          .build();
       picker.setVisible(true);
    }

    // A simple callback implementation.
    function pickerCallback(data) {
      if (data.action == google.picker.Action.PICKED) {
        console.log(data.docs);
        $.each( data.docs, function( key, value ) {
          console.log( value.name );
          console.log( value.embedUrl );
          $('#iframe-viewer').attr('src',value.embedUrl);
        });
      }
    }
    </script>
    <div id="result"></div>
    <iframe id="iframe-viewer" src="" width="600" height="480" style="border: none;"></iframe>


    <!-- The Google API Loader script. -->
    <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=loadPicker"></script>







               </div>
            </div>
            <!-- END PAGE CONTENT-->


         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->