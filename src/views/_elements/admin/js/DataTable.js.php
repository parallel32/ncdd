<script type="text/javascript">
(function( DataTable, $, undefined ) {
    
    var params = {}
	
	DataTable.init = function(p){
		
		params = p; 
		params.tableName = params.tableName || '#table';

		if (!jQuery().dataTable) {
                return;
            }

            // begin second table
            $('#'+params.tableName).dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 10,
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });

            jQuery('#'+params.tableName+'_wrapper .dataTables_filter input').addClass("m-wrap small"); // modify table search input
            jQuery('#'+params.tableName+'_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
            jQuery('#'+params.tableName+'_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

	    
	};
    
}( io.saw.DataTable = io.saw.DataTable || {}, io.saw.jQuery || jQuery ));
</script>  