<?php
?>

<script type='text/javascript'>
// jQuery dataTables
	$('.datatable-reports-platform').dataTable(
		{
			"bProcessing": true,
        	"bServerSide": true,
        	"bAutoWidth":true,
        	"sPaginationType": "full_numbers",
        	"sAjaxSource": "http://localhost:8080/services/strategy/manage/get_all_strategies/1",
        	"fnServerData": function ( sSource, aoData, fnCallback ) {
	            $.ajax( {
	                "dataType": 'json', 
	                "type": "POST", 
	                "url": sSource, 
	                "data": aoData, 
	                "success": fnCallback
	            } );
        	}
		}
	);
</script>