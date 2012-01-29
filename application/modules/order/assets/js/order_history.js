// jQuery dataTables
$('.datatable_order_history').dataTable(
	{
		"bProcessing": true,
    	"bServerSide": true,
    	"bAutoWidth":true,
    	"sPaginationType": "full_numbers",
    	"sAjaxSource": "http://localhost:8080/services/order/manage/get_order_history/1",
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