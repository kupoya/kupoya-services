<?php

// echo "<br/><br/>";
// if (isset($message)) echo $message;
// echo "<br/><br/>";

// echo validation_errors();
// echo "<br/><br/>";
// echo "<br/><br/>";

// var_dump($strategy);
// echo "<br/><br/>";
// var_dump($plan);

// echo "<br/><br/>";
// echo "<br/><br/>";

// var_dump($advertisement);
// echo "<br/><br/>";
// echo "<br/><br/>";
// var_dump($advertisement_blocks);


// //var_dump($error);

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
	$advertisement_statistics_url = base_url().'strategy/reports/overview/index/'.$strategy['id'].'/'.$campaign['id'];

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
					<h2><?=lang('advertisement:my_campaign')?></h2>
					<!-- Article Header Tab Navigation -->
					<nav>
						<ul class="tab-switch-url-ajax">
							<!-- Get Default Strategy links -->
							<?php
								echo Modules::run('strategy/strategy_overview/_get_reports_links', $data);
							?>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->


				<!-- Article Content -->
				<section class="content" id="loaded_content">

				</section>
