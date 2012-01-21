<?php

$data['strategy'] = $strategy;
$data['campaign'] = $campaign;

$advertisement_view_url = '#';
if (isset($campaign['id']) && isset($strategy['id']))
	$advertisement_view_url = base_url().'strategy/manage/view/'.$strategy['id'].'/'.$campaign['id'];

$advertisement_edit_url = '#';
if (isset($campaign['id']) && isset($strategy['id']))
	$advertisement_edit_url = base_url().'strategy/manage/edit/'.$strategy['id'].'/'.$campaign['id'];

$advertisement_statistics_url = '#';
if (isset($campaign['id']) && isset($strategy['id']))
	$advertisement_statistics_url = base_url().'strategy/reports/overview/'.$strategy['id'].'/'.$campaign['id'];

?>
				<!-- Article Header -->
				<header>
					<h2><?=lang('My_Campaign')?></h2>
					<!-- Article Header Tab Navigation -->
					<nav>
						<ul class="tab-switch-url">
							<li><a href="<?=$advertisement_view_url; ?>" rel="tooltip" title="Switch to next tab"><?=lang('View')?></a></li>
							<li><a href="<?=$advertisement_statistics_url; ?>" class="default-tab current" rel="tooltip" title="Switch to next tab"><?=lang('Statistics')?></a></li>
							<li><a href="<?=$advertisement_edit_url; ?>" rel="tooltip" title="Switch to next tab"><?=lang('Edit')?></a></li>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->


				<!-- Article Header -->
				<header>
					<h2><?=lang('My_Campaign')?></h2>
					<!-- Article Header Tab Navigation -->
					<nav>
						<ul class="tab-switch-url">
							<!-- Get Default Strategy links -->
							<?php
								echo Modules::run('strategy/strategy_overview/_get_reports_links', $data);
							?>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->


<!-- Side Tab Navigation -->
	<nav class="sidetab-switch">
		<ul>
			<li><a class="default-sidetab" href="#sidetab1">Requests</a></li>
			<li><a href="#sidetab2">Unnamed</a></li>
			<li><a href="#sidetab3">Unnamed</a></li>
		</ul>
		<p>dont know what to put here... dont know what to put here...</p>
	</nav>
	<!-- /Side Tab Navigation -->
	


	<!-- Side Tab Content #sidetab1 -->
	<div class="sidetab default-sidetab" id="sidetab1">
		
		<?php
			echo Modules::run('strategy/strategy_overview/_get_requests_graph', $data);
		?>

		<?php
			echo Modules::run('strategy/strategy_overview/_get_requests_graph_extended', $data);
		?>

	</div>
	<!-- /Side Tab Content #sidetab1 -->
	
	<!-- Side Tab Content #sidetab2 -->
	<div class="sidetab" id="sidetab2">
		<div>
			missing info here...
		</div>
	</div>

	<div class="sidetab" id="sidetab3">
			missing info here...
	</div>