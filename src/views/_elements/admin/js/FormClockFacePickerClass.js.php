<script type="text/javascript">
(function( FormClockFacePicker, $, undefined ) {
    
    FormClockFacePicker.init = function(mode){
        
        if (!$().clockface) {
            return;
        }

        $('.clockface').clockface();

        

        /*
        if (!jQuery().clockface) {
            return;
        }

        $('.clockface_1').clockface();

        $('#clockface_2').clockface({
            format: 'HH:mm',
            trigger: 'manual'
        });

        $('#clockface_2_toggle').click(function (e) {
            e.stopPropagation();
            $('#clockface_2').clockface('toggle');
        });

        $('#clockface_2_modal').clockface({
            format: 'HH:mm',
            trigger: 'manual'
        });

        $('#clockface_2_modal_toggle').click(function (e) {
            e.stopPropagation();
            $('#clockface_2_modal').clockface('toggle');
        });

        $('.clockface_3').clockface({
            format: 'H:mm'
        }).clockface('show', '14:30');
        //*/
    };
    
    
}( io.saw.FormClockFacePicker = io.saw.FormClockFacePicker || {}, io.saw.jQuery || jQuery ));
</script>