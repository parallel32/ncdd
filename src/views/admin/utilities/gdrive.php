<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Picker Example</title>

    <!-- The standard Google Loader script; use your own key. -->
    <script src="http://www.google.com/jsapi?key=AIzaSyDSPPIQdSKTwwVnzINjbaEFVK422DRxfnM"></script>
    <script type="text/javascript">

    // Use the Google Loader script to load the google.picker script.
    google.setOnLoadCallback(createPicker);
    google.load('picker', '1');

    // Create and render a Picker object for searching images.
    var view = new google.picker.View(google.picker.ViewId.DOCS);
    view.setMimeTypes("image/png,image/jpeg,image/jpg");

    function createPicker() {
       picker = new google.picker.PickerBuilder()
          .enableFeature(google.picker.Feature.NAV_HIDDEN)
          .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
          .setAppId('969032818706.apps.googleusercontent.com')
          .addView(view)
          .addView(new google.picker.DocsUploadView())
          .setCallback(pickerCallback)
          .build();
       picker.setVisible(true);
    }

    // A simple callback implementation.
    function pickerCallback(data) {
        if (data.action == google.picker.Action.PICKED) {
            var fileId = data.docs[0].id;
            alert('The user selected: ' + fileId);
        }
    }
    </script>
  </head>
  <body>
    <div id="result"></div>
  </body>
</html>