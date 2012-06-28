<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// var_dump($strategy);
// echo '<br/><br/>';
// var_dump($microdeal);
// echo '<br/><br/>';
// var_dump($plan);
// echo '<br/><br/>';
// var_dump($blocks);
// echo '<br/><br/>';

if (isset($plan['plan_type']))
{
	// handle expiration 
	if ($plan['plan_type'] === 'expiration' && isset($strategy['expiration_date']))
	{
		$plan_type = 'expiration';
		// in expiration, plan_total means the unix timestamp of the expiration date
		$plan_total = @strtotime($strategy['expiration_date']);

		// and the plan_used will be the current timestamp
		$plan_used = time();
		$plan_used_percent = number_format(($plan_used / $plan_total), 2) * 100;

		$plan_available = ($plan_total - $plan_used);
		$plan_available_percent = number_format(($plan_available / $plan_total), 2) * 100;
	}

	// handle bank size
	if ($plan['plan_type'] === 'expiration')
	{
		$plan_type = 'bank';
	}
}

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
							<li><a href="<?=$advertisement_view_url; ?>" class="default-tab current" rel="tooltip" title="Switch to next tab"><?=lang('View')?></a></li>
							<li><a href="<?=$advertisement_statistics_url; ?>" rel="tooltip" title="Switch to next tab"><?=lang('Statistics')?></a></li>
							<li><a href="<?=$advertisement_edit_url; ?>" rel="tooltip" title="Switch to next tab"><?=lang('Edit')?></a></li>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->

				<!-- Article Content -->
				<section>

		<!-- Half Content Block -->
		<article class="half-block">

			<!-- Article Container for safe floating -->
			<div class="article-container">

					<?php
						echo Modules::run('strategy/strategy_overview/_get_strategy_overview', $data);
					?>

			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Half Content Block -->

		<!-- Half Content Block -->
		<article class="half-block clearrm">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<header>
					<h2>Properties</h2>
				</header>

				
						
				<?php echo Modules::run('microdeal/microdeal_widgets/_get_total_redemptions', $data); ?>
				
				<ul class="stats-summary">
						<li>
							<strong class="stats-count">89</strong>
							<p>New visitors</p>
							<a href="#" class="button stats-view" title="View new visitros" rel="tooltip">View</a>
						</li>
						<li>
							<strong class="stats-count">346</strong>
							<p>New sales</p>
							<a href="#" class="button stats-view" rel="tooltip" original-title="View new sales">View</a>
						</li>
						<li>
							<strong class="stats-count">266</strong>
							<p>New orders</p>
							<a href="#" class="button stats-view" title="View new orders" rel="tooltip">View</a>
						</li>
						<li>
							<strong class="stats-count">1024</strong>
							<p>New requests</p>
							<a href="#" class="button stats-view" title="View new requests" rel="tooltip">View</a>
						</li>
					</ul>

						<?php if (isset($plan_used_percent)): ?>
						<div class="clearfix"></div>

						<div style="display: none">
							<label> Plan Usage </label>
							<div class="progress-bar red small">
								<div style="width: <?=$plan_used_percent?>%; ">
									<span><?=$plan_used_percent?><sup>%</sup></span>
								</div>
							</div>
						<div>
						<?php endif; ?>

			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Half Content Block -->

<div class="clearfix"></div>
<hr/>

					<!-- Strategy Widgets Information -->
					<!-- Widget Container -->
					<section id="widgets-container">
					
						<?php
							echo Modules::run('strategy/strategy_widgets/_get_strategy_widgets', $data);
							echo Modules::run('microdeal/microdeal_widgets/_get_strategy_widgets', $data);
						?>
						
					</section>
					<!-- /Widget Container -->
					<!-- /Strategy Widgets Information -->

					<hr>
					<?php
						echo Modules::run('microdeal/microdeal_reports_overview/_widget_requests_graph', $data);
					?>

				</section>
				<!-- /Article Content -->