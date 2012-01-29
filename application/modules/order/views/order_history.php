<?php
	$strategy_id = isset($strategy['id']) ? $strategy['id'] : '0';
?>				

<br/>
<!-- Full Content Block with .nested style -->
		<article class="full-block nested">
		
			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>
				<!-- Article Header -->
				<header>
					<h2>Order History</h2>

					<!-- Article Header Tab Navigation -->
					<nav>
					</nav>
					<!-- /Article Header Tab Navigation -->

				</header>

						<!-- Side Tab Content #sidetab1 -->
						<div class="sidetab default-sidetab" id="sidetab1">
							

							<table class="datatable_order_history">
								<thead>
									<tr>
										<th>time</th>
										<th>plan_name</th>
										<th>bank</th>
										<th>plan_type</th>
										<th>status</th>
										<th>order_total</th>
									</tr>
								</thead>
							</table>

				<!-- /Article Content -->
				</section>

			</div>

		</article>


<script type="text/javascript">

$(document).ready(function () {
	$('.datatable_order_history').dataTable(
		{
			"bProcessing": true,
	    	"bServerSide": true,
	    	"bAutoWidth":true,
	    	"sPaginationType": "full_numbers",
	    	"sAjaxSource": "<?= base_url(); ?>order/manage/get_order_history/<?= $strategy_id; ?>",
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
});
</script>