<?php

/*
				<!-- Article Header -->
				<header>
					<h2><?=lang('Campaigns')?></h2>
					<!-- Article Header Tab Navigation -->
					<nav>
						<ul class="tab-switch">
							<li><a class="default-tab" href="#tab0" rel="tooltip" title="Switch to next tab"><?=lang('Campaigns')?></a></li>
							<li><a href="#tab1" rel="tooltip" title="Switch to next tab"><?=lang('Campaigns_Stats')?></a></li>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->
*/
?>				
				<!-- Article Content -->
				<section>

						<!-- Side Tab Content #sidetab1 -->
						<div class="sidetab default-sidetab" id="sidetab1">
							<h3><?=lang('menu:campaigns:campaign_selection')?></h3>

							<table class="datatable">
								<thead>
									<tr>
										<th><?=lang('Campaign_Name');?></th>
										<!-- <th><?=lang('Campaign_Type');?></th> -->
									</tr>
								</thead>
							</table>

				<!-- /Article Content -->
				</section>


<script type="text/javascript">

// jQuery dataTables
$(document).ready(function () {
		$('.datatable').dataTable(
		{
		"bProcessing": true,
	   	"bServerSide": true,
	   	"bAutoWidth":true,
	   	"sPaginationType": "full_numbers",
	   	"sAjaxSource": "<?= base_url() ?>strategy/manage/get_all_strategies/<?=$brand['id']?>",
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