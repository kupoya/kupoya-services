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

<?php

	$strategy_graph_gender = base_url();
	$strategy_graph_age = base_url();

	if (isset($strategy['id']))
	{
		$strategy_graph_gender .= 'strategy/reports/demographics/get_by_gender/'.$strategy['id'];
		$strategy_graph_age .= 'strategy/reports/demographics/get_by_age/'.$strategy['id'];
	}

?>
			<!-- Begin Pie Chart By Day -->

					<!--Load the AJAX API-->
				    <script type="text/javascript">

				    // Load the Visualization API and the piechart package.
				    google.load('visualization', '1', {'packages':['corechart']});
				      
				    // Set a callback to run when the Google Visualization API is loaded.
				    google.setOnLoadCallback(drawChartPie_Day);
				      
				    function drawChartPie_Day() {

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_gender; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 600, height: 400,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          title: 'Redemptions Grouped by Gender'
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.PieChart(document.getElementById('pie_chart1'));
				      chart.draw(data, options);
				    }
				    </script>
				    <!--/Load the AJAX API-->



			<!-- Begin Pie Chart By Hour -->

					<!--Load the AJAX API-->
				    <script type="text/javascript">

				    // Load the Visualization API and the piechart package.
				    google.load('visualization', '1', {'packages':['corechart']});
				      
				    // Set a callback to run when the Google Visualization API is loaded.
				    google.setOnLoadCallback(drawChartPie_Hour);
				      
				    function drawChartPie_Hour() {

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_age; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 600, height: 400,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          title: 'Requests Grouped by Age'
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.PieChart(document.getElementById('pie_chart2'));
				      // var chart = new google.visualization.BarChart(document.getElementById('pie_chart2'));
				      chart.draw(data, options);
				    }
				    </script>
				    <!--/Load the AJAX API-->




<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->

		<!-- Quarter Content Block -->
		<article class="half-block clearfix">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="pie_chart2">
					</div>

				</section>
			
			</div>

		</article>



		<!-- Quarter Content Block -->
		<article class="half-block clearrm">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="pie_chart1">
					</div>

				</section>
			
			</div>

		</article>
